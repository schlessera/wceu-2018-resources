<?php declare( strict_types=1 );

namespace WordCampEurope\WorkshopAuth\OAuth;

class WordPress {

	const API_URL = 'https://public-api.wordpress.com/';
	const API_ENDPOINT_AUTH = 'oauth2/authorize';
	const API_ENDPOINT_TOKEN = 'oauth2/token';

	/**
	 * @var string
	 */
	protected $client_id;

	/**
	 * @var string
	 */
	protected $client_secret;

	/**
	 * @var string
	 */
	protected $redirect_uri;

	/**
	 * @return string
	 */
	public function get_authorize_url(): string {
		if ( empty( $this->client_id ) || empty( $this->redirect_uri ) ) {
			throw new \RuntimeException( 'Missing client_id or redirect_uri.' );
		}

		$params = [
			'client_id'     => $this->client_id,
			'redirect_uri'  => $this->redirect_uri,
			'response_type' => 'code',
		];

		$url = self::API_URL . self::API_ENDPOINT_AUTH . '?' . http_build_query( $params );

		return $url;
	}

	/**
	 * @param $code
	 *
	 * @return false|object
	 */
	public function get_token( $code ) {
		if ( empty( $this->client_id ) || empty( $this->client_secret ) || empty( $this->redirect_uri ) ) {
			throw new \RuntimeException( 'Missing client_id, client_secret or redirect_uri.' );
		}

		$params = [
			'client_id'     => $this->client_id,
			'client_secret' => $this->client_secret,
			'redirect_uri'  => $this->redirect_uri,
			'grant_type'    => 'authorization_code',
			'code'          => $code,
		];

		$url = self::API_URL . self::API_ENDPOINT_TOKEN;

		$response = wp_remote_post( $url, [
			'body' => $params,
		] );

		if ( (int) wp_remote_retrieve_response_code( $response ) !== 200 ) {
			return false;
		}

		$body = json_decode( wp_remote_retrieve_body( $response ) );

		if ( ! isset( $body->access_token ) ) {
			return false;
		}

		return $body;
	}

	/**
	 * @return string
	 */
	public function get_client_id(): string {
		return $this->client_id;
	}

	/**
	 * @param string $client_id
	 *
	 * @return $this
	 */
	public function set_client_id( string $client_id ): WordPress {
		$this->client_id = $client_id;

		return $this;
	}

	/**
	 * @return string
	 */
	public function get_client_secret(): string {
		return $this->client_secret;
	}

	/**
	 * @param string $client_secret
	 *
	 * @return $this
	 */
	public function set_client_secret( string $client_secret ): WordPress {
		$this->client_secret = $client_secret;

		return $this;
	}

	/**
	 * @return string
	 */
	public function get_redirect_uri(): string {
		return $this->redirect_uri;
	}

	/**
	 * @param string $redirect_uri
	 *
	 * @return $this
	 */
	public function set_redirect_uri( string $redirect_uri ): WordPress {
		$this->redirect_uri = $redirect_uri;

		return $this;
	}

}