<?php
/*-----------引入檔案區--------------*/
$xoopsOption['template_main'] = "cnu_show_adm_main.tpl";
include_once "header.php";
include_once "../function.php";

# 模組 目錄
$module_name = $xoopsModule->dirname();
#強制關除錯
//ugm_module_debug_mode(0);
#引入類別物件---------------------------------
include_once XOOPS_ROOT_PATH . "/modules/ugm_tools2/ugmKind3.php";
#引入上傳物件
include_once XOOPS_ROOT_PATH . "/modules/ugm_tools2/ugmUpFiles3.php";


#實體化 類別物件
$stopLevel = 2; //層數
#(模組名稱,關鍵字，層數)
$kindKey = "kind_prod";
$ugmKind = new ugmKind($module_name,$kindKey,$stopLevel);
# 如果資料表非預設 請自行設定


/*-----------執行動作判斷區----------*/
include_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$op = system_CleanVars($_REQUEST, 'op', '', 'string');
$sn = system_CleanVars($_REQUEST, 'sn', '', 'int');
$kind = system_CleanVars($_REQUEST, 'kind', '', 'int');

switch ($op) {
  #---- 商品表單
  case "opForm":
    ugm_module_debug_mode(0);
    opForm($sn);
    break;

  #---- 新增商品資料
  case "opInsert":
    $sn = opInsert();
    XoopsCache::clear();
    redirect_header($_SESSION['return_url'], 3, _BP_SUCCESS);
    exit;

  #---- 編輯商品資料
  case "opUpdate":
    $sn = opUpdate($sn);
    XoopsCache::clear();
    redirect_header($_SESSION['return_url'], 3, _BP_SUCCESS);
    exit;

  #---- 複製商品資料
  case "opCopy":
    opCopy($sn);
    XoopsCache::clear();
    redirect_header($_SESSION['return_url'], 3, "複製成功！！");
    exit;

  #---- 刪除商品資料
  case "opDelete":
    opDelete($sn);
    XoopsCache::clear();
    redirect_header($_SESSION['return_url'], 3, _BP_DEL_SUCCESS);
    exit;

  #---- 更新商品狀態 ----
  case "opUpdateEnable":
    opUpdateEnable();
    XoopsCache::clear();
    redirect_header($_SESSION['return_url'], 3, _BP_SUCCESS);
    exit;

  #---- 更新精選狀態 ----
  case "opUpdateChoice":
    opUpdateChoice();
    XoopsCache::clear();
    redirect_header($_SESSION['return_url'], 3, _BP_SUCCESS);
    exit;


  #---- 商品排序
  case "opSort":
    opSort();
    break;

  case "opUpdateSort": //更新排序
    #強制關除錯
    ugm_module_debug_mode(0);
    echo opUpdateSort();
    exit;


  default:
    # ---- 目前網址 ----
    $_SESSION['return_url'] = getCurrentUrl();
    $op = "opList";
    opList();
    break;
}

/*-----------秀出結果區--------------*/
#CSS
$xoTheme->addStylesheet(XOOPS_URL . "/modules/cnu_show/css/xoops_adm.css");
$xoTheme->addStylesheet(XOOPS_URL . "/modules/cnu_show/css/forms.css");
$xoTheme->addStylesheet(XOOPS_URL . "/modules/cnu_show/css/module.css");
$xoopsTpl->assign("op", $op);

#相容舊版jquery
$ver = intval(str_replace('.', '', substr(XOOPS_VERSION, 6, 5)));
if ($ver >= 259){
  $xoTheme->addScript('modules/tadtools/jquery/jquery-migrate-3.0.0.min.js');
}else{
  $xoTheme->addScript('modules/tadtools/jquery/jquery-migrate-1.4.1.min.js');
}

$xoopsTpl->assign("labelTitle", _MD_CNUSHOW_PROD);

include_once 'footer.php';


/*-----------function區--------------*/

####################################################
#  列表
####################################################
function opList() {
  global $xoopsDB, $xoopsTpl, $module_name, $kind, $ugmKind;
  #---- 過濾讀出的變數值 ----
  $myts = MyTextSanitizer::getInstance();

  # ----得到ForeignKeyMainOption選項 ---------------------------- 
  $ForeignKeyMainOption = $ugmKind->get_kindOption($kind);
  $ForeignKeyForm = "
    <div class='row' style='margin-bottom:5px;'>
      <div class='col-sm-3'>
        <select name='kind' id='kind' onchange=\"location.href='?kind='+this.value\"  class='form-control'>
          <option value=''>" . _MD_UGMMODULE_ALL . "</option>\n
          $ForeignKeyMainOption
        </select>
      </div>
    </div>
  ";
  $xoopsTpl->assign('ForeignKeyForm', $ForeignKeyForm);
  $xoopsTpl->assign('kind', $kind);

  #身體array
  $and_key = $kind ? " where a.kind='{$kind}'" : "";

  //sn  kind  kind_gallery  title summary content price amount  enable  date  sort
  $sql = "select a.*,b.title as kind_title
          from " . $xoopsDB->prefix("cnu_show_prod") . " as a
          left join " . $xoopsDB->prefix("cnu_show_kind") . " as b on a.kind=b.sn
          {$and_key}
          order by a.sort desc,a.date desc"; //die($sql);

  //getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
  $p_count = 20;
  $PageBar = getPageBar($sql, $p_count, 10);
  $bar = $PageBar['bar'];
  $sql = $PageBar['sql'];
  $total = $PageBar['total'];
  $bar = $total > $p_count ? $bar : "";
  $xoopsTpl->assign("bar", $bar);

  $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, web_error());
  $rows = array();

  #----單檔圖片上傳
  $subdir = "prod";                                      //子目錄(前後不要有 / )
  $ugmUpFiles = new ugmUpFiles($module_name, $subdir);   //實體化
  $col_name = "prod";                                    //資料表關鍵字 
  $thumb = false ;                                       //顯示縮圖                         
  while ($row = $xoopsDB->fetchArray($result)) {
    $row['sn'] = intval($row['sn']);
    #一般文字
    $row['title'] = $myts->htmlSpecialChars($row['title']);
    $row['enable'] = intval($row['enable']);
    $row['choice'] = intval($row['choice']);
    $row['price'] = intval($row['price']);
    $row['date'] = intval($row['date']);
    $row['kind_title'] = $myts->htmlSpecialChars($row['kind_title']);
    #日期
    $row['date'] = date("Y-m-d", xoops_getUserTimestamp($row['date'])); //從資料庫撈出
    
    $col_sn = $row['sn'];                                 //關鍵字流水號
    $row['prod'] = $ugmUpFiles->get_rowPicSingleUrl($col_name,$col_sn,$thumb);
    #-----------------------------------
    if($row['prod']){       
      $row['prod'] = "<a href='{$row['prod']}' class='showImg'><img src='{$row['prod']}' style='width:50px;' class='img-responsive center-block'></a>";
    }
    $rows[] = $row;
  }

  # ---- fancybox_code ----
  if (!file_exists(XOOPS_ROOT_PATH . "/modules/tadtools/fancybox.php")) {
    redirect_header("index.php", 3, _MA_NEED_TADTOOLS);
  }
  include_once XOOPS_ROOT_PATH . "/modules/tadtools/fancybox.php";
  $fancybox = new fancybox('.showImg', '90%', '90%');
  $reload = false;
  $fancybox->render($reload);

  #刪除-------------------------------------------------------
  if (!file_exists(XOOPS_ROOT_PATH . "/modules/tadtools/sweet_alert.php")) {
    redirect_header("index.php", 3, _MA_NEED_TADTOOLS);
  }
  include_once XOOPS_ROOT_PATH . "/modules/tadtools/sweet_alert.php";
  $sweet_alert_obj = new sweet_alert();
  $sweet_alert_obj->render('op_delete_js', "?op=opDelete&sn=", "sn");
  # ------------------------------------------------------------
  $xoopsTpl->assign("rows", $rows);
}

########################################
#  函數說明
#  外部變數請用參數傳值方式或global
########################################
function opForm($sn = "") {
  global $xoopsDB,$xoopsTpl,$module_name,$ugmKind,$xoTheme;
  //----------------------------------*/
  //抓取預設值
  if (!empty($sn)) {
    $row = get_ugm_module_tbl($sn, "cnu_show_prod");//取得某筆記錄資料
    $pre = _EDIT;
    $row['op'] = "opUpdate";//在表單中表示接下來流程
  } else {
    $row = array();
    $pre = _ADD;
    $row['op'] = "opInsert";//在表單中表示接下來流程
  }
  $row['form_title'] = $pre . _MD_CNUSHOW_PROD;

  //預設值設定
  $row['sn'] = (!isset($row['sn'])) ? "" : $row['sn'];
  $row['kind'] = (!isset($row['kind'])) ? "" : $row['kind'];
  $row['kind_option'] = $ugmKind->get_kindOption($row['kind']);
  $row['title'] = (!isset($row['title'])) ? "" : $row['title'];
  $row['youtube'] = (!isset($row['youtube'])) ? "" : $row['youtube'];
  $row['summary'] = (!isset($row['summary'])) ? "" : $row['summary'];
  $row['price'] = (!isset($row['price'])) ? "" : $row['price'];
  #排序,新增取得最大排序，編輯則按資料庫決定
  $row['sort'] = (!isset($row['sort'])) ? get_ugm_module_max_sort("sort", "cnu_show_prod"):$row['sort'];
  //$row['amount'] = (!isset($row['amount'])) ? "" : $row['amount'];
  $row['choice'] = (!isset($row['choice'])) ? "0" : $row['choice'];
  $row['enable'] = (!isset($row['enable'])) ? "1" : $row['enable'];
  $row['date'] = !isset($row['date']) ? date("Y-m-d H:i:s", xoops_getUserTimestamp(strtotime("now"))) : date("Y-m-d H:i:s", xoops_getUserTimestamp($row['date']));
  //strtotime("now")：為目前主機的時間磋記，xoops_getUserTimestamp(strtotime("now")))：將時間磋記改為會員的時間磋記
  $row['content'] = (!isset($row['content'])) ? "" : $row['content'];
  //內容#資料放「content」
  # ======= ckedit====
  //$UserPtah="config"
  if (!file_exists(XOOPS_ROOT_PATH . "/modules/tadtools/ck.php")) {
    redirect_header("http://www.tad0616.net/modules/tad_uploader/index.php?of_cat_sn=50", 3, _TAD_NEED_TADTOOLS);
  }
  include_once XOOPS_ROOT_PATH . "/modules/tadtools/ck.php";

  #---- 檢查資料夾
  mk_dir(XOOPS_ROOT_PATH . "/uploads/{$module_name}/fck");
  mk_dir(XOOPS_ROOT_PATH . "/uploads/{$module_name}/fck/image");
  mk_dir(XOOPS_ROOT_PATH . "/uploads/{$module_name}/fck/flash");
  $dir_name = $module_name . "/fck";
  #----
  $ck = new CKEditor($dir_name, "content", $row['content'], $module_name);
  $ck->setHeight(300);
  $row['content_editor'] = $ck->render();
  #-------------------------------------

  #上傳單張圖片
  #----單檔圖片上傳
  $subdir = "prod";                                   //子目錄(前後不要有 / )
  $ugmUpFiles = new ugmUpFiles($module_name, $subdir);//實體化 

  $name = "prod";                                     //表單欄位名稱
  $col_name = "prod";                                 //資料表關鍵字
  $col_sn = $row['sn'];                              //關鍵字流水號
  $multiple = false;                                 //單檔 or 多檔上傳
  $accept = "image/*";                               //可接受副檔名

  $row['prod'] = $ugmUpFiles->upform($name,$col_name,$col_sn,$multiple,$accept);
  #-----------------------------------  
  #上傳pdf型錄
  $subdir = "prod";                                   //子目錄(前後不要有 / )
  $ugmUpFiles = new ugmUpFiles($module_name, $subdir);//實體化 

  $name = "prodPdf";                                  //表單欄位名稱
  $col_name = "prodPdf";                              //資料表關鍵字
  $col_sn = $row['sn'];                               //關鍵字流水號
  $multiple = false;                                  //單檔 or 多檔上傳
  $accept = "application/pdf";                        //可接受副檔名

  $row['prodPdf'] = $ugmUpFiles->upform($name,$col_name,$col_sn,$multiple,$accept);
  //-------------------------------*/
  
  //----- 驗證碼 -----------------*/
  if (!file_exists(XOOPS_ROOT_PATH . "/modules/tadtools/formValidator.php")) {
    redirect_header("index.php", 3, _TAD_NEED_TADTOOLS);
  }
  include_once XOOPS_ROOT_PATH . "/modules/tadtools/formValidator.php";
  $formValidator = new formValidator("#myForm", true);
  $formValidator_code = $formValidator->render();
  //-------------------------------*/
  #小月曆
  $xoTheme->addScript('modules/tadtools/My97DatePicker/WdatePicker.js');
  $xoopsTpl->assign('row', $row);
}
########################################
#  新增、編輯資料
########################################
function opInsert() {
  global $xoopsDB,$xoopsUser,$module_name,$xoopsModuleConfig;
  //---- 過濾資料 -----------------------------------------*/
  $myts = &MyTextSanitizer::getInstance();

  #標題
  $_POST['title'] = $myts->addSlashes($_POST['title']);
  #youtube id
  $_POST['youtube'] = $myts->addSlashes($_POST['youtube']);
  #商品類別
  $_POST['kind'] = intval($_POST['kind']);
  #日期
  $_POST['date'] = userTimeToServerTime(strtotime($myts->addSlashes($_POST['date'])));
  #狀態
  $_POST['enable'] = intval($_POST['enable']);
  #精選
  $_POST['choice'] = intval($_POST['choice']);
  #排序
  $_POST['sort'] = intval($_POST['sort']);
  #單位
  $_POST['unit'] = $myts->addSlashes($_POST['unit']);
  #規格
  $_POST['standard'] = $myts->addSlashes($_POST['standard']);
  #尺寸
  $_POST['size'] = $myts->addSlashes($_POST['size']);
  #內容
  $_POST['content'] = $myts->addSlashes($_POST['content']);
  #摘要
  $_POST['summary'] = $myts->addSlashes($_POST['summary']); 
  #sn
  $_POST['sn'] = intval($_POST['sn']);
  #價格
  //$_POST['price'] = intval($_POST['price']);
  #數量
  //$_POST['amount'] = intval($_POST['amount']);

  //print_r($_POST);die();
  //-------------------------------------------------------*/

  $sql = "insert into " . $xoopsDB->prefix("cnu_show_prod") . "
  (`title`,`youtube`,`kind`,`date`,`enable`,`choice`,`sort`,`unit`,`standard`,`size`,`content`,`summary`)
  values
  ('{$_POST['title']}','{$_POST['youtube']}','{$_POST['kind']}','{$_POST['date']}','{$_POST['enable']}','{$_POST['choice']}','{$_POST['sort']}','{$_POST['unit']}','{$_POST['standard']}','{$_POST['size']}','{$_POST['content']}','{$_POST['summary']}')";
  $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'], 3, web_error());
  //取得最後新增資料的流水編號
  $_POST['sn'] = $xoopsDB->getInsertId();

  #處理圖片
  
  #----單圖上傳  
  $subdir = "prod";                                      //子目錄(前後不要有 / )
  $ugmUpFiles = new ugmUpFiles($module_name, $subdir);   //實體化
  
  $name = "prod";                                        //表單欄位名稱
  $col_name = "prod";                                    //資料表關鍵字
  $col_sn = $_POST['sn'];                                //關鍵字流水號
  $multiple = false;                                     //單檔 or 多檔上傳
  $main_width = 840;                                     //大圖壓縮尺吋，-1則不壓縮
  $thumb_width = 120;                                    //小圖壓縮尺吋
  $ugmUpFiles->upload_file($name,$col_name,$col_sn,$multiple,$main_width,$thumb_width);
  #------------------------------------------------

  #上傳pdf型錄  
  #---- 
  $subdir = "prod";                                      //子目錄(前後不要有 / )
  $ugmUpFiles = new ugmUpFiles($module_name, $subdir);   //實體化
  
  $name = "prodPdf";                                     //表單欄位名稱
  $col_name = "prodPdf";                                 //資料表關鍵字
  $col_sn = $_POST['sn'];                                //關鍵字流水號
  $multiple = false;                                     //單檔 or 多檔上傳
  $main_width = "";                                      //大圖壓縮尺吋，-1則不壓縮
  $thumb_width = "";                                     //小圖壓縮尺吋
  $ugmUpFiles->upload_file($name,$col_name,$col_sn,$multiple,$main_width,$thumb_width);

  return $_POST['sn'];
}

########################################
#  編輯資料
########################################
function opUpdate($sn = "") {
  global $xoopsDB, $xoopsUser,$module_name,$xoopsModuleConfig;
  //---- 過濾資料 -----------------------------------------*/
  $myts = &MyTextSanitizer::getInstance();
  #標題
  $_POST['title'] = $myts->addSlashes($_POST['title']);
  #youtube id
  $_POST['youtube'] = $myts->addSlashes($_POST['youtube']);
  #日期
  $_POST['date'] = userTimeToServerTime(strtotime($myts->addSlashes($_POST['date'])));//把時間改為主機時間搓記
  #精選
  $_POST['choice'] = intval($_POST['choice']);
  #狀態
  $_POST['enable'] = intval($_POST['enable']);
  #商品類別
  $_POST['kind'] = intval($_POST['kind']);
  #排序
  $_POST['sort'] = intval($_POST['sort']);
  #單位
  $_POST['unit'] = $myts->addSlashes($_POST['unit']);
  #規格
  $_POST['standard'] = $myts->addSlashes($_POST['standard']);
  #尺寸
  $_POST['size'] = $myts->addSlashes($_POST['size']);
  #價格
  //$_POST['price'] = intval($_POST['price']);
  #數量
  //$_POST['amount'] = intval($_POST['amount']);
  #內容
  $_POST['content'] = $myts->addSlashes($_POST['content']);
  #摘要
  $_POST['summary'] = $myts->addSlashes($_POST['summary']);
  #sn
  $_POST['sn'] = intval($_POST['sn']);

  //print_r($_POST);die();
  //-------------------------------------------------------*/

  $sql = "update " . $xoopsDB->prefix("cnu_show_prod") . "
          set
          `title`='{$_POST['title']}',
          `date`='{$_POST['date']}',
          `choice`='{$_POST['choice']}',
          `enable`='{$_POST['enable']}',
          `kind`='{$_POST['kind']}',
          `content`='{$_POST['content']}',
          `summary`='{$_POST['summary']}',
          `sort`='{$_POST['sort']}',
          `unit`='{$_POST['unit']}', 
          `standard`='{$_POST['standard']}', 
          `size`='{$_POST['size']}',                
          `youtube`='{$_POST['youtube']}'
          where `sn`='{$_POST['sn']}'"; //die($sql);
  $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'], 3, web_error());

 
  #處理圖片
  
  #----單圖上傳  
  $subdir = "prod";                                      //子目錄(前後不要有 / )
  $ugmUpFiles = new ugmUpFiles($module_name, $subdir);   //實體化
  
  $name = "prod";                                        //表單欄位名稱
  $col_name = "prod";                                    //資料表關鍵字
  $col_sn = $_POST['sn'];                                //關鍵字流水號
  $multiple = false;                                     //單檔 or 多檔上傳
  $main_width = 840;                                     //大圖壓縮尺吋，-1則不壓縮
  $thumb_width = 120;                                    //小圖壓縮尺吋
  $ugmUpFiles->upload_file($name,$col_name,$col_sn,$multiple,$main_width,$thumb_width);
  #------------------------------------------------

  #上傳pdf型錄  
  #---- 
  $subdir = "prod";                                      //子目錄(前後不要有 / )
  $ugmUpFiles = new ugmUpFiles($module_name, $subdir);   //實體化
  
  $name = "prodPdf";                                     //表單欄位名稱
  $col_name = "prodPdf";                                 //資料表關鍵字
  $col_sn = $_POST['sn'];                                //關鍵字流水號
  $multiple = false;                                     //單檔 or 多檔上傳
  $main_width = "";                                      //大圖壓縮尺吋，-1則不壓縮
  $thumb_width = "";                                     //小圖壓縮尺吋
  $ugmUpFiles->upload_file($name,$col_name,$col_sn,$multiple,$main_width,$thumb_width);

  return $_POST['sn'];
}

########################################
#  複製商品資料
########################################
function opCopy($sn = "") {
  global $xoopsDB, $xoopsTpl, $module_name, $ugmKind, $xoTheme;
  #強制關除錯
  //ugm_module_debug_mode(0);
  //----------------------------------*/
  #得到商品資料
  $row = get_ugm_module_tbl($sn, "cnu_show_prod");
  $row['date'] = strtotime("now");
  $row['enable'] = 1;
  if($row['sn']){
    #複寫商品資料
    $sql = "insert into " . $xoopsDB->prefix("cnu_show_prod") . "
    (`title`,`youtube`,`kind`,`date`,`enable`,`choice`,`sort`,`unit`,`standard`,`size`,`content`,`summary`)
    values
    ('{$row['title']}','{$row['youtube']}','{$row['kind']}','{$row['date']}','{$row['enable']}','{$row['choice']}','{$row['sort']}','{$row['unit']}','{$row['standard']}','{$row['size']}','{$row['content']}','{$row['summary']}')";

    $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'], 3, web_error());
    //取得最後新增資料的流水編號
    $copy_sn = $xoopsDB->getInsertId();
    
    #複製圖片   
    $col_name = "prod"; 
    $sql = "select *
            from " . $xoopsDB->prefix("cnu_show_files_center") . "
            where col_name='{$col_name}' and col_sn='{$sn}'"; //die($sql);
    $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, web_error());
    $row = $xoopsDB->fetchArray($result);
    
    #檢查是否有圖檔
    if($row['files_sn']){
      #寫入資料庫
      
      $ext = $row['file_type'] == "image/png" ? "png" :"jpg";
      $file_name = "prod_{$copy_sn}_1.{$ext}";

      $sql = "insert into " . $xoopsDB->prefix("cnu_show_files_center") . "
      (`col_name` , `col_sn` ,`sort` ,`kind` , `file_name`,`file_type`,`file_size`,`description`,`counter`,`original_filename`,`hash_filename`,`sub_dir`)
      values
      ('{$row['col_name']}' ,'{$copy_sn}' ,'{$row['sort']}' , '{$row['kind']}','{$file_name}' ,'{$row['file_type']}','{$row['file_size']}','{$row['description']}',0,'{$row['original_filename']}','{$row['hash_filename']}','{$row['sub_dir']}')";//die($sql);
      $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'], 3, web_error());
      //取得最後新增資料的流水編號
      //$pic_sn = $xoopsDB->getInsertId();;
      #複製實體檔案
      copy(XOOPS_ROOT_PATH."/uploads/{$module_name}/prod/{$row['file_name']}", XOOPS_ROOT_PATH."/uploads/{$module_name}/prod/{$file_name}");

      copy(XOOPS_ROOT_PATH."/uploads/{$module_name}/prod/thumbs/{$row['file_name']}", XOOPS_ROOT_PATH."/uploads/{$module_name}/prod/thumbs/{$file_name}");


    } 
    #複製pdf    
    $col_name = "prodPdf"; 
    $sql = "select *
            from " . $xoopsDB->prefix("cnu_show_files_center") . "
            where col_name='{$col_name}' and col_sn='{$sn}'"; //die($sql);
    $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, web_error());
    $row = $xoopsDB->fetchArray($result);
    if($row['files_sn']){
      #寫入資料庫      
      $file_name = "prodPdf_{$copy_sn}_1.pdf";

      $sql = "insert into " . $xoopsDB->prefix("cnu_show_files_center") . "
      (`col_name` , `col_sn` ,`sort` ,`kind` , `file_name`,`file_type`,`file_size`,`description`,`counter`,`original_filename`,`hash_filename`,`sub_dir`)
      values
      ('{$row['col_name']}' ,'{$copy_sn}' ,'{$row['sort']}' , '{$row['kind']}','{$file_name}' ,'{$row['file_type']}','{$row['file_size']}','{$row['description']}',0,'{$row['original_filename']}','{$row['hash_filename']}','{$row['sub_dir']}')";
      $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'], 3, web_error());
      //取得最後新增資料的流水編號
      $pdf_sn = $xoopsDB->getInsertId();
      
      #複製實體檔案
      if (copy(XOOPS_ROOT_PATH."/uploads/{$module_name}/prod/file/{$row['file_name']}", XOOPS_ROOT_PATH."/uploads/{$module_name}/prod/file/{$file_name}")) {
          // 檔案複製成功
      } else {
          // 檔案複製失敗
      }
    }


  }else{    
    redirect_header($_SESSION['return_url'], 3, "複製商品失敗");
  }
  return;

}

#########################################
#  刪除資料
#########################################
function opDelete($sn = "") {
  global $xoopsDB, $module_name;
  if (empty($sn)) {
    redirect_header($_SESSION['return_url'], 3, _BP_DEL_ERROR);
  }

  #檢查
  $sql = "delete from " . $xoopsDB->prefix("cnu_show_prod") . "
          where sn='{$sn}'"; //die($sql);
  $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'], 3, web_error());

  #----單圖上傳  
  $subdir = "prod";                                      //子目錄(前後不要有 / )
  $ugmUpFiles = new ugmUpFiles($module_name, $subdir);   //實體化
  $col_name = "prod";
  $ugmUpFiles->set_col($col_name, $sn);
  $ugmUpFiles->del_files();

  #商品型錄
  $col_name = "prodPdf";                                  
  $ugmUpFiles->set_col($col_name, $sn);
  $ugmUpFiles->del_files();
}

#########################################
#  更新商品狀態
#########################################
function opUpdateEnable() {
  global $xoopsDB;
  #權限
  /***************************** 過瀘資料 *************************/
  $enable = intval($_GET['enable']);
  $sn = intval($_GET['sn']);
  /****************************************************************/
  //更新
  $sql = "update " . $xoopsDB->prefix("cnu_show_prod") . " set  `enable` = '{$enable}' where `sn`='{$sn}'";
  $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'], 3, web_error());
  return;
}

#########################################
#  更新精選狀態
#########################################
function opUpdateChoice() {
  global $xoopsDB;
  #權限
  /***************************** 過瀘資料 *************************/
  $choice = intval($_GET['choice']);
  $sn = intval($_GET['sn']);
  /****************************************************************/
  //更新
  $sql = "update " . $xoopsDB->prefix("cnu_show_prod") . " set  `choice` = '{$choice}' where `sn`='{$sn}'";
  $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'], 3, web_error());
  return;
}

########################################
#  列表
########################################
function opSort() {
  global $xoopsDB, $xoopsTpl, $module_name, $kind, $ugmKind;

  #---- 過濾讀出的變數值 ----
  $myts = MyTextSanitizer::getInstance();

  $sql = "select a.sn,a.title,a.enable,a.choice,a.date,a.sort
          from " . $xoopsDB->prefix("cnu_show_prod") . " as a
          order by a.sort desc,a.date desc"; //die($sql);

  $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, web_error());
  $rows = array();

  #----單檔圖片上傳
  $subdir = "prod";                                      //子目錄(前後不要有 / )
  $ugmUpFiles = new ugmUpFiles($module_name, $subdir);   //實體化
  $col_name = "prod";                                    //資料表關鍵字 
  $thumb = true ;                                        //顯示縮圖  
  while ($row = $xoopsDB->fetchArray($result)) {
    $row['sn'] = intval($row['sn']);
    $row['title'] = $myts->htmlSpecialChars($row['title']);
    $row['sort'] = intval($row['sort']);
    $row['enable'] = intval($row['enable']);
    $row['choice'] = intval($row['choice']);
    #日期
    $row['date'] = intval($row['date']);
    $row['date'] = date("Y-m-d", xoops_getUserTimestamp($row['date'])); //從資料庫撈出

    $col_sn = $row['sn'];                                 //關鍵字流水號
    $row['prod'] = $ugmUpFiles->get_rowPicSingleUrl($col_name,$col_sn,$thumb);
    #-----------------------------------
    if($row['prod']){       
      $row['prod'] = "<img src='{$row['prod']}' style='width:50px;' class='img-responsive center-block'>";
    }
    $rows[] = $row;
  }
  $xoopsTpl->assign("rows", $rows);
  #-----拖曳排序 -------------------------
  get_jquery(true);
  #---------------------------------------
}


########################################
#  自動更新排序ajax
########################################
function opUpdateSort() {
  global $xoopsDB;
  $sort = getTblRow("cnu_show_prod");
  $msg="";
  foreach ($_POST['tr'] as $sn) {
    if (!$sn) {
      continue;
    }
    $sql = "update " . $xoopsDB->prefix("cnu_show_prod") . " set `sort`='{$sort}' where `sn`='{$sn}'";
    if(!$xoopsDB->queryF($sql)){
      $msg[]=$sn;
    } 
    $sort--;
  }
  if(!$msg){
    return true;
  }
  return false; 
}

#
function getTblRow($tbl){
  global $xoopsDB;
  $sql="select count(*) as count from ".$xoopsDB->prefix($tbl);//die($sql);
  $result=$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, web_error());
  $row = $xoopsDB->fetchArray($result);
  return $row['count'];
}
