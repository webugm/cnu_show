<?php

//判斷是否對該模組有管理權限
$isAdmin == false;
if ($xoopsUser) {
    $module_id = $xoopsModule->getVar('mid');
    $isAdmin   = $xoopsUser->isAdmin($module_id);
}

//工具列設定

//回模組首頁
$interface_menu[_TAD_TO_MOD] = "index.php";
$interface_icon[_TAD_TO_MOD] = "fa-chevron-right";

//模組後台
if ($isAdmin) {
    $interface_menu[_TAD_TO_ADMIN] = "admin/main.php";
    $interface_icon[_TAD_TO_ADMIN] = "fa-chevron-right";
}


#工具列設定
$mod_name   = $xoopsModule->name();//模組中文名
$module_name = $xoopsModule->dirname();//模組
$moduleMenu = array();
if($isAdmin) { 
  $i = 0;
  $moduleMenu[$i]['url']="index.php";
  $moduleMenu[$i]['title']="回首頁";
  $moduleMenu[$i]['icon']="fa-home";

  $i++;
  $moduleMenu[$i]['url']="admin/index.php";
  $moduleMenu[$i]['title']=sprintf(_TAD_ADMIN,$mod_name);//管理後台
  $moduleMenu[$i]['icon']="fa-wrench";
  $i++;
  $moduleMenu[$i]['url']=XOOPS_URL."/modules/system/admin.php?fct=preferences&op=showmod&mod={$module_id}";
  $moduleMenu[$i]['title']=sprintf(_TAD_CONFIG,$mod_name);//」偏好設定
  $moduleMenu[$i]['icon']="fa-edit";
  $i++;
  $moduleMenu[$i]['url']=XOOPS_URL."/modules/system/admin.php?fct=modulesadmin&op=update&module={$module_name}";
  $moduleMenu[$i]['title']=sprintf(_TAD_UPDATE,$mod_name);//更新
  $moduleMenu[$i]['icon']="fa-refresh";
  $i++;
  $moduleMenu[$i]['url']=XOOPS_URL."/modules/system/admin.php?fct=blocksadmin&op=list&filter=1&selgen={$module_id}&selmod=-2&selgrp=-1&selvis=-1";
  $moduleMenu[$i]['title']=sprintf(_TAD_BLOCKS,$mod_name);//」區塊管理
  $moduleMenu[$i]['icon']="fa-th";

}
