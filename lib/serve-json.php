<?php

/**
 * Handle requests with Accept: JSON.
 *
 * @return void
 */
function tjapi_serve_json() {
    global $post;

    if( !isset( $_SERVER['HTTP_ACCEPT'] ) ) {
        return;
    }
    $accept_header = $_SERVER['HTTP_ACCEPT'];
    $requested_type = parse_accept_header( $accept_header );
    if ( $requested_type !== 'application/json' ) {
        return;
    }
    
    $permitted = apply_filters( 'tjapi_available', true, $post );

    if( !$permitted ) {
        wp_die( '<h2>401 unauthorized</h2>', 'Not authorized', [ 'response' => 401 ] );
    }

    $json = tjapi_get_json( $post );

    wp_send_json( $json );
}

add_action( 'template_redirect', 'tjapi_serve_json' );

/**
 * Get a $post as JSON
 *
 * @param WP_Post $post
 * @return å string of JSON
 */
function tjapi_get_json( $post ) {

    $json = [
        'title' => $post->post_title,
        'content' => apply_filters( 'the_content', $post->post_content )
    ];

    $json = apply_filters( 'tjapi_json_before_encoding', $json, $post );

    return json_encode( $json, JSON_UNESCAPED_SLASHES );
}
