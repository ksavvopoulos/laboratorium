<?php 

	//checks if the form FOR A LINK has been submitted
if(isset($_POST['onedesc']) && isset($_POST['oneurl'])){
	if (strlen($_POST['oneurl'])>7 && strlen($_POST['onedesc'])>=1 && $_POST['onedesc']!='url description') {
		$theFile = file("links.txt"); 
		$theLink = '<a href="' . $_POST["oneurl"] . '" target="_new">' . $_POST['onedesc'] . '</a> | ';
		$theNewFile = $theLink . implode('', $theFile);
		$handle = fopen("links.txt", 'wb');
		fwrite($handle, $theNewFile);
		fclose($handle);
		$theFile = file("links.txt");
		echo (implode('', $theFile));
	} 
	else if (strlen($_POST['oneurl'])<=7) {
		echo ("Url is too short");
	}
	else if (strlen($_POST['onedesc'])<1 || $_POST['onedesc']!='url description'){
		echo ("Please give a description");
	}
}
?>
