<?php

class Items_CPB {
	
	public $parse_content;
	
	public $item_set = array();
	
	public function __construct( $parse_content ){
		
		$this->parse_content = $parse_content;
		
	} // end __construct
	
	public function get_content_items( $content ){
		
		$items = $this->get_items_from_content( $content , array( 'section' ) , 'section' , true  );
		
		return $items;
		
	} // end get_content_items
	
	
	public function get_items_from_content( $content , array $shortcodes , $default = false , $recursive = false ){
		
		$regex = $this->parse_content->get_regex( $shortcodes );
		
		$split_content = $this->parse_content->get_split_content( $content , $regex );
		
		$shortcode_array = $this->parse_content->get_extract_shortcode( $split_content , $regex , $default );
		
		$items = $this->get_items_from_shortcode_array( $shortcode_array , $recursive );
		
		return $items;
		
	} // end get_items_from_content
	
	public function get_items_from_shortcode_array( $shortcode_array , $recursive = false ){
		
		$items = array();
		
		foreach( $shortcode_array as $shortcode ){
			
			$items[] = $this->get_item( $shortcode['shortcode'] , $shortcode['settings'] , $shortcode['content'] , true );
			
		} // end foreach
		
		return $items;
		
	}
	
	public function get_children( $item , $recursive = true ){
		
		$allowed_types = ( 'all' == $item->allowed_children )? array_keys( $this->item_set ) : $item->allowed_children ;
				
		$children = $this->get_items_from_content( $item->content , $allowed_types , $item->default_child , $recursive  );
		
		if ( 'row' == $item->shortcode ) {
			
			$layout = $item->get_layout();
			
			//var_dump( $layout );
			
			while ( count( $children ) < $layout[0] ) { 
				
				$child = $this->get_item( 'column' , array(), ' ' , true );
				
				$children[] = $child;
				
			} // end while
			
		} // end if
		
		foreach( $children as $index => $child ){
			
			$children[ $index ]->i = $index;
			
		} // end foreach
		
		return $children;
		
	}
	
	public function get_item( $name , $settings = array() , $content = '' , $recursive = false ){
		
		if ( array_key_exists( $name , $this->item_set ) ){
			
			require_once $this->item_set[ $name ]['file_path'];
			
			$item = new $this->item_set[ $name ]['class']( $settings , $content );
			
			if ( $recursive && $item->allowed_children ){
				
				$item->children = $this->get_children( $item , $recursive ); 
				
			}
			
			return $item;
			
		} else {
			
			return $false;
			
		}// end if
		
	} // end get_item
	
	/*public function get_form_recursive( $item ){
		
		$forms = $item->the_form();
		
		if ( $item->children ){
			
			foreach ( $item->children as $child ){
				
				$forms .=  $this->get_form_recursive( $child );
				
			} // end foreach
			
		} // end if
		
		return $forms;
		
	} // end get_form_recursive*/
	
	public function get_form_recursive( $item ){
		
		$forms[] = array( 'type' => $item->shortcode , 'id' => $item->id , 'html' => $item->the_form() );
		
		//var_dump( $forms );
		
		if ( $item->children ){
			
			$child_forms = array();
			
			foreach ( $item->children as $child ){
				
				$child_forms = $this->get_form_recursive( $child );
				
			} // end foreach
			
			$forms = array_merge( $forms , $child_forms );
			
		} // end if
		
		//var_dump( $forms );
		
		return $forms;
		
	} // end get_form_recursive
	
	public function get_form_html( $form_array ){
		
		$forms = '';
		
		foreach( $form_array as $form ){
			
			//var_dump( $form );
			
			$forms .= $form['html'];
			
		} // end foreach
		
		return $forms;
		
	} // end get_form_html
	
	public function get_editors_html( $item ){
		
		$child_content = '';
		
		if ( isset( $item->children ) ){
			
			foreach( $item->children as $child ){
				
				$child_content .= $this->get_editors_html( $child );
				
			} // end foreach
			
		} // end if
		
		$html = $item->the_editor( $child_content );
		
		return $html;
		
	}
	
	
	/*public function set_columns( &$item ){
		
		$layout = $item->settings['layout'];
		
		$cols = count( $item->children );
		
		$layout_cols = ( ! empty( $item->layouts[ $layout ] ) ) ? $item->layouts[ $layout ]['c_count'] : 1 ;
		
		if ( $cols < $layout_cols ){
			
			for ( $i = 0; $i < ( $cols - $layout_cols ); $i++ ){
				
				$child_item = $this->get_item( 'column' );
				
				$child_item->children = $this->get_items_from_content( '' , array_keys( $this->item_set ) , 'textblock' , true  );
				
				$item->children[] =  $child_item;
				
			} // end for
			
		} else if ( $cols > $layout_cols ) {
			
			
		} // end if
		
		var_dump( count( $item->children ) );
		
		var_dump( $layout_cols );
		
	}*/
	
	public function register_items(){
		
		$registered_items = array( 
			'section'     => array( 
				'class'   => 'Item_Section_CPB', 
				'file_path' => CPBDIR . 'items/item-section-cpb.php' ,
				'type' => 'shortcode',
			),
			'row'         => array( 
				'class'   => 'Item_Row_CPB', 
				'file_path' => CPBDIR . 'items/item-row-cpb.php',
				'type' => 'shortcode', 
			),
			'column'      => array( 
				'class'   => 'Item_Column_CPB', 
				'file_path' => CPBDIR . 'items/item-column-cpb.php',
				'type' => 'shortcode',
			),
			'textblock'   => array( 
				'class'   => 'Item_Textblock_CPB', 
				'file_path' => CPBDIR . 'items/item-textblock-cpb.php',
				'type' => 'shortcode',
			),
			'subtitle'    => array( 
				'class'   => 'Item_Subtitle_CPB', 
				'file_path' => CPBDIR . 'items/item-subtitle-cpb.php',
				'type' => 'shortcode', 
			),
			'promo'       => array( 
				'class'   => 'Item_Promo_CPB', 
				'file_path' => CPBDIR . 'items/item-promo-cpb.php', 
				'type' => 'shortcode',
			),
			'insertpost'  => array( 
				'class'   => 'Item_Insertpost_CPB', 
				'file_path' => CPBDIR . 'items/item-insertpost-cpb.php',
				'type' => 'shortcode', 
			),
			'inserttable' => array( 
				'class'   => 'Item_Inserttable_CPB', 
				'file_path' => CPBDIR . 'items/item-inserttable-cpb.php',
				'type' => 'shortcode',
			),
			'figure'      => array( 
				'class'   => 'Item_Figure_CPB', 
				'file_path' => CPBDIR . 'items/item-figure-cpb.php',
				'type' => 'shortcode', 
			),
		);
		
		$registered_items = apply_filters( 'cpb_register_items' , $registered_items );
		
		$this->item_set = $registered_items;
		
	} // end 
	
}