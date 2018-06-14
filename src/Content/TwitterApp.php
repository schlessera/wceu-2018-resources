<?php declare( strict_types=1 );

namespace WordCampEurope\Resources\Content;

use WordCampEurope\Resources\ContentSteps;
use WordCampEurope\Resources\View;
use WordCampEurope\Resources\Content;

class TwitterApp extends Content {

	/**
	 * @param int $id
	 *
	 * @return string
	 */
	protected function get_image( int $id ): string {
		return WCEU_WORKSHOP_AUTH_URL . "assets/images/twitter_app_{$id}.png";
	}

	public function render(): string {
		$steps = new ContentSteps();

		$steps->add_step()
		      ->set_title( 'Go to Twitter Apps' )
		      ->set_description( 'Login to Twitter and go to <a target="_blank" href="https://apps.twitter.com/">https://apps.twitter.com/</a>' );

		$steps->add_step()
		      ->set_title( 'Create a New App' )
		      ->set_image( $this->get_image( 1 ) );

		$steps->add_step()
		      ->set_title( 'Configure the App' )
		      ->set_image( $this->get_image( 2 ) )
		      ->set_description( 'Use a fully qualified domain name (FQDN) for "Website" and use the same domain for "Callback URLs" with the suffix "' . $this->page->get_slug() . '".' );;

		$steps->add_step()
		      ->set_title( 'Go to Keys and Access Tokens Tab' )
		      ->set_image( $this->get_image( 3 ) );

		$steps->add_step()
		      ->set_title( 'Create an Access Token' )
		      ->set_image( $this->get_image( 4 ) )
		      ->set_description( 'You will find your API key and API Secret here. Scroll down and press the button "Create my access token".' );

		$steps->add_step()
		      ->set_title( 'Check the Access Token' )
		      ->set_image( $this->get_image( 5 ) )
		      ->set_description( 'It might take a few seconds, but you should see the tokens required for Twitter OAuth.' );

		$steps->add_step()
		      ->set_title( 'Update env.php' )
		      ->set_description( 'Add the API Key, API Secret, Access Token and Access Token Secret to the Twitter env variables in env.php (found in the root of this plugin).' );

		$view = new View();
		$view->set_template( 'partial/steps' );

		return $view->render( [
			'steps' => $steps,
		] );
	}

}