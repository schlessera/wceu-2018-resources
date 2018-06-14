<?php declare( strict_types=1 );

namespace WordCampEurope\WorkshopAuth;

class Page {

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @var string
	 */
	protected $slug;

	/**
	 * @var string
	 */
	protected $url = '';

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
	public function set_title( string $title ): Page {
		$this->title = $title;

		return $this;
	}

	/**
	 * @return string
	 */
	public function get_slug(): string {
		return $this->slug;
	}

	/**
	 * @param string $slug
	 *
	 * @return $this
	 */
	public function set_slug( string $slug ): Page {
		$this->slug = $slug;

		return $this;
	}

	/**
	 * @return string
	 */
	public function get_url(): string {
		return $this->url;
	}

	/**
	 * @return Page
	 */
	public function set_url(): Page {
		$this->url = get_permalink( $this->get_id() );

		return $this;
	}

	/**
	 * @return int
	 */
	public function get_id(): int {
		$page = $this->get_page();

		if ( ! $page ) {
			return $this->persist();
		}

		return $page->ID;
	}

	protected function persist() {
		$result = wp_insert_post( [
			'post_type'    => 'page',
			'post_content' => '',
			'post_status'  => 'publish',
			'post_title'   => $this->title,
			'post_name'    => $this->slug,
		] );

		if ( is_wp_error( $result ) ) {
			$result = 0;
		}

		return $result;
	}

	protected function get_page() {
		return get_page_by_path( $this->slug );
	}

}