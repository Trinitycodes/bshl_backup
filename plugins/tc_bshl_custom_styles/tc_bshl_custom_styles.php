<?php
/*
Plugin Name: TC BSHL Custom Styles
Plugin URI: -
Description: Adds Custom Styles to bigskyhorseleasing.com
Version: 0.1
Author: Trinity Vandenacre
Author URI: http://trinitycodes.com
License: GPLV2
*/

class TC_Bshl_Custom_Styles
{

	public function __construct() {

		add_action( 'wp_enqueue_scripts', array( $this, 'tc_add_custom_styles' ) );

	}

	function tc_add_custom_styles() {

		// Register the stylesheet
		wp_register_style( 'tc-nav-styles', plugins_url( 'css/style.css', __FILE__ ) );
		wp_enqueue_style( 'tc-nav-styles' );

	}

}
$bshl_styles = new TC_Bshl_Custom_styles();