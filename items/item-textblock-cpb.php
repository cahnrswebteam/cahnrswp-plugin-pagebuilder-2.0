<?php

class Item_Textblock_CPB extends Item_Abstract_CPB {
	
	public $shortcode = 'textblock';
	
	public $label = 'Textblock';
	
	public $description = 'Block of HTML content';
	
	public $form_size = 'large';
	
	public $default_settings = array(
		'title' => array( '' , 'text' ),
	);
	
	public function item( $settings , $content ){
	}
	
	public function editor( $settings , $child_content ){
		
		$html = '<textarea class="cpb-frame-content">' . wp_kses_post( apply_filters( 'the_content' ,  $this->content ) ) . '</textarea>';
		
		$html .= '<textarea class="cpb-frame-css">' . $this->get_stylesheets() . '</textarea>';
		
		$html .= '<iframe src="about:blank" ></iframe>';
		
		return $html;
		
	}
	
	/*
	* Item Form
	* --------------------------------------------------
	*/
	public function form( $settings ){
		
		ob_start();
		
		wp_editor( $this->content , '_content_' . $this->id );
		
		return ob_get_clean();
		
	}
	
	/*
	* Item Specific Methods
	* --------------------------------------------------
	*/
	public function get_stylesheets(){
		
		$parent = get_template_directory_uri();
		
		$child = get_stylesheet_directory_uri();
		
		if ( $parent == $child ){
			
			$style = '<link rel="stylesheet"  href="' . $child . '/style.css" type="text/css" media="all" />';
			
		} else {
			
			$style = '<link rel="stylesheet"  href="' . $parent . '/style.css" type="text/css" media="all" />';
			
			$style .= '<link rel="stylesheet"  href="' . $child . '/style.css" type="text/css" media="all" />';
			
		} // end if
		
		$style .= '<link rel="stylesheet" href="https://repo.wsu.edu/spine/1/spine.min.css?ver=0.20.1" type="text/css" media="all" />';
		
		$style .= '<style type="text/css">body,html { background: #fff !important; overflow: auto; };</style>';
		
		return $style;
		
	}
		
}