      <!-- Array ( [sn] => 1 [ofsn] => 0 [title] => 商品類別1 [count] => 1 ) -->
      
      <link rel="stylesheet" href="<{xoAppUrl}>modules/tadtools/dtree/dtree.css" type="text/css">
      <script src="<{xoAppUrl}>modules/tadtools/dtree/dtree.js" type="text/javascript"></script>
      <div> 
        <script type="text/javascript"> 
          prod = new dTree('prod','<{xoAppUrl modules/tadtools/dtree}>');//new一个树对象 
          //设置树的节点及其相关属性 
          prod.add(0,-1,' <{$block.options.1}>'); 
          <{foreach from=$block.rows item=row}>
            prod.add(<{$row.sn}>,<{$row.ofsn}>,"<{$row.title}><{if $row.count}>(<{$row.count}>)<{/if}>","<{xoAppUrl}>modules/cnu_show/index.php?op=showKind&kind=<{$row.sn}>");
          <{/foreach}> 
          //config配置，设置文件夹不能被链接，即有子节点的不能被链接。 
          //prod.config.folderLinks=false; 
          document.write(prod); 
        </script> 
        <p>
          <a href="javascript: prod.openAll();">展開</a> | <a href="javascript: prod.closeAll();">闔起</a>
        </p>          
      </div>

