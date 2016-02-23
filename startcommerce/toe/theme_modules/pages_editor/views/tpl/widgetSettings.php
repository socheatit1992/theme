<script type="text/javascript">
var toeSelectedWidgetId = '<?php echo $this->widgetId?>';
// <!--
jQuery(function(){
	jQuery('.widget-top').remove();
	jQuery('.widget-inside').show();
	jQuery('.widget-inside form:first')
		.append('<input type="hidden" name="action" value="save-widget" />')
		.append('<input type="hidden" name="savewidgets" value="'+ jQuery('#_wpnonce_widgets').val()+ '" />')
		.append('<input type="hidden" name="sidebar" value="<?php echo $this->sidebarId?>" />');
	jQuery('.widget-inside form:first').submit(function(){
		jQuery(this).sendForm({
			msgElID: 'toeWidgetMsg_'+ toeSelectedWidgetId,
			dataType: 'html',
			onSuccess: function(res) {
				if(res != '0' && res != '-1') {
					jQuery('#toeWidgetMsg_'+ toeSelectedWidgetId).html(toeLang('Data Saved'));
				}
			}
		});
		return false;
	});
	jQuery('.widget-control-close').click(function(){
		subScreen.clearAndHide();
		return false;
	});
	jQuery('.widget-control-remove').click(function(){
		toeRemoveWidgetFromSidebar(jQuery('.toeWidgetEditorShellClonned[sidebarid="<?php echo $this->sidebarId?>"][widgetid="<?php echo $this->widgetId?>"]'));
		subScreen.clearAndHide();
		return false;
	});
});
// -->
</script>
<?php
	wp_widget_control(array('widget_id' => $this->widgetId,
		'id' => $this->sidebarId));
?>
<?php wp_nonce_field( 'save-sidebar-widgets', '_wpnonce_widgets', false );?>
<div id="toeWidgetMsg_<?php echo $this->widgetId; ?>"></div>