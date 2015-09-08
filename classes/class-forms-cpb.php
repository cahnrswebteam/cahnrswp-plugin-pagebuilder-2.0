<?php
class Forms_CPB {
	
	public function hidden_field( $name , $value ){
		
		$html = '<input type="hidden" name="' . $name . '" value="' . $value . '" />';
		
		return $html;
		
	}
	
	public function select_field( $name , $values , $current_value , $args = array() ){
		
		$class = ( ! empty( $args['class'] ) )? ' ' . $args['class'] : '';
		
		if ( $wrap ) $html .= '<span class="cwp-field-wrap">'; 
		
		$html .= '<select name="' . $name . '">';
		
			foreach( $values as $value => $title ){
				
				$html .= '<option value="' . $value . '" ' . selected( $value , $current_value , false ) . '>' . $title . '</option>';
				
			} // end foreach
		
		$html .= '</select>';
		
		if ( empty( $args['no_wrap'] )  ) $html = $this->wrap_field( $html , $args );
		
		return $html;
		
	}
	
	public function wrap_field( $field , $args ){
		
		$wrap_class = ( ! empty( $args['wrap_class'] ) )? $args['wrap_class'] : '';
		
		$html = '<span class="cwp-field-wrap ' . $wrap_class . '">';
		
			$html .= $field;
		
		$html .= '</span>';
		
		return $html;
		
	}
	
	/*protected $full_colors  = array(
		'','#fff','#eff0f1','#d7dadb','#b5babe','#8d959a','#5e6a71','#464e54','#2a3033',
		'#000','#981e32','#c60c30','#f4f2eb','#e3dfcd','#cbc4a2','#afa370','#8f7e35',
		'#72652a','#564c20','#393215','#ada400','#f8f1eb','#eddccc','#ddbea1','#cb9b6e','#b67233',
		'#925b29','#6d441f','#492e14','#f6861f','#edf3f4','#d3e1e3','#aec7cb','#82a9af','#4f868e','#3f6b72',
		'#2f5055','#203639','#00a5bd','#f9f4e7','#f1e4c4','#e5cd93','#d7b258','#c69214','#9e7510','#77580c',
		'#4f3a08','#ffb81c',
	);
	
	//Gets
	public function get_full_colors(){ return $this->full_colors; }
	
	
	public function checkbox( $name , $current_value = NULL , $label = '', $args = array() , $label_args = array() ){
		
		$input = '';
		
		$checkbox_defaults = array(
			'id'            => rand( 0 , 1000000 ),
			'value'         => 1,
			'class'         => '',
			'style'         => '',
			'wrap'          => true,
			'wrap_class'    => '',
		);
		
		$label_defaults = array(
			'class' => '',
			'style' => '',
		);
		
		$this->service_set_defaults( $args , $checkbox_defaults );
		
		$id = $name . '_' . $args['id'];
		
		$input .= '<input style="display:none" type="checkbox" ';
		
		$input .= 'name="' . $name . '" ';
		
		$input .= 'value="" checked="checked" />';
		
		$input .= '<input type="checkbox" ';
		
		$input .= 'name="' . $name . '" ';
		
		$input .= 'value="' . $args['value'] . '" ';
		
		$input .= 'class="' . $args['class'] . '" ';
		
		$input .= 'id="' . $id . '" ';
		
		if ( NULL !== $current_value ){
		
		$input .= checked( $current_value , $args['value'], false );
		
		} // end if
		
		$input .= ' />';
		
		if ( $label ){
			
			$this->service_set_defaults( $label_args , $label_defaults );
			
			$input .= '<label class="' . $label_args['class'] . '" for="' . $id . '">' . $label . '</label>';
			
		} // end if
		
		if ( $args['wrap'] ){
			
			$input = '<span class="cwp-input-wrap ' . $args['wrap_class'] . '">' . $input . '</span>';
			
		}
		
		return $input;
		
	}
	
	public function short_text( $name, $current_value, $label = '' , $args = array(), $label_args = array() ){
		
		$input = '';
		
		$args_defaults = array(
			'class'         => '',
			'style'         => '',
			'wrap'          => true,
			'wrap_class'    => '',
		);
		
		$label_defaults = array(
			'class' => '',
			'style' => '',
		);
		
		$this->service_set_defaults( $args , $args_defaults );
		
		if ( $label ){
			
			$this->service_set_defaults( $label_args , $label_defaults );
			
			$input .= '<label class="' . $label_args['class'] . '">' . $label . '</label>';
			
		} // end if
		
		$input .= '<input type="text" ';
		
		$input .= 'name="' . $name . '" ';
		
		$input .= 'value="' . $current_value . '" ';
		
		$input .= 'class="cwp-short-input ' . $args['class'] . '" ';
		
		$input .= ' />';
		
		if ( $args['wrap'] ){
			
			$input = '<span class="cwp-input-wrap ' . $args['wrap_class'] . '">' . $input . '</span>';
			
		} // end if
		
		return $input;
		
	}
	
	public function radio( $name , $current_value = NULL , $value , $label = '', $args = array() , $label_args = array() ){
		
		$input = '';
		
		$args_defaults = array(
			'id'            => rand( 0 , 1000000 ),
			'class'         => '',
			'style'         => '',
			'wrap'          => true,
			'wrap_class'    => '',
		);
		
		$label_defaults = array(
			'class' => '',
			'style' => '',
		);
		
		$this->service_set_defaults( $args , $args_defaults );
		
		$id = $name . '_' . $args['id'];
		
		$input .= '<input type="radio" ';
		
		$input .= 'name="' . $name . '" ';
		
		$input .= 'value="' . $value . '" ';
		
		$input .= 'class="' . $args['class'] . '" ';
		
		$input .= 'id="' . $id . '" ';
		
		if ( NULL !== $current_value ){
		
		$input .= checked( $current_value ,  $value, false );
		
		} // end if
		
		$input .= ' />';
		
		if ( $label ){
			
			$this->service_set_defaults( $label_args , $label_defaults );
			

			$input .= '<label class="' . $label_args['class'] . '" for="' . $id . '">' . $label . '</label>';
			
		} // end if
		
		if ( $args['wrap'] ){
			
			$input = '<span class="cwp-input-wrap ' . $args['wrap_class'] . '">' . $input . '</span>';
			
		}
		
		return $input;
		
	}
	
	public function color_select( $name, $values, $current_value = '', $label = '', $args = array(), $label_args = array() ){
		
		$input = '';
		
		$args_defaults = array(
			'class'         => '',
			'style'         => '',
			'wrap'          => true,
			'wrap_class'    => '',
		);
		
		$label_defaults = array(
			'class' => '',
			'style' => '',
		);
		
		$this->service_set_defaults( $args , $args_defaults );
		
		if ( $label ){
			
			$this->service_set_defaults( $label_args , $label_defaults );
			
			$input .= '<label class="' . $label_args['class'] . '" for="' . $id . '">' . $label . '</label>';
			
		} // end if
		
		$input .= '<select class="' . $args['class'] . '" name="' . $name . '" style="' . $args['style'] . '" />';
		
			foreach( $values as $color ){
				
				$color_style = ( $color ) ? 'background:' . $color . ';' : '';
				
				$input .= '<option value="' . $color . '" style="' . $color_style . '" ' . selected( $current_value , $color , false ) . ' >' . $color . '</option>';
				
			}
		
		$input .= '</select>';
		
		if ( $args['wrap'] ){
			
			$input = '<span class="cwp-input-wrap ' . $args['wrap_class'] . '">' . $input . '</span>';
			
		} // end if
		
		return $input;
		
	}
	
	
	private function service_set_defaults( &$current , $default ){
		
		foreach( $default as $key => $value ){
			
			if ( ! array_key_exists( $key , $current ) ){
				
				$current[ $key ] = $value;
				
			} // end if 
			
		} // end foreach
		
	}
	*/
	
}