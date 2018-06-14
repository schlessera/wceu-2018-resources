<?php declare( strict_types=1 );

namespace WordCampEurope\Resources\Content;

use WordCampEurope\Resources\Content;
use WordCampEurope\Resources\ContentSteps;
use WordCampEurope\Resources\View;
use WordCampEurope\Resources\Page;

class WPApp extends Content {

	/**
	 * @var string
	 */
	protected $wp_auth_url;

	public function __construct( Page $page, string $wp_auth_url ) {
		$this->wp_auth_url = $wp_auth_url;

		parent::__construct( $page );
	}

	/**
	 * @param int $id
	 *
	 * @return string
	 */
	protected function get_image( int $id ): string {
		return WCEU_WORKSHOP_AUTH_URL . "assets/images/wp_app_{$id}.png";
	}

	public function render(): string {
		$steps = new ContentSteps();

		$steps->add_step()
		      ->set_title( 'Go to WordPress.com Apps' )
		      ->set_description( 'Login to WordPress.com and go to <a target="_blank" href="https://developer.wordpress.com/apps">https://developer.wordpress.com/apps/</a>' );

		$steps->add_step()
		      ->set_title( 'Create a New App' )
		      ->set_image( $this->get_image( 1 ) );

		$steps->add_step()
		      ->set_title( 'Configure the App' )
		      ->set_image( $this->get_image( 2 ) )
		      ->set_description( sprintf(
			      'Under "Redirect URLs", use the just created permalink: <strong>%s</strong>. Then press create and then update.',
			      $this->wp_auth_url
		      ) );

		$steps->add_step()
		      ->set_title( 'Update env.php' )
		      ->set_image( $this->get_image( 3 ) )
		      ->set_description( sprintf(
			      'Add the Client ID and Client Secret to the WordPress.com env variables in env.php (found in the root of this plugin). And then, <a href="%s">create a token via this page</a>.',
			      $this->wp_auth_url
		      ) );

		$view = new View();
		$view->set_template( 'partial/steps' );

		return $view->render( [
			'steps' => $steps,
		] );
	}

}