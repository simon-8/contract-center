### 安装

> 通过composer安装程序所需扩展
    
    composer install
    
> 运行安装脚本, 按提示输入相关信息
    
    php artisan admin:install
    
> 修改.env配置文件

    修改配置文件中相关配置

> 后台地址
  
    http://你配置的域名/pc
    账号: admin
    密码: 123456
    
> 线上部署优化
    
    #配置缓存
    php artisan config:cache
    #路由缓存
    php artisan route:cache
    #类映射加载优化
    php artisan optimize --force

### 配置supervisor
- 程序用到了`laravel-horizon`队列服务, 由`supervisor`管理

```ini
[program:contractCenter]
user=www
process_name=%(program_name)s
autostart=true
autorestart=true
redirect_stderr=true
stdout_logfile=/data/wwwlogs/supervisor/contractCenter.log
directory=/data/wwwroot/contract-center/
command=/usr/local/php/bin/php /data/wwwroot/contract-center/artisan horizon
```
    
- 如果要重启队列, 使用如下命令, 队列会在运行后中止, 由`supervisor`将其启动
```ini
php artisan horizon:terminate
```

### E签名
- 首次使用e签名时, 需要初始化行业 && 场景值
```
php artisan esign:init
```
- 此命令执行如下操作
    - 在e签名账户内: 
         - 定义所属行业类型: 房屋租赁行业
         - 定义业务凭证(证据发生场景): 房屋租赁合同签署
    - 在配置文件内(.env):
        - 增加所属行业ID
        - 增加业务凭证ID