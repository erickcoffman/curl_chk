<?php	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://www.google.com/");	
	curl_setopt($ch, CURLOPT_HEADER, false);	
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);
	curl_close($ch);	
	echo $result;	
?>