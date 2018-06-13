<?php declare( strict_types=1 );

/*
 * Plugin Name:     WCEU-2018 Workshop Code: Resources
 * Plugin URI:      https://github.com/schlessera/wceu-2018-auth
 * Description:     Resources for the WordCamp Europe 2018 Workshop "Dependency Injection and Design Patterns in Real Life" presented by David Mosterd & Alain Schlesser
 * Author:          David Mosterd & Alain Schlesser
 * Version:         1.0.0
 */

use WordCampEurope\WorkshopAuth\Page;
use WordCampEurope\WorkshopAuth\OAuth;

define( 'WCEU_WORKSHOP_AUTH_URL', plugin_dir_url( __FILE__ ) );
define( 'WCEU_WORKSHOP_AUTH_DIR', plugin_dir_path( __FILE__ ) );

// First we make sure the Autoloader that Composer provides is loaded.
$autoloader = __DIR__ . '/vendor/autoload.php';

if ( is_readable( $autoloader ) ) {
	include_once $autoloader;
}

require __DIR__ . '/env.php';

/* @var Page[] $wceu_pages */
$wceu_pages = [
	new Page\WPApp(),
	new Page\WPAuth(),
	new Page\TwitterApp(),
];

add_action( 'init', function () use ( $wceu_pages ) {
	foreach ( $wceu_pages as $page ) {
		$page->persist();

		if ( $page instanceof Page\WPAuth ) {
			$oauth = new OAuth\WordPress();
			$oauth->set_client_id( getenv( 'WORDPRESS_COM_CLIENT_ID' ) )
			      ->set_client_secret( getenv( 'WORDPRESS_COM_CLIENT_SECRET' ) )
			      ->set_redirect_uri( $page->get_permalink() );

			$page->set_oauth( $oauth );
		}
	}
} );

add_filter( 'the_content', function ( $content ) use ( $wceu_pages ) {
	foreach ( $wceu_pages as $page ) {
		if ( is_page( $page->get_slug() ) ) {
			return $page->render();
		}
	}

	return $content;
} );