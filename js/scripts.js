// Adjust lede size
function setDimensions(){

	// Get windows height
	var windowsHeight = jQuery(window).height();
	
	// Get windows width
	var windowsWidth = jQuery(window).width();
	
	var originalVideoWidth = 16;
	var originalVideoHeight = 9;
	var originalVideoRatio = originalVideoWidth / originalVideoHeight;
	var windowRatio = windowsWidth / windowsHeight;
	
	// Set media wrapper to windows height
	// This pushes the main page content down
	jQuery( '#zendy-lede-media-wrapper' ).css( 'height', windowsHeight + 'px' );
	
	// Set the overlay size to full height
	jQuery( '#zendy-lede-overlay' ).css( 'height', windowsHeight + 'px' );
	
	// Set the text wrapper size size to full height
	jQuery( '#zendy-lede-text-wrapper' ).css( 'height', windowsHeight + 'px' );
	
	// Set the more info link
	jQuery( '#zendy-lede-info' ).css( 'top', ( windowsHeight - 60 ) + 'px' );	
	
	jQuery( '#zendy-lede-video' ).css( 
		{
			'height': windowsHeight + 'px',
			'width': 'auto'
		}
	);
		
	if( originalVideoRatio < windowRatio ){
		var newVideoWidth = windowsWidth;
		var newVideoHeight = ( newVideoWidth * originalVideoHeight ) / originalVideoWidth;
		jQuery( '#zendy-lede-video' ).css( 
			{
				'width': newVideoWidth + 'px',
				'height': newVideoHeight + 'px'
			}
		);
		var newVideoHeightOffset = ( windowsHeight - newVideoHeight ) / 2;
		jQuery( '#zendy-lede-video' ).css( 
			{
				'top': newVideoHeightOffset + 'px',
				'left': '0px'
			}
		);
	}else{
		var newVideoHeight = windowsHeight;
		var newVideoWidth = ( newVideoHeight * originalVideoWidth ) / originalVideoHeight;
		jQuery( '#zendy-lede-video' ).css( 
			{
				'height': newVideoHeight + 'px',
				'width': newVideoWidth + 'px'
			}
		);
		var newVideoWidthOffset = ( windowsWidth - newVideoWidth ) / 2;
		jQuery( '#zendy-lede-video' ).css( 
			{
				'left': newVideoWidthOffset + 'px',
				'top': '0px'
			}
		);
	}
	
	jQuery('#zendy-lede-text-wrapper').css('padding-top', (windowsHeight / 3.5) + 'px');
	if( windowsHeight < 410 ){
	   jQuery('.home-image-wrapper').hide();
	}
	
		   
}

//when site loads, we adjust the heights of the sections
jQuery( document ).ready(function(){

	if( window.location.pathname === '/' ){

		var data = {};
		data.action = 'zendy_lede_get_lede_html';
		jQuery.post(
			'/wp-admin/admin-ajax.php', 
			data,
			function( ledeHTML ){

				jQuery('body.home').prepend( ledeHTML );
				setDimensions();
				jQuery('#zendy-lede-text-wrapper').click(function(){
					jQuery('#zendy-lede-video').get(0).play();
				});
				jQuery('#zendy-lede-video').on('loadstart', function(evt){

					jQuery('body.home').fadeIn(500);
				});
				jQuery('#zendy-lede-info').click(function(evt){
					evt.preventDefault();
					jQuery('html, body').animate({
				        scrollTop: jQuery("#zendy-lede-bottom-border").offset().top
				    }, 500);
				});	
			}			
		);
	}
});

//when resizing the site, we adjust the heights of the sections
jQuery(window).resize(function() {
	if( window.location.pathname === '/' ){
    	setDimensions();
    }
});