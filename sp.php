<?php
/*
   Plugin Name: Multi Functional Flexi LightBox
   Plugin URI: http://arevico.com/multifunctional-lightbox-plugin/
   Description:  Multi Functional Flexi LightBox
   Version: 1.2
   Author: Arevico
   Author URI: http://www.arevico.com/
   Copyright: 2011, Arevico
*/
require_once(rtrim(dirname(__FILE__), '/\\') . DIRECTORY_SEPARATOR . 'options.php');
add_filter('the_content', 'appender');
add_action('wp_enqueue_scripts', 'my_jq_apper');

function appender($content){
	$options = defaulter(get_option('arv_lb'));

	if (!stristr($content,$options['exc']) && ((is_single() && ($options['display_on_post'] >0) ) || (is_page() && ($options['display_on_page'] >0)))){
			$content = $content . genLB();
	    }
		$content = str_ireplace($option['exc'],"",$content);

	return $content;
	}

	function genLB(){
	$options = defaulter(get_option('arv_lb'));

	$lret="";
	$x = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));

	$lret .= genStyle(array('thickbox.css'));

	$lret .= js_localize( 'options', $options);
	$lret .= genScript(array('thickbox.php'));

	return $lret . "<div id=\"hiddenContent\" style=\"display: none\">".  $options['message'] ."</div>";

}


function genScript($arr_rel_src){
	$lret="";
	$x = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));

	foreach ($arr_rel_src as $src){
		$lret .= '<script src="'.$x . $src .'" type="text/javascript"></script>';
	}
	return $lret;
}
/**
 *	Generate style code ()
 * 	@param $arr_rel_src array, with relative script source to the plugin directory, no leading slash
 * */

function genStyle($arr_rel_src){
	$lret="";
	$x = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));

	foreach ($arr_rel_src as $src){
		$lret .= '<link rel="stylesheet" type="text/css" href="'. $x . $src .'"></link>';
	}
	return $lret;
}

/**
 *Custom function to localize js inline
 */
function js_localize($name, $vars) {
	$lret="";
	$data = "var $name = {";
	$arr = array();
	foreach ($vars as $key => $value) {
		$arr[count($arr)] = $key . " : '" . esc_js($value) . "'";
	}
	$data .= implode(",",$arr);
	$data .= "};";
	$lret .= "<script type='text/javascript'>\n";
	//	$lret .= "/* <![CDATA[ */\n";
	$lret .= $data;
	//	$lret .= "\n/* ]]> */\n";
	$lret .= "</script>\n";
	return 	print_r($lret,true);
}

function my_jq_apper() {
	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js');
	wp_enqueue_script( 'jquery' );
}

?>