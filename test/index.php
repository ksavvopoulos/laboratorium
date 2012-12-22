<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <style type="text/css">
			body{ font: 62.5% "Trebuchet MS", sans-serif; margin: 10px; color:white;}
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
<script src="js/jquery-1.6.2.min.js" type="text/javascript"></script>
<script src="js/jquery.orbit-1.2.3.min.js" type="text/javascript"></script>

<script type="text/javascript">
     $(window).ready(function() {
         $('#featured').orbit({
     animation: 'horizontal-push',                  // fade, horizontal-slide, vertical-slide, horizontal-push
     animationSpeed: 400,                // how fast animtions are
     timer: false, 			 // true or false to have the timer
     advanceSpeed: 4000, 		 // if timer is enabled, time between transitions 
     pauseOnHover: false, 		 // if you hover pauses the slider
     startClockOnMouseOut: false, 	 // if clock should start on MouseOut
     startClockOnMouseOutAfter: 1000, 	 // how long after MouseOut should the timer start again
     directionalNav: true, 		 // manual advancing directional navs
     captions: true, 			 // do you want captions?
     captionAnimation: 'fade', 		 // fade, slideOpen, none
     captionAnimationSpeed: 800, 	 // if so how quickly should they animate in
     bullets: true,			 // true or false to activate the bullet navigation
     bulletThumbs: true,		 // thumbnails for the bullets
     bulletThumbLocation: '/orbit',		 // location from this file where thumbs will be
     afterSlideChange: function(){} 	 // empty function 
});
         
     });
</script>
<link rel="stylesheet" href="orbit-1.2.3.css">
 <link rel="stylesheet" type="text/css" href="flashmo_251_style.css">
</head>
<body bgcolor="black">
<div style="top:25%; left:15%; position:fixed; width: 930px; height: 480px; ">
<div id="featured" style="background-color:black;">
<div class = 'content' style="">
<?php

 $i=0;
 $j=0;
$xml = simplexml_load_file("flashmo_251_item_list.xml");
foreach($xml->children() as $child){
	$i++;
	
	if($j){
 	$des= $child->description->asXML();
 	$des=str_replace('<![CDATA[',"",$des);
 	$des=str_replace(']]>',"",$des);
 	
 	preg_match('/#\w{6}/',$des,$matches);
 	if(isset($matches[0])){
 		$color=$matches[0];
 		echo "<div  style='width:300px; float:left; border:5px solid black; background-color:".$color.";height:155px;'>".$des."</div>";
	}else{
		echo "<div  style='width:300px; float:left; height:155px;'>".$des."</div>";
	}
	if($i==9){
	echo "</div>";
	echo "<div class = 'content' style=''>";
	$i=0;
	}
	}
	$j++;
}
?> 
</div>
</div>
</div>
</body>
</html>
