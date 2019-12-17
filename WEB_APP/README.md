PASN WMS
## 介绍
* 这是一款基于luman+vue+jwt-auth，使用element ui+vue element admin所开发的前后端分离WMS系统。
* 前端应用为：WEB_APP
* 接口应用为:WEB_API


## 环境要求
* php7.2+
* nginx/apache
* mysql/sql srv

## 目录结构
请参考<a href="https://lumen.laravel.com/docs/6.x">luman</a>目录结构以及<a href="https://panjiachen.github.io/vue-element-admin-site/zh/guide/#%E7%9B%AE%E5%BD%95%E7%BB%93%E6%9E%84">element admin</a>目录结构。

## 安装使用
1. 执行``` git clone git@github.com:GabbyMrH/PASN_WEB.git ```;
2. 切换到 ``` WEB_API ```目录执行
``` composer install ```安装composer扩展;
3. 在``` WEB_API ```目录需要手动生成```APP_KEY```放入```.env```文件对应位置(.env.)。
4. 切换到 ``` WEB_APP ```目录执行
``` npm install ```安装npm扩展;
5. 分别部署两个应用，入口指向public目录。

## 二开规范
* 需要您掌握laravel、lumen、jwt-auth、restAPI、vue、vuex、vue-router、webpack、axios、request.js以数据库相关知识。
* 请遵循开发规范，以便于后期维护。