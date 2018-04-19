<?php

namespace ColdTrick\EntityToTitleMenu;

class Views {
	
	/**
	 * Don't display entity menu in full view (moved to title menu)
	 *
	 * @param \Elgg\Hook $hook 'view_vars', 'object/elements/summary'
	 *
	 * @return void|array
	 */
	public static function summaryVars(\Elgg\Hook $hook) {
		
		$return = $hook->getValue();
		
		$entity = elgg_extract('entity', $return);
		if (!$entity instanceof \ElggEntity || !elgg_extract('full_view', $return, false)) {
			return;
		}
		
		if (stripos(current_page_url(), $entity->getURL()) !== 0) {
			// looking at a full full, but not of the entity for the page
			return;
		}
		
		$return['show_entity_menu'] = false;
		
		return $return;
	}
}
