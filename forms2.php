<?php
//define a maxim size for the uploaded images in Kb
define ("MAX_SIZE","100000"); 
// define the width and height for the thumbnail
// note that theese dimmensions are considered the maximum dimmension and are not fixed, 
// because we have to keep the image ratio intact or it will be deformed
define ("WIDTH","150"); 
define ("HEIGHT","150"); 
//This variable is used as a flag. The value is initialized with 0 (meaning no error  found)  
//and it will be changed to 1 if an errro occures.  
//If the error occures the file will not be uploaded.
$errors=0;
$copied=false;

$allowedExts = array("jpg", "jpeg", "gif", "png");
$extension = end(explode(".", $_FILES["image"]["name"]));
if ((($_FILES["image"]["type"] == "image/gif")
|| ($_FILES["image"]["type"] == "image/jpeg")
|| ($_FILES["image"]["type"] == "image/png")
|| ($_FILES["image"]["type"] == "image/pjpeg"))
&& in_array($extension, $allowedExts)){
	if ($_FILES["image"]["error"] > 0){
    	echo "Error: " . $_FILES["image"]["error"] . "<br>";
    }
  	else{
    	echo "Your post was submitted!".$extension;
    	$image_name=time().'.'.$extension;
    	$newname="images/".$image_name;
    	echo $newname;
    	$copied = copy($_FILES['image']['tmp_name'], $newname);
    	$filename="images/s_".$image_name;
    	//$filename='images/'.$_FILES["image"]["name"];
    	$copied = copy($_FILES['image']['tmp_name'],$filename);
    	make_thumb($newname,$filename,300,300);
    }
}
else{
	echo "Invalid image";
}
if(isset($_POST['desc']) && isset($_POST['from']) && isset($_POST['titl1']) ){
	$temp1 = $_POST['desc'];
	$temp2 = $_POST['from'];
	$temp3 = $_POST['titl1'];
}
 
  
// arkoun gia na anebei to note opote ftiaxnw to string mou
$myItem = '<item>'.PHP_EOL.'<description bgcolor="#666666" padding="0"><![CDATA[';
if ($copied) {
	$myItem .= '<img src="' . $filename . '" width="300" height="155" vspace="0" hspace="0" />';
}
else if  (isset($_POST['theurl']) && strlen($_POST['theurl']) > 7){
	$myItem .= '<img src="' . $_POST['theurl'] . '" width="300" height="155" vspace="0" hspace="0" />';
}
else {
	$myItem .= '<span class="title_medium"> ' . $_POST['titl1'] . '</span> ';
}
$myItem .= '<p>dummy</p> ]]></description> 	<content bgcolor="#FFFFFF"><![CDATA[ <span class="title">';
$myItem .= $_POST['titl1'] . '</span>';
if ($copied) {
	$myItem .= '<img src="' . $filename . '" width="150" height="150" vspace="0" hspace="10" />';
}
else if  (strlen($_POST['theurl']) > 7){
	$myItem .= '<img src="' . $_POST['theurl'] . '" width="150" height="150" vspace="0" hspace="10" />';
}
$myItem .= '<span class="subtitle"> ' . $_POST['from'] . '</span> ';
$myItem .= '<p align="justify">' . $_POST['desc'] . '</p>';
$myItem .= ']]></content>'.PHP_EOL.'</item>'.PHP_EOL;
		
// update XML
if (isset($_POST['group2']) && $_POST['group2']=='prior') {
	// put item on top	
	$lines=file('flashmo_251_item_list.xml');
	$fp = fopen('flashmo_251_item_list_end.xml', 'w');
	foreach ($lines as $line_num => $line) {
		if ($line_num>27){
			fwrite($fp, $line);
		}
	}
	fclose($fp);
	$lines=file('flashmo_251_item_list_start.xml');
	$fp = fopen('flashmo_251_item_list.xml', 'w'); 
	fwrite($fp, implode('', $lines));
	fwrite($fp,PHP_EOL.$myItem.PHP_EOL ); 
	$lines=file('flashmo_251_item_list_end.xml');
	fwrite($fp, implode('', $lines));
	fclose($fp);
	$lines=file('flashmo_251_item_list.xml');
	$fp = fopen('flashmo_251_item_list.xml', 'w');
	$i=0;
	foreach ($lines as $line_num => $line) {
		$pos = strpos($line, '<item>');
		if ($pos===false){
		}
		else{
			$i+=1;
		}	
		if ($i<10){
			$number_line=preg_replace('/class="title_extra">\d{2}/','class="title_extra">0'.strval($i),$line);
		}
		else{
			$number_line=preg_replace('/class="title_extra">\d{2}/','class="title_extra">'.strval($i),$line);
		}
		fwrite($fp, $number_line);
	}
	fclose($fp);
}
else {
	// put item on eof
	// 1. cut the last line from existing xml: </photos>
	// load the data and delete the line from the array 
	//echo($myItem);
			 
	$lines = file('flashmo_251_item_list.xml'); 
	$last = sizeof($lines) - 1 ; 
	unset($lines[$last]); 
	// write the new data to the file 
	$fp = fopen('flashmo_251_item_list.xml', 'w'); 
	fwrite($fp, implode('', $lines)); 
	// 2. append myItem
	fwrite($fp,$myItem ); 
	fwrite($fp,PHP_EOL.PHP_EOL.'</items>' );
	// 3. close file
	fclose($fp); 
			 
} 
//This function reads the extension of the file. It is used to determine if the file is an image by checking the extension.
function getExtension($str) {
	$i = strrpos($str,".");
    if (!$i) { return ""; }
  	$l = strlen($str) - $i;
    $ext = substr($str,$i+1,$l);
    return $ext;
}

// this is the function that will create the thumbnail image from the uploaded image
// the resize will be done considering the width and height defined, but without deforming the image
function make_thumb($img_name,$filename,$new_w,$new_h){
 	//get image extension.
 	$ext=getExtension($img_name);
 	//creates the new image using the appropriate function from gd library
 	if(("jpg"==$ext) || ("jpeg"==$ext)){
 		$src_img=imagecreatefromjpeg($img_name);
	}
  	if("png"==$ext){
 		$src_img=imagecreatefrompng($img_name);
	}
 	 	//gets the dimmensions of the image
 	$old_x=imageSX($src_img);
 	$old_y=imageSY($src_img);

 	 // next we will calculate the new dimmensions for the thumbnail image
 	// the next steps will be taken: 
 	// 	1. calculate the ratio by dividing the old dimmensions with the new ones
 	//	2. if the ratio for the width is higher, the width will remain the one define in WIDTH variable
 	//		and the height will be calculated so the image ratio will not change
 	//	3. otherwise we will use the height ratio for the image
 	// as a result, only one of the dimmensions will be from the fixed ones
 	$ratio1=$old_x/$new_w;
 	$ratio2=$old_y/$new_h;
 	if($ratio1>$ratio2)	{
 		$thumb_w=$new_w;
 		$thumb_h=$old_y/$ratio1;
 	}
 	else	{
 		$thumb_h=$new_h;
 		$thumb_w=$old_x/$ratio2;
 	}

  	// we create a new image with the new dimmensions
 	$dst_img=ImageCreateTrueColor($thumb_w,$thumb_h);

 	// resize the big image to the new created one
 	imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y); 

 	// output the created image to the file. Now we will have the thumbnail into the file named by $filename
 	if(!strcmp("png",$ext)){
 		imagepng($dst_img,$filename); 
 	}else{
 		imagejpeg($dst_img,$filename); 
	}
  	//destroys source and destination images. 
 	imagedestroy($dst_img); 
 	imagedestroy($src_img); 
 }

?> 
