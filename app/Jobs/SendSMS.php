<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Toplan\PhpSms\Sms;


class SendSMS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	protected $sms;

	/**
	 * Create a new job instance.
	 *
	 * @param Sms $sms
	 */
	public function __construct(Sms $sms)
	{
		$this->sms = $sms;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		$this->sms->send();
	}
}
