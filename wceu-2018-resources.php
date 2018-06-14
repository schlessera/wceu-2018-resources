<?php declare( strict_types=1 );

/*
 * Plugin Name:     WCEU-2018 Workshop Code: Resources
 * Plugin URI:      https://github.com/schlessera/wceu-2018-resources
 * Description:     Resources for the WordCamp Europe 2018 Workshop "Dependency Injection and Design Patterns in Real Life" presented by David Mosterd & Alain Schlesser
 * Author:          David Mosterd & Alain Schlesser
 * Version:         1.0.0
 */

use WordCampEurope\Resources\Page;
use WordCampEurope\Resources\OAuth;
use WordCampEurope\Resources\Content;
use WordCampEurope\Resources\Pages;

define( 'WCEU_WORKSHOP_AUTH_URL', plugin_dir_url( __FILE__ ) );
define( 'WCEU_WORKSHOP_AUTH_DIR', plugin_dir_path( __FILE__ ) );

// First we make sure the Autoloader that Composer provides is loaded.
$autoloader = __DIR__ . '/vendor/autoload.php';

if ( is_readable( $autoloader ) ) {
	include_once $autoloader;
}

require __DIR__ . '/env.php';

$pages_config = [
	'wceu-wp-auth'     => 'Generate a WordPress.com OAuth Token',
	'wceu-wp-app'      => 'Create a WordPress.com App',
	'wceu-twitter-app' => 'Create Twitter App',
];

$wceu_pages = new Pages();

foreach ( $pages_config as $slug => $title ) {
	$page = new Page( $slug, $title );
	$page->register();

	$wceu_pages->add_page( $page );
}

add_action( 'init', function () use ( $wceu_pages ) {
	$page_wp_app = $wceu_pages->get_page( 'wceu-wp-app' );
	$page_wp_auth = $wceu_pages->get_page( 'wceu-wp-auth' );

	$oauth = new OAuth\WordPress();
	$oauth->set_client_id( getenv( 'WORDPRESS_COM_CLIENT_ID' ) )
	      ->set_client_secret( getenv( 'WORDPRESS_COM_CLIENT_SECRET' ) )
	      ->set_redirect_uri( $page_wp_app->get_url() );

	$contents = [
		new Content\WPAuth( $page_wp_auth, $page_wp_app->get_url(), $oauth ),
		new Content\WPApp( $page_wp_app, $page_wp_auth->get_url() ),
		new Content\TwitterApp( $wceu_pages->get_page( 'wceu-twitter-app' ) ),
	];

	foreach ( $contents as $content ) {
		$content->register();
	}
} );