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

        register_rest_route( 'price-catalog/v1', '/prices/batch', array(
            'methods' => 'POST',
            'callback' => array( $this, 'batch_update_prices' ),
            'permission_callback' => function() {
                return current_user_can( 'manage_options' );
            },
        ) );

        register_rest_route( 'price-catalog/v1', '/prices', array(
            'methods' => 'GET',
            'callback' => array( $this, 'get_prices' ),
            'permission_callback' => function() {
                return current_user_can( 'manage_options' );
            },
        ) );
    }

    public function create_price( $request ) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'customer_specific_prices';

        $user_id = $request['user_id'];
        $username = $request['username'];
        $product_id = $request['product_id'];
        $sku = $request['sku'];
        $price = $request['price'];

        $wpdb->replace( $table_name, array(
            'user_id' => $user_id,
            'username' => $username,
            'product_id' => $product_id,
            'sku' => $sku,
            'price' => $price,
        ), array(
            '%d',
            '%s',
            '%d',
            '%s',
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

    public function batch_update_prices( $request ) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'customer_specific_prices';

        $prices = $request['prices'];
        $responses = array();

        foreach ( $prices as $price_data ) {
            $user_id = $price_data['user_id'];
            $username = $price_data['username'];
            $product_id = $price_data['product_id'];
            $sku = $price_data['sku'];
            $price = $price_data['price'];
            $operation = isset( $price_data['operation'] ) ? $price_data['operation'] : 'update';

            if ( 'delete' === $operation ) {
                $deleted = $wpdb->delete( $table_name, array(
                    'user_id' => $user_id,
                    'product_id' => $product_id,
                ), array(
                    '%d',
                    '%d',
                ) );

                if ( $deleted ) {
                    $responses[] = array( 'status' => 'deleted', 'user_id' => $user_id, 'product_id' => $product_id );
                } else {
                    $responses[] = new WP_Error( 'delete_failed', 'Failed to delete price', array( 'status' => 500 ) );
                }
            } else {
                $wpdb->replace( $table_name, array(
                    'user_id' => $user_id,
                    'username' => $username,
                    'product_id' => $product_id,
                    'sku' => $sku,
                    'price' => $price,
                ), array(
                    '%d',
                    '%s',
                    '%d',
                    '%s',
                    '%f',
                ) );

                $responses[] = array( 'status' => 'updated', 'user_id' => $user_id, 'product_id' => $product_id, 'price' => $price );
            }
        }

        return new WP_REST_Response( $responses, 200 );
    }

    public function get_prices( $request ) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'customer_specific_prices';

        $user_id = $request->get_param('user_id');
        $username = $request->get_param('username');

        if ( $user_id ) {
            $query = $wpdb->prepare( "SELECT * FROM $table_name WHERE user_id = %d", $user_id );
        } elseif ( $username ) {
            $query = $wpdb->prepare( "SELECT * FROM $table_name WHERE username = %s", $username );
        } else {
            return new WP_Error( 'invalid_request', 'You must provide a user_id or username', array( 'status' => 400 ) );
        }

        $results = $wpdb->get_results( $query );

        if ( $results ) {
            return new WP_REST_Response( $results, 200 );
        }

        return new WP_Error( 'no_prices', 'No prices found', array( 'status' => 404 ) );
    }
}

new Price_Catalog_API();
