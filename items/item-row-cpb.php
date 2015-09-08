<?php

class Item_Row_CPB extends Item_Abstract_CPB {
	
	public $is_layout = true;
	
	public $shortcode = 'row';
	
	public $label = 'Page Row';
	
	public $description = 'Add new page row to layout';
	
	public $form_size = 'medium';
	
	public $default_child = 'column';
	
	public $allowed_children = array('column');
	
	public $default_settings = array(
		'title'  => array( '' , 'text' ),
		'layout' => array( 'single' , 'text' ),
	);
	
	// Used for rows and sections to add new
	public $ajax_request = false;
	
	public function item( $settings , $content ){
	}
	
	public function editor( $settings , $child_content ){
		
		$title = ( ! empty( $settings['title'] ) ) ? $settings['title'] : $this->label;
		
		$html = '<div class="cpb-row">';
		
			$html .= '<header>';
			
				$html .= '<h4>' . $title . '</h4>';
			
			$html .= '</header>';
			
			$html .= '<div class="cpb-item-set ' . $settings['layout'] . '">';
			
				$html .= $child_content;
			
			$html .= '</div>';
			
			$html .= '<footer>';
			
			$html .= '</footer>';
		
		$html .= '</div>';
		
		return $html;
		
	}
	
	public function form( $settings ){
		
		$html = '';
		
		if ( isset( $this->ajax_request ) && $this->ajax_request ){
			
			$layouts = array(
				'single' => 'Single Column',
				'halves' => 'Two Columns - Halves',
			);
			
			$html .= $this->select_field( $this->get_name('layout') , $layouts , $settings['layout'] );
			
			$html .= $this->hidden_field( 'part' , 'row' );
			
		} // end if
		
		return $html;
		
	}
	
	public function get_layout( ){
		
		switch( $this->settings['layout'] ){
			
			case 'halves':
				$layout = array( 2 , array('50%','50%') );
				break;
			case 'side-right':
				$layout = array( 2 , array('70%','30%') );
				break;
			case 'side-left':
				$layout = array( 2 , array('30%','70%') );
				break;
			case 'thirds':
				$layout = array( 3 , array( '33.33%','33.33%','33.33%') );
				break;
			case 'quarters': 
				$layout = array( 4 , array('25%','25%','25%','25%') ); 
				break;
			case 'triptych':
				$layout = array( 3 , array('25%','50%','25%') );
				break;
			default:
				$layout = array( 1 , array('auto') );
				//$layout = array( 2 , array('50%','50%') );
				break;
		} // end switch
		
		return $layout;
		
	}
	
}