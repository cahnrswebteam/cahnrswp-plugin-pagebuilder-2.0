<?php

class Item_Insertpost_CPB extends Item_Abstract_CPB {
	
	public $shortcode = 'insertpost';
	
	public $label = 'Insert Post';
	
	public $description = 'Add post/page content to layout';
	
	public $default_settings = array(
		'title' => array( '' , 'text' ),
	);
	
	public function item( $settings , $content ){
	}
	
	public function editor( $settings , $content ){
		
	}
	
	public function form( $settings ){
	}
	
	
}