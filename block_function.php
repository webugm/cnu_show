<?php
define("_TAD_NEWS_ERROR_LEVEL",1);

//錯誤顯示方式
if(!function_exists("show_error")){
  function show_error($sql=""){
  	if(_TAD_NEWS_ERROR_LEVEL==1){
  		return web_error()."<p>$sql</p>";
  	}elseif(_TAD_NEWS_ERROR_LEVEL==2){
  		return web_error();
  	}elseif(_TAD_NEWS_ERROR_LEVEL==3){
  		return "sql error";
  	}
  	return;
  }
}

##################################
# 0. 取得主檔所有類別及數量
# 1. $tbl_main 主檔資料表
# 2. $tbl_kind 類別檔資料表
# 3. $admin 管理員
# 4. dtree.js -> (sn,ofsn,title,url)
##################################
function getAllMain0KindCount($tbl_main,$tbl_kind,$admin=0){
  global $xoopsDB;
  //---- 過濾資料 ------------------------*/
  $myts = &MyTextSanitizer::getInstance();
  $andKey = $admin ? "":" where a.enable='1' and b.enable='1'";
  
  #所有商品的類別
  $sql = "select b.sn,b.ofsn,b.title,count(*) as count 
          from ".$xoopsDB->prefix($tbl_main)." as a
          left join ".$xoopsDB->prefix($tbl_kind)." as b on a.kind = b.sn
          {$andKey} 
          group by a.`kind`
          order by b.ofsn,b.sort";//die($sql);
  $result = $xoopsDB->query($sql) or redirect_header(XOOPS_URL,3, web_error());
  while($row=$xoopsDB->fetchArray($result) ){
    //以下會產生這些變數： sn title  enable
    $row['sn']=intval($row['sn']);
    $row['ofsn']=intval($row['ofsn']);
    $row['count']=intval($row['count']);    
    $row['title'] = $myts->htmlSpecialChars($row['title']);
    $rows[] = $row;
  }
  return $rows;
} 

