<{includeq file="$xoops_rootpath/modules/ugm_tools2/templates/ugm_tools_toolbar.tpl"}>
<{if $op=="opList" or $op=="showKind"}>
	<style type="text/css">
		.prod-head {
	    padding: 10px;
	    background-color: #333;
	    color:#fff;
		}
		.space-10{
			height:10px;
		}
		.space-20{
			height:20px;
		}
		.space-30{
			height:30px;
		}
		.space-40{
			height:40px;
		}
		.space-50{
			height:50px;
		}
		.space-60{
			height:60px;
		}

		/**img**/
		.item_holder {
		  background-color: #fff;
		  text-align: center;
		  padding: 15px;
		  position: relative;
		  margin-bottom: 30px;
		  border: 1px solid #eee;
		  -moz-transition: all 0.3s;
		  -o-transition: all 0.3s;
		  -webkit-transition: all 0.3s;
		  transition: all 0.3s;
		}
		.item_holder img {
		  display: block;
		  margin: 0 auto;
		  -moz-transition: all 0.3s;
		  -o-transition: all 0.3s;
		  -webkit-transition: all 0.3s;
		  transition: all 0.3s;
		}
		.item_holder img:hover {
		  -moz-transform: scale3d(0.95, 0.95, 0.95);
		  -o-transform: scale3d(0.95, 0.95, 0.95);
		  -ms-transform: scale3d(0.95, 0.95, 0.95);
		  -webkit-transform: scale3d(0.95, 0.95, 0.95);
		  transform: scale3d(0.95, 0.95, 0.95);
		}
		.item_holder .title {
		  padding-top: 25px;
		}
		.item_holder .title h5 {
		  font-size: 14px;
		  font-weight: 600;
		  line-height: 20px;
		  letter-spacing: 1px;
		  font-family: "Open Sans", sans-serif;
		  color: #333;
		}
		.item_holder:hover {
		  border-color: #1ab394;
		}

	</style>
	<div class="prod-head">
	  <h1><{$main.title}></h1>
	</div>
	<div class="space-40"></div>
	<div class="row prod-list">
		<{foreach from=$main.rows item=row}>			             
			<div class="col-sm-4">
			  <div class="item_holder">
			    <a href="<{xoAppUrl}>modules/cnu_show/index.php?op=opShow&sn=<{$row.sn}>">
			    	<img src="<{$row.prod}>" alt="<{$row.title}>" class="img-responsive">
			    </a>
			    <div class="title">
			      <h5><{$row.title}></h5>
			      <span class="kind"><{$row.kind_title}></span>
			    </div>
			  </div><!--item holder-->
			</div><!--col end-->
		<{/foreach}> 
   
	</div>
	<{$bar}>
	<div class="space-60"></div>
<{/if}>

<{if $op == "opShow"}>
  <style type="text/css">
		.prod-head {
	    padding: 10px;
	    background-color: #333;
	    color:#fff;
		}
		.space-10{
			height:10px;
		}
		.space-20{
			height:20px;
		}
		.space-30{
			height:30px;
		}
		.space-40{
			height:40px;
		}
		.space-50{
			height:50px;
		}
		.space-60{
			height:60px;
		}
    .show{
      padding-bottom:50px;
      letter-spacing: 1.5px;          
      font-family: -apple-system,"PingFang SC","Helvetica Neue","Hiragino Sans GB","Microsoft YaHei","Microsoft JhengHei","Source Han Sans SC","Noto Sans CJK SC","Source Han Sans CN","Noto Sans SC","Source Han Sans TC","Noto Sans CJK TC","WenQuanYi Micro Hei",SimSun,sans-serif;
    }
    .mg-post h1{
      font-size:24px;
      color:#000;
    }
    .mg-post .mg-post-title {  
      margin-bottom: 15px; 
    }
    }
    .mg-post .mg-post-title a {
      color: #16262e;
    }
    .mg-post .mg-post-title a:hover {
      color: #e7b315;
    }
    .mg-post .mg-post-meta {
      border-bottom: 1px solid #f2f2f2;
      margin-bottom: 20px; 
      color: #96a3a9;
    }
    .mg-post .mg-post-meta span {
      padding-right: 10px;
    }
    .mg-post .mg-post-meta span:after {
      content: '/';
      padding-left: 15px;
      color: #0f0f0f;
    }

    #show .mg-post .mg-post-meta span:last-child:after {
      content: '';
      padding-left: 0;
    }
    .mg-post .mg-post-meta a {
      color: #0f0f0f;
    }
    .mg-post .mg-post-meta a:hover {
      color: #e7b315;
    }
    .mg-post .mg-read-more {
      font-family: "Playfair Display", serif;
      font-style: italic;
      font-size: 15px;
    }

    .mg-post-title  i {
      display: block;
      width: 60px;
      line-height: 60px;
      background-color: #32c5d2;
      text-align: center;
      font-size: 40px;
      color: #000;
      border-radius: 50%;
      float: left;
      -webkit-transition: background-color 0.3s;
      transition: background-color 0.3s;
    }
    .content{
      line-height: 1.7;
      font-size: 16px;
      color: #404040;         
      font-family: -apple-system,"PingFang SC","Helvetica Neue","Hiragino Sans GB","Microsoft YaHei","Microsoft JhengHei","Source Han Sans SC","Noto Sans CJK SC","Source Han Sans CN","Noto Sans SC","Source Han Sans TC","Noto Sans CJK TC","WenQuanYi Micro Hei",SimSun,sans-serif;
    }
    .show img{
      border: 2px solid #fafafa;
      border-radius: 8px;
      background-image: -webkit-gradient(linear, center top, center bottom, from(#fcfcfc), to(#bfbfbf), color-stop(3%, #f7f7f7), color-stop(12%, #f2f2f2), color-stop(90%, #d9d9d9));
      background-image: -webkit-linear-gradient(top, #fcfcfc, #f7f7f7 3%, #f2f2f2 12%, #d9d9d9 90%, #bfbfbf);
      background-image: -moz-linear-gradient(top, #fcfcfc, #f7f7f7 3%, #f2f2f2 12%, #d9d9d9 90%, #bfbfbf);
      background-image: -o-linear-gradient(top, #fcfcfc, #f7f7f7 3%, #f2f2f2 12%, #d9d9d9 90%, #bfbfbf);
      background-image: -ms-linear-gradient(top, #fcfcfc, #f7f7f7 3%, #f2f2f2 12%, #d9d9d9 90%, #bfbfbf);
      background-image: linear-gradient(to bottom, #fcfcfc, #f7f7f7 3%, #f2f2f2 12%, #d9d9d9 90%, #bfbfbf);
      -webkit-box-shadow: 0 1px 1px 1px rgba(58,60,61,0.75), inset 0 1px 0 #f5f5f5;
      -moz-box-shadow: 0 1px 1px 1px rgba(58,60,61,0.75), inset 0 1px 0 #f5f5f5;
      box-shadow: 0 1px 1px 1px rgba(58,60,61,0.75), inset 0 1px 0 #f5f5f5;

    }
  </style>
  <div id="show" class="show">
    <!--內容-->
    <div class="row">
      <div class="col-sm-5">
        <a href="#myModal" data-toggle="modal" >
          <img src="<{$row.prod}>" class="img-responsive" alt="<{$row.title}>">
        </a>          
      </div>

      <div class="col-sm-7 mg-post">
        <h1><{$row.title}></h1>
        <div class="mg-post-meta">
          <span><i class="fa fa-calendar"></i> <{$row.date}></span> 
          <span>            
            <a href="<{xoAppUrl modules/cnu_show/index.php?op=showKind&kind=}><{$row.kind}>">
              <i class="fa fa-window-restore"></i> <{$row.kind_title}>                
            </a>
          </span>
          <span><i class="fa fa-calendar"></i> <{$row.counter}></span> 
          <{if $isAdmin}>
	          <span>
	            <a href="<{xoAppUrl modules/cnu_show/admin/main.php?op=opForm&sn=}><{$row.sn}>">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> <{$smarty.const._EDIT}>
              </a>
	          </span>      
          <{/if}>       
        </div>
        <div style="margin:10px 0;" id="link"> 
          <{if $row.pdf}>
            <a href="<{$row.pdf}>" title="<{$row.title}>" class="btn btn-info btn-lg" target="_blank" >型錄</a>
          <{/if}>
          <{if $row.youtube}>
            <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#Modal-Movie">影片</button>
          <{/if}>
        </div>
        <div>
          <{if $row.standard}>
            <div class="available">
              規格 : <{$row.standard}>   
            </div>
          <{/if}> 
          <{if $row.size}>
            <div class="available">
              尺寸 : <{$row.size}>
            </div> 
          <{/if}> 
          <{if $row.unit}>
            <div class="available">
              單位 : <{$row.unit}>
            </div> 
          <{/if}> 
          <{if $row.kind_title}>
            <div class="available">
              類別 : <{$row.kind_title}>
            </div>
          <{/if}>
        </div>
      </div>
    </div>
    <div class="space-20"></div>

    <div class="row">
      <div class="col-sm-12">
        <{$row.content}>
      </div>
    </div>
  </div>
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog" style="padding-top:50px;">
    <div class="modal-dialog">        
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">×</button>
          <h4 class="modal-title text-center" style="color:#000;"><{$row.title}></h4>
        </div>
        <div class="modal-body">
          <img src="<{$row.prod}>" class="img-responsive " alt="<{$row.title}>">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>          
    </div>
  </div>
  <{if $row.youtube}>
    <!-- Modal -->
    <div class="modal fade" id="Modal-Movie" role="dialog" style="padding-top:50px;">
      <div class="modal-dialog">        
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h4 class="modal-title text-center" style="color:#000;"><{$row.title}></h4>
          </div>
          <div class="modal-body">
            <div class="video-container">
              <iframe width="560" height="315" src="https://www.youtube.com/embed/<{$row.youtube}>" frameborder="0" allowfullscreen></iframe>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
        </div>          
      </div>
    </div>    
  <{/if}>
<{/if}>
