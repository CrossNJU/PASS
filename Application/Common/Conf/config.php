<?php
return array(
	//'配置项'=>'配置值'
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => 'localhost', // 服务器地址
    'DB_NAME'   => 'phyCSS', // 数据库名
    'DB_USER'   => 'test', // 用户名
    'DB_PWD'    => 'chen123', // 密码
    'DB_PORT'   => 3306, // 端口
    'DB_PREFIX' => '', // 数据库表前缀

    'TMPL_L_DELIM'          =>  '<{',            // 模板引擎普通标签开始标记
    'TMPL_R_DELIM'          =>  '}>',            // 模板引擎普通标签结束标记

    // 配置邮件发送服务器
    'MAIL_HOST' => 'smtp.163.com',//smtp服务器的名称
    'MAIL_USERNAME' => 'wudiwudicr2',//你的邮箱名
    'MAIL_FROM' =>'wudiwudicr2@163.com',//发件人地址
    'MAIL_FROM_NAME'=>'pass',//发件人姓名
    'MAIL_PASSWORD' =>'afdnaboovrdbiudz',//邮箱密码

    'TAGLIB_BEGIN'=>'<{',
    'TAGLIB_END'=>'}>',

    'URL_BASE' => './Public/uploads/',
    'URL_HEAD' => 'http://localhost/PASS/',

    'URL_MODEL'             =>  2,       // URL访问模式,可选参数0、1、2、3,代表以下四种模式：
    // 0 (普通模式); 1 (PATHINFO 模式); 2 (REWRITE  模式); 3 (兼容模式)  默认为PATHINFO 模式
);