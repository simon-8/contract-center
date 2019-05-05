<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Zttp\Zttp;


class PaymentNotify implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;

    public $tries = 3;
    public $timeout = 10;
    //protected $maxAttempts =

    /**
     * PaymentNotify constructor.
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function handle()
    {
        //if ($this->attempts()) {
        //    return false;
        //}

        logger('PaymentNotify:' . json_encode($this->order));

        $order = $this->order;
        //if ($order->status != 'init') {
        //    return;
        //}

        $order->status = config("laravel-omnipay.sync", 'sync');
        $order->save();

        $data = [
            'order_id' => (string) id_encode($order->id),
            'user_id'  => (string) $order->user_id,
            'amount'   => $order->price + $order->coin, //支付总额
            'info'     => $order->info,
            'status'   => config("laravel-omnipay.complete", 'complete')
        ];
        $notifyData['action'] = 'order';
        $notifyData['client_id'] = (string)$order->client_id;
        $notifyData['data'] = $data;

        if (empty($order->notify_url)) {
            if (empty($order->oauthClient->notify)) {
                logger(sprintf("客户端 %s 通知地址未设置", $order->oauthClient->id));
                return false;
            } else {
                $notifyURL = $order->oauthClient->notify;
            }
        } else {
            $notifyURL = $order->notify_url;
        }

        $data = client_sign($order->oauthClient, $notifyData);

        $response = Zttp::post($notifyURL, $data);
        $body = $response->body();
        $status = $response->status();

        logger(sprintf('PaymentNotify RESPONSE Code: %s Content: %s', $status, $body));

        if (!$response->isSuccess() || str_contains(strtolower(trim($body)), 'fail')) {
            // 准备重试
            $this->setRelease();
            $this->fail(new \Exception('订单通知响应失败'));
            return false;
        }

        $order->status = config("laravel-omnipay.complete", 'complete');
        $order->result = $status . '-' . substr($body, 0, 30);
        $order->save();

        return true;
    }

    /**
     * 通知失败时重试
     * @param \Exception $exception
     */
    public function failed(\Exception $exception)
    {
        logger('JOB FAILED ' . $exception->getMessage());
    }

    /**
     * 设置等待时间
     */
    public function setRelease()
    {
        logger('当前任务运行次数' . $this->attempts());
        switch ($this->attempts()) {
            case 1:
                $delay = 10;
                break;
            case 2:
                $delay = 240;
                break;
            case 3:
                $delay = 600;
                break;
            case 4:
                $delay = 3600;
                break;
            case 5:
                $delay = 7200;
                break;
            case 6:
                $delay = 14400;
                break;
            default:
                $delay = 10;
                break;
        }
        $this->release($delay);
    }

    public function sign($client, $data)
    {
        $clientId = $client->id;
        $clientSecret = $client->secret;

        $data['client_id'] = $clientId;
        $data['timestamp'] = time();

        $data = array_sort_recursive($data);
        $jsonData = json_encode($data);

        $data['sign'] = md5($jsonData . $clientSecret);

        return $data;
    }
}
