<?php
class pages_editorModel extends model {
	public function addWidgetToSidebar($d = array()) {
		$newWidgetId = false;
		if(empty($d['widgetId']) || empty($d['sidebarId'])) {
			$this->pushError(lang::_('Invalid data provided'));
		}
		if(!$this->haveErrors()) {
			$num = 0;
			if(strpos($d['widgetId'], '-')) {
				$d['widgetId'] = array_map('trim', explode('-', $d['widgetId']));
				$num = (int)$d['widgetId'][1] - 1;
				$d['widgetId'] = $d['widgetId'][0];
			}
			$newWidgetId = addWidgetToSidebar($d['sidebarId'], $d['widgetId'], $num);
		}
		return $newWidgetId;
	}
	public function removeWidgetFromSidebar($d = array()) {
		if(empty($d['widgetId']) || empty($d['sidebarId'])) {
			$this->pushError(lang::_('Invalid data provided'));
		}
		if(!$this->haveErrors()) {
			$sidebarsWidgets = (get_option('sidebars_widgets'));
			if(!empty($sidebarsWidgets) && is_array($sidebarsWidgets) && isset($sidebarsWidgets[ $d['sidebarId'] ]) && !empty($sidebarsWidgets[ $d['sidebarId'] ])) {
				foreach($sidebarsWidgets[ $d['sidebarId'] ] as $i => $widgetId) {
					if(trim($widgetId) == trim($d['widgetId'])) {
						array_splice($sidebarsWidgets[ $d['sidebarId'] ], $i, 1);
						break;
					}
				}
				update_option('sidebars_widgets', $sidebarsWidgets);
				return true;
			} else
				$this->pushError (lang::_('Empty or invalid sidebar'));
		}
		return false;
	}
	public function moveWidgetBetweenSidebars($d = array()) {
		if(empty($d['widgetId']) 
			|| empty($d['senderSidebarId'])
			|| empty($d['receiverSidebarId'])
		) {
			$this->pushError(lang::_('Invalid data provided'));
		}
		if(!$this->haveErrors()) {
			$sidebarsWidgets = get_option('sidebars_widgets');
			if(!empty($sidebarsWidgets) 
				&& is_array($sidebarsWidgets) 
				&& isset($sidebarsWidgets[ $d['senderSidebarId'] ]) 
				&& isset($sidebarsWidgets[ $d['receiverSidebarId'] ])
			) {
				foreach($sidebarsWidgets[ $d['senderSidebarId'] ] as $i => $widgetId) {
					if(trim($widgetId) == trim($d['widgetId'])) {
						array_splice($sidebarsWidgets[ $d['senderSidebarId'] ], $i, 1);
						break;
					}
				}
				$sidebarsWidgets[ $d['receiverSidebarId'] ][] = trim($d['widgetId']);
				update_option('sidebars_widgets', $sidebarsWidgets);
				return true;
			} else
				$this->pushError (lang::_('Empty or invalid sidebar'));
		}
		return false;
	}
	public function saveWidgetsOrdering($d = array()) {
		if(empty($d['sidebarId']) 
			|| empty($d['widgetsIds'])
			|| !is_array($d['widgetsIds'])
		) {
			$this->pushError(lang::_('Invalid data provided'));
		}
		if(!$this->haveErrors()) {
			$sidebarsWidgets = get_option('sidebars_widgets');
			if(!empty($sidebarsWidgets) 
				&& is_array($sidebarsWidgets) 
				&& isset($sidebarsWidgets[ $d['sidebarId'] ])
				&& is_array($sidebarsWidgets[ $d['sidebarId'] ])
			) {
				foreach($d['widgetsIds'] as $i => $wId) {
					if(!in_array($wId, $sidebarsWidgets[ $d['sidebarId'] ])) {
						array_splice($d['widgetsIds'], $i, 1);
					}
				}
				$sidebarsWidgets[ $d['sidebarId'] ] = $d['widgetsIds'];
				update_option('sidebars_widgets', $sidebarsWidgets);
				return true;
			} else
				$this->pushError (lang::_('Empty or invalid sidebar'));
		}
		return false;
	}
}
?>