<?php 
	ini_set("display_errors", 0);
	error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	function logData($method,$reason, $ip, $ua, $hash, $value){
		$date = date("Y-m-d H:i:s");
		$logfile = "log.txt";
		$logValue = "Date: $date | Type: $method | Status: blocked| Reason: $reason | IP: $ip | UA: $ua | User Hash: $hash | Sent Hash: (Token: $value[0] / Cookie: $value[1])";
		if(file_exists($logfile)){
			if(is_writable($logfile))
			{
				if($handle = fopen($logfile, "a")){
					$content = "{$logValue}\r\n";
					fwrite($handle, $content);
					fclose($handle);
				}else{
				return "File Error";
				}
			}
			else{
				return "File is not writable";
			}
		}
		else{fopen($logfile, "w");}
	}
	if(isset( $_SERVER["HTTP_CF_CONNECTING_IP"] )){
		$ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
	}
	else{/*$ip= $_SERVER["HTTP_X_FORWARDED_FOR"];*/$ip = $_SERVER["REMOTE_ADDR"];}
	$ua = $_SERVER["HTTP_USER_AGENT"];
	$method = "token";
	$value = array(0 => $_GET["id"]);
	if(isset($_GET["id"])){
		$hash = md5($ip.$ua);
		if($hash !== $value[0]){
			logData($method,"hash mismatch", $ip, $ua, $hash, $value);
			header("Location: https:/www.msn.com", true, 301);
		}
	}
	else{
		logData($method,"direct hit", $ip, $ua, $hash, $value);
		header("Location: http://www.google.com/", true, 301);
	}
?>