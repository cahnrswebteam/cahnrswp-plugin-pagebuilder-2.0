<?php
/**
* Plugin Name: CAHNRSWP Pagebuilder 2.0
* Plugin URI:  http://cahnrs.wsu.edu/communications/
* Description: Adds custom layout functionality to wordpress
* Version:     2.0.0
* Author:      CAHNRS Communications, Danial Bleile
* Author URI:  http://cahnrs.wsu.edu/communications/
* License:     Copyright Washington State University
* License URI: http://copyright.wsu.edu
*/

/*
* Filters: clean_editor_content
*/

class CAHNRSWP_Pagebuilder_CPB {
	
	public $items;
	
	public $editor;
	
	public $ajax;
	
	public $parse_content;
	
	public function __construct(){
		
		define( 'CPBURL' , plugin_dir_url( __FILE__ ) ); // Plugin Base url
		
		define( 'CPBDIR' , plugin_dir_path( __FILE__ ) ); // Plugin Directory Path
		
		require_once 'classes/class-forms-cpb.php';
		
		require_once 'items/item-abstract-cpb.php';
		
		require_once 'classes/class-items-cpb.php';
		
		require_once 'classes/class-parse-content-cpb.php';
		
		$this->parse_content = new Parse_Content_CPB();
		
		$this->items = new Items_CPB( $this->parse_content );
		
		add_action( 'init', array( $this->items , 'register_items' ), 99 );
		
		if ( is_admin() ){
			
			$this->the_admin();
			
		} else {
			
			$this->the_public();
			
		}// end if
		
	} // end __construct
	
	
	private function the_admin(){
		
		require_once 'classes/class-editor-cpb.php';
		
		require_once 'classes/class-ajax-cpb.php';
			
		$this->editor = new Editor_CPB( $this->items );
		
		$this->ajax = new AJAX_CPB( $this->items );
		
		add_action( 'edit_form_after_title' , array( $this->editor , 'the_editor' ) );
		
		add_action( 'admin_enqueue_scripts', array( $this , 'the_admin_scripts' ) );
		
		// Support ajax request
		add_action( 'wp_ajax_request_cpb', array( $this->ajax , 'request' ) );
		
	} // end the_admin
	
	
	public function the_admin_scripts(){
		
		wp_enqueue_style( 'admin-css', CPBURL . 'css/admin.css', array(), '1.0.0' );
		
		wp_enqueue_script( 'admin-js', CPBURL . 'js/admin.js', array(), '1.0.0' );
		
	} // end the_admin_scripts
	
	
	private function the_public(){
	}
	
}

$cahnrspb = new CAHNRSWP_Pagebuilder_CPB(); 