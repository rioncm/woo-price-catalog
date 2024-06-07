<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Price_Catalog {
	private static $_instance = null;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}

	public function init() {
		// Hooks to modify WooCommerce behavior
		add_filter( 'woocommerce_product_get_price', array( $this, 'get_customer_specific_price' ), 10, 2 );
		add_filter( 'woocommerce_product_variation_get_price', array( $this, 'get_customer_specific_price' ), 10, 2 );

		// Load API
		include_once dirname( __FILE__ ) . '/class-price-catalog-api.php';
	}

	public function get_customer_specific_price( $price, $product ) {
		if ( is_user_logged_in() ) {
			$user_id = get_current_user_id();
			$product_id = $product->get_id();
			
			// Fetch customer specific price from the database
			global $wpdb;
			$table_name = $wpdb->prefix . 'customer_specific_prices';
			$query = $wpdb->prepare( "SELECT price FROM $table_name WHERE user_id = %d AND product_id = %d", $user_id, $product_id );
			$customer_price = $wpdb->get_var( $query );

			if ( $customer_price ) {
				return $customer_price;
			}
		}

		return $price;
	}

	public static function activate() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'customer_specific_prices';
	
		$charset_collate = $wpdb->get_charset_collate();
	
		$sql = "CREATE TABLE $table_name (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			user_id bigint(20) NOT NULL,
			username varchar(60) NOT NULL,
			product_id bigint(20) NOT NULL,
			sku varchar(100) NOT NULL,
			price decimal(10,2) NOT NULL,
			PRIMARY KEY  (id),
			UNIQUE KEY user_product (user_id, product_id)
		) $charset_collate;";
	
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );
	}
	

	public static function deactivate() {
		// Optionally, drop the table on deactivation
	}
}
