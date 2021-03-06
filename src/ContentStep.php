<?php declare( strict_types=1 );

namespace WordCampEurope\Resources;

class ContentStep {

	/**
	 * @var string
	 */
	protected $description = '';

	/**
	 * @var string
	 */
	protected $image;

	/**
	 * @var string
	 */
	protected $title = '';

	/**
	 * @return string
	 */
	public function get_description(): string {
		return $this->description;
	}

	/**
	 * @param string $description
	 *
	 * @return $this
	 */
	public function set_description( string $description ): ContentStep {
		$this->description = $description;

		return $this;
	}

	/**
	 * @return null|string
	 */
	public function get_image() {
		return $this->image;
	}

	/**
	 * @param string $image
	 *
	 * @return $this
	 */
	public function set_image( string $image ): ContentStep {
		$this->image = $image;

		return $this;
	}

	/**
	 * @return string
	 */
	public function get_title(): string {
		return $this->title;
	}

	/**
	 * @param string $title
	 *
	 * @return $this
	 */
	public function set_title( string $title ): ContentStep {
		$this->title = $title;

		return $this;
	}

}