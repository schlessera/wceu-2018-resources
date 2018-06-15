<?php declare( strict_types=1 );

namespace WordCampEurope\Resources\Content;

use WordCampEurope\Resources\Content;
use WordCampEurope\Resources\ContentSteps;
use WordCampEurope\Resources\View;
use WordCampEurope\Resources\Page;

class GitBranches extends Content {

	public function render(): string {
		$branches = [
			'1-in-the-near-future',
			'2-feed-me',
			'3-cache-is-king',
			'3-cache-is-king-final',
			'4-test-me-if-you-can',
			'4-test-me-if-you-can-final',
			'5-sort-it-out',
			'6-thats-all-folks',
		];

		$view = new View();
		$view->set_template( 'partial/git-branches' );

		return $view->render( [
			'branches' => $branches,
		] );
	}

}