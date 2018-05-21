<?php
/*-----------引入檔案區--------------*/
include_once "header.php";
$xoopsOption['template_main'] = "cnu_show_index.tpl";
include_once XOOPS_ROOT_PATH . "/header.php";


#引入上傳物件
include_once XOOPS_ROOT_PATH . "/modules/ugm_tools2/ugmUpFiles3.php";

/*-----------執行動作判斷區----------*/
include_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$op = system_CleanVars($_REQUEST, 'op', '', 'string');
$sn = system_CleanVars($_REQUEST, 'sn', '', 'int');
$kind = system_CleanVars($_REQUEST, 'kind', '', 'int');

switch ($op) {
  //顯示類別
  case "showKind":
    showKind($kind);
    break;

  
  case "opShow":
    opShow($sn);
    break;

  default:
    # ---- 目前網址 ----
    $_SESSION['return_url'] = getCurrentUrl();
    $op = "opList";
    opList();
    break;
}


#相容JQUERY
$ver = intval(str_replace('.', '', substr(XOOPS_VERSION, 6, 5)));
if ($ver >= 259) {
  $xoTheme->addScript('modules/tadtools/jquery/jquery-migrate-3.0.0.min.js');
} else {
  $xoTheme->addScript('modules/tadtools/jquery/jquery-migrate-1.4.1.min.js');
}

$xoTheme->addStylesheet(XOOPS_URL . "/modules/cnu_show/css/module.css");
$xoopsTpl->assign( "moduleMenu" , $moduleMenu) ;
$xoopsTpl->assign( "isAdmin" , $isAdmin) ;//interface_menu.php
$xoopsTpl->assign( "op" , $op) ;
#關閉左右區塊
//$xoopsTpl->assign( 'xoops_showlblock', 0 );
//$xoopsTpl->assign( 'xoops_showrblock', 0 );
/*-----------秀出結果區--------------*/
include_once XOOPS_ROOT_PATH . '/footer.php';

/*-----------function區--------------*/

#商品列表
function opList() {
  global $xoopsDB, $xoopsTpl,$module_name;
  #---- 過濾讀出的變數值 ----
  $myts = MyTextSanitizer::getInstance();

  $sql = "select a.sn,a.title,b.title as kind_title
          from      " . $xoopsDB->prefix("cnu_show_prod") . " as a
          left join " . $xoopsDB->prefix("cnu_show_kind") . " as b on a.kind=b.sn
          where a.enable='1'
          order by a.`sort` desc,a.`date` desc
          "; //die($sql);

  //getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
  $p_count = 9;
  $PageBar = getPageBar($sql, $p_count, 10);
  $bar = $PageBar['bar'];
  $sql = $PageBar['sql'];
  $total = $PageBar['total'];
  $bar = $total > $p_count ? $bar : "";
  $xoopsTpl->assign("bar", $bar);
  $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, web_error());
  #----單檔圖片上傳
  $subdir = "prod";                                      //子目錄(前後不要有 / )
  $ugmUpFiles = new ugmUpFiles($module_name, $subdir);   //實體化
  $col_name = "prod";                                    //資料表關鍵字 
  $thumb = false ;                                       //顯示縮圖
  $rows = array();
  while ($row = $xoopsDB->fetchArray($result)) {
    $row['sn'] = intval($row['sn']);
    $row['title'] = $myts->addSlashes($row['title']);
    $row['kind_title'] = $myts->addSlashes($row['kind_title']);
    $col_sn = $row['sn'];                                 //關鍵字流水號
    $row['prod'] = $ugmUpFiles->get_rowPicSingleUrl($col_name,$col_sn,$thumb);
    #-----------------------------------
    $rows[] = $row;
  }
  $main['rows'] = $rows;
  $main['title'] = "商品展示";
  $xoopsTpl->assign("main", $main);
}

#單筆顯示
function opShow($sn = "") {
  global $xoopsDB,$xoopsTpl,$module_name;
  if (!$sn) {
    redirect_header(XOOPS_URL, 3, "資料錯誤！！");
  }
  #---- 過濾讀出的變數值 ----
  $myts = MyTextSanitizer::getInstance();

  //sn  kind  kind_gallery  title summary content price amount  enable  date  sort
  $sql = "select a.*,b.title as kind_title
          from " . $xoopsDB->prefix("cnu_show_prod") . "      as a
          left join " . $xoopsDB->prefix("cnu_show_kind") . " as b on a.kind=b.sn
          where a.sn='{$sn}' and a.enable='1'
          "; //die($sql);

  $result = $xoopsDB->query($sql) or redirect_header(XOOPS_URL, 3, web_error());
  $row = $xoopsDB->fetchArray($result);
  #-----------------------------------------------------
  if (!$row) {
    redirect_header(XOOPS_URL, 3, "資料錯誤！！");
  }

  #計數器+1
  InsertCounteAddOne($row['sn'], "cnu_show_prod"); //ugm_tools2/ugmTools.php
  #-----------------------------------------------------

  //以下會產生這些變數：  a.sn,a.kind,a.title,a.url,a.content,b.file_name,b.sub_dir
  $row['sn'] = intval($row['sn']);
  $row['kind'] = intval($row['kind']);
  #一般文字
  $row['title'] = $myts->htmlSpecialChars($row['title']);
  $row['date'] = intval($row['date']);
  #日期
  $row['date'] = date("Y-m-d", xoops_getUserTimestamp($row['date'])); //從資料庫撈出
  $row['counter'] = intval($row['counter']);
  $row['kind_title'] = $myts->htmlSpecialChars($row['kind_title']);
  $row['youtube'] = $myts->htmlSpecialChars($row['youtube']);//大類名稱
  #大量文字，
  $html = 0;
  $br = 1;
  $row['summary'] = $myts->displayTarea($row['summary'], $html, 1, 0, 1, $br);
  #大量文字，編輯器
  $html = 1;
  $br = 0;
  $row['content'] = $myts->displayTarea($row['content'], $html, 1, 0, 1, $br);

  #----單檔圖片上傳
  $subdir = "prod";                                      //子目錄(前後不要有 / )
  $ugmUpFiles = new ugmUpFiles($module_name, $subdir);   //實體化
  $col_name = "prod";                                    //資料表關鍵字 
  $thumb = false ;                                       //顯示縮圖
  $col_sn = $row['sn'];                                 //關鍵字流水號
  $row['prod'] = $ugmUpFiles->get_rowPicSingleUrl($col_name,$col_sn,$thumb);

  #-----------------------------------------------------
  #型錄
  #上傳pdf型錄
  $multiple = false;
  $col_name = "prodPdf";
  $ugmUpFiles->set_col($col_name, $row['sn']);
  $row['pdf'] = $ugmUpFiles->get_rowFileSingleUrl($col_name, $row['sn']);
  #-----------------------------------------------------
  $xoopsTpl->assign("row", $row);
  #-----------------------------------------------------
}
#顯示類別底下的商品
function showKind($kind = "") {
  global $xoopsDB, $xoopsTpl,$module_name;
  if (!$kind) {
    redirect_header(XOOPS_URL, 3, "資料錯誤！！");
  }
  #---- 過濾讀出的變數值 ----
  $myts = MyTextSanitizer::getInstance();

  $sql = "select a.sn,a.title,b.title as kind_title
          from      " . $xoopsDB->prefix("cnu_show_prod") . " as a
          left join " . $xoopsDB->prefix("cnu_show_kind") . " as b on a.kind=b.sn
          where a.enable='1' and a.kind='{$kind}'
          order by a.`sort` desc,a.`date` desc
          "; //die($sql);

  //getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
  $p_count = 9;
  $PageBar = getPageBar($sql, $p_count, 10);
  $bar = $PageBar['bar'];
  $sql = $PageBar['sql'];
  $total = $PageBar['total'];
  $bar = $total > $p_count ? $bar : "";
  $xoopsTpl->assign("bar", $bar);
  $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, web_error());
  #----單檔圖片上傳
  $subdir = "prod";                                      //子目錄(前後不要有 / )
  $ugmUpFiles = new ugmUpFiles($module_name, $subdir);   //實體化
  $col_name = "prod";                                    //資料表關鍵字 
  $thumb = false ;                                       //顯示縮圖
  $rows = array();
  while ($row = $xoopsDB->fetchArray($result)) {
    $row['sn'] = intval($row['sn']);
    $row['title'] = $myts->addSlashes($row['title']);
    $row['kind_title'] = $myts->addSlashes($row['kind_title']);
    $col_sn = $row['sn'];                                 //關鍵字流水號
    $row['prod'] = $ugmUpFiles->get_rowPicSingleUrl($col_name,$col_sn,$thumb);
    #-----------------------------------
    $rows[] = $row;
    $main['title'] = $row['kind_title'];
  }

  $main['rows'] = $rows;
  $xoopsTpl->assign("main", $main);
}