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



$xml = simplexml_load_file("flashmo_251_item_list.xml");

$items=0;
foreach($xml->children() as $child){
  $items+=1;
}



if (isset($_POST['group1']) && $_POST['group1']=='prior') {
	$number="01";
}
else{
	$number=strval($items);
}

if (isset($_POST['titl2']) && strlen($_POST['titl2'])>4){
	$desc_small=$_POST['titl2'];
}
else{
	$desc_small="No Description";
}
//checks if the form FOR A NOTE has been submitted
if(isset($_POST['desc']) && isset($_POST['from']) && isset($_POST['titl1']) ){
	$temp1 = $_POST['desc'];
	$temp2 = $_POST['from'];
	$temp3 = $_POST['titl1'];

	$colors=array("0066CC","228844","262626","660022","AA6600","445511","115566");
	$color = $colors[array_rand($colors)];
 
 	$paddings=array("0","25","50");
 	$padding=$paddings[array_rand($paddings)];
 	
 	$aligns=array('left','right','center');
 	$align=$aligns[array_rand($aligns)];
 	
 	$lefts=array('0','1');
 	$left=$lefts[array_rand($lefts)];
 	
 	$myItem = '<item>'.PHP_EOL.'<description bgcolor="#'.$color.'" padding="'.$padding.'"><![CDATA[<p class="white_text" align="'.$align.'">';
 	if ($left=='0'){
 		$myItem .= '<span class="title_large"> ' . $_POST['titl1'] . '</span> <span class="title_extra">'.$number.'</span></p>';
 	}
 	else{
 		$myItem .= '<span class="title_extra">'.$number.'</span><span class="title_large"> ' . $_POST['titl1'] .'</span></p>';
 	}
	$myItem .= '<p class="white_text" align="'.$align.'">'.$desc_small.'</p> ]]></description> '.PHP_EOL.'	<content bgcolor="#'.$color.'"><![CDATA[ <p class="white_text"><span class="title">';
	$myItem .= $_POST['titl1'] . '</span>';
	$myItem .= '<span class="subtitle"> ' . $_POST['from'] . '</span> ';
	$myItem .= '<p class="white_text" align="justify">' . $_POST['desc'] . '</p>';
	$myItem .= ']]></content>'.PHP_EOL.'</item>';
}
 
 
if (isset($_POST['group1']) && $_POST['group1']=='prior') {
	// put item on top	
	echo "empty";
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
	fwrite($fp,implode('', $lines));
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
	echo "else";
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
?>
