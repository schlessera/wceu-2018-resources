<?php declare( strict_types=1 );

namespace WordCampEurope\WorkshopAuth\Page;

use WordCampEurope\WorkshopAuth\OAuth;
use WordCampEurope\WorkshopAuth\Page;
use WordCampEurope\WorkshopAuth\PageStep;
use WordCampEurope\WorkshopAuth\PageSteps;
use WordCampEurope\WorkshopAuth\View;

class WPApp extends Page {

	/**
	 * @param View $view
	 */
	public function __construct( View $view = null ) {
		$this->set_title( 'Create a WordPress.com App' );

		parent::__construct( 'wceu-wp-app', $view );
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
		$steps = new PageSteps();

		$steps->add_step()
		      ->set_title( 'Go to WordPress.com Apps' )
		      ->set_description( 'Login to WordPress.com and go to <a target="_blank" href="https://developer.wordpress.com/apps">https://developer.wordpress.com/apps/</a>' );

		$steps->add_step()
		      ->set_title( 'Create a New App' )
		      ->set_image( $this->get_image( 1 ) );

		$steps->add_step()
		      ->set_title( 'Configure the App' )
		      ->set_image( $this->get_image( 2 ) )
		      ->set_description( 'Fill in the form and use the permalink of the "Generate a WordPress.com OAuth Token" page on your local WordPress install and press create and then update.' );

		$steps->add_step()
		      ->set_title( 'Update env.php' )
		      ->set_image( $this->get_image( 3 ) )
		      ->set_description( 'Add the Client ID and Client Secret to the WordPress.com env variables in env.php (found in the root of this plugin).' );

		return $this->view
			->add_data( 'steps', $steps->get_steps() )
			->set_template( 'partial/steps' )
			->render();
	}

}