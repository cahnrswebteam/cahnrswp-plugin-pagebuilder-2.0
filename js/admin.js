jQuery( document ).ready( function( $ ){
	
	
	
	/*
	* Admin Object
	* -----------------------------------
	*/
	var cpb_admin = function( l , f , e ){
	
		var a = this;
		
		// Set Iframe Heights
		e.pop_iframes();
		
		e.editor.on( 'click' , '.cpb-edit-item' , function( event ){ 
		
			a.se( event ); 
			
			f.show( $( this ).data('id') );
			
			l.show(); 
			
		});
		
		e.editor.on( 'mouseenter' , '.cpb-add-part-wrapper' , function(){ 
		
			e.add_part( 'show' , $( this ) ); 
			
		});
		
		e.editor.on( 'mouseleave' , '.cpb-add-part-wrapper' , function(){ 
		
			e.add_part( 'hide' , $( this ) ); 
			
		});
		
		e.editor.on( 'click' , '.editor-add-part' , function( event ){ 
		
			a.se( event ); 
			
			e.active_itm = $( this );
			
			f.show( $( this ).data('part') + '_ajax_request' );
			
			l.show(); 
			
		});
		
		e.editor.on( 'click' , '.cpb-ajax-request' , function( event ){
			
			a.se( event );
			
			e.ajax_part( $( this ), e.active_itm );
			
		});
		
		// Closes form on click
		$( 'body').on( 'click' , '#cpb-lb-bg' ,  function( event ){
			
			event.stopPropagation();
			
			f.hide();
			
			l.hide();
			
			});
		
		a.se = function( ev ){ ev.preventDefault(); }
		
		
	 
	} // end cpb_admin
	
	
	
	/*
	* Lightbox object
	* -----------------------------------
	*/
	var cpb_lightbox = function(){
	
		var l = this;
		
		l.bj = '';
	
		l.add_bg = function(){
			
			if ( ! $( '#cpb-lb-bg').length ){
				
				$( 'body' ).append( '<div id="cpb-lb-bg"></div>' );
				
			} // end if
			
			l.bj = $( '#cpb-lb-bg');
			
		} // end add_bg
		
		l.show = function(){
			
			l.bj.fadeIn( 'fast' );
			
		} // end show
		
		l.hide = function(){
			
			l.bj.fadeOut( 'fast' );
			
		} // end hide
		
		l.add_bg();
		
	} // end cpb_lightbox
	
	
	/*
	* Forms object
	* --------------------------------------------
	*/
	var cpb_forms = function(){
		
		var f = this;
		
		f.forms = $('#cwp-pagebuilder-forms');
		
		f.show = function( id ){
			
			var form = f.forms.find( '#' + id );
			
			form.addClass( 'active');
	
		} // end show
		
		f.hide = function( id ){
			
			f.forms.find( '.cpb-form-wrapper.active' ).css('top' , -9999 ).removeClass( 'active');
	
		} // end show
		
	} // end cpb_forms
	
	
	/*
	* Editor object
	* --------------------------------------------
	*/
	
	var cpb_editor = function(){
		
		var e = this;
		
		e.active_itm = false;
		
		e.editor = $('#cwp-pagebuilder');
		
		e.pop_iframes = function(){
		
			$( '.cpb-item iframe' ).each( function(){
				
				e.pop_iframe( $( this ) );
				
			}); // 
			
		} // end pop_iframes
	
	
		e.pop_iframe = function( frame ){
				
			var content = frame.siblings('textarea.cpb-frame-content');
			
			var css =  frame.siblings('textarea.cpb-frame-css');
			
			if ( content.length ){
				
				e.iframe_content( frame , content.val() );
				
			} // end if
			
			if ( css.length ){
				
				e.iframe_css( frame , css );
				
			} // end if
			
		} // end pop_iframe
		
		e.iframe_content = function( frame , content ){
			
			frame.contents().find('body').html( content );
			
			e.iframe_height( frame );
			
			setTimeout(function(){ e.iframe_height( frame ) }, 500 );
			
		} // end frame_content
		
		e.iframe_css = function( frame , css ){
			
			frame.contents().find('head').append( css.val() );
			
		} // end frame_css
		
		e.iframe_height = function( frame ){
			
			frame.height( '' );
			
			var wh = frame.contents().find('body').innerHeight();
			
			console.log( wh );
			
			frame.height( wh + 10 );
			
		} // end iframe_height
		
		e.add_part = function( action , itm ){
			
			if ( 'show' == action ){
				
				itm.find( 'a').stop().slideDown('fast');
				
			} else {
				
				itm.find( 'a').stop().slideUp('fast');
			}
			
		} // end add_part
		
		/*e.ajax = function( itm , data ){
			
			var form = itm.closest( '.cpb-form-wrapper' );
			
			var data = form.serialize();
			
			var action = itm.data('request');
			
			data.push({ name: 'action', value: 'request_cpb' } 
					'action': 'request_cpb',
					'part':   'row',
				})
			
			jQuery.post(
				ajaxurl, 
				$.param( data ), 
				function(response){
					
					console.log( response );
				
				},
				'json'
			);
			
		}*/ 
		
		e.ajax_part = function( itm , active_itm ){
			
			var form = itm.closest( '.cpb-item-form' );
			
			var data = form.serialize();
			
			jQuery.post(
				ajaxurl, 
				data += '&action=request_cpb&request=part', 
				function(response){
					
					e.add_edtrs( response , active_itm );
					
					e.add_forms( response ); 			
				
				},
				'json'
			);
			
		} 
		
		e.add_edtrs = function( response , active_itm ){
			
			active_itm = active_itm.closest('.cpb-add-part-wrapper');
					
			if ( 'row' == response.part ){
				
				var item_set = active_itm.prev('.cpb-section').children('.cpb-item-set');
				
				item_set.append( response.editor );
				
			} else if ( 'section' == response.part ){
				
				active_itm.after( response.editor );
				
			}// end if
			
		} // end add_edtrs
		
		e.add_forms = function( response ){
			
			var wrap = $( '#cwp-pagebuilder-forms' ); 
			
			for( var i = 0; i < response.forms.length; i++ ){
				
				if ( 'textblock' == response.forms[i]['type'] ){
					
					$('#textblock_ajax_request').first().attr('id' , response.forms[i]['id'] );
					
				} else {
					
					wrap.append( response.forms[i]['html'] );
					
				}// end if
				
			} // end for
			
		} // end add_forms
		
	}
	
	/*
	* Build Objects
	* --------------------------------------------
	*/
	
	var cpb_edtr = new cpb_editor();

	var cpb_fms = new cpb_forms();
	
	var cpb_lb = new cpb_lightbox();
	
	var cpb = new cpb_admin( cpb_lb , cpb_fms , cpb_edtr );
	
});










