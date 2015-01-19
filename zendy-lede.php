<?php
/*
Plugin Name: Zendy Lede
Version: 1.1.3
Plugin URI: https://hq.zendy.net/wordpress/plugins/lede/
Author: Zendy Labs
Author URI: https://hq.zendy.net/
Description: Add a high-impact opening statement with full-screen video background on your homepage
TODO: internationalize
*/


/**
 * ===========================
 * REGISTER STYLES AND SCRIPTS
 * ===========================
 */

add_action( 'wp_enqueue_scripts', 'zendy_lede_styles' );
add_action( 'wp_enqueue_scripts', 'zendy_lede_scripts' );
add_action( 'admin_enqueue_scripts', 'zendy_lede_admin_head' );

if ( !function_exists( 'zendy_lede_admin_head' ) ){
	function zendy_lede_admin_head(){
		wp_enqueue_style( 'zendy_lede_stylesheet', plugins_url( 'css/back-end-styles.css', __FILE__	) );
	}
}

if ( !function_exists ( 'zendy_lede_styles' ) ){
	function zendy_lede_styles(){
		wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css', '', '', 'all' );
		wp_register_style( 'zendy_lede_styles', plugins_url( 'css/front-end-styles.css', __FILE__ ), false, false );
		wp_enqueue_style( 'zendy_lede_styles' );
	
	}
}

if ( !function_exists ( 'zendy_lede_scripts' ) ){
	function zendy_lede_scripts(){
		wp_register_script( 'zendy_lede_scripts', plugins_url( 'js/scripts.js', __FILE__ ), array( 'jquery' ), false, true );
		$params = array(
	        'wp_admin_ajax_url'  => admin_url("admin-ajax.php"),
	    );
		wp_localize_script( 'zendy_lede_scripts', 'frontEndParams', $params );
		wp_enqueue_script( 'zendy_lede_scripts' );
	}
}

/**
 * =============================
 * DASHBOARD MENU & OPTIONS PAGE
 * =============================
 */

add_action( 'admin_menu', 'zendy_lede_add_admin_menu' );
add_action( 'admin_init', 'zendy_lede_settings_init' );

if ( !function_exists( 'zendy_lede_add_admin_menu' ) ){
	function zendy_lede_add_admin_menu(){ 
		add_options_page( 'Zendy Lede', 'Zendy Lede', 'manage_options', 'zendy_lede', 'zendy_lede_options_page' );
	}
}

if ( !function_exists( 'zendy_lede_settings_init' ) ){
	
	function zendy_lede_settings_init(  ) { 
	
		register_setting( 'pluginPage', 'zendy_lede_settings' );
		
		add_settings_section(
			'zendy_lede_pluginPage_section', 
			__( 'Section description 1', 'zendy_lede' ), 
			'zendy_lede_settings_section_callback', 
			'pluginPage'
		);
	
		// FIELD: MP4 URL
		add_settings_field( 
			'zendy_lede_text_field_media_mp4_url', 
			__( 'Media MP4 URL', 'zendy_lede' ), 
			'zendy_lede_text_field_media_mp4_url_render', 
			'pluginPage', 
			'zendy_lede_pluginPage_section' 
		);
	
		// FIELD: OGG URL
		add_settings_field( 
			'zendy_lede_text_field_media_ogg_url', 
			__( 'Media OGG URL', 'zendy_lede' ), 
			'zendy_lede_text_field_media_ogg_url_render', 
			'pluginPage', 
			'zendy_lede_pluginPage_section' 
		);
	
		// FIELD: WebM URL
		add_settings_field( 
			'zendy_lede_text_field_media_webm_url', 
			__( 'Media WebM URL', 'zendy_lede' ), 
			'zendy_lede_text_field_media_webm_url_render', 
			'pluginPage', 
			'zendy_lede_pluginPage_section' 
		);
		
		// FIELD: Poster
		add_settings_field( 
			'zendy_lede_text_field_media_poster_url', 
			__( 'Media Poster', 'zendy_lede' ), 
			'zendy_lede_text_field_media_poster_url_render', 
			'pluginPage', 
			'zendy_lede_pluginPage_section' 
		);
		
		// FIELD: Heading Type
		add_settings_field( 
			'zendy_lede_select_field_heading_type', 
			__( 'Heading Type', 'zendy_lede' ), 
			'zendy_lede_select_field_heading_type_render', 
			'pluginPage', 
			'zendy_lede_pluginPage_section' 
		);

		// FIELD: Heading Image
		add_settings_field( 
			'zendy_lede_text_field_heading_image_url', 
			__( 'Heading Image URL', 'zendy_lede' ), 
			'zendy_lede_text_field_heading_image_url_render', 
			'pluginPage', 
			'zendy_lede_pluginPage_section' 
		);

		// FIELD: Heading
		add_settings_field( 
			'zendy_lede_textarea_field_heading', 
			__( 'Heading', 'zendy_lede' ), 
			'zendy_lede_textarea_field_heading_render', 
			'pluginPage', 
			'zendy_lede_pluginPage_section' 
		);
	
		// FIELD: Subheading
		add_settings_field( 
			'zendy_lede_textarea_field_subheading', 
			__( 'Subheading', 'zendy_lede' ), 
			'zendy_lede_textarea_field_subheading_render', 
			'pluginPage', 
			'zendy_lede_pluginPage_section' 
		);
	
		// FIELD: Call to action
		add_settings_field( 
			'zendy_lede_text_field_cta', 
			__( 'Call to action text', 'zendy_lede' ), 
			'zendy_lede_text_field_cta_render', 
			'pluginPage', 
			'zendy_lede_pluginPage_section' 
		);
	
		// FIELD: Link for call to action
		add_settings_field( 
			'zendy_lede_text_field_cta_link', 
			__( 'Call to action link URL', 'zendy_lede' ), 
			'zendy_lede_text_field_cta_link_render', 
			'pluginPage', 
			'zendy_lede_pluginPage_section' 
		);
	
		// FIELD: More info text
		add_settings_field( 
			'zendy_lede_text_field_info', 
			__( 'More info text', 'zendy_lede' ), 
			'zendy_lede_text_field_info_render', 
			'pluginPage', 
			'zendy_lede_pluginPage_section' 
		);
	
	}
	
}

// FIELD: Heading Type
if ( !function_exists( 'zendy_lede_select_field_heading_type_render' ) ){
	function zendy_lede_select_field_heading_type_render(  ) { 
		$options = get_option( 'zendy_lede_settings' );
		?>
		<select name='zendy_lede_settings[zendy_lede_select_field_heading_type]'>
			<option value='none' <?php selected( $options['zendy_lede_select_field_heading_type'], 'none' ); ?>>None</option>
			<option value='image' <?php selected( $options['zendy_lede_select_field_heading_type'], 'image' ); ?>>Image</option>
			<option value='text' <?php selected( $options['zendy_lede_select_field_heading_type'], 'text' ); ?>>Text</option>
		</select>
		<?php
	}
}

// FIELD RENDER: MP4 URL
if ( !function_exists( 'zendy_lede_text_field_media_mp4_url_render' ) ){
	function zendy_lede_text_field_media_mp4_url_render(  ) { 
		$options = get_option( 'zendy_lede_settings' );
		?>
		<input size="70" type='text' name='zendy_lede_settings[zendy_lede_text_field_media_mp4_url]' value='<?php echo $options['zendy_lede_text_field_media_mp4_url'] ? $options['zendy_lede_text_field_media_mp4_url'] : 'http://example.com/my-video.mp4'; ?>'>
		<p>
			If you need a sample video to test this plugin you can use the following URL for the MP4 format:<br>
		</p>
		<p>
			<code>http://cdn.zendy.net/videos/zendy-lede-placeholder-video.mp4</code>
		</p>
		<?php
	}
}

// FIELD: OGG URL
if ( !function_exists( 'zendy_lede_text_field_media_ogg_url_render' ) ){
	function zendy_lede_text_field_media_ogg_url_render(  ) { 
		$options = get_option( 'zendy_lede_settings' );
		?>
		<input size="70" type='text' name='zendy_lede_settings[zendy_lede_text_field_media_ogg_url]' value='<?php echo $options['zendy_lede_text_field_media_ogg_url'] ? $options['zendy_lede_text_field_media_ogg_url'] : 'http://example.com/my-video.ogv'; ?>'>
		<p>
			If you need a sample video to test this plugin you can use the following URL for the OGG format:<br>
		</p>
		<p>
			<code>http://cdn.zendy.net/videos/zendy-lede-placeholder-video.ogv</code>
		</p>
		<?php
	}
}

// FIELD: WebM URL
if ( !function_exists( 'zendy_lede_text_field_media_webm_url_render' ) ){
	function zendy_lede_text_field_media_webm_url_render(  ) { 
		$options = get_option( 'zendy_lede_settings' );
		?>
		<input size="70" type='text' name='zendy_lede_settings[zendy_lede_text_field_media_webm_url]' value='<?php echo $options['zendy_lede_text_field_media_webm_url'] ? $options['zendy_lede_text_field_media_webm_url'] : 'http://example.com/my-video.webm'; ?>'>
		<p>
			If you need a sample video to test this plugin you can use the following URL for the WEBM format:<br>
		</p>
		<p>	
			<code>http://cdn.zendy.net/videos/zendy-lede-placeholder-video.webm</code>
		</p>
		<?php
	}
}

// FIELD: Poster URL
if ( !function_exists( 'zendy_lede_text_field_media_poster_url_render' ) ){
	function zendy_lede_text_field_media_poster_url_render(  ) { 
		$options = get_option( 'zendy_lede_settings' );
		?>
		<input size="70" type='text' name='zendy_lede_settings[zendy_lede_text_field_media_poster_url]' value='<?php echo $options['zendy_lede_text_field_media_poster_url'] ? $options['zendy_lede_text_field_media_poster_url'] : 'http://example.com/my-image.jpg'; ?>'>
		<?php
	}
}

// FIELD: Heading Image URL
if ( !function_exists( 'zendy_lede_text_field_heading_image_url_render' ) ){
	function zendy_lede_text_field_heading_image_url_render(  ) { 
		$options = get_option( 'zendy_lede_settings' );
		?>
		<input size="70" type='text' name='zendy_lede_settings[zendy_lede_text_field_heading_image_url]' value='<?php echo $options['zendy_lede_text_field_heading_image_url'] ? $options['zendy_lede_text_field_heading_image_url'] : 'http://example.com/my-image.jpg'; ?>'>
		<?php
	}
}

// FIELD: Heading
if ( !function_exists( 'zendy_lede_textarea_field_heading_render' ) ){
	function zendy_lede_textarea_field_heading_render(  ) { 
		$options = get_option( 'zendy_lede_settings' );
		?>
		<textarea cols='40' rows='5' name='zendy_lede_settings[zendy_lede_textarea_field_heading]'><?php echo $options['zendy_lede_textarea_field_heading'] ? $options['zendy_lede_textarea_field_heading'] : 'Heading'; ?></textarea>
		<?php
	}
}

// FIELD: Subheading
if ( !function_exists( 'zendy_lede_textarea_field_subheading_render' ) ){
	function zendy_lede_textarea_field_subheading_render(  ) { 
		$options = get_option( 'zendy_lede_settings' );
		?>
		<textarea cols='40' rows='5' name='zendy_lede_settings[zendy_lede_textarea_field_subheading]'><?php echo $options['zendy_lede_textarea_field_subheading'] ? $options['zendy_lede_textarea_field_subheading'] : 'Subheading'; ?></textarea>
		<?php
	}
}

// FIELD: Call to action text
if ( !function_exists( 'zendy_lede_text_field_cta_render' ) ){
	function zendy_lede_text_field_cta_render(  ) { 
		$options = get_option( 'zendy_lede_settings' );
		?>
		<input type='text' name='zendy_lede_settings[zendy_lede_text_field_cta]' value='<?php echo $options['zendy_lede_text_field_cta'] ? $options['zendy_lede_text_field_cta'] : 'Call To Action'; ?>'>
		<?php
	}
}

// FIELD: Link for call to action
if ( !function_exists( 'zendy_lede_text_field_cta_link_render' ) ){
	function zendy_lede_text_field_cta_link_render(  ) { 
		$options = get_option( 'zendy_lede_settings' );
		?>
		<input type='text' name='zendy_lede_settings[zendy_lede_text_field_cta_link]' value='<?php echo $options['zendy_lede_text_field_cta_link'] ? $options['zendy_lede_text_field_cta_link'] : '#'; ?>'>
		<?php
	}
}

// FIELD: More info text
if ( !function_exists( 'zendy_lede_text_field_info_render' ) ){
	function zendy_lede_text_field_info_render(  ) { 
		$options = get_option( 'zendy_lede_settings' );
		?>
		<input type='text' name='zendy_lede_settings[zendy_lede_text_field_info]' value='<?php echo $options['zendy_lede_text_field_info'] ? $options['zendy_lede_text_field_info'] : 'More Info'; ?>'>
		<?php
	}
}

if ( !function_exists( 'zendy_lede_settings_section_callback' ) ){
	function zendy_lede_settings_section_callback(  ) { 
		// Nothing here for now
	}
}

if ( !function_exists( 'zendy_lede_options_page' ) ){
	function zendy_lede_options_page(  ) { 
	
		?>
		<!-- Settings confirmation messages -->
		<div class="zendy-updated" <?= empty( $_GET['settings-updated'] ) ? 'style="display:none"' : '' ?>>
			Settings saved.
		</div>
	
		<!-- Plugin HTML wrap -->		
		<div id="zendy-lede-wrap" class="zendy-lede-wrap wrap">
		
			<!-- Header -->
			<div class="zendy-lede-header">
			
				
				<img class="zendy-lede-logo" src="<?= plugin_dir_url( __FILE__ ) . '/images/zendy-lede-logo-250x250.png' ?>" alt="Zendy lede Logo" />
				
				<!-- Description -->
				<h1 class="zendy-lede-title">Zendy Lede</h1>
				
				
				<h3 class="zendy-lede-title">Make a splash with a full screen video background on your website.</h3>
				<p class="zendy-lede-title">Zendy lede allows you to easily add a high-impact opening statement on your Wordpress website homepage.</p>
				
				<?php
				
				// Tabs list
				//$tabs = array( 'settings' => 'Settings', 'troubleshooting' => 'Troubleshooting', 'faq' => 'FAQ' );
				$tabs = array( 'settings' => 'Settings' );
				
				// Set current tab or default to settings tab
				$current = isset( $_GET['tab'] ) ? $_GET['tab'] : 'settings';
				
				// Output tabs
				echo '<h2 class="nav-tab-wrapper zendy-lede-tabs">';
				foreach( $tabs as $tab => $name ){
					$class = ( $tab == $current || ( !isset( $_GET['tab'] ) && $tab == 'settings' ) ) ? ' nav-tab-active' : '';
					echo "<a class='nav-tab$class' href='?page=zendy_lede&tab=$tab'>$name</a>";			
				}
				echo '</h2>';	
	
				?>
				
			</div> <!-- /.zendy-lede-header -->
			
			<div class="zendy-lede-form-wrapper">
	
				<form action='options.php' method='post'>
				
					<h2>Zendy Lede</h2>
					
					<?php
					settings_fields( 'pluginPage' );
					do_settings_sections( 'pluginPage' );
					submit_button();
					?>
					
				</form>
				
			</div>
		</div>
		<?php
	
	}
}

/**
 * =======================
 * HTML OUTPUT TO HOMEPAGE
 * THIS IS CALLED VIA AJAX
 * =======================
 */

add_action( 'wp_ajax_zendy_lede_get_lede_html', 'zendy_lede_get_lede_html_callback' );
add_action( 'wp_ajax_nopriv_zendy_lede_get_lede_html', 'zendy_lede_get_lede_html_callback' );

//add_action("wp_ajax_zendy_lede_get_lede_html", "zendy_lede_get_lede_html");
//add_action("wp_ajax_nopriv_zendy_lede_get_lede_html", "zendy_lede_get_lede_html");

if ( !function_exists( 'zendy_lede_get_lede_html_callback' ) ){
	function zendy_lede_get_lede_html_callback(){
		$options = get_option( 'zendy_lede_settings' );
		?>
		
		<!-- VIDEO CODE -->
		<div id="zendy-lede-media-wrapper">
			<video id="zendy-lede-video" autoplay loop muted="true">
				<source src="<?php echo $options['zendy_lede_text_field_media_mp4_url'] ? $options['zendy_lede_text_field_media_mp4_url'] : 'http://example.com/my-video.mp4' ?>" type="video/mp4">
				<source src="<?php echo $options['zendy_lede_text_field_media_ogg_url'] ? $options['zendy_lede_text_field_media_ogg_url'] : 'http://example.com/my-video.ogv' ?>" type="video/ogg">
				<source src="<?php echo $options['zendy_lede_text_field_media_webm_url'] ? $options['zendy_lede_text_field_media_webm_url'] : 'http://example.com/my-video.webm' ?>" type="video/webm">
			</video>
		</div>
		
		<!-- DARK OVERLAY TO MAKE WHITE TEXT MORE READABLE -->
		<div id="zendy-lede-overlay"></div>
		
		<!-- TEXT / HEADING / LINKS -->
		<div id="zendy-lede-text-wrapper">
			<?php
			if( $options['zendy_lede_select_field_heading_type'] !== 'none' ){
				if( $options['zendy_lede_select_field_heading_type'] == 'text' ){
					?>
					<h1 id="zendy-lede-heading"><?php echo $options['zendy_lede_textarea_field_heading'] ? $options['zendy_lede_textarea_field_heading'] : 'Heading' ?></h1>
					<h2 id="zendy-lede-subheading"><?php echo $options['zendy_lede_textarea_field_subheading'] ? $options['zendy_lede_textarea_field_subheading'] : 'Subheading' ?></h2>
					<?php
				}elseif( $options['zendy_lede_select_field_heading_type'] == 'image' ){
					?>
					<h1 id="zendy-lede-heading"><img src="<?php echo $options['zendy_lede_text_field_heading_image_url'] ?>" /></h1>
					<?php	
				}
				?>
				<div id="zendy-lede-cta"><a href="<?php echo $options['zendy_lede_text_field_cta_link'] ? $options['zendy_lede_text_field_cta_link'] : '#' ?>"><?php echo $options['zendy_lede_text_field_cta'] ? $options['zendy_lede_text_field_cta'] : 'Call To Action' ?> <i class="fa fa-caret-right"></i></a></div>
			<?
			} 
			?>
			<div id="zendy-lede-info"><a href="#"><?php echo $options['zendy_lede_text_field_info'] ? $options['zendy_lede_text_field_info'] : 'More Info' ?><br><i class="fa fa-caret-down"></i></a></div>
		</div>
		
		<!-- THIS IS USED FOR STYLING AND TO AUTO-SCROLL TO CONTENT -->
		<div id="zendy-lede-bottom-border"></div>
		<?
		// Adding "exit()" here prevents wp_ajax from returning an extra 0 character
		exit();
	}
}


// Plugin page links
// Row meta links (links under description of plugin)
// Add action links on plugin page in to Plugin Description block
// Add row meta links on plugin page (links under plugin description)
add_filter( 'plugin_row_meta', 'zendy_lede_register_plugin_row_meta_links', 10, 2 );

if ( ! function_exists ( 'zendy_lede_register_plugin_row_meta_links' ) ) {
	
	// Add row meta links (links under description of plugin)
	// Gets hooked on plugin_row_meta
	function zendy_lede_register_plugin_row_meta_links( $links, $file ) {
		
		// If our plugin name is in the file name, let's do stuff
		if ( strpos( $file, 'zendy-lede.php' ) !== false ) {
		
			// Add all new links into an array
			$new_links = array(	
				'<a href="https://hq.zendy.net/wordpress/plugins/" target="_blank">More plugins by Zendy Labs</a>',
				'<a href="https://hq.zendy.net/wordpress/plugins/lede/donate/" target="_blank">Donate</a>'
			);
		
			// Merge new links into main row meta links array
			$links = array_merge( $links, $new_links );
		}
	
		return $links;	      
	
	}

}

// Add action links on plugin page (links under plugin name)
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'zendy_lede_register_plugin_action_links' );

// Plugin page links
// Action links (links under name of plugin)
if ( ! function_exists ( 'zendy_lede_register_plugin_action_links' ) ) {

	// Function to add action links (links under name of plugin)
	// Gets hooked on plugin_action_links_
	function zendy_lede_register_plugin_action_links( $links ) {
	
		// Add all new links into an array
		$new_links = array(
			'<a href="'. get_admin_url(null, 'options-general.php?page=zendy_lede') .'">Settings</a>'
		);

		// Merge new links into main action links array
		$links = array_merge( $links, $new_links );
		
		return $links;
	
	}

}