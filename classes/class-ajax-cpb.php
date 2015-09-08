<?php
class AJAX_CPB {
	
	public $items;
	
	public function __construct( $items ){
		
		$this->items = $items;
		
	} // end __construct
	
	public function request(){
		
		//var_dump( $_POST );
		
		switch( $_POST['request'] ){
			
			case 'part':
				$html = $this->ajax_part();
			
		} // end switch
		
		echo $html;
		
		die();
		
	} // end
	
	public function ajax_part(){
		
		$the_part = array();
		
		if ( ! empty( $_POST['part'] ) ){
			
			$shortcode = $_POST['part'];
			
			$settings = ( ! empty( $_POST['settings'] ) ) ? $_POST['settings'] : array();
			
			$content =  ( ! empty( $_POST['content'] ) ) ? $_POST['content'] : ' ';
			
			$item = $this->items->get_item( $shortcode, $settings , $content , true );
			
			if ( $item ){
				
				$the_part['part'] = $shortcode;
				
				$the_part['editor'] = $this->items->get_editors_html( $item );
				
				$the_part['forms'] = $this->items->get_form_recursive( $item );
				
			} // end if
			
		} // end if
		
		return json_encode( $the_part );
		
	} // end ajax_part
	
}