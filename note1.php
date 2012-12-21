<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PanSoft Labs - Post a note</title>

<link type="text/css" href="flashmo_251_style.css" rel="stylesheet" />
<link type="text/css" href="css/dark-hive/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
<link type="text/css" href="tinyeditor/tinyeditor.css"  rel="stylesheet">

<script type="text/javascript" src="tinyeditor/tiny.editor.packed.js"></script>
<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="js/jquery.form.js"></script>

<script type="text/javascript">
			$(document).ready(function(){
				$("#help").click(function(){
					alert('Εδω σας μαλωνω προκαταβολικα μην ποσταρετε οτι να ναι');
				});
			});
			$(function(){
				// buttons
				$( "input:submit, a, button", ".jqBTN" ).button();
				//submits the url form
				$( "#internal" ).click(function(){
				var data_string = $('form#newurl').serialize();
				if (oneurl.value.length>7 && onedesc.value.length>=1 && onedesc.value!='url description'){
				
					$.ajax({
						type:"POST",
						url:"showurl.php",
						data:data_string,
						success:    function(data) {
        					document.getElementById('hello').innerHTML=data
        				}
					});
				}else if (oneurl.value.length<=7){
					alert("Url too short")
				}else if (onedesc.value.length<1 || onedesc.value=='url description' ){
					alert("Please give a description")
				}
			
				return false;
				})
				
				$( "#post1" ).click(function(){
				editor.post();
				var form1_string=$('form#newad').serialize();
				//document.write(form1_string);
				$.ajax({
						type:"POST",
						url:"forms1.php",
						data:form1_string,
						success:    function(data) {
        					alert(data);
        				}
					});
				
				return false;
				});
				
				//forma me eikona
				$( "#post2" ).click(function(){
				editor1.post();
				var formData = new FormData($('form#newpic')[0]);
				//alert(formData);
				$.ajax({
						type:"POST",
						url:"forms2.php",
						xhr: function() {  // custom xhr
          				myXhr = $.ajaxSettings.xhr();
            			if(myXhr.upload){ // check if upload property exists
                		myXhr.upload.addEventListener('progress',progressHandlingFunction, false); // for handling the progress of the upload
            			}
            			return myXhr;
        				},
					data:formData,
					cache: false,
        				contentType: false,
        				processData: false,
						success:    function(data) {
        						alert(data);
        					}
					});
				
				$('form#newpic')[0].reset();
				return false;
				});
				function progressHandlingFunction(e){
			 	   if(e.lengthComputable){
		      			  $('progress').attr({value:e.loaded,max:e.total});
				    }
				}
				
				// links
				$( "a", ".jqLinks" ).click(function() { return false; });
				// Tabs
				$('#tabs').tabs();
				// Dialog			
				$('#dialog').dialog({
					autoOpen: true,
					modal: true,
					resizable: false,
					buttons: {
						"Ok": function() { 
							$(this).dialog("close"); 
						}
					}
				});
				//radio
				$(".radio").buttonset();
				// Datepicker
				$('#datepicker').datepicker({
					inline: true
				});			
				
			});
	
		</script>
		
        <style type="text/css">
			body{ font: 62.5% "Trebuchet MS", sans-serif; margin: 50px; color:white;}
			.demoHeaders { margin-top: 2em; }
			#dialog_link {padding: .4em 1em .4em 20px;text-decoration: none;position: relative; color:white;}
			#dialog_link span.ui-icon {margin: 0 5px 0 0;position: absolute;left: .2em;top: 50%;margin-top: -8px; color:white;}
  			#dialog {color:white;}
			ul#icons {margin: 0; padding: 0;}
			ul#icons li {margin: 2px; position: relative; padding: 4px 0; cursor: pointer; float: left;  list-style: none;}
			ul#icons span.ui-icon {float: left; margin: 0 4px;}
			a {
			color:#FFFFFF;
			font-size: 14px;
			}
		</style>	
</head>

<body bgcolor="#666666" background="images/back1.jpg">
<table height="600px" width="100%" border="0" align="center" style="margin-top: -30px; text-align: left;">
  <tr>
    <td width="40%" valign="bottom"> <center><h1>Post_a_note by JohnPan @ 2013</h1> </center>
    <a href="http://www.pansoft.gr/" target="_new">Pansoft official</a> | <a href="http://www.pansoft.gr/labs/" target="_new">Pansoft Labs website</a> | <a href="http://pansofthellas.wordpress.com/" target="_new">Pansoft English blog</a>
    </td>
    <td colspan="3" align="center" valign="top"><span style="text-align: left; font-size: 4em;">PanSoft Labs admin  </span><img src="logo_trans.png" alt="" width="125" height="59"  /></td>
  </tr>
   
  <tr valign="top">
    <td height="419"> <center><h2 class="ui-state-default">Posted Links</h2></center>
  		<div id="hello">
  		<?php
  			 $theFile = file("links.txt");
	  		 echo (implode('', $theFile));
  		?>
   	</div>
    </td>
    <td rowspan="2" valign="top" width="45%" align="center">
      <center><h2 class="ui-state-default">Ανέβασμα σημείωσης</h2></center>
      
      <div id="tabs">
    <ul>
        <li><a href="#tabs-1">Box κειμένου</a></li>
        <li><a href="#tabs-2" >Box εικόνας</a></li>
    </ul>
    <div id="tabs-1">
   
        <p> 
<table bgcolor="#445511" padding="25" width="290" height="150" align="center"><tr><td> <p class="white_text" align="right"><span class="title_large">Caption</span><span class="title_extra">08</span></p><br /><p class="desc_small" align="right"><span class="white_text">A small Description to explain more about the Caption. This is not the content of the box</span></p></td></tr></table>
      <form  action="" method="post" enctype="multipart/form-data" name="newad" id="newad"><table align="center" border="0" bordercolor="#FFFFFF" >
        
        <tr>
          <td align="center" style="border:thin; border-color:#FFFFFF; color:#FFFFFF">
          Caption:<br/> <input name="titl1" type="text" value="" size="20" /><br/>
          Description: <br/><input name="titl2" type="text" value="" size="40" /><br/></td>
          </tr>
        <tr>
          <td>Αποστολέας<br/>
            <input name="from" type="text" value="" size="40" /></td>
          </tr>
        <tr>
          <td>Κείμενο<br/>
            <textarea name="desc" id='tinyeditor' cols="50" rows="3" width="100%"></textarea>
           </td>
        </tr>
        <tr>
          <td>Προτεραιότητα <br/>
            <div class="radio" align="center">
            <input type="radio" id="radio1" name="group1" value="prior" checked="checked" /><label for="radio1">Μεγάλη</label> 
            <input name="group1" type="radio" id="radio2" value="notprior" /><label for="radio2">Μικρή</label>  
            </div>          
          </tr>
        <tr>
          <td align="center" class="jqBTN"><input  name="Submit" type="submit" id="post1" value="Ανέβασμα σημείωσης" /></td>
          </tr>
        </table>
    </form>
      	</p>
    </div>
    <div id="tabs-2">
        <p> <table bgcolor="#445511" padding="25" width="290" height="150" align="center"><tr><td> <img src="images/flashmo_300x150_02.jpg" /> </td></tr></table>
        
<form  action="" method="post" enctype="multipart/form-data" name="newpic" id="newpic"><table align="center" border="0" bordercolor="#FFFFFF" > <table align="center" border="0" bordercolor="#FFFFFF" ><tr>
        
          <td align="center" style="border:thin; border-color:#FFFFFF; color:#FFFFFF">Εικόνα από δίσκο<div class="jqLinks"><input name="image" type="file" id="image" size="35"  /></div><br/>
            ή από URL<br/>
            <input name="theurl" type="text" value="" size="40" /> 
            </td>
          </tr>
        <tr>
          <td>
          Caption: <input name="titl1" type="text" value="" size="20" /><br/>
          </td>
          </tr>
        <tr>
          <td>Αποστολέας<br/>
            <input name="from" type="text" value="" size="40" /></td>
          </tr>
        <tr>
          <td>Κείμενο<br/>
            <textarea name="desc" id="tinyeditor1" cols="50" rows="3" width="100%"></textarea>
            </td>
          </tr>
        <tr>
          <td>Προτεραιότητα <br/>
            <div class="radio" align="center">
            <input type="radio" id="radio3" name="group2" value="prior" checked="checked"/><label for="radio3">Μεγάλη</label> 
            <input name="group2" type="radio" id="radio4" value="notprior"  /><label for="radio4">Μικρή</label>  </div>          
          </td>
          </tr>
        <tr>
          <td align="center" class="jqBTN"><input  name="Submit" type="submit" value="Ανέβασμα σημείωσης" id="post2" /></td>
          </tr>
        </table>
    </form>

	</p>
    </div>
    
</div>
      
      </td>
    <td rowspan="2" align="center" valign="top" width="20%">
      
      <h2 class="ui-state-default" >Ημερολόγιο</h2>
      <table align="center" border="0" bordercolor="#FFFFFF"><tr><td>
        <div id="datepicker"></div>
      </td></tr></table>
      <h2 class="ui-state-default">Ρολογάκι</h2>
      <table align="center" border="1" bordercolor="#FFFFFF"><tr><td>
        <div id="clock"></div>
       </td></tr></table>
        <h2 class="ui-state-default">Βοήθεια</h2>
       <div class="jqBTN"><input name="help" id="help" type="submit" value="Read Me before you Post" /></div>
</td>
  <tr valign="bottom">
    <td><center><h2 class="ui-state-default">Post Internal Link</h2></center>
    <form  action="" method="post" enctype="multipart/form-data" name="newurl" id="newurl">
      <input name="oneurl" type="text" id="oneurl" value="http://" size="25" />
      <input name="onedesc" type="text" id="onedesc" value="url description" size="30" />
    <div class="jqBTN"><input name="SubmitURL" id="internal" type="submit" value="Post" />You can post an internal link here (Will not appear in Labs) </div></form></td></tr>
</table>
    <td>&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
</body>

  <script>
  	// tiny editors must be declared after the declaration of the textareas and their ids
  	var editorParams = {
				id: 'tinyeditor',
				width: 584,
				height: 175,
				cssclass: 'tinyeditor',
				controlclass: 'tinyeditor-control',
				rowclass: 'tinyeditor-header',
				dividerclass: 'tinyeditor-divider',
				controls: ['bold', 'italic', 'underline', 'strikethrough', '|', 'subscript', 'superscript', '|',
				'orderedlist', 'unorderedlist', '|', 'outdent', 'indent', '|', 'leftalign',
				'centeralign', 'rightalign', 'blockjustify', '|', 'unformat', '|', 'undo', 'redo', 'n',
				'font', 'size', 'style', '|', 'image', 'hr', 'link', 'unlink', '|', 'print'],
				footer: true,
				fonts: ['Verdana','Arial','Georgia','Trebuchet MS'],
				xhtml: true,
				css:'body{background-color:#ccc}',
				cssfile: 'tinyeditor/tinyeditor.css',
				//bodyid: 'editor',
				footerclass: 'tinyeditor-footer',
				toggle: {text: 'source', activetext: 'wysiwyg', cssclass: 'toggle'},
				resize: {cssclass: 'resize'}
		};
		//copy value of editorParams
		var editor1Params= jQuery.extend(true, {}, editorParams);
		editor1Params.id='tinyeditor1';
		var editor = new TINY.editor.edit('editor', editorParams);
		var editor1=new TINY.editor.edit('editor1', editor1Params);
  </script>
</html>

