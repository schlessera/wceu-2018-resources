<?php declare( strict_types=1 );

namespace WordCampEurope\WorkshopAuth\Page;

use WordCampEurope\WorkshopAuth\OAuth;
use WordCampEurope\WorkshopAuth\Page;
use WordCampEurope\WorkshopAuth\View;

class WPAuth extends Page {

	/**
	 * @var OAuth\WordPress
	 */
	protected $oauth;

	/**
	 * @param View $view
	 */
	public function __construct( View $view = null ) {
		$this->set_title( 'Generate a WordPress.com OAuth Token' );

		parent::__construct( 'wceu-wp-auth', $view );
	}

	/**
	 * @param OAuth\WordPress $oauth
	 *
	 * @return WPAuth
	 */
	public function set_oauth( OAuth\WordPress $oauth ): WPAuth {
		$this->oauth = $oauth;

		return $this;
	}

	/**
	 * @param string $error
	 *
	 * @return string
	 */
	protected function render_error( string $error ): string {
		$error .= sprintf( ' <a href="%s">%s</a>', $this->get_permalink(), 'Try again?' );

		$partial = clone $this->view;
		$partial->add_data( 'error', $error )
		        ->set_template( 'partial/error' );

		return $partial->render();
	}

	public function render(): string {
		$code = filter_input( INPUT_GET, 'code' );
		$redirect_uri = $this->oauth->get_redirect_uri();

		if ( empty( $redirect_uri ) ) {
			return $this->render_error( 'Found invalid redirect URI.' );
		}

		$partial = clone $this->view;

		if ( ! $code ) {
			$partial->add_data( 'url', $this->oauth->get_authorize_url() )
			        ->set_template( 'partial/wp-oauth-url' );

			return $partial->render();
		}

		$token = $this->oauth->get_token( $code );

		if ( $token ) {
			$partial->add_data( 'token', $token->access_token )
			        ->set_template( 'partial/wp-oauth-token' );

			return $partial->render();
		}

		return $this->render_error( 'Something went wrong...' );
	}

}