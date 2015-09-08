<?php

class Item_Subtitle_CPB extends Item_Abstract_CPB {
	
	public $shortcode = 'subtitle';
	
	public $label = 'Subtitle';
	
	public $description = 'Adds subtitle to layout';
	
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