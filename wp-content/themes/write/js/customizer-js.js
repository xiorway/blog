( function( $ ) {

	// Add upgrade link
	upgrade = $( '<a class="themehaus-link"></a>' )
			.attr( 'href', write_customizer_links.url )
			.attr( 'target', '_blank' )
			.text( write_customizer_links.label );
	$( '.preview-notice' ).append( upgrade );

} )( jQuery );