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
    protected $description = '后台安装, 将会执行数据表恢复、添加初始化数据、生成应用密钥等操作';

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
        $this->line('************* 初始化数据库 *************');
        $this->call('migrate', [
            '--seed' => true
        ]);

        $this->line('************* 生成应用密钥 *************');
        $this->call('key:generate');

        $this->line('************ Passport:keys ************');
        $this->call('passport:keys', [
            '--force' => true
        ]);

        $this->info('************* 应用安装完成 *************');
        $this->info('************ 请尽快修改密码 ************');
        $this->line('后台链接：http://你的域名/pc');
        $this->line('用户名：admin');
        $this->line('密码：123456');
    }
}
