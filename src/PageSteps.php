<?php declare( strict_types=1 );

namespace WordCampEurope\WorkshopAuth;

class PageSteps {

	/**
	 * @var PageStep[]
	 */
	protected $steps = [];

	/**
	 * @param PageStep $step
	 *
	 * @return PageStep
	 */
	public function add_step( PageStep $step = null ): PageStep {
		if ( null === $step ) {
			$step = new PageStep();
		}

		$this->steps[] = $step;

		return $step;
	}

	public function get_steps(): array {
		$numbered = [];
		$i = 0;

		foreach ( $this->steps as $step ) {
			$numbered[ ++$i ] = $step;
		}

		return $numbered;
	}

}