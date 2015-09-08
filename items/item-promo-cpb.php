<?php

class Item_Promo_CPB extends Item_Abstract_CPB {
	
	public $shortcode = 'promo';
	
	public $label = 'Promo';
	
	public $description = 'Add image & text promo to layout';
	
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