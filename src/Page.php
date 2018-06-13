<?php declare( strict_types=1 );

namespace WordCampEurope\WorkshopAuth;

abstract class Page
	implements Renderable {

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @var string
	 */
	protected $slug;

	/**
	 * @var View
	 */
	protected $view;

	/**
	 * @param string $slug
	 * @param View   $view
	 */
	public function __construct( string $slug, View $view = null ) {
		if ( null === $view ) {
			$view = new View();
		}

		$this->slug = $slug;
		$this->view = $view;
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
	 * @return false|\WP_Post
	 */
	public function get_page() {
		$page = get_page_by_path( $this->slug );

		if ( ! $page ) {
			return false;
		}

		return $page;
	}

	/**
	 * @return string
	 */
	public function get_permalink(): string {
		$page = $this->get_page();

		if ( ! $page ) {
			return '';
		}

		return get_permalink( $page->ID );
	}

	/**
	 * Save the page
	 *
	 * @return int|\WP_Error
	 */
	public function persist() {
		if ( empty( $this->slug ) ) {
			throw new \RuntimeException( 'Missing page slug.' );
		}

		$page = $this->get_page();

		if ( $this->get_page() ) {
			return $page->ID;
		}

		return wp_insert_post( [
			'post_type'    => 'page',
			'post_content' => '',
			'post_status'  => 'publish',
			'post_title'   => $this->get_title(),
			'post_name'    => $this->get_slug(),
		] );
	}

	/**
	 * @return string
	 */
	public abstract function render(): string;

}