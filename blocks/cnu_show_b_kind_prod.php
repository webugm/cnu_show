<?php
//區塊主函式 (cnu_show_b_kind_prod)
include_once XOOPS_ROOT_PATH."/modules/cnu_show/block_function.php"; 
function cnu_show_b_kind_prod($options) {
	global $xoopsDB;
	//---- 過濾資料 ----------------------*/
	$myts = &MyTextSanitizer::getInstance();
	#區塊id
	$options[0] = intval($options[0]);
	#區塊標題
	$options[1] = $myts->addSlashes($options[1]);

	#----------------------------------------------------	
	#Array ( [sn] => 1 [ofsn] => 0 [title] => 商品類別1 [count] => 1 )
	$tbl_main="cnu_show_prod";
	$tbl_kind="cnu_show_kind";
	$rows=getAllMain0KindCount($tbl_main,$tbl_kind);
	#----------------------------------------------------	
	$block['options'] = $options;
	$block['rows'] = $rows;
	return $block;
}

//區塊編輯函式 (cnu_show_b_kind_prod_edit)
function cnu_show_b_kind_prod_edit($options) {
	global $xoopsDB;
	$options[0] = intval($_GET['bid']); //block.id

	$form = "
    <style>
      .block_edit tr{height:30px;}
      .block_edit td{vertical-align: middle;}
    </style>
    <table style='width:auto;' class='block_edit'>
      <tr>
        <th>1</th>
        <th>Block ID</th>
        <td>{$options[0]}<input type='hidden' name='options[0]' value='{$options[0]}'></td>
        <td style='vertical-align: middle;'>系統自行取得，複製區塊後，請執行編輯區塊！！</td>
      </tr>
      <tr>
        <th>2</th>
        <th>區塊標題</th>
        <td><input type='text' name='options[1]' value='{$options[1]}' size=12></td>
        <td style='vertical-align: middle;'>區塊標題</td>
      </tr>
    </table>
  ";
	return $form;
}