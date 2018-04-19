<?php

namespace ColdTrick\EntityToTitleMenu;

use Elgg\DefaultPluginBootstrap;

class Bootstrap extends DefaultPluginBootstrap {
	
	/**
	 * {@inheritDoc}
	 */
	public function init() {
		
		// CSS
		elgg_extend_view('elements/components/menus.css', 'css/entity_to_title_menu/title_menu.css');
		elgg_extend_view('elgg.css', 'css/entity_to_title_menu/hide_entity_menu.css');
		
		// plugin hooks
		$hooks = $this->elgg()->hooks;
		$hooks->registerHandler('register', 'menu:title', __NAMESPACE__ . '\TitleMenu::register', 600);
		$hooks->registerHandler('view_vars', 'object/elements/summary', __NAMESPACE__ . '\Views::summaryVars');
	}
}
