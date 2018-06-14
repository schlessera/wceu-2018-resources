<?php

namespace WordCampEurope\Resources;

class Pages extends Collection {

	/**
	 * @param Page $page
	 *
	 * @return Pages
	 */
	public function add_page( Page $page ): Pages {
		$this->data[ $page->get_slug() ] = $page;

		return $this;
	}

	/**
	 * @param $slug
	 *
	 * @return Page|false
	 */
	public function get_page( $slug ) {
		if ( ! isset( $this->data[ $slug ] ) ) {
			return false;
		}

		return $this->data[ $slug ];
	}

}