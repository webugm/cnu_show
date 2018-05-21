<!-- 後台 program head -->
<div class="CPbigTitle" style="background-image: url(<{xoAppUrl /modules/ugm_tools2/images/admin/button.png}>); background-repeat: no-repeat; background-position: left; padding-left: 50px;margin-bottom: 20px;">
  <strong><{$labelTitle}></strong>
</div> 

<{if $op == "opForm"}>	
  <div class='container-fluid'>
    <div class="panel panel-primary">
      <div class="panel-heading"><h3 class="panel-title"><{$row.form_title}></h3></div>
      <div class="panel-body">
        <form role="form" action="main.php" method="post" id="myForm" enctype="multipart/form-data">
          <div class="row">
            <div class="col-sm-8">
              <div class="row">
                <!--標題-->              
                <div class="col-sm-8">
                  <div class="form-group">
                    <label><{$smarty.const._MD_UGMMODULE_TITLE}></label>
                    <input type="text" class="form-control validate[required]" name="title" id="title" value="<{$row.title}>">
                  </div>
                </div>
                <!--標題-->              
                <div class="col-sm-4">
                  <div class="form-group">
                    <label>YOUTUBE ID</label>
                    <input type="text" class="form-control" name="youtube" id="youtube" value="<{$row.youtube}>">
                  </div>
                </div>
              </div>
              <div class="row">
                <!--類別-->
                <div class="col-sm-4">
                  <div class="form-group">
                    <label><{$smarty.const._MD_UGMMODULE_KIND}></label>
                    <select name="kind" class="form-control" size="1">
                      <{$row.kind_option}>
                    </select>
                  </div>
                </div>
                <!--日期-->
                <div class="col-sm-4">
                  <div class="form-group">
                    <label><{$smarty.const._MD_UGMMODULE_DATE}></label>
                    <input type="text" name="date" id="date" class="form-control " value="<{$row.date}>" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss' , startDate:'%y-%M-%d %H:%m:%s'})">
                  </div>
                </div>

                <!--狀態-->
                <div class="col-sm-2">
                  <div class="form-group">
                    <label style="display:block;"><{$smarty.const._MD_UGMMODULE_ENABLE}></label>
                    <input type='radio' name='enable' id='enable_1' value='1' <{if  $row.enable==1}>checked<{/if}>>
                    <label for='enable_1'><{$smarty.const._MD_UGMMODULE_ENABLE_1}></label>&nbsp;&nbsp;
                    <input type='radio' name='enable' id='enable_0' value='0' <{if $row.enable==0}>checked<{/if}>>
                    <label for='enable_0'><{$smarty.const._MD_UGMMODULE_ENABLE_0}></label>
                  </div>
                </div>        

                <!--精選-->              
                <div class="col-sm-2">
                  <div class="form-group">
                    <label style="display:block;"><{$smarty.const._MD_UGMMODULE_CHOICE}></label>
                    <input type='radio' name='choice' id='choice_1' value='1' <{if  $row.choice==1}>checked<{/if}>>
                    <label for='choice_1'><{$smarty.const._MD_UGMMODULE_ENABLE_1}></label>&nbsp;&nbsp;
                    <input type='radio' name='choice' id='choice_0' value='0' <{if $row.choice==0}>checked<{/if}>>
                    <label for='choice_0'><{$smarty.const._MD_UGMMODULE_ENABLE_0}></label>
                  </div>
                </div>
                
              </div>
              <div class="row">                  

                <!--圖片-->  
                <div class="col-sm-4">
                  <div class="form-group">
                    <label><{$smarty.const._MD_UGMMODULE_PIC}><span>(840x840)</span></label>
                    <{$row.prod}>
                  </div>
                </div>                 

                <!--PDF-->  
                <div class="col-sm-4">
                  <div class="form-group">
                    <label>PDF</label>
                    <{$row.prodPdf}>
                  </div>
                </div>                

                <!--排序-->  
                <div class="col-sm-2">
                  <div class="form-group">
                    <label><{$smarty.const._MD_UGMMODULE_SORT}></label>
                    <input type="text" class="form-control text-right" name="sort" id="sort" value="<{$row.sort}>" >
                  </div>
                </div>

                <!--單位-->  
                <div class="col-sm-2">
                  <div class="form-group">
                    <label><{$smarty.const._MD_UGMMODULE_UNIT}></label>
                    <input type="text" class="form-control" name="unit" id="unit" value="<{$row.unit}>" >
                  </div>
                </div>           

              </div>
              <div class="row">
                <!--規格-->              
                <div class="col-sm-6">
                  <div class="form-group">
                    <label><{$smarty.const._MD_UGMMODULE_STANDARD}></label>
                    <input type="text" class="form-control" name="standard" id="standard" value="<{$row.standard}>">
                  </div>
                </div>
                <!--尺寸-->              
                <div class="col-sm-6">
                  <div class="form-group">
                    <label><{$smarty.const._MD_UGMMODULE_SIZE}></label>
                    <input type="text" class="form-control" name="size" id="size" value="<{$row.size}>">
                  </div>
                </div>
              </div>


              
            </div>
            <!-- 摘要-->
            <div class="col-sm-4">
              <div class="form-group">
                <label><{$smarty.const._MD_UGMMODULE_SUMMARY}></label>
                <textarea class="form-control" rows="12" id="summary" name="summary"><{$row.summary}></textarea>
              </div>
              
            </div>
          </div>

          <!--內容-->
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label for="content"><{$smarty.const._MD_UGMMODULE_CONTENT}></label>
                <{$row.content_editor}>
              </div>
            </div>
          </div>

          <div class="form-group text-center">
            <button type="submit" class="btn btn-primary"><{$smarty.const._SUBMIT}></button>
            <{if !$row.sn}>
            <button type="reset" class="btn btn-danger"><{$smarty.const._RESET}></button>
            <{/if}>
            <button type="button" class="btn btn-warning" onclick="location.href='<{$smarty.session.return_url}>'"><{$smarty.const._BACK}></button>
            <input type='hidden' name='op' value='<{$row.op}>'>
            <input type='hidden' name='sn' value='<{$row.sn}>'>
          </div>
        </form>
      </div>
    </div>
  </div>

<{/if}>
<{if $op=="opList"}>
  <div class='container-fluid'>
    <{$ForeignKeyForm}>
    <div class='row'>
      <div id="save_msg"></div>
      <table id="form_table" class="table table-bordered table-condensed table-hover">
        <thead>
          <tr>
            <th class="col-sm-1 text-center"><{$smarty.const._MD_UGMMODULE_THUMB}></th>
            <th class="col-sm-1 text-center"><{$smarty.const._MD_UGMMODULE_DATE}></th>
            <th class="col-sm-4 text-center"><{$smarty.const._MD_UGMMODULE_TITLE}></th>
            <th class="col-sm-1 text-center"><{$smarty.const._MD_UGMMODULE_SORT}></th>
            <th class="col-sm-1 text-center"><{$smarty.const._MD_UGMMODULE_CHOICE}></th>
            <th class="col-sm-1 text-center"><{$smarty.const._MD_UGMMODULE_ENABLE}></th>
            <th class="col-sm-2 text-center">
            	<a href='?op=opForm' class='btn btn-primary btn-xs' ait='<{$smarty.const._ADD}>' ><{$smarty.const._ADD}></a>
            	<a href='?op=opSort' class='btn btn-success btn-xs' ait='<{$smarty.const._MD_UGMMODULE_SORT}>' ><{$smarty.const._MD_UGMMODULE_SORT}></a>
            </th>
          </tr>
        </thead>
        <{foreach from=$rows item=row key=id name=t}>
          <{if $smarty.foreach.t.first}>
            <tbody id='sort'>
          <{/if}>          
          <tr id='tr_<{$row.sn}>'>
            <td class="text-center"><{$row.prod}></td>
            <td class="text-center"><{$row.date}></td>
            <td class="text-center"><{$row.title}></td>
            <td class="text-center"><{$row.sort}></td>
            <td class="text-center">              
              <{if $row.choice}>
                <a href='?op=opUpdateChoice&sn=<{$row.sn}>&choice=0' atl='<{$smarty.const._MD_UGMMODULE_ENABLE_0}>' title='<{$smarty.const._MD_UGMMODULE_ENABLE_0}>'><img src='<{$xoops_url}>/modules/ugm_tools2/images/on.png' /></a>
              <{else}>
                <a href='?op=opUpdateChoice&sn=<{$row.sn}>&choice=1' atl='<{$smarty.const._MD_UGMMODULE_ENABLE_1}>' title='<{$smarty.const._MD_UGMMODULE_ENABLE_1}>'><img src='<{$xoops_url}>/modules/ugm_tools2/images/off.png' /></a>
              <{/if}>                
            </td>
            <td class="text-center">
              <{if $row.enable}>
                <a href='?op=opUpdateEnable&sn=<{$row.sn}>&enable=0' atl='<{$smarty.const._MD_UGMMODULE_ENABLE_0}>' title='<{$smarty.const._MD_UGMMODULE_ENABLE_0}>'><img src='<{$xoops_url}>/modules/ugm_tools2/images/on.png' /></a>
              <{else}>
                <a href='?op=opUpdateEnable&sn=<{$row.sn}>&enable=1' atl='<{$smarty.const._MD_UGMMODULE_ENABLE_1}>' title='<{$smarty.const._MD_UGMMODULE_ENABLE_1}>'><img src='<{$xoops_url}>/modules/ugm_tools2/images/off.png' /></a>
              <{/if}>                
            </td>
            <td class="text-center">
              <a href="<{xoAppUrl modules/cnu_show/index.php?op=opShow&sn=}><{$row.sn}>" class="btn btn-primary btn-xs" target="_blank">前台</a>
              <a href="?op=opForm&sn=<{$row.sn}>" class="btn btn-success btn-xs"><{$smarty.const._EDIT}></a>
              <a href="?op=opCopy&sn=<{$row.sn}>" class="btn btn-default btn-xs" target="_blank">複製</a>
              <a href="javascript:op_delete_js(<{$row.sn}>);" class="btn btn-danger btn-xs"><{$smarty.const._DELETE}></a> 
            </td>
          </tr>

          <{if $smarty.foreach.t.last}>            
            </tbody>
          <{/if}>
        <{/foreach}>
      </table>
      <{$bar}>
    </div>
  </div>
<{/if}>

<{if $op=="opSort"}>
	
	<{* 排序 *}> 

	<link rel="stylesheet" href="<{xoAppUrl modules/tadtools/sweet-alert/sweet-alert.css}>" type="text/css" />
	<script src="<{xoAppUrl modules/tadtools/sweet-alert/sweet-alert.js}>" type="text/javascript"></script> 
	<script type='text/javascript'>
	  $(document).ready(function(){
	    $('#sort').sortable({ opacity: 0.6, cursor: 'move', update: function() {
	      var order = $(this).sortable('serialize') + '&op=opUpdateSort';
	      $.post('main.php', order, function(msg){
	        if(msg ==1){
	          swal("<{$smarty.const._BP_SORT_SUCCESS}>", "", "success");
	          location.reload();
	        }else{
	          swal("<{$smarty.const._BP_SORT_ERROR}>", "", "error");
	          location.reload();
	        }              
	      });
	    }
	    });
	  });
	</script>
  <div class='container-fluid'>
  	<h2>商品排序</h2>
    <div class='row'>
      <div id="save_msg"></div>
      <table id="form_table" class="table table-bordered table-condensed table-hover">
        <thead>
          <tr>
            <th class="col-sm-1 text-center"><{$smarty.const._MD_UGMMODULE_THUMB}></th>
            <th class="col-sm-1 text-center"><{$smarty.const._MD_UGMMODULE_DATE}></th>
            <th class="col-sm-4 text-center"><{$smarty.const._MD_UGMMODULE_TITLE}></th>
            <th class="col-sm-1 text-center"><{$smarty.const._MD_UGMMODULE_SORT}></th>
            <th class="col-sm-1 text-center"><{$smarty.const._MD_UGMMODULE_CHOICE}></th>
            <th class="col-sm-1 text-center"><{$smarty.const._MD_UGMMODULE_ENABLE}></th>
            <th class="col-sm-2 text-center">
            	<button type="button" class="btn btn-warning btn-xs" onclick="location.href='<{$smarty.session.return_url}>'"><{$smarty.const._BACK}></button>
            </th>
          </tr>
        </thead>
        <{foreach from=$rows item=row key=id name=t}>
          <{if $smarty.foreach.t.first}>
            <tbody id='sort'>
          <{/if}>          
          <tr id='tr_<{$row.sn}>'>
            <td class="text-center"><{$row.prod}></td>
            <td class="text-center"><{$row.date}></td>
            <td class="text-center"><{$row.title}></td>
            <td class="text-center"><{$row.sort}></td>
            <td class="text-center">              
              <{if $row.choice}>
                <img src='<{$xoops_url}>/modules/ugm_tools2/images/on.png' />
              <{else}>
                <img src='<{$xoops_url}>/modules/ugm_tools2/images/off.png' />
              <{/if}>                
            </td>
            <td class="text-center">
              <{if $row.enable}>
                <img src='<{$xoops_url}>/modules/ugm_tools2/images/on.png' />
              <{else}>
                <img src='<{$xoops_url}>/modules/ugm_tools2/images/off.png' />
              <{/if}>                
            </td>
            <td class="text-center">
              <img src="<{$xoops_url}>/modules/tadtools/treeTable/images/updown_s.png" style="cursor: s-resize;" alt="<{$smarty.const._TAD_SORTABLE}>" title="<{$smarty.const._TAD_SORTABLE}>"> 
            </td>
          </tr>

          <{if $smarty.foreach.t.last}>            
            </tbody>
          <{/if}>
        <{/foreach}>
      </table>
      <{$bar}>
    </div>
  </div>
<{/if}>