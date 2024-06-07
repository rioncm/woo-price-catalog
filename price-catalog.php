<?php
/*
Plugin Name: Price Catalog
Description: Display and transact business with predetermined customer-specific pricing. All pricing methods are "fixed".
Version: 1.2
Author: Rion Morgenstern
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Include the main class
include_once dirname( __FILE__ ) . '/includes/class-price-catalog.php';

// Initialize the plugin
register_activation_hook( __FILE__, array( 'Price_Catalog', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Price_Catalog', 'deactivate' ) );

Price_Catalog::instance();
