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
        
# 客户端注意
- HTTP请求Header需要增加`client-id`字段, 以供服务端识别所属客户端


# E签名

### JAVA 环境部署
1. [安装JDK, 设置环境变量](https://www.cnblogs.com/BokzBCheung/p/7912625.html?tdsourcetag=s_pctim_aiomsg)
2. 安装Tomcat, 解压即可
3. [Tomcat服务器部署war包](https://blog.csdn.net/cx15733896285/article/details/80996924)
4. 运行 `Tomcat/bin/startup.sh` 启动Tomcat
5. 确定 http://127.0.0.1:8080/tech-sdkwrapper/ 连接可访问
6. 配置E签名PHP部分


### PHP环境部署
- 配置文件
```
extends/tech/comm/initConfig.php
```
- 首次使用e签名时, 需要初始化
```
php artisan esign:init
```

# OCR身份证识别
- 实名认证
    - 使用阿里云OCR接口识别图片中的身份证信息
[文档地址](https://market.aliyun.com/products/57124001/cmapi010401.html)

# 生成PDF扩展
- laravel-snappy [文档](https://github.com/barryvdh/laravel-snappy)
    - 中文乱码
        - 复制`simsun.ttc` 到服务器 `/usr/share/fonts/truetype`