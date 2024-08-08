<?php
include("../wp-config.php");
global $wpdb;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

	$result = $wpdb->get_results("
                     SELECT id,count_view FROM ". $wpdb->prefix ."countpreview WHERE id = $id;
                "); 

    if (count($result) > 0) {
	foreach ( $result as $page )
		{
		   $view = $page->count_view;
		}
		$view = $view+1;
		echo $view;
	$wpdb->get_results("
                     UPDATE ". $wpdb->prefix ."countpreview SET count_view=$view WHERE id=$id;
                "); 

    } else {
	$wpdb->get_results("
                     INSERT INTO ". $wpdb->prefix ."countpreview (id, count_view)
               VALUES ($id, '1');
                ");        
            
    }
}
?>
