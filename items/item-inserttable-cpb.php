<?php

class Item_Inserttable_CPB extends Item_Abstract_CPB {
	
	public $shortcode = 'inserttable';
	
	public $label = 'Insert Table';
	
	public $description = 'Add image & HTML table to layout';
	
	public $default_settings = array(
		'img_src' => array( '' , 'text' ),
		'title' => array( '' , 'text' ),
	);
	
	public function item( $settings , $content ){
	}
	
	public function editor( $settings , $content ){
		
	}
	
	public function form( $settings ){
	}
	
	
}