<?php
class pages_editor extends module {
    public function init() {
		add_filter('sidebars_widgets', array($this, 'filterSidebarWidgets'));
		add_filter('dynamic_sidebar_params', array($this, 'filterDynamicSidebarParams'));
        parent::init();
    }
	public function addLicensedThemeMenu($d = array('file' => '')) {
		if(!empty($d['file'])) {
			frame::_()->addScript('jquery-ui-sortable');
			frame::_()->addScript('pages-editor-admin', $this->getModPath(). 'js/pagesEditor.js');
			$subMenus = array(
				array('title' => 'Pages View', 'capability' => 10, 'menu_slug' => 'toeeditpagesview', 'function' => array($this->getController()->getView(), 'getEditPagesView')),
			);
			foreach($subMenus as $opt) {
				add_submenu_page($d['file'], lang::_($opt['title']), lang::_($opt['title']), $opt['capability'], $opt['menu_slug'], $opt['function']);
			}
		}
	}
	public function filterSidebarWidgets($widgets) {
		
		return $widgets;
	}
	public function filterDynamicSidebarParams($params) {
		$beforeWidget = '<div class="toeWidgetShell">';
		$afterWidget = '</div>';
		if(frame::_()->isTplEditor()) {
			static $sidebarId;
			if(isset($params[0]['id']) && !empty($params[0]['id']))
				$sidebarId = $params[0]['id'];
			$beforeWidget = $beforeWidget. '<div 
				class="toeWidgetEditorShell toeWidgetId_'. $params[0]['widget_id']. ' portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" 
				name="'. $params[0]['widget_name']. '"
				sidebarId="'. $sidebarId. '">';
			$afterWidget = '</div>'. $afterWidget;
		}
		if(strpos($params[0]['widget_name'], 'Ready!') === false) {
			$beforeWidget = $beforeWidget. $params[0]['before_widget'];
			$afterWidget = $params[0]['after_widget']. '</div>';
		}
		$params[0]['before_widget'] = $beforeWidget;
		$params[0]['after_widget'] = $afterWidget;
		return $params;
	}
	public function contentStart() {
		if(frame::_()->isTplEditor())
			echo '<div class="toePageMainContent">';
	}
	public function contentEnd() {
		if(frame::_()->isTplEditor())
			echo '</div>';
	}
	public function dynamicSidebar($index = 1) {
		if(frame::_()->isTplEditor())
			echo '<div class="toeSidebarShell toeSidebarShellId_'. $index. '">';
		$res = dynamic_sidebar($index);
		if(frame::_()->isTplEditor())
			echo '</div>';
		return $res;
	}
	public function isActiveSidebar($index) {
		if(frame::_()->isTplEditor())	// For each sidebar in tpl editor mode - make it active
			return true;
		return is_active_sidebar($index);
	}
}
?>
