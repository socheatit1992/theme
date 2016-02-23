/**
 * Licensed themes setup functions
 */
function toeAddWidgetToSidebar(widgetObj) {
	var widgetId = jQuery(widgetObj).attr('widgetId');
	var sidebarId = jQuery(widgetObj).attr('sidebarId');
	jQuery.sendForm({
		msgElID: 'toeEditPagesMsg',
		data: {page: 'pages_editor', 
			action: 'addWidgetToSidebar', 
			reqType: 'ajax', 
			widgetId: widgetId, 
			sidebarId: sidebarId},
		onSuccess: function(res) {
			if(!res.error) {
				if(res.data.newWidgetId) {
					jQuery(widgetObj).attr('widgetId', res.data.newWidgetId);
				}
				//jQuery(iFrame)[0].contentWindow.location.reload(true);
			}
		}
	});
}
function toeRemoveWidgetFromSidebar(widgetObj, params) {
	params = jQuery.extend(params, {});
	var widgetId = params.widgetId ? params.widgetId : jQuery(widgetObj).attr('widgetId');
	var sidebarId = params.sidebarId ? params.sidebarId : jQuery(widgetObj).attr('sidebarId');
	jQuery.sendForm({
		msgElID: 'toeEditPagesMsg',
		data: {page: 'pages_editor', 
			action: 'removeWidgetFromSidebar', 
			reqType: 'ajax', 
			widgetId: widgetId, 
			sidebarId: sidebarId},
		onSuccess: function(res) {
			if(!res.error) {
				jQuery(widgetObj).remove();
			}
		}
	});
}
function toeMoveWidgetBetweenSidebars(widgetObj, senderSidebarId, receiverSidebarId, sidebarObj) {
	var widgetId = jQuery(widgetObj).attr('widgetId');
	jQuery.sendForm({
		msgElID: 'toeEditPagesMsg',
		data: {page: 'pages_editor', 
			action: 'moveWidgetBetweenSidebars', 
			reqType: 'ajax',
			widgetId: widgetId, 
			senderSidebarId: senderSidebarId, 
			receiverSidebarId: receiverSidebarId},
		onSuccess: function(res) {
			if(!res.error) {
				jQuery(widgetObj).attr('sidebarId', receiverSidebarId);
				if(sidebarObj)
					toeSaveWidgetsOrdering(sidebarObj);
			}
		}
	});
}
function toeSaveWidgetsOrdering(sidebarObj) {
	var widgetsIds = [];
	jQuery(sidebarObj).find('.toeWidgetEditorShellClonned').each(function(){
		widgetsIds.push(jQuery(this).attr('widgetId'));
	});
	var sidebarId = jQuery(sidebarObj).getClassId('Id');
	jQuery.sendForm({
		msgElID: 'toeEditPagesMsg',
		data: {page: 'pages_editor', 
			action: 'saveWidgetsOrdering', 
			reqType: 'ajax',
			widgetsIds: widgetsIds, 
			sidebarId: sidebarId},
		onSuccess: function(res) {
			if(!res.error) {
				//jQuery(widgetObj).attr('sidebarId', receiverSidebarId);
			}
		}
	});
}
function toeGetWidgetSettings(settingsLink) {
	var widgetObj = jQuery(settingsLink).parents('.toeWidgetEditorShellClonned:first');
	var widgetId = jQuery(widgetObj).attr('widgetId');
	var sidebarId = jQuery(widgetObj).attr('sidebarId');
	jQuery.sendForm({
		msgElID: 'toeEditPagesMsg',
		clearMsg: true,
		data: {page: 'pages_editor', 
			action: 'getWidgetSettingsHtml', 
			reqType: 'ajax',
			widgetId: widgetId, 
			sidebarId: sidebarId,
			tplEditor: 1},
		onSuccess: function(res) {
			if(!res.error && res.html) {
				subScreen
					.show( res.html )
					.insertTitle(toeLang('Widget Settings'));
			}
		}
	});
}
function toeLoadTabFrame(tab, url) {
	if(jQuery('.toeSidebarShellClonned').size()) {
		jQuery('.toeSidebarShellClonned').remove();
		jQuery('.toeSidebarShellClonedLabel').remove();
		jQuery('.toeWidgetEditorShellClonned').remove();
		jQuery('.toeWidgetEditorShellClonnedLabel').remove();
	}
	if(jQuery(tab).find('iframe').size() == 0) {
		jQuery(tab).html('<iframe class="toePageExampleIframe" src="' + url + '" onload="toeAfterEditorIframeLoad(this, \''+ tab+ '\');">Load Failed?</iframe>');
	} else {
		toeCreateEditedIframeElements(toeEditorIframes[tab]);
	}
	return false;
}
function toeAfterEditorIframeLoad(iframe, tab) {
	toeEditorIframes[tab] = iframe;
	jQuery(iframe).contents().find('body').addClass('toePageEditBody');
	
	/**
	 * Lines bellow is removing some attributes from foundation framework for correct document size calculation
	 */
	jQuery(iframe).contents().find('body').css('min-width', 'auto');
	jQuery(iframe).contents().find('body').css('max-width', 'none');
	
	jQuery(iframe).contents().find('#container').css('min-width', 'auto');
	jQuery(iframe).contents().find('#container').css('max-width', 'none');
	/*****/
	
	var newHeight = jQuery(iframe.contentWindow.document).height() + 50;
	var newWidth = jQuery(iframe.contentWindow.document).width() + 50;

	jQuery(iframe).height( newHeight );
	jQuery(iframe).parent('div').height( newHeight );
	jQuery(iframe).width( newWidth );
	jQuery(iframe).parent('div').width( newWidth );

	jQuery(iframe).contents().find('*').unbind();
	jQuery(iframe).contents().find('*').click(function(){
		return false;
	});
	
	toeCreateEditedIframeElements(iframe);
}
function toeCreateEditedIframeElements(iframe) {
	var iFramePos = jQuery(iframe).offset();
	jQuery(iframe.contentWindow.document).find('.toeSidebarShell').each(function(){
		var pos = jQuery(this).offset();
		var classes = str_replace(jQuery(this).attr('class'), 'toeSidebarShell', '');
		var sidebarId = jQuery(this).getClassId('toeSidebarShellId');
		

		var wSidebarClone = jQuery('<div class="toeSidebarShellClonned '+ classes+ '"></div>')
			.css('top', pos.top + iFramePos.top)
			.css('left', pos.left + iFramePos.left)
			//.width(jQuery(this).width() + 20)
			//.height(jQuery(this).height() + 20)
			.appendTo('body');
		jQuery('<div class="toeSidebarShellClonedLabel">'+ toeStrFirstUp(sidebarId)+ '</div>')
			//.css('top', pos.top + iFramePos.top - 15)
			//.css('left', pos.left + iFramePos.left + 5)
			.appendTo(wSidebarClone);
		jQuery(this).find('.toeWidgetEditorShell').each(function(){
			pos = jQuery(this).position();
			var widgetId = jQuery(this).getClassId('toeWidgetId');
			//alert(widgetId);
			var widgetName = jQuery(this).attr('name');
			var widgetClone = jQuery('<div '
					+'class="toeWidgetEditorShellClonned portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" '
					+'name="'+ widgetName+ '" '
					+'sidebarId="'+ sidebarId+ '" '
					+'widgetId="'+ widgetId+ '"></div>')
				.css('top', pos.top)
				.css('left', pos.left)
				.width(jQuery(this).width() + 20)
				.height(jQuery(this).height() + 20)
				.appendTo(wSidebarClone);
			jQuery('<div class="toeWidgetEditorShellClonnedLabel ui-widget-header ui-corner-all">'+ widgetName+ '</div>')
				.appendTo(widgetClone);
			toeCompleteWidgetInstance(widgetClone);
		});
	});
	jQuery( ".toeWidgetsContainer" ).sortable({
		connectWith: ".toeSidebarShellClonned",
		helper: 'clone',
		start: function(event, ui) {
			jQuery(ui.item).show();
			item = jQuery(ui.item);
			before = jQuery(ui.item).prev();
			hasBefore = jQuery(ui.item).prev().size();
		},
		receive: function(event, ui) {
			// Remove widget from sidebar
			toeRemoveWidgetFromSidebar(ui.item);
			ui.item.remove();
		}
	}).disableSelection();
	jQuery( ".toeSidebarShellClonned" ).sortable({
		connectWith: ".toeSidebarShellClonned, .toeWidgetsContainer",
		start: function(){ /*alert(1); */},
		receive: function(event, ui) {
			// Add widget to sidebar
			if(item && jQuery(ui.sender).hasClass('toeWidgetsContainer')) {
				if(hasBefore)
					before.after(jQuery(item).clone());
				else {
					jQuery('.toeWidgetsContainer').prepend(jQuery(item).clone());
				}
				toeCompleteWidgetInstance(ui.item);
				jQuery(ui.item)
					.find('.toeWidgetLabel:first')
					.addClass('toeWidgetEditorShellClonnedLabel');
				jQuery(ui.item).addClass('toeWidgetEditorShellClonned');
				var sidebarId = jQuery(ui.item).parents('.toeSidebarShellClonned:first').getClassId('Id');
				jQuery(ui.item).attr('sidebarId', sidebarId);
				toeAddWidgetToSidebar(ui.item);
			} else if(jQuery(ui.sender).hasClass('toeSidebarShellClonned')) {
				var senderSidebarId = jQuery(ui.sender).getClassId('Id');
				var receiverSidebarId = jQuery(ui.item).parents('.toeSidebarShellClonned:first').getClassId('Id');
				jQuery(this).attr('justReceivedFromOther', 1);
				toeMoveWidgetBetweenSidebars(ui.item, senderSidebarId, receiverSidebarId, this);
			}
		},
		update: function(event, ui) {
			var justReceivedFromOther = jQuery(this).attr('justReceivedFromOther');
			if(typeof(justReceivedFromOther) !== 'undefined' && justReceivedFromOther !== false) {
				jQuery(this).removeAttr('justReceivedFromOther');
			} else {
				toeSaveWidgetsOrdering(this);
			}
		}
	}).disableSelection();
} 
function toeCompleteWidgetInstance(widgetObj) {
	jQuery('<div class="toeWidgetRemove"></div>')
		.click(function(){
			toeRemoveWidgetFromSidebar(widgetObj);
		})
		.appendTo(widgetObj);
	jQuery('<div class="toeWidgetControls">'
				+ '<a href="#" onclick="toeGetWidgetSettings(this); return false;">'
				+ toeLang('Settings')
				+ '</a>'
			+ '</div>')
		.appendTo(widgetObj);
}
function toeGetSidebarOpts(sidebarId, key) {
	var res = null;
	for(var i in toeAvailableWidgets) {
		if(toeAvailableWidgets[ i ].id == sidebarId) {
			res = toeAvailableWidgets[ i ];
			break;
		}
	}
	if(res && key) {
		res = res[ key ];
	}
	return res;
}
/*****/