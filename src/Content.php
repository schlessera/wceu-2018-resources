<?php

namespace WordCampEurope\WorkshopAuth;

abstract class Content
	implements Renderable, Registrable {

	/**
	 * @var Page
	 */
	protected $page;

	/**
	 * @param Page $page
	 */
	public function __construct( Page $page ) {
		$this->page = $page;
	}

	public function register() {
		add_action( 'the_content', [ $this, 'replace_content' ] );
	}

	/**
	 * @param $content
	 *
	 * @return string
	 */
	public function replace_content( $content ): string {
		if ( is_page( $this->page->get_slug() ) ) {
			$content = $this->render();
		}

		return $content;
	}

}