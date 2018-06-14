<?php

namespace WordCampEurope\Resources;

interface Renderable {

	/**
	 * @return string
	 */
	public function render(): string;

}