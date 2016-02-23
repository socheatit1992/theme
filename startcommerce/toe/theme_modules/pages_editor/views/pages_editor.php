<?php
class pages_editorView extends view {
    public function getEditPagesView() {
		global $wp_registered_widgets, $sidebars_widgets, $wp_registered_widget_controls, $wp_widget_factory;
		require_once(ABSPATH . 'wp-admin/includes/widgets.php');
		//toeVarDump($wp_widget_factory);
		$sort = $wp_registered_widgets;
		usort( $sort, '_sort_name_callback' );
		$done = array();
		$availableWidgets = array();
		foreach ( $sort as $widget ) {
			if ( in_array( $widget['callback'], $done, true ) ) // We already showed this multi-widget
				continue;

			$sidebar = is_active_widget( $widget['callback'], $widget['id'], false, false );
			$done[] = $widget['callback'];
			$availableWidgets[] = $widget;
		}
		$wpDefaultWidgets = array();
		$readyWidgets = array();
		$otherWidgets = array();
		$categorizedWigets = array();
		foreach($availableWidgets as $w) {
			$isOther = true;
			if(isset($w['callback']) && is_array($w['callback']) && is_object($w['callback'][0])) {
				$isOther = false;
				$callback = $w['callback'][0];
				$wClassName = get_class($callback);
				if(in_array($wClassName, array('WP_Nav_Menu_Widget', 'WP_Widget_Archives', 'WP_Widget_Calendar', 'WP_Widget_Categories', 'WP_Widget_Links',
					'WP_Widget_Text', 'WP_Widget_Tag_Cloud', 'WP_Widget_Search', 'WP_Widget_Recent_Posts', 'WP_Widget_Recent_Comments', 'WP_Widget_Meta',
					'WP_Widget_Pages', 'WP_Widget_RSS'))) {
					$wpDefaultWidgets[] = $w;
					$categorizedWigets['wpDefaultWidgets'][] = $w;
				} elseif(strpos($wClassName, 'toe') === 0) {	//begining from toe
					$rWidgCat = utils::getWidgetCategory($callback->id_base);
					if(!isset($readyWidgets[ $rWidgCat ]))
						$readyWidgets[ $rWidgCat ] = array();
					$readyWidgets[ $rWidgCat ][] = $w;
					$categorizedWigets[ $rWidgCat ][] = $w;
				} else {
					$isOther = true;
				}
			}
			if($isOther) {
				$otherWidgets[] = $w;
				$categorizedWigets[ 'otherWidgets' ][] = $w;
			}
		}
		$editablePages = array(
			'main'		=> array('title' => 'Main', 'loadHref' => uri::_(array('baseUrl' => get_bloginfo('url'), 'tplEditor' => true))),
			'catalog'	=> array('title' => 'Catalog'),
			'product'	=> array('title' => 'Products Details'),
			'cart'		=> array('title' => 'Shopping Cart', 'loadHref' => uri::_(array('baseUrl' => frame::_()->getModule('pages')->getLink(array('mod' => 'user', 'action' => 'getShoppingCart')), 'tplEditor' => true))),
			'checkout'	=> array('title' => 'Checkout', 'loadHref' => uri::_(array('baseUrl' => frame::_()->getModule('pages')->getLink(array('mod' => 'checkout', 'action' => 'getAllHtml')), 'tplEditor' => true))),
			'contacts'	=> array('title' => 'Contacts'),
		);
		$selectedCattId = frame::_()->getModule('options')->get('page_editor_example_cat');
		$selectedProdId = frame::_()->getModule('options')->get('page_editor_example_prod');
		
		$allCategories = frame::_()->getModule('products')->getCategories();
		$selectedCategory = null;
		if(!empty($allCategories)) {
			// If there was selected category
			if(!empty($selectedCattId)) {
				foreach($allCategories as $c) {
					if($selectedCattId == $c->term_id) {
						$selectedCategory = $c;
						break;
					}
				}
			}
			// If no - select first that have products
			if(empty($selectedCategory)) {
				foreach($allCategories as $c) {
					if($c->count) {
						$selectedCategory = $c;
						break;
					}
				}
			}
			if(!$selectedCategory)
				$selectedCategory = $allCategories[0];
		}
		if($selectedCategory) {
			$editablePages['catalog']['loadHref'] = uri::_(array('baseUrl' => frame::_()->getModule('products')->getLinkToCategory($selectedCategory), 'tplEditor' => true));
		}
		$allProducts = frame::_()->getModule('products')->getHelper()->getProducts();
		if(!empty($allProducts)) {
			if($selectedProdId && isset($allProducts[ $selectedProdId ]))
				$selectedProd = $selectedProdId;
			else
				$selectedProd = key($allProducts);
			$editablePages['product']['loadHref'] = uri::_(array('baseUrl' => frame::_()->getModule('products')->getLink($selectedProd), 'tplEditor' => true));
		}
		$categoriesForSelect = array();
		if(!empty($allCategories)) {
			foreach($allCategories as $c) {
				$categoriesForSelect[ $c->term_id ] = $c->name;
			}
		}
		$readyWidgetsTypes = array(
			'products' => 'Products widgets',
			'shopping' => 'Shopping widgets',
			'additional' => 'Additional functionality widgets',
		);
		$widgetsListLogic = array(
			'readyWidgets' => array('label' => 'Ready! Widgets'),
			'wpDefaultWidgets' => array('label' => 'Default Widgets'),
			'otherWidgets' => array('label' => 'Other Widgets'),
		);
		$this->assign('availableWidgets', $availableWidgets);
		$this->assign('wpDefaultWidgets', $wpDefaultWidgets);
		$this->assign('readyWidgets', $readyWidgets);
		$this->assign('otherWidgets', $otherWidgets);
		$this->assign('editablePages', $editablePages);
		$this->assign('allCategories', $allCategories);
		$this->assign('allProducts', $allProducts);
		$this->assign('categoriesForSelect', $categoriesForSelect);
		$this->assign('selectedCategory', $selectedCategory);
		$this->assign('selectedProd', $selectedProd);
		$this->assign('readyWidgetsTypes', $readyWidgetsTypes);
		$this->assign('widgetsListLogic', $widgetsListLogic);
		$this->assign('categorizedWigets', $categorizedWigets);
		parent::display('editPages');
	}
	public function getSidebarHtml($index) {
		$this->assign('index', $index);
		return parent::getContent('sidebarHtml');
	}
	public function getWidgetSettingsHtml($d = array()) {
		if(empty($d['sidebarId']) 
			|| empty($d['widgetId'])
		) {
			$this->pushError(lang::_('Invalid data provided'));
		}
		if(!$this->haveErrors()) {
			require_once(ABSPATH . 'wp-admin/includes/widgets.php');
			$this->assign('sidebarId', $d['sidebarId']);
			$this->assign('widgetId', $d['widgetId']);
			return parent::getContent('widgetSettings');
		}
		return false;
	}
}
?>
