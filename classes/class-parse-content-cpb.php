<?php
class Parse_Content_CPB {
	
	
	
	public function get_split_content( $content , $regex ){
		
		if ( '' == $content ) $content = ' ';
		
		// Add Delimiter to content. This is required to account for content outside of shortcodes
		$content_set = preg_replace_callback( $regex , function( $matches ){ return '|$|' . $matches[0] . '|$|'; }, $content );
		
		// Split into an array of content and shortcodes
		$content_set = explode( '|$|' , $content_set ); 
		
		return $content_set;
		
	}
	
	public function get_extract_shortcode( $split_content , $regex , $default ){
		
		$shortcodes = array();
		
		foreach( $split_content as $content ){
			
			if ( $content ){
				
				$sc = array();
			
				// Check section for top level shortcode
				preg_match_all( $regex , $content , $shortcode );
				
				if ( $shortcode[2][0] ){
					
					$sc['shortcode'] = $shortcode[2][0];
					
					$sc['settings'] = shortcode_parse_atts( $shortcode[3][0] );
					
					$sc['content'] = $shortcode[5][0];
					
					$shortcodes[] = $sc;
					
				} else if ( $default ) {
				
					$sc['shortcode'] = $default;
					
					$sc['settings'] = array();
					
					$sc['content'] = $content;
					
					$shortcodes[] = $sc;
					
				}// end if
			
			} // end if
			
		} // end foreach
		
		return $shortcodes;
		
	} // end get_extract_shortcode
	
	
	public function get_regex( array $types ){
		
		// Create empty array to populate later
		$tags = array();
		
		// Populate array with $types as keys
		foreach( $types as $type ){
		
			$tags[$type] = true;
		
		} // end foreach
		
		// The keys from $shortcode_tags are used to populate the regex in parsing code
		global $shortcode_tags;
		
		// Temporarily write tags to temp
		$temp = $shortcode_tags;
		
		// Override with custom set
		$shortcode_tags = $tags;
		
		// Get regex code using WP function
		$regex = get_shortcode_regex();
			
		// Set back to original
		$shortcode_tags = $temp;
		
		$regex = '/' . $regex . '/';
		
		return $regex;
		
	}
	
	
}