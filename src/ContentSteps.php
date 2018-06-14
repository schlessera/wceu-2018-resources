<?php declare( strict_types=1 );

namespace WordCampEurope\Resources;

class ContentSteps extends Collection {

	/**
	 * @param ContentStep $step
	 *
	 * @return ContentStep
	 */
	public function add_step( ContentStep $step = null ): ContentStep {
		if ( null === $step ) {
			$step = new ContentStep();
		}

		$this->data[] = $step;

		return $step;
	}

	/**
	 * @inheritDoc
	 */
	public function key() {
		return parent::key() + 1;
	}

}