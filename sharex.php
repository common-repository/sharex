<?php
	/*Plugin Name: Sharex
	Plugin URI: http://nexxuz.com/
	Description: Share This (Facebook, Twitter, Delicious, MySpace), Buttons float in your blog
	Version: 0.2
	Author: Jodacame
	Author URI: http://nexxuz.com/*/
function sharex($content){
	global $wpdb; 
	$parent_title = get_the_title($post->post_parent);
	$parent_title=limitar_titulo($parent_title,70);
	
	$dir = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
	$table_name = $wpdb->prefix . "sharex";
	$op_single= $wpdb->get_var("SELECT op_single FROM $table_name  LIMIT 0, 1; " );
	$op_fixed= $wpdb->get_var("SELECT op_fixed FROM $table_name  LIMIT 0, 1; " );
	$op_bg= $wpdb->get_var("SELECT op_bg FROM $table_name  LIMIT 0, 1; " );
	
	include('template/sharex.html');		
	
	
	return $content;
}
function sharex_instala(){
	global $wpdb; 
	$table_name= $wpdb->prefix . "sharex";
   $sql = " CREATE TABLE $table_name(
		id mediumint( 9 ) NOT NULL AUTO_INCREMENT ,
		op_single int(1) NOT NULL ,
		op_fixed varchar(25) NOT NULL ,
		op_bg varchar(25) NOT NULL ,
		PRIMARY KEY ( `id` )	
	) ;";
	$wpdb->query($sql);
	$sql = "INSERT INTO $table_name VALUES ('',0,'fixed','white');";
		
	$wpdb->query($sql);
}
function sharex_desinstala(){
	global $wpdb; 
	$table_name = $wpdb->prefix . "sharex";
	$sql = "DROP TABLE $table_name";
	$wpdb->query($sql);
}	
function sharex_panel(){
		
	
	global $wpdb; 
	$table_name = $wpdb->prefix . "sharex";
	if ($_POST['actualizar']==1){
	
		if(isset($_POST['op_single_inserta'])){	
			//$sql = "INSERT INTO $table_name (saludo) VALUES ('{$_POST['saludo_inserta']}');";
			$sql = "UPDATE $table_name set op_single=({$_POST['op_single_inserta']}),op_fixed=('{$_POST['op_fixed_inserta']}'),op_bg=('{$_POST['op_bg_inserta']}');";
	
		}else{
				$sql = "UPDATE $table_name set op_single=(0),op_fixed=('{$_POST['op_fixed_inserta']}'),op_bg=('{$_POST['op_bg_inserta']}');";
		}
		$wpdb->query($sql);
		echo '<div style="width:100%;background-color:#FFFF00;text-align:center;">Datos Guardados Correctamente</div>';			
	}
			
			include('template/panel.html');	
				//echo $sql;
			
}

function sharex_add_menu(){	
	if (function_exists('add_options_page')) {
		//add_menu_page
		add_options_page('sharex', 'Sharex', 8, basename(__FILE__), 'sharex_panel');
	}
}
function writeCSS() {
		$dir = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));

 echo ( '<link rel="stylesheet" type="text/css" href="'. $dir . 'style.css">' ); 
 echo ( '<script type="text/javascript" charset="utf-8" src="'. $dir . 'js/script.js" ></script> ' ); 
 
 

 
}
function limitar_titulo( $str, $num) {
	if (strlen($str) >= $num) {  
		$str = substr($str, 0, $num).'...'; 
		} 
		return $str;

	}
if (function_exists('add_action')) {
	add_action('admin_menu', 'sharex_add_menu'); 
}


add_action('activate_sharex/sharex.php','sharex_instala');
add_action('deactivate_sharex/sharex.php', 'sharex_desinstala');
add_action('the_content', 'sharex');
add_action('wp_head', 'writeCSS');
?>
