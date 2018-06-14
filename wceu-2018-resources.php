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
use WordCampEurope\WorkshopAuth\Content;

define( 'WCEU_WORKSHOP_AUTH_URL', plugin_dir_url( __FILE__ ) );
define( 'WCEU_WORKSHOP_AUTH_DIR', plugin_dir_path( __FILE__ ) );

// First we make sure the Autoloader that Composer provides is loaded.
$autoloader = __DIR__ . '/vendor/autoload.php';

if ( is_readable( $autoloader ) ) {
	include_once $autoloader;
}

require __DIR__ . '/env.php';

add_action( 'after_setup_theme', function () {
	$page_wp_auth = ( new Page() )
		->set_slug( 'wceu-wp-auth' )
		->set_title( 'Generate a WordPress.com OAuth Token' )
		->set_url();

	$page_wp_app = ( new Page() )
		->set_slug( 'wceu-wp-app' )
		->set_title( 'Create a WordPress.com App' )
		->set_url();

	$page_twitter_app = ( new Page() )
		->set_slug( 'wceu-twitter-app' )
		->set_title( 'Create Twitter App' )
		->set_url();

	$oauth = new OAuth\WordPress();
	$oauth->set_client_id( getenv( 'WORDPRESS_COM_CLIENT_ID' ) )
	      ->set_client_secret( getenv( 'WORDPRESS_COM_CLIENT_SECRET' ) )
	      ->set_redirect_uri( $page_wp_auth->get_url() );

	$contents = [
		new Content\WPAuth( $page_wp_auth, $page_wp_app->get_url(), $oauth ),
		new Content\WPApp( $page_wp_app, $page_wp_auth->get_url() ),
		new Content\TwitterApp( $page_twitter_app ),
	];

	foreach ( $contents as $content ) {
		$content->register();
	}
} );