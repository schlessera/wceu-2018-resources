<?php declare( strict_types=1 );

namespace WordCampEurope\WorkshopAuth;

class Page
	implements Registrable {

	/**
	 * @var bool
	 */
	protected $loaded = false;

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
	 * @var int
	 */
	protected $id = 0;

	/**
	 * @param string $slug
	 * @param string $title
	 */
	public function __construct( string $slug, string $title ) {
		$this->slug = $slug;
		$this->title = $title;
	}

	public function register() {
		add_action( 'after_setup_theme', [ $this, 'persist' ] );
	}

	/**
	 * @return string
	 */
	public function get_title(): string {
		return $this->title;
	}

	/**
	 * @return string
	 */
	public function get_slug(): string {
		return $this->slug;
	}

	/**
	 * @return string
	 */
	public function get_url(): string {
		if ( ! $this->loaded ) {
			$this->load();
		}

		return $this->url;
	}

	/**
	 * @return int
	 */
	public function get_id(): int {
		if ( ! $this->loaded ) {
			$this->load();
		}

		return $this->id;
	}

	protected function load() {
		$this->loaded = true;
		$page = get_page_by_path( $this->slug );

		if ( $page instanceof \WP_Post ) {
			$this->id = $page->ID;
			$this->url = get_permalink( $page->ID );
		}
	}

	public function persist() {
		if ( ! $this->loaded ) {
			$this->load();
		}

		if ( $this->id ) {
			return;
		}

		wp_insert_post( [
			'post_type'    => 'page',
			'post_content' => '',
			'post_status'  => 'publish',
			'post_title'   => $this->title,
			'post_name'    => $this->slug,
		] );
	}

}