<?php
$modversion = array();

//---模組基本資訊---//
$modversion['name']        = _MI_CNUSHOW_NAME;
$modversion['version']     = '1.01';
$modversion['description'] = _MI_CNUSHOW_DESC;
$modversion['author']      = _MI_CNUSHOW_AUTHOR;
$modversion['credits']     = _MI_CNUSHOW_CREDITS;
$modversion['help']        = 'page=help';
$modversion['license']     = _MI_CNUSHOW_LICENSE;
$modversion['license_url'] = 'www.gnu.org/licenses/gpl-2.0.html/';
$modversion['image']       = 'images/logo.png';
$modversion['dirname']     = basename(dirname(__FILE__));

//---模組狀態資訊---//
$modversion['release_date']        = '2018/05/25';
$modversion['module_website_url']  = 'https://www.ugm.com.tw';
$modversion['module_website_name'] = '育將電腦工作室';
$modversion['module_status']       = 'release';
$modversion['author_website_url']  = 'https://www.ugm.com.tw';
$modversion['author_website_name'] = '育將電腦工作室';
$modversion['min_php']             = 5.2;
$modversion['min_xoops']           = '2.5';
$modversion['min_tadtools']        = '3.17';

//---paypal資訊---//
$modversion['paypal']                  = array();
$modversion['paypal']['business']      = 'tawan158@gmail.com';
$modversion['paypal']['item_name']     = 'Donation : ' . 'ugm';
$modversion['paypal']['amount']        = 0;
$modversion['paypal']['currency_code'] = 'USD';

//---後台使用系統選單---//
$modversion['system_menu'] = 1;

//---模組資料表架構---//
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'][1] = 'cnu_show_files_center';
$modversion['tables'][2] = 'cnu_show_kind';
$modversion['tables'][3] = 'cnu_show_prod';

//---後台管理介面設定---//
$modversion['hasAdmin']   = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu']  = 'admin/menu.php';

//---前台主選單設定---//
$modversion['hasMain'] = 1;
//$modversion['sub'][1]['name'] = '';
//$modversion['sub'][1]['url'] = '';

//---模組自動功能---//
$modversion['onInstall'] = "include/onInstall.php";
$modversion['onUpdate'] = "include/onUpdate.php";
$modversion['onUninstall'] = "include/onUninstall.php";

//---樣板設定---//
$modversion['templates']                    = array();
$i                                          = 1;
$modversion['templates'][$i]['file']        = 'cnu_show_adm_main.tpl';
$modversion['templates'][$i]['description'] = '後台管理頁樣板';

$i++;
$modversion['templates'][$i]['file']        = 'cnu_show_index.tpl';
$modversion['templates'][$i]['description'] = '模組首頁樣板';

$i++;
$modversion['templates'][$i]['file']        = 'cnu_show_adm_kind.tpl';
$modversion['templates'][$i]['description'] = '後台類別管理樣板';

//---偏好設定---//
$modversion['config'] = array();
//$i=0;
//$modversion['config'][$i]['name']    = '偏好設定名稱（英文）';
//$modversion['config'][$i]['title']    = '偏好設定標題（常數）';
//$modversion['config'][$i]['description']    = '偏好設定說明（常數）';
//$modversion['config'][$i]['formtype']    = '輸入表單類型';
//$modversion['config'][$i]['valuetype']    = '輸入值類型';
//$modversion['config'][$i]['default']    = 預設值;
//
//$i++;

//---搜尋---//
//$modversion['hasSearch'] = 1;
//$modversion['search']['file'] = "include/search.php";
//$modversion['search']['func'] = "搜尋函數名稱";

//---區塊設定---//
//$modversion['blocks'] = array();

# 商品類別
# block_id | title  
$i = 1;
$modversion['blocks'][$i]['file'] = 'cnu_show_b_kind_prod.php';
$modversion['blocks'][$i]['name'] = _MI_CNUSHOW_B_KIND_PROD;
$modversion['blocks'][$i]['description'] = _MI_CNUSHOW_B_KIND_PROD_DESC;
$modversion['blocks'][$i]['show_func'] = 'cnu_show_b_kind_prod';
$modversion['blocks'][$i]['template'] = 'cnu_show_b_kind_prod.tpl';
$modversion['blocks'][$i]['edit_func'] = 'cnu_show_b_kind_prod_edit';
$modversion['blocks'][$i]['options'] = "|" . _MI_CNUSHOW_B_KIND_PROD ;
//
//$i++;

//---評論---//
//$modversion['hasComments'] = 1;
//$modversion['comments']['pageName'] = '單一頁面.php';
//$modversion['comments']['itemName'] = '主編號';

//---通知---//
//$modversion['hasNotification'] = 1;