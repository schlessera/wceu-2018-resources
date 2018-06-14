<?php declare( strict_types=1 );

namespace WordCampEurope\WorkshopAuth;

class View
	implements Renderable {

	/**
	 * @var string
	 */
	protected $template_dir;

	/**
	 * @var string
	 */
	protected $template;

	public function __construct( string $template_dir = null ) {
		if ( null === $template_dir ) {
			$template_dir = WCEU_WORKSHOP_AUTH_DIR . 'template';
		}

		$this->set_template_dir( $template_dir );
	}

	/**
	 * Reset object to initial state except for template directory
	 */
	public function __clone() {
		$this->data = [];
		$this->template = null;
	}

	/**
	 * @param string $template_dir
	 */
	public function set_template_dir( string $template_dir ) {
		if ( ! is_dir( $template_dir ) ) {
			throw new \InvalidArgumentException( sprintf( 'Could not locate template dir %s.', $template_dir ) );
		}

		$this->template_dir = $template_dir;
	}

	/**
	 * @param string $template
	 *
	 * @return $this
	 */
	public function set_template( string $template ): View {
		$this->template = $template;

		return $this;
	}

	/**
	 * @param array $data
	 *
	 * @return string
	 * @throws \Exception
	 */
	public function render( array $data = [] ): string {
		extract( $data );

		$template = sprintf( '%s/%s.php', $this->template_dir, $this->template );

		if ( ! is_readable( $template ) ) {
			throw new \Exception( sprintf( 'Could not locate template %s', $template ) );
		}

		ob_start();

		include $template;

		return ob_get_clean();
	}

}