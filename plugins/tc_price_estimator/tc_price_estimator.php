<?php
/*
Plugin Name: TC Price Estimator
Plugin URI: -
Description: Price Estimator for Big Sky Horse Leasing Website.
Version: 0.1
Author: Trinity Vandenacre
Author URI: http://trinitycodes.com
License: GPLV2
*/

class TC_Price_Estimator
{

	public function __construct() {

		// add the rewrite rules to init action
		add_action( init, array( $this, 'manage_rate_routes' ) );

		register_activation_hook( __FILE__, array( $this, 'flush_application_rewrite_rules' ) );

		// Set the query_vars
		add_filter( 'query_vars', array( $this, 'manage_rate_routes_query_vars' ) );

		add_action( 'template_redirect', array( $this, 'front_controller' ) );

		// load estimator
		add_action( 'trin_load_estimator', array( $this, 'load_estimator' ) );

		// Include the ajax ligraries on the frontend
		//add_action( 'wp_head', array( $this, 'load_ajax_libraries' ) );
		//
		add_action( 'wp_ajax_tc_calculate_totals', array( $this, 'tc_calculate_totals' ) );
		add_action( 'wp_ajax_nopriv_tc_calculate_totals', array( $this, 'tc_calculate_totals' ) );

		// make the rates available to every page
		add_shortcode( 'rates', array( $this, 'create_rates_shortcodes' ) );

	}

	// Front Controller
	public function front_controller()
	{

		global $wp_query;

		$control_action = isset( $wp_query->query_vars['control_action'] ) ? $wp_query->query_vars['control_action'] : '';

		switch( $control_action ) {

			case 'estimator':
				do_action( 'trin_load_estimator' );
				break;

		}
	}

	// AJAX script for calculating totals
	public function tc_calculate_totals() {

		if( !$_POST['data'] ) {

			echo '0';
			exit;

		}

		$data = $_POST['data'];

		$horses = $data['horses'];
        $lease_rate = $data['lease_rate'];
        $miles = $data['hauling'];
        $shoeing = $data['shoeing'];
        $riding_packages = $data['num_riding'];
        $pack_packages = $data['num_packing'];
        $saddle_bags = $data['num_saddle_bags'];
        $rawlide_boxes = $data['num_rawlide_boxes'];
        $hobbles = $data['num_hobbles'];
        $scabbards = $data['num_scabbards'];
        $ropes = $data['num_ropes'];
        $tents = $data['tent_val'];
        $stove = $data['stove_val'];

        $num_horses = $horses === 0 || $horses === '' ? 0 : $horses;
        $lease_total = $lease_rate === 'empty' ? 0 : $lease_rate * $num_horses;
        $hauling_total = $miles === 0 || $miles === '' ? 0 : round(($miles * 1.7) * 2);
        $shoeing_total = $shoeing === 'no' || $shoeing === 'empty' ? 0 : $shoeing * $num_horses;
        $riding_total = $riding_packages === '' || $riding_packages === 0 ? 0 : $riding_packages * 100;
        $pack_total = $pack_packages === '' || $pack_packages === 0 ? 0 : $pack_packages * 100;
        $saddle_bags_total = $saddle_bags === '' || $saddle_bags === 0 ? 0 : $saddle_bags * 15;
        $rawlide_boxes_total = $rawlide_boxes === '' || $rawlide_boxes === 0 ? 0 : $rawlide_boxes * 50;
        $hobbles_total = $hobbles === '' || $hobbles === 0 ? 0 : $hobbles * 5;
        $scabbards_total = $scabbards === '' || $scabbards === 0 ? 0 : $scabbards * 20;
        $ropes_total = $ropes === '' || $ropes === 0 ? 0 : $ropes * 5;
        $tents_val = $tents === 'empty' ? 0 : $tents;
        $stove_val = $stove === 'checked' ? 50 : 0;

        $leasing_total = $lease_total + $hauling_total + $shoeing_total;

        $accessories_total = $riding_total + $pack_total + $saddle_bags_total + $rawlide_boxes_total + $hobbles_total + $scabbards_total + $ropes_total + $tents_val + $stove_val;

        $grand_total = $leasing_total + $accessories_total;

        $down_payment = round($grand_total / 3);

        echo json_encode( array( "leasing_total" => $leasing_total, "accessories_total" => $accessories_total, "grand_total" => $grand_total, "down_payment" => $down_payment ) );

        exit;
    }

    // Create the rates array
    public function create_rates_shortcodes( $atts ) {

    	$attribs = shortcode_atts( array(
    			'name' => ''
    		), $atts);

    	// Get the rates fields from the all-rates page
    	// to do this you must enter the page id into the function.
    	$custom_fields = get_post_custom( 200 );

    	$custom_field = $custom_fields[$atts['name']];

    	if( !$custom_field ) {

    		return 'Rate Not Given';
    		exit;

    	}

    	foreach( $custom_field as $key => $value ) {

    		 $text = $value;

    	}

    	return '$' . $text;
    	exit;
    	
    }

	// Adding custom routing
	public function manage_rate_routes()
	{

		add_rewrite_rule( '^rates/([^/]+)/?', 'index.php?control_action=$matches[1]', 'top' );

	}

	public function manage_rate_routes_query_vars( $query_vars )
	{

		$query_vars[] = 'control_action';
		return $query_vars;

	}

	// Flush the rewrite rules on plugin activation
	public function flush_application_rewrite_rules()
	{

		$this->manage_rate_routes();
		flush_rewrite_rules();

	}

	// Load the Estimator
	public function load_estimator() {

		// Load the css files
		wp_register_style( 'tc-estimator-css', plugins_url( 'css/estimator.css', __FILE__));
		wp_enqueue_style( 'tc-estimator-css' );

	    wp_enqueue_script( 'jquery' );
	    wp_register_script( 'tc-estimator-js', plugins_url( 'js/tc_estimator.js', __FILE__ ), array('jquery'), '1.0', true );
	    wp_enqueue_script( 'tc-estimator-js' );

	    $config_array = array(
	    		'ajaxURL' => admin_url( 'admin-ajax.php' ),
	    		'ajaxNonce' => wp_create_nonce( 'est-nonce' )
	    	);

	    wp_localize_script( 'tc-estimator-js', 'tcest', $config_array );

		include dirname(__FILE__) . '/templates/estimator.php';
		exit;
	}

}
$estimator = new TC_Price_Estimator();

	