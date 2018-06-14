<?php declare( strict_types=1 );

namespace WordCampEurope\WorkshopAuth;

class ContentSteps
	implements \Iterator {

	/**
	 * @var ContentStep[]
	 */
	protected $steps = [];

	/**
	 * @param ContentStep $step
	 *
	 * @return ContentStep
	 */
	public function add_step( ContentStep $step = null ): ContentStep {
		if ( null === $step ) {
			$step = new ContentStep();
		}

		$this->steps[] = $step;

		return $step;
	}

	/**
	 * @inheritDoc
	 */
	public function current() {
		return current( $this->steps );
	}

	/**
	 * @inheritDoc
	 */
	public function next() {
		return next( $this->steps );
	}

	/**
	 * @inheritDoc
	 */
	public function key() {
		return key( $this->steps ) + 1;
	}

	/**
	 * @inheritDoc
	 */
	public function valid() {
		return key( $this->steps ) !== null;
	}

	/**
	 * @inheritDoc
	 */
	public function rewind() {
		return reset( $this->steps );
	}

}