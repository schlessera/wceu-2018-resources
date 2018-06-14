<?php declare( strict_types=1 );

namespace WordCampEurope\WorkshopAuth\Content;

use WordCampEurope\WorkshopAuth\OAuth;
use WordCampEurope\WorkshopAuth\Content;
use WordCampEurope\WorkshopAuth\View;
use WordCampEurope\WorkshopAuth\Page;

class WPAuth extends Content {

	/**
	 * @var OAuth\WordPress
	 */
	protected $oauth;

	/**
	 * @var string
	 */
	protected $wp_app_url;

	/**
	 * @param Page            $page
	 * @param string          $wp_app_url
	 * @param OAuth\WordPress $oauth
	 */
	public function __construct( Page $page, string $wp_app_url, OAuth\WordPress $oauth ) {
		$this->oauth = $oauth;
		$this->wp_app_url = $wp_app_url;

		parent::__construct( $page );
	}

	/**
	 * @param string $error
	 *
	 * @return string
	 */
	protected function render_error( string $error ): string {
		$view = new View();
		$view->set_template( 'partial/error' );

		return $view->render( [
			'title' => 'Error',
			'error' => $error,
		] );
	}

	public function render(): string {
		$code = filter_input( INPUT_GET, 'code' );

		if ( ! $this->oauth->is_valid() ) {
			$error = sprintf( 'Did you complete the steps from <a href="%s">this page?</a>', $this->wp_app_url );

			return $this->render_error( $error );
		}

		if ( ! $code ) {
			$view = new View();
			$view->set_template( 'partial/wp-oauth-url' );

			return $view->render( [
				'url' => $this->oauth->get_authorize_url(),
			] );
		}

		$token = $this->oauth->get_token( $code );

		if ( $token ) {
			$view = new View();
			$view->set_template( 'partial/wp-oauth-token' );

			return $view->render( [
				'token' => $token->access_token,
			] );
		}

		return $this->render_error( 'Something went wrong... ' . sprintf( '<a href="%s">%s</a>', $this->wp_app_url, 'Maybe try again?' ) );
	}

}