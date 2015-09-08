<?php

class Item_Section_CPB extends Item_Abstract_CPB {
	
	public $is_layout = true;
	
	public $shortcode = 'section';
	
	public $label = 'Page Section';
	
	public $description = 'Add new page section to layout';
	
	public $default_child = 'row';
	
	public $allowed_children = array('row');
	
	public $default_settings = array(
		'title' => array( '' , 'text' ),
	);
	
	
	
	public function item( $settings , $content ){
	}
	
	public function editor( $settings , $child_content ){
		
		$title = ( ! empty( $settings['title'] ) ) ? $settings['title'] : $this->label;
		
		$html = '<div class="cpb-section">';
		
			$html .= '<header>';
			
				$html .= '<h4>' . $title . '</h4>';
			
			$html .= '</header>';
			
			$html .= '<div class="cpb-item-set">';
			
				$html .= $child_content;
			
			$html .= '</div>';
			
			$html .= '<footer>';
			
			$html .= '</footer>';
		
		$html .= '</div>';
		
		$html .= '<div class="cpb-add-part-wrapper">';
		
			$html .= '<a href="#" class="editor-add-part cpb-standard-button cpb-button-left" data-part="row">+ Add Row</a>';
		
			$html .= '<a href="#" class="editor-add-part cpb-standard-button cpb-button-grey cpb-button-left" data-part="section">+ New Section</a>';
			
		$html .= '</div>';
		
		return $html;
		
	}
	
	public function form( $settings ){
	}
	
	
}