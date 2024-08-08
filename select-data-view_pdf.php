<?php
global $wpdb;
//include("../wp-config.php");

function select_view($id,$wpdb){
//global $wpdb;
//include("../wp-config.php");
	//echo "test";
	$result = $wpdb->get_results("
      SELECT id,count_view FROM  " . $wpdb->prefix . "countpreview
      WHERE id = $id;
"); 
	//var_dump($result);

	if(count($result) > 0){
		foreach ( $result as $page )
		{
		   $view = $page->count_view;
		   return $view;
		   //echo $view;
		}
	}else{
		return 0;
	}
}

function count_row($wpdb){
	$wpdb->get_results("
                     SELECT ID FROM " . $wpdb->prefix . "posts
                        WHERE post_type = 'sdm_downloads' AND post_status = 'publish';
                "); 

	$countrow = intval($wpdb->num_rows);
	return $countrow;
}

function convertThaiChars($text) {
    // เน€เธญเธฒเธชเธฃเธฐเน€เธ”เธตเนเธขเธง เธงเธฃเธฃเธ“เธขเธธเธเธ•เน เนเธฅเธฐเธเธดเธเธซเธดเธ•เธญเธญเธ เนเธ•เนเธเธเธชเธฃเธฐเธเธฃเธฐเธเธญเธเนเธงเน
    $textWithoutVowelsAndToneMarks = preg_replace('/[เธฑเธดเธตเธถเธทเธธเธนเน€เนเนเนเนเนเนเนเนเน]/u', '', $text);
    // เธเธฑเธเธเธงเธฒเธกเธขเธฒเธงเธเธญเธเธเนเธญเธเธงเธฒเธกเธ—เธตเนเน€เธซเธฅเธทเธญ
    $length = mb_strlen($textWithoutVowelsAndToneMarks, 'UTF-8');
	
	if($length < 23){
		echo("$text<br><br>");
	}elseif($length > 44){
		echo(mb_substr($text,0,42,'UTF-8')."...");
	}else{
		echo("$text");
	}	
}

function file_size($urlfile){
	$headers = get_headers($urlfile, true);
	$filesize = $headers['Content-Length'];
	if($filesize >= (1024 * 1024)){
		$filesize_MB = round($filesize / (1024 * 1024), 2);
		echo("$filesize_MB MB");
	}else{
		$filesize_KB = round($filesize / 1024 , 2);
		echo("$filesize_KB KB");
	}
}

function datetimes($post_date){
	
	$date_str = substr($post_date, 0, -9);
    $date = DateTime::createFromFormat('Y-m-d', $date_str);
		//$new_date_str = $date;
    $new_date_str = $date->format('d/m/Y');
	
	return $new_date_str;
}
?>
