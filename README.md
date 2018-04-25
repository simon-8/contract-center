### 安装
> 使用git克隆本项目

    git clone https://github.com/simon-8/laravel5.5.git laravel
    cd laravel

> 通过composer安装程序所需扩展
    
    composer install
    
> 运行安装脚本, 按提示输入相关信息
    
    php artisan story:install
    
![install](https://raw.githubusercontent.com/simon-8/MarkdownPhotos/master/blog/install.jpg)

> 修改.env配置文件

    修改配置文件中相关配置

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