<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Price_Catalog_API {

	public function __construct() {
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	public function register_routes() {
		register_rest_route( 'price-catalog/v1', '/price', array(
			'methods' => 'POST',
			'callback' => array( $this, 'create_price' ),
			'permission_callback' => function() {
				return current_user_can( 'manage_options' );
			},
		) );

		register_rest_route( 'price-catalog/v1', '/price/(?P<id>\d+)', array(
			'methods' => 'GET',
			'callback' => array( $this, 'get_price' ),
			'permission_callback' => function() {
				return current_user_can( 'manage_options' );
			},
		) );

		register_rest_route( 'price-catalog/v1', '/price/(?P<id>\d+)', array(
			'methods' => 'DELETE',
			'callback' => array( $this, 'delete_price' ),
			'permission_callback' => function() {
				return current_user_can( 'manage_options' );
			},
		) );
	}

	public function create_price( $request ) {
		global $wpdb;
		$table_name = $wpdb->prefix . 'customer_specific_prices';

		$user_id = $request['user_id'];
		$product_id = $request['product_id'];
		$price = $request['price'];

		$wpdb->replace( $table_name, array(
			'user_id' => $user_id,
			'product_id' => $product_id,
			'price' => $price,
		), array(
			'%d',
			'%d',
			'%f',
		) );

		return new WP_REST_Response( 'Price added/updated', 200 );
	}

	public function get_price( $request ) {
		global $wpdb;
		$table_name = $wpdb->prefix . 'customer_specific_prices';
		$id = $request['id'];

		$query = $wpdb->prepare( "SELECT * FROM $table_name WHERE id = %d", $id );
		$result = $wpdb->get_row( $query );

		if ( $result ) {
			return new WP_REST_Response( $result, 200 );
		}

		return new WP_Error( 'no_price', 'Price not found', array( 'status' => 404 ) );
	}

	public function delete_price( $request ) {
		global $wpdb;
		$table_name = $wpdb->prefix . 'customer_specific_prices';
		$id = $request['id'];

		$deleted = $wpdb->delete( $table_name, array( 'id' => $id ), array( '%d' ) );

		if ( $deleted ) {
			return new WP_REST_Response( 'Price deleted', 200 );
		}

		return new WP_Error( 'no_price', 'Price not found', array( 'status' => 404 ) );
	}
}

new Price_Catalog_API();
