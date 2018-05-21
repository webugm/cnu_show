<?php
include_once XOOPS_ROOT_PATH . "/modules/ugm_tools2/InstallFunction.php";
function xoops_module_install_cnu_show(&$module) {

  #安裝
  go_install();
  #更新
  go_update(); 

  return true;

return true;
}

//安裝
function go_install() {
	global $xoopsDB;
	#建立資料夾	
  mk_dir(XOOPS_ROOT_PATH . "/uploads/cnu_show");
	return true;
}


//更新
function go_update() {
  global $xoopsDB;

  //資料表   
  #---- 增加資料表 cnu_show_kind
  $tbl = "cnu_show_kind";
  if(!chk_isTable($tbl)){
    $sql="
      CREATE TABLE `" . $xoopsDB->prefix($tbl) . "` (
        `sn` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'sn',
        `ofsn` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '父類別',
        `kind` varchar(255) NOT NULL DEFAULT 'nav_home' COMMENT '分類',
        `title` varchar(255) NOT NULL DEFAULT '' COMMENT '標題',
        `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
        `enable` enum('1','0') NOT NULL DEFAULT '1' COMMENT '狀態',
        `url` varchar(255) NOT NULL DEFAULT '' COMMENT '網址',
        `target` enum('1','0') NOT NULL DEFAULT '0' COMMENT '外連',
        `col_sn` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'col_sn',
        `content` text COMMENT '內容',
        `ps` varchar(255) DEFAULT NULL COMMENT '備註',
        PRIMARY KEY (`sn`)
      ) ENGINE=MyISAM;
    ";
    $xoopsDB->queryF($sql);
  } 
  
  #---- 增加資料表 cnu_show_prod
  $tbl = "cnu_show_prod";
  if(!chk_isTable($tbl)){
    $sql="
      CREATE TABLE `" . $xoopsDB->prefix($tbl) . "` (
        `sn` int(10) unsigned NOT NULL auto_increment comment 'prod_sn',
        `kind` smallint(5) unsigned NOT NULL default 0 comment '分類',
        `title` varchar(255) NOT NULL default '' comment '名稱',
        `summary` text NULL comment '摘要',
        `content` text NULL comment '內容',
        `enable` enum('1','0') NOT NULL default '1' comment '狀態',
        `choice` enum('1','0') NOT NULL default '0' comment '精選',
        `date` int(10) unsigned NOT NULL default 0 comment '建立日期',
        `sort` smallint(5) unsigned NOT NULL default 0 comment '排序',
        `counter` int(10) unsigned NOT NULL default 0 comment '人氣',
        `icon` varchar(255) NOT NULL default ''  comment '圖示',
        `price` int(10) unsigned NOT NULL default 0 comment '價格',
        `amount` int(10) unsigned NOT NULL default 0 comment '數量',
        `youtube` varchar(255) NOT NULL default '' comment 'youtube',
        `standard` varchar(255) NOT NULL default '' comment '規格',
        `size` varchar(255) NOT NULL default '' comment '尺寸',
        `unit` varchar(255) NOT NULL default '' comment '單位',
        PRIMARY KEY  (`sn`)
      ) ENGINE=MyISAM;
    ";
    $xoopsDB->queryF($sql);
  } 

}
 
