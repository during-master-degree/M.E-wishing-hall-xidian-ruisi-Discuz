<?php
/**
 * 	官方文档在 : http://dev.discuz.org/wiki/ , 有完整的说明
 *  此插件为插件开发实例, 在通用头部里面显示信息, 可以在后台设置是否显示! 并且
 *  插件 -> 插件设计 -> 变量! 
 *   脚本里面要获取就是 $_G['cache']['plugin']['sample']['变量名称']
 *   语言包: 开发的时候首先需要创建一个 data/plugindata/identifier.lang.php 文件, 导出的时候会
 *   			对应到 xml 文件里面去!
 **/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

/** 必须定义一个类, plugin_ $插件唯一标识符 , 不管里面有没有东西*/
class plugin_sample {
	public $settings = array();

	/** 构造函数*/
	function __construct() {
		global $_G;
		/** 获取插件的配置信息,  配置信息的获取是  $_G['cache']['plugin'] 在加上插件的唯一标识符 ! */
		$this->settings = $_G['cache']['plugin']['sample']['showHeaderTPL'];
	}

	/** 自定义的帮助方法, 用来获取配置信息里面的插件配置信息! */
	function getSettings($name) {
		if(isset($this->settings[$name])) {
			return $this->settings[$name];
		}
		return NULL;
	}
	
	/** 插件钩子里面有 global_ 前缀的, 都必须在这个插件基类里面定义! */
	function global_header() {
		global $_G;
		
		/** 如果配置信息有, 就输出 */
		if ($this->getSettings ( 'showHeaderTPL' )) {
			/** 
			 * 可以在这里写 HTML , 也可以写一个自定义的模版, 模板文件位于插件根目录下面的
			 * template 文件夹下, 得自己创建, 注意模版有自己的一套写法, 要写成下面这样 
			 * <!--{block return}-->html在这里<!--{/block}-->, 不然的话就直接输出了!
			 **/
			include template ( 'sample:global_header' );
			/** 把模版输出 */
			return $return;
		}
	}
}

/** 
 * 执行应用类, 集成上面的插件基础类, class 的命名规范为 , plugin_sample_$入口文件名
 * 例如: 论坛为 forum, 家园为 home , 全局的 (global_) 前缀的, 要写在基类里面去 !! 
 * 开启插件钩子页面嵌入显示模式就可以看到页面的插件嵌入点了!  $_config['plugindeveloper'] = 2; 
 **/
class plugin_sample_forum extends plugin_sample {
	
	/**  这个钩子是属于字符串类型的钩子 ! */
	function index_top() {
		//string
		return '<font style="color:red;">Hello World!</font>';
	}

	/**  forum.php?mod=forumdisplay&fid=1 板块帖子列表里面, */
	function forumdisplay_author() {
		/** 
		 * 注意这里的插件钩子是数组形式的! 
		 * 插件钩子有两类, 一种为 字符串, 一种为数组!
		 * 字符串是页面一个地点的标记, 数组是会随着内容的多少而变化的! 
		 **/
		$forumdisplay_authors = array(
			'<font style="color:red;">1</font>',
			'<font style="color:blue;">2</font>',
			'<font style="color:green;">3</font>'
		);
		return $forumdisplay_authors;
	}
}

/** 家园里面的 */
class plugin_sample_home extends plugin_sample {}

/** 群组里面的 */
class plugin_sample_group extends plugin_sample {}