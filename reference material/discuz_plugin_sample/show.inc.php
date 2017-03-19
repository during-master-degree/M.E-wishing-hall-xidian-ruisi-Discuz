<?php
/**
 * 浏览器访问方式 plugin.php?id=sample:show
 * 浏览器访问地址此脚本的命名: sample 为插件标识符, show 为此脚本的名称
 * 已经已经加载上了 DX 的核心, 需要调用数据库的时候直接调用就行!
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

include template('common/header');
?>

<div style=" border: 2px solid #ccc;  padding: 80px 0; font-size: 24px; text-align: center; font-weight: bold;margin:40px 0;"> 
你从浏览器访问了插件!! ;-)  
</div>

<?php 

include template('common/footer');