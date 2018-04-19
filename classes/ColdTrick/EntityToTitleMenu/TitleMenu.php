<?php

namespace ColdTrick\EntityToTitleMenu;

class TitleMenu {
	
	/**
	 * @param \Elgg\Hook $hook 'register', 'menu:title'
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function register(\Elgg\Hook $hook) {
		
		$entity = $hook->getEntityParam();
		if (!$entity instanceof \ElggEntity) {
			return;
		}
		
		/* @var $return \Elgg\Menu\MenuItems */
		$return = $hook->getValue();
		
		/* @var $entity_menu \Elgg\Menu\UnpreparedMenu */
		$entity_menu = elgg()->menus->getUnpreparedMenu('entity', [
			'entity' => $entity,
		]);
		if (empty($entity_menu)) {
			return;
		}
		
		$add_toggle = false;
		
		/* @var $menu_item \ElggmenuItem */
		foreach ($entity_menu->getItems() as $menu_item) {
			if ($return->has($menu_item->getId())) {
				continue;
			}
			
			switch ($menu_item->getName()) {
				case 'edit':
					$menu_item->addLinkClass('elgg-button');
					$menu_item->addLinkClass('elgg-button-action');
					
					$menu_item->setSection('z-last');
					break;
				default:
					if ($menu_item->getSection() === 'default') {
						$add_toggle = true;
						$menu_item->setParentName('title-menu-toggle');
						$menu_item->setSection('z-last');
					} else {
						$menu_item->addLinkClass('elgg-button');
						$menu_item->addLinkClass('elgg-button-action');
					}
					break;
			}
			
			$return->add($menu_item);
		}
		
		if ($add_toggle) {
			$toggle_menu = \ElggMenuItem::factory([
				'name' => 'title-menu-toggle',
				'icon' => 'ellipsis-v',
				'href' => false,
				'text' => '',
				'child_menu' => [
					'display' => 'dropdown',
					'data-position' => json_encode([
						'at' => 'right bottom',
						'my' => 'right top',
						'collision' => 'fit fit',
					]),
					'class' => "elgg-{$hook->getParam('name')}-dropdown-menu",
				],
				'link_class' => [
					'elgg-button',
					'elgg-button-action',
				],
				'priority' => 999,
				'section' => 'z-last',
			]);
			
			$return->add($toggle_menu);
		}
		
		return $return;
	}
}
