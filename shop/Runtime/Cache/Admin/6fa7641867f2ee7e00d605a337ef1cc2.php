<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<script type="text/javascript" src='<?php echo (AD_JS_URL); ?>jquery-1.8.3.min.js' ></script>
<style type="text/css">
<!--
body { 
    margin-left: 3px;
    margin-top: 0px;
    margin-right: 3px;
    margin-bottom: 0px;
}
.STYLE1 {
    color: #e1e2e3;
    font-size: 12px;
}
.STYLE6 {color: #000000; font-size: 12; }
.STYLE10 {color: #000000; font-size: 12px; }
.STYLE19 {
    color: #344b50;
    font-size: 12px;
}
.STYLE21 {
    font-size: 12px;
    color: #3b6375;
}
.STYLE22 {
    font-size: 12px;
    color: #295568;
}
a:link{
    color:#e1e2e3; text-decoration:none;
}
a:visited{
    color:#e1e2e3; text-decoration:none;
}

-->
</style>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="30"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="24" bgcolor="#353c44"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="6%" height="19" valign="bottom"><div align="center"><img src="<?php echo (AD_IMG_URL); ?>tb.gif" width="14" height="14" /></div></td>
                <td width="94%" valign="bottom"><span class="STYLE1"> <?php echo ($daohang["first"]); ?> -> <?php echo ($daohang["second"]); ?></span></td>
              </tr>
            </table></td>
            <td><div align="right"><span class="STYLE1">
              <a href="<?php echo ($daohang["third_url"]); ?>"><img src="<?php echo (AD_IMG_URL); ?>add.gif" width="10" height="10" /> <?php echo ($daohang["third"]); ?></a>   &nbsp; 
              </span>
              <span class="STYLE1"> &nbsp;</span></div></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>

<!--中间体现不同页面的具体内容，并且每个页面内容不一样
通过content代表不同具体业务模板内容
-->
﻿<script type="text/javascript" src='<?php echo (PLUGIN_URL); ?>ueditor/ueditor.config.js' ></script>
<script type="text/javascript" src='<?php echo (PLUGIN_URL); ?>ueditor/ueditor.all.min.js' ></script>
<script type="text/javascript" src='<?php echo (PLUGIN_URL); ?>ueditor/lang/zh-cn/zh-cn.js' ></script>
  <tr>
    <td>
    <style type="text/css">
    #tabbar-div {
        font-size:12px;
        background: none repeat scroll 0 0 #80BDCB;
        height: 22px;
        padding-left: 10px;
        padding-top: 1px;
    }
    #tabbar-div p {
        margin: 2px 0 0;
    }
    .tab-back {
        border-right: 1px solid #FFFFFF;
        color: #FFFFFF;
        cursor: pointer;
        line-height: 20px;
        padding: 4px 15px 4px 18px;
    }
    .tab-front {
        background: none repeat scroll 0 0 #BBDDE5;
        border-right: 2px solid #278296;
        cursor: pointer;
        font-weight: bold;
        line-height: 20px;
        padding: 4px 15px 4px 18px;
    }
    </style>
    <div id="tabbar-div">
    <p>
    <span id="general-tab" class="tab-front">通用信息</span>
    <span id="detail-tab" class="tab-back">详细描述</span>
    <span id="mix-tab" class="tab-back">其他信息</span>
    <span id="properties-tab" class="tab-back">商品属性</span>
    <span id="gallery-tab" class="tab-back">商品相册</span>
    <span id="linkgoods-tab" class="tab-back">关联商品</span>
    <span id="groupgoods-tab" class="tab-back">配件</span>
    <span id="article-tab" class="tab-back">关联文章</span>
    </p>
    </div>
    <script type='text/javascript'>
    //给全部的“标签”设置“click点击”事件
    //页面加载完毕后，设置事件
    //click()内部有遍历机制，会给每个span设置onclick事件
    $(function(){
      $('#tabbar-div span').click(function(){
        $('#tabbar-div span').attr('class','tab-back')//全部标签变暗
        //this：当前点击span的dom对象
        //$(this): 把dom对象变成jquery对象
        $(this).attr('class','tab-front');//当前点击的标签高亮

        //标签对应的内容显示
        $('table[id$=-show]').hide();//全部的table隐藏
        //当前标签对应的table显示
        var idflag = $(this).attr('id');
        $('#'+idflag+'-show').show();
      });
    });
    </script>
<script type='text/javascript'>
//主分类切换显示第一个扩展分类
//参数now_catid  当前商品已经选取的全部的"扩展"分类信息
function show_cat1(now_catid=""){
  //获得当前选取的主分类id信息
  var cat_id = $('#main_cat0').val();

  //不显示分类信息处理
  if(cat_id==0){
      $('#ext_cat1 option:gt(0)').remove();//清除旧数据标签
      $('#ext_cat2 option:gt(0)').remove();//清除第二个扩展分类信息
  }else{
      //让ajax带着cat_id信息，去服务器端获得子级分类信息
      $.ajax({
        url:"/index.php/Admin/Category/getCatByPid",
        data:{'cat_id':cat_id},
        dataType:'json',
        type:'get',
        async:false,
        success:function(msg){
          var s = "";
          //遍历msg并与html标签(option)结合，最后追加给页面
          $.each(msg,function(){
            s += "<option value='"+this.cat_id+"'";
            if(now_catid.indexOf(this.cat_id)>=0){
              s +=  " selected='selected' ";
            }
            s += ">--/"+this.cat_name+"</option>";
          });
          $('#ext_cat1 option:gt(0)').remove();//清除旧数据标签
          $('#ext_cat2 option:gt(0)').remove();//清除第二个扩展分类信息
          $('#ext_cat1').append(s);//追加新标签
        }
      });
    }
}
//第一个扩展分类切换显示第二个扩展分类
function show_cat2(now_catid=""){
  //获得当前选取的第一级别扩展分类id信息
  var cat_id = $('#ext_cat1').val();

  //不显示分类信息处理
  if(cat_id==0){
    $('#ext_cat2 option:gt(0)').remove();//清除旧数据标签
  }else{
    //让ajax带着cat_id信息，去服务器端获得子级分类信息
    $.ajax({
      url:"/index.php/Admin/Category/getCatByPid",
      data:{'cat_id':cat_id},
      dataType:'json',
      type:'get',
      async:false,
      success:function(msg){
        var s = "";
        //遍历msg并与html标签(option)结合，最后追加给页面
        $.each(msg,function(){
          //s += "<option value='"+this.cat_id+"'>--/--/"+this.cat_name+"</option>";
          s += "<option value='"+this.cat_id+"'";
            if(now_catid.indexOf(this.cat_id)>=0){
              s +=  " selected='selected' ";
            }
            s += ">--/"+this.cat_name+"</option>";
        });
        $('#ext_cat2 option:gt(0)').remove();//清除旧数据标签
        $('#ext_cat2').append(s);//追加新标签
      }
    });
  }
}

$(function(){
  //当前商品已经拥有的扩展分类ids信息
  var extcatids = $('#extcatids').val();
  show_cat1(extcatids);   //extcatids='5,6'
  show_cat2(extcatids);   //extcatids='5,6'
});
</script>
    <form action="/index.php/Admin/Goods/upd/goods_id/34.html" method="post" enctype='multipart/form-data'>
    <input type='hidden' id='extcatids' value='<?php echo ($extcatids); ?>' />
    <input type='hidden' name='goods_id' value='<?php echo ($info["goods_id"]); ?>' />
    <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce" id='general-tab-show'>
      <tr>
        <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span class="STYLE19">商品名称：</span></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="left">
        <input type="text" name="goods_name" value="<?php echo ($info["goods_name"]); ?>" />
        </div></td>
      </tr>
      <tr>
        <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span class="STYLE19">价格：</span></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="left"><input type="text" name="goods_price" value="<?php echo ($info["goods_price"]); ?>" /></div></td>
      </tr>
      <tr>
        <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span class="STYLE19">数量：</span></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="left"><input type="text" name="goods_number" value="<?php echo ($info["goods_number"]); ?>" /></div></td>
      </tr>
      <tr>
        <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span class="STYLE19">重量：</span></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="left"><input type="text" name="goods_weight" value="<?php echo ($info["goods_weight"]); ?>" /></div></td>
      </tr>

  <tr>
    <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span class="STYLE19">商品主分类：</span></div></td>
    <td height="20" bgcolor="#FFFFFF" class="STYLE19">
    <div align="left">
    <select id='main_cat0' name='cat_id' onchange='show_cat1()'>
      <option value='0'>-请选择-</option>
      <?php if(is_array($catinfoA)): foreach($catinfoA as $key=>$v): ?><option value="<?php echo ($v["cat_id"]); ?>"
      <?php if(($info["cat_id"]) == $v["cat_id"]): ?>selected='selected'<?php endif; ?>
      ><?php echo ($v["cat_name"]); ?></option><?php endforeach; endif; ?>
    </select>
    </div></td>
  </tr>  
  <tr>
    <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span class="STYLE19">扩展分类：</span></div></td>
    <td height="20" bgcolor="#FFFFFF" class="STYLE19">
    <div align="left">
    <select id='ext_cat1' name='ext_cat[]' onchange='show_cat2()'>
    <option value='0'>-请选择-</option></select>
    <select id='ext_cat2' name='ext_cat[]'>
    <option value='0'>-请选择-</option></select>
    </div></td>
  </tr>

      <tr>
        <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span class="STYLE19">商品logo图片：</span></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="left">
        <input type="file" name="goods_logo" />
        <img src='<?php echo (SITE_URL); echo (substr($info["goods_small_logo"],2)); ?>' alt='没有logo' width='100' height='100' />
        </div></td>
      </tr>

    </table>

    <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce" style='display:none;' id='detail-tab-show'>
          <tr>
        <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span class="STYLE19">详情描述：</span></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="left">
        <textarea rows="5" cols="30" id='goods_introduce' name='goods_introduce' style='width:550px;height:260px;'><?php echo ($info["goods_introduce"]); ?></textarea>
        </div></td>
      </tr>
    </table>
    <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce" style='display:none;' id='mix-tab-show'>
          <tr>
        <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="left"><span class="STYLE19">其他信息</span></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="left">
        </div></td>
      </tr>
    </table>

<script type='text/javascript'>
//声明一个缓存变量，存储请求回来的属性信息
var attrinfo_cache = new Array();

//通过类型关联属性信息
function show_attr3(){
  //当前选中的类型id
  var typeid = $('[name=type_id]').val();
  //当前正在修改的商品
  var goodsid = $('[name=goods_id]').val();

if(typeof attrinfo_cache[typeid] === 'undefined'){
  //带着typeid去服务器端请求对应的属性列表信息回来
  $.ajax({
    url:"/index.php/Admin/Attribute/getAttributeByType3",
    data:{'typeid':typeid,'goodsid':goodsid},
    dataType:'json',
    type:'get',
    async:false,
    success:function(msg){
      var s = "";
      var flag = msg.flag;

      //遍历msg，并与具体的html代码结合同时追加给页面
      if(msg.flag==1){
        //1)展示空壳属性信息
        $.each(msg.data,function(){
          //展示的信息：属性名称、输入框/下拉列表
          if(this.attr_sel=='0'){
            //单选属性
            s += '<tr><td align="right"  bgcolor="#FFFFFF"><span class="STYLE19"><em>'+this.attr_name+'：</em></span></td><td bgcolor="#FFFFFF">';
            s += '<input type="text" size="40" value="" name="attrid['+this.attr_id+'][]">';
          }else{
            //多选属性
            s += '<tr><td align="right"  bgcolor="#FFFFFF"><span class="STYLE19"><span onclick="add_attr(this)">[+]</span><em>'+this.attr_name+'：</em></span></td><td bgcolor="#FFFFFF">';
            //拆分attr_vals供选择的信息，并追加给下拉列表
            var vals = this.attr_vals.split(',');
            s += '<select name="attrid['+this.attr_id+'][]"><option value="0">-请选择-</option>';
            for(var i=0; i<vals.length; i++){
              s += '<option value="'+vals[i]+'">'+vals[i]+'</option>';
            }
            s += '</select>';
          }
          s += '</td></tr>';
        });
      }else{
        //2) 展示实体属性信息
        $.each(msg.data,function(m,n){
          //m 代表遍历的数字索引下标 0/1/2/3..
          //n 和 this 都是指引同一个地方，即遍历出来的数组元素
          if(this.attr_sel=='0'){
            //A. 展示单选属性
            s += '<tr><td align="right"  bgcolor="#FFFFFF"><span class="STYLE19"><em>'+this.attr_name+'：</em></span></td><td bgcolor="#FFFFFF">';
            s += '<input type="text" size="40" value="'+this.attrvalues+'" name="attrid['+this.attr_id+'][]">';
            s += '</td></tr>';
          }else{
            //B. 展示多选属性
            //多选属性
            //把多选属性的值变化为数组：string-->Array
            var selvals = this.attrvalues.split(',');
            //selvals = array('白色','绿色')
            $.each(selvals,function(mm,nn){
              //mm：代表遍历数组元素的下标序号 0/1/2/3..
              //this：代表遍历出来的数组元素，即白色、绿色
              s += '<tr><td align="right"  bgcolor="#FFFFFF"><span class="STYLE19">';
              if(mm==0){
              s += '<span onclick="add_attr(this)">[+]</span>';
              }else{
              s += '<span onclick="$(this).parent().parent().parent().remove()">[-]</span>';
              }

              s += '<em>'+n.attr_name+'：</em></span></td><td bgcolor="#FFFFFF">';
              //拆分attr_vals供选择的信息，并追加给下拉列表
              var vals = n.attr_vals.split(',');
              s += '<select name="attrid['+n.attr_id+'][]"><option value="0">-请选择-</option>';
              for(var i=0; i<vals.length; i++){
                s += '<option value="'+vals[i]+'"';
                if(vals[i] == this){
                  s += "selected='selected'";
                }
                s += '>'+vals[i]+'</option>';
              }
              s += '</select>';
              s += '</td></tr>';
            });
          }
        });
      }
      attrinfo_cache[typeid] = s;
    }
  });
}
      //去除旧的属性信息
      $('#properties-tab-show tr:gt(0)').remove();
      //追加s到页面上
      $('#properties-tab-show').append(attrinfo_cache[typeid]);
}

//点击[+]增加多选属性tr
//@param obj: 代表[+]外边的span的dom对象
function add_attr(obj){
  //“复制”obj对应的tr节点
  var fu_tr = $(obj).parent().parent().parent().clone();

  //把fu_tr内部的[+]号变为[-]，并给[-]号设置触发事件
  fu_tr.find('.STYLE19 span').remove(); //删除fu_tr内部的[+]号span
  fu_tr.find('em').before('<span onclick="$(this).parent().parent().parent().remove()">[-]</span>')//给fu_tr再追加一个[-]号span

  //追加fu_tr 称为obj对应tr的后续兄弟节点
  $(obj).parent().parent().parent().after(fu_tr); //兄弟关系节点追加
}

//页面加载完毕，显示当前商品拥有的属性信息
$(function(){
  show_attr3();
});

</script>

<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce" style='display:none;' id='properties-tab-show'>
  <tr>
    <td width='40%' height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span class="STYLE19">商品类型：</span></div></td>
    <td height="20" bgcolor="#FFFFFF" class="STYLE19">
    <div align="left">
      <select name='type_id' onchange='show_attr3()'>
        <option value='0'>-请选择-</option>
        <?php if(is_array($typeinfo)): foreach($typeinfo as $key=>$v): ?><option value='<?php echo ($v["type_id"]); ?>'
          <?php if(($info["type_id"]) == $v["type_id"]): ?>selected='selected'<?php endif; ?>
          ><?php echo ($v["type_name"]); ?></option><?php endforeach; endif; ?>
      </select>
    </div></td>
  </tr>
</table>

<script type="text/javascript">
function add_pics(){
  //增加相册
  //就是给table增加tr节点而已
  $('#gallery-tab-show').append('<tr><td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span onclick="$(this).parent().parent().parent().remove()" class="STYLE19">[-]商品相册：</span></div></td><td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="left"><input type="file" name="goods_pics[]"></div></td></tr>');
}

//删除单个的相册图片
function del_pics(pics_id){
  if(confirm('确认要删除该相册么？')){
    $.ajax({
      url:"/index.php/Admin/Goods/delPics",
      data:{'pics_id':pics_id},
      dataType:'json',
      type:'get',
      success:function(msg){
        if(msg.flag==1){
          //通过dom方式去除页面上的相册图片
          $('#pics_'+pics_id).remove();
        }
      }
    });
  }
}
</script>
    <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce" style='display:none;' id='gallery-tab-show'>
      <tr>
        <td>
<style type='text/css'>
li{list-style: none; float:left;}
</style>
          <ul>
          <?php if(is_array($picsinfo)): foreach($picsinfo as $k=>$v): ?><li id='pics_<?php echo ($v["pics_id"]); ?>'><img src='<?php echo (SITE_URL); echo (substr($v["pics_mid"],2)); ?>' alt='' width='160' /><span style='cursor:pointer;' onclick="del_pics(<?php echo ($v["pics_id"]); ?>)">[-]</span></li><?php endforeach; endif; ?>
          </ul>
        </td>
      </tr>
      <tr>
        <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span class="STYLE19" onclick="add_pics()">[+]商品相册：</span></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="left">
        <input type='file' name='goods_pics[]' />
        </div></td>
      </tr>      

    </table>
    <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce">
      <tr>
        <td height="20" bgcolor="#FFFFFF" class="STYLE6" colspan='2'><div align="center"><input type="submit" value='修改商品' /></div></td>
      </tr>
    </table>
    </form>
    </td>
  </tr>

<script type="text/javascript">
    var ue = UE.getEditor('goods_introduce',{toolbars: [[
            'fullscreen', 'source', '|', 'undo', 'redo', '|',
            'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
            'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
            'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
            'directionalityltr', 'directionalityrtl', 'indent', '|',
            'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',
            'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
            'simpleupload', 'insertimage'
        ]]});
</script>


</table>
</body>
</html>