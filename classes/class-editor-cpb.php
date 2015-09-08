<?php
class Editor_CPB {
	
	public $items;
	
	public function __construct( $items ){
		
		$this->items = $items;
		
	} // end __construct
	
	public function the_editor( $post ){
		
		$items = $this->items->get_content_items( $post->post_content );
		
		//var_dump( $items );
		
		$html = '<div id="cwp-pagebuilder">';
		
			$html .= $this->layout_editor( $items );
			
			$html .= $this->form_editor( $items );
		
		$html .= '</div>';
		
		echo $html;
		
	} // end get_editor
	
	public function layout_editor( $items ){
		
		$html = '<div id="cwp-pagebuilder-editor">';
		
		foreach( $items as $item ){
			
			$html .= $this->get_editor_item( $item , true );
			
		} // end foreach
		
		$html .= '</div>';
		
		return $html;
		
	} // end layout_editor
	
	public function get_editor_item( $item , $recursive = false ){
		
		$content = '';
		
		if ( $recursive && $item->children ){
			
			foreach( $item->children as $child ){
				
				$content .= $this->get_editor_item( $child , true );
				
			} // end foreach
			
		} // end if
		
		$html = $item->the_editor( $content );
		
		return $html;
		
	} // get_editor_item
	
	
	public function form_editor( $items ){
		
		$html = '<div id="cwp-pagebuilder-forms">';
		
			foreach( $items as $item ){
				
				$forms = $this->items->get_form_recursive( $item );
				
				$html .= $this->items->get_form_html( $forms ); 
				
 
				
			} // end foreach
			
			$html .= $this->add_ajax_forms( array( 'row' , 'section' ) );
		
		$html .= '</div>';
		
		return $html;
		
	}
	
	public function add_ajax_forms( $forms ){
		
		$html = '';
		
		foreach( $forms as $form ){
		
			$item = $this->items->get_item( $form );
			
			$item->is_ajax();
			
			$html .= $this->items->get_form_html( $this->items->get_form_recursive( $item ) );
		
		} // end foreach
		
		for ( $i = 0; $i < 16; $i++ ){
			
			$item = $this->items->get_item( 'textblock' );
			
			$item->is_ajax();
			
			$html .= $this->items->get_form_html( $this->items->get_form_recursive( $item ) );
			
		} // end for
		
		return $html;
		
	}
	
	
	
	
	
	
}