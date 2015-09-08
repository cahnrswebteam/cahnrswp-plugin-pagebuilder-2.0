<?php

class Item_Column_CPB extends Item_Abstract_CPB {
	
	public $is_layout = true;
	
	public $shortcode = 'column';
	
	public $label = 'Column';
	
	public $description = 'Add new page column to layout';
	
	public $default_child = 'textblock';

	public $allowed_children = 'all';
	
	public $default_settings = array(
		'title' => array( '' , 'text' ),
	);
	
	public function item( $settings , $content ){
	}
	
	public function editor( $settings , $child_content ){
		
		$title = ( ! empty( $settings['title'] ) ) ? $settings['title'] : $this->label;
		
		$html = '<div class="cpb-column">';
		
			$html .= '<div class="cpb-column-inner">';
		
				$html .= '<header>';
				
					$html .= '<h4>' . $title . '</h4>';
				
				$html .= '</header>';
				
				$html .= '<div class="cpb-item-set">';
				
					$html .= $child_content;
				
				$html .= '</div>';
				
				$html .= '<footer>';
				
				$html .= '</footer>';
			
			$html .= '</div>';
		
		$html .= '</div>';
		
		return $html;
		
	}
	
	public function form( $settings ){
	}
	
	
}