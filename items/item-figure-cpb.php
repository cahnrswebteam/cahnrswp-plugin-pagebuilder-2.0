<?php

class Item_Figure_CPB extends Item_Abstract_CPB {
	
	public $shortcode = 'figure';
	
	public $label = 'Figure & Caption';
	
	public $description = 'Add image /w caption to layout';
	
	public $default_settings = array(
		'img_id' => array( '' , 'int' ),
		'caption' => array( '' , 'html' ),
	);
	
	public function item( $settings , $content ){
	}
	
	public function editor( $settings , $content ){
		
	}
	
	public function form( $settings ){
	}
	
	
}