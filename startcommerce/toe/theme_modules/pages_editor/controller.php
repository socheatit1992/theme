<?php
class pages_editorController extends controller {
	public function addWidgetToSidebar() {
		//global $sidebars_widgets;
		$res = new response();
		if($newWidgetId = $this->getModel()->addWidgetToSidebar(req::get('post'))) {
			//$res->setHtml( $this->getView()->getSidebarHtml(req::getVar('sidebarId')) );
			$res->addData('newWidgetId', $newWidgetId);
			$res->addMessage(lang::_('Done'));
		} else {
			$res->pushError($this->getModel()->getErrors());
		}
		return $res->ajaxExec();
	}
	public function removeWidgetFromSidebar() {
		//global $sidebars_widgets;
		$res = new response();
		if($this->getModel()->removeWidgetFromSidebar(req::get('post'))) {
			//$res->setHtml( $this->getView()->getSidebarHtml(req::getVar('sidebarId')) );
			$res->addMessage(lang::_('Done'));
		} else {
			$res->pushError($this->getModel()->getErrors());
		}
		return $res->ajaxExec();
	}
	public function moveWidgetBetweenSidebars() {
		//global $sidebars_widgets;
		$res = new response();
		if($this->getModel()->moveWidgetBetweenSidebars(req::get('post'))) {
			//$res->setHtml( $this->getView()->getSidebarHtml(req::getVar('sidebarId')) );
			$res->addMessage(lang::_('Done'));
		} else {
			$res->pushError($this->getModel()->getErrors());
		}
		return $res->ajaxExec();
	}
	public function saveWidgetsOrdering() {
		//global $sidebars_widgets;
		$res = new response();
		if($this->getModel()->saveWidgetsOrdering(req::get('post'))) {
			//$res->setHtml( $this->getView()->getSidebarHtml(req::getVar('sidebarId')) );
			$res->addMessage(lang::_('Done'));
		} else {
			$res->pushError($this->getModel()->getErrors());
		}
		return $res->ajaxExec();
	}
	public function getWidgetSettingsHtml() {
		$res = new response();
		if(($html = $this->getView()->getWidgetSettingsHtml(req::get('post'))) !== false) {
			$res->setHtml( $html );
			$res->addMessage(lang::_('Done'));
		} else {
			$res->pushError($this->getView()->getErrors());
		}
		return $res->ajaxExec();
	}
	public function setCategoryExample() {
		$res = new response();
		$termId = (int) req::getVar('termId');
		if($termId) {
			frame::_()->getModule('options')->getModel()->put(array('code' => 'page_editor_example_cat', 'value' => $termId));
			$res->addData('catLink', uri::_(array('baseUrl' => frame::_()->getModule('products')->getLinkToCategory($termId), 'tplEditor' => 1)));
			$res->addMessage(lang::_('Done'));
		} else
			$res->pushError (lang::_('Invalid Category ID'));
		return $res->ajaxExec();
	}
	public function setProductExample() {
		$res = new response();
		$pid = (int) req::getVar('pid');
		if($pid) {
			frame::_()->getModule('options')->getModel()->put(array('code' => 'page_editor_example_prod', 'value' => $pid));
			$res->addData('catLink', uri::_(array('baseUrl' => frame::_()->getModule('products')->getLink($pid), 'tplEditor' => 1)));
			$res->addMessage(lang::_('Done'));
		} else
			$res->pushError (lang::_('Invalid Product ID'));
		return $res->ajaxExec();
	}
}
?>
