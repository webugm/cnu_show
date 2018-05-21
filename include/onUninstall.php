<?php
function xoops_module_uninstall_cnu_show(&$module) {
  GLOBAL $xoopsDB;
	$date=date("Ymd");

 	rename(XOOPS_ROOT_PATH."/uploads/cnu_show",XOOPS_ROOT_PATH."/uploads/cnu_show_bak_{$date}");

	return true;
}

