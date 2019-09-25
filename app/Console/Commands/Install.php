<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'auto install script';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException|\Exception
     */
    public function handle()
    {
        $dbhost = $this->ask('请输入数据库地址', 'localhost');
        $dbname = $this->ask('请输入数据库名称', 'hotel-center');
        $dbuser = $this->ask('请输入数据库用户名', 'homestead');
        $dbpass = $this->ask('请输入数据库密码', false);
        $dbpass = $dbpass ? $dbpass : 'secret';
        $appKey = 'base64:'. base64_encode(random_bytes(32));

        $envExample = \File::get(base_path('.env.example'));
        $envExample = explode("\r\n", $envExample);
        foreach ($envExample as $key => $env) {
            $name = substr($env, 0, strpos($env, '='));
            switch ($name) {
                case 'APP_KEY':
                    $envExample[$key] = $name .'='. $appKey;
                    break;
                case 'DB_HOST':
                    $envExample[$key] = $name .'='. $dbhost;
                    break;
                case 'DB_DATABASE':
                    $envExample[$key] = $name .'='. $dbname;
                    break;
                case 'DB_USERNAME':
                    $envExample[$key] = $name .'='. $dbuser;
                    break;
                case 'DB_PASSWORD':
                    $envExample[$key] = $name .'='. $dbpass;
                    break;
                default:
                    //$envExample[$key] = $name .'='. $val;
                    break;
            }
        }
        $envExample = implode("\r\n", $envExample);
        $saveResult = \File::put(base_path('.env'), $envExample);
        if (!$saveResult) {
            $this->error("配置生成失败");
            return;
        }
        $this->info("配置生成成功");

        // todo 环境变量未更新, 无法执行数据库还原
        //$this->call('migrate', [
        //    '--seed' => true
        //]);
        //$this->info("数据库还原成功");
        //$this->call('key:generate');

        $this->info('*************** 配置完成 ***************');
        $this->info('*                                      *');
        $this->info('*  最后一步, 执行下面命令进行数据还原  *');
        $this->info('*      php artisan migrate --seed      *');
        $this->info('*                                      *');
        $this->info('************ 请尽快修改密码 ************');
        $this->line('后台链接：http://你的域名/pc');
        $this->line('用户名：admin ');
        $this->line('密码：123456 ');
    }
}
