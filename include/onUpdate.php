<?php
include_once "onInstall.php";
function xoops_module_update_cnu_show(&$module, $old_version) {	
  #��s
  go_update();
  return true;
}

