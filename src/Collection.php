<?php

namespace WordCampEurope\Resources;

class Collection
	implements \Iterator {

	/**
	 * @var array
	 */
	protected $data;

	/**
	 * @param array $data
	 */
	public function __construct( array $data = [] ) {
		$this->date = $data;
	}

	/**
	 * @inheritDoc
	 */
	public function current() {
		return current( $this->data );
	}

	/**
	 * @inheritDoc
	 */
	public function next() {
		return next( $this->data );
	}

	/**
	 * @inheritDoc
	 */
	public function key() {
		return key( $this->data );
	}

	/**
	 * @inheritDoc
	 */
	public function valid() {
		return key( $this->data ) !== null;
	}

	/**
	 * @inheritDoc
	 */
	public function rewind() {
		return reset( $this->data );
	}

}