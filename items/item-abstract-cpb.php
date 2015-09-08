<?php 
class Item_Abstract_CPB extends Forms_CPB{
	
	public $name_prefix = '_cpb';
	
	public $default_settings = array();
	
	public $default_child = false;
	
	public $allowed_children = array();
	
	public $content = '';
	
	public $children = array();
	
	public $id;
	
	public $form_size = 'small';
	
	public function __construct( $settings , $content ){
		
		$this->settings = $this->get_settings( $settings );
		
		$this->content = $content;
		
		$this->id = $this->shortcode . '_' . rand( 0 , 100000000 );
		
	} // end __construct
	
	public function the_editor( $content = '' ){
			
		$html = $this->editor( $this->settings , $content );
		
		if ( ! isset( $this->is_layout ) ) $html = $this->wrap_item( $html );
		
		return $html;
		
	} // end the_editor
	
	public function the_form(){
		
		$html .= '<div id="' . $this->id . '" class="cpb-form-wrapper">';
		
			$html .= '<fieldset class="cpb-item-form cpb-form-' . $this->form_size . '">';
			
			$form_data = $this->form( $this->settings );
			
			if ( is_array( $form_data ) ){
				
				$html .= $this->wrap_form( $form_data );
				
			} else {
				
				$html .= $this->wrap_form( array( 'Settings' => $form_data ) );
				
			}
			
			$html .= '</fieldset>';
		
		$html .= '</div>';
		
		return $html;
		
	} // end the_editor
	
	public function is_ajax(){
		
		$this->ajax_request = true;
		
		$this->id = $this->shortcode . '_ajax_request';
	 
	} // end is_ajax
	
	
	
	
	public function wrap_item( $content ){
		
		$settings = $this->settings;
		
		$title = ( ! empty( $settings['title'] ) ) ? $settings['title'] : $this->label;
		
		$html = '<div class="cpb-item cpb-' . $this->shortcode . '">';
		
			$html .= '<header>';
			
				$html .= '<h4>' . $title . '</h4>';
			
			$html .= '</header>';
			
			$html .= '<div class="cpb-item-set">';
			
				$html .= '<div class="cpb-item-content">';
			
					$html .= $content;
				
				$html .= '</div>';
				
				$html .= '<a href="#" class="cpb-edit-item" data-id="' . $this->id . '"></a>';
			$html .= '</div>';
			
			$html .= '<footer>';
			
			$html .= '</footer>';
		
		$html .= '</div>';
		
		return $html;
		
	}
	
	public function wrap_form( $form_array ){
		
		$nav = '<nav class="cpb-item-form-nav">';
		
		$sections = '<div class="cpb-item-form-sections">';
		
		$active = ' active';
		
		foreach ( $form_array as $title => $form ){
			
			$nav .= '<a href="#" class="' . $active . '">' . $title . '</a>';
			
			$sections .= '<div class="cpb-item-form-section ' . $active . '">';
			
				$sections .= $form;
			
			$sections .= '</div>';
			
			$active = '';
			
		} // end foreach
		
		$nav .= '</nav>';
		
		$sections .= '</div>';
		
		$html = $nav . $sections;
		
		$html .= '<footer>';
		
			if ( isset( $this->ajax_request ) && $this->ajax_request ){
				
				$html .= '<a href="#" class="cpb-ajax-request cpb-standard-button" data-code="' . $this->shortcode . '">Insert</a>';
				
			} else {
				
				$html .= '<a href="#" class="cpb-edit-done cpb-standard-button" data-code="' . $this->shortcode . '">Done</a>';
				
			}// end if
		
		$html .= '</footer>';
		
		return $html;
		
	}
	
	
	public function get_settings( $settings ){
		
		$clean_sett = array();
		
		foreach( $this->default_settings as $key => $value ){
			
			if ( array_key_exists( $key , $settings ) ){
				
				$clean_sett[ $key ] = $settings[ $key ];
				
			} else {
				
				$clean_sett[ $key ] = $value[0];
				
			} // end if
			
		} // end foreach
		
		return $clean_sett;
		
	} // end get_settings
	
	public function get_name( $attribute = false ){
		
		if ( isset( $this->ajax_request ) && $this->ajax_request ){
			
			$name = 'settings';
		
		} else {
			
			$name = $this->name_prefix . '[' . $this->id . '][settings]';
			
		} // end if
		
		if ( $attribute ) $name .= '[' . $attribute . ']';
		
		return $name;
		
	}
	
}