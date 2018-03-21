### 安装
> 使用git克隆本项目

    git clone https://github.com/simon-8/laravel5.5.git laravel
    cd laravel

> 复制配置文件

    cp .env.example .env

> 通过composer安装程序所需扩展
    
    composer install
    
> 生成应用程序密钥

    php artisan key:generate

> 修改.env配置文件

    修改配置文件中数据库等配置
    
> 还原数据库备份 , 生成菜单 , 默认管理员等数据
    
    php artisan migrate --seed
    
> 后台地址
  
    http://你配置的域名/admin
    账号: admin
    密码: 123456
    
> 线上部署优化
    
    #配置缓存
    php artisan config:cache
    #路由缓存
    php artisan route:cache
    #类映射加载优化
    php artisan optimize --force