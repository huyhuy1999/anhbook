/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	
	wp.customize( 'newstore_blog_content_width', function( value ) {
		value.bind( function( to ) {
			var total = 100;
			var sidebar_width = total - to;
			$( 'main#main.site-main' ).css({
				'-ms-flex': '0 0 '+to+'%',
			    'flex': '0 0 '+to+'%',
			    'max-width': to+'%',
			});

			$( 'aside#secondary.sidebar-widget-area' ).css({
				'-ms-flex': '0 0 '+sidebar_width+'%',
			    'flex': '0 0 '+sidebar_width+'%',
			    'max-width': sidebar_width+'%',
			});
			
		});
	});
	

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title, .site-description' ).css( {
					'clip': 'auto',
					'position': 'relative'
				} );
				$( '.site-title a, .site-description' ).css( {
					'color': to
				} );
			}
		} );
	} );
} )( jQuery );
