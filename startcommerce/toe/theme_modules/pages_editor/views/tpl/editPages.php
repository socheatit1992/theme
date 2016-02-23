<script type="text/javascript">
// <!--
var toeEditablePages = <?php echo utils::jsonEncode($this->editablePages)?>;
var toeAvailableWidgets = <?php echo utils::jsonEncode($this->availableWidgets)?>;
var toeEditorIframes = {};

var item = null, before = null, hasBefore = 0;
var toeEditorTabs = null;
jQuery(document).ready(function(){
	toeEditorTabs = jQuery('#toeEditPagesTabsContent').tabs();
	jQuery('.toeEditPagesTabLink').click(function(){
		toeLoadTabFrame(jQuery(this).attr('href'), jQuery(this).attr('rel'));
		switch(jQuery(this).attr('id')) {
			case 'toeEditPageTabLink_catalog':
				jQuery('#toeEditPagesCategoryExampleSelection').show(TOE_DATA.animationSpeed);
				jQuery('#toeEditPagesProductExampleSelection').hide(TOE_DATA.animationSpeed);
				break;
			case 'toeEditPageTabLink_product':
				jQuery('#toeEditPagesProductExampleSelection').show(TOE_DATA.animationSpeed);
				jQuery('#toeEditPagesCategoryExampleSelection').hide(TOE_DATA.animationSpeed);
				break;
			default:
				jQuery('#toeEditPagesCategoryExampleSelection').hide(TOE_DATA.animationSpeed);
				jQuery('#toeEditPagesProductExampleSelection').hide(TOE_DATA.animationSpeed);
				break;
		}
	});
	jQuery('#toeCategoryExample').change(function(){
		jQuery.sendForm({
			msgElID: 'toeEditPagesMsg',
			data: {page: 'pages_editor', action: 'setCategoryExample', reqType: 'ajax', termId: jQuery(this).val()},
			onSuccess: function(res) {
				if(typeof(res.data.catLink) == 'string') {
					jQuery('#toeEditPageTabLink_catalog').attr('rel', res.data.catLink);
					jQuery('#toeEdit_catalog').html('');
					jQuery('#toeEditPageTabLink_catalog').trigger('click');
				}
			}
		});
	});
	jQuery('#toeProductExample').change(function(){
		jQuery.sendForm({
			msgElID: 'toeEditPagesMsg',
			data: {page: 'pages_editor', action: 'setProductExample', reqType: 'ajax', pid: jQuery(this).val()},
			onSuccess: function(res) {
				if(typeof(res.data.catLink) == 'string') {
					jQuery('#toeEditPageTabLink_product').attr('rel', res.data.catLink);
					jQuery('#toeEdit_product').html('');
					jQuery('#toeEditPageTabLink_product').trigger('click');
				}
			}
		});
	});
	
	new toeHtmlSlider('toeEditPagesAvailableWidgetsShell', {left: 70});
	
	// Load iFrame for the first selected tab
	jQuery('#toeEditPagesTabsContent li.ui-state-active a').trigger('click');
    
    var icons = {
      header: "ui-icon-circle-arrow-e",
      activeHeader: "ui-icon-circle-arrow-s"
    };
	jQuery( ".toeActiveWidgetsList, .toeReadyWidgetsList" ).accordion({
		icons: icons,
		heightStyle: "content"
	});
	/*jQuery( ".toeReadyWidgetsList" ).accordion({
		icons: icons,
		heightStyle: "content"
	});*/
	
});
// -->
</script>
<style>
	 .toeSidebarShellHighlighted  {
		 border-width: 3px;
		 border-color: red;
	 }
	 .ui-accordion-content {
		 overflow: visible !important;
	 }
</style>
<div style="">
	<div id="toeEditPagesCategoryExampleSelection" style="display: none;">
		<h1><?php lang::_e('Example Product Category')?></h1>
		<?php if(!empty($this->categoriesForSelect)) {?>
			<label for="toeCategoryExample"><?php lang::_e('Choose catalog')?>: </label>
			<?php echo html::selectbox('categoryExample', array('options' => $this->categoriesForSelect, 
				'value' => $this->selectedCategory->term_id,
				'attrs' => 'id="toeCategoryExample"'))?>
		<?php } else {
			lang::_e('You have no Product Categories. Create them at first.');
		}?>
	</div>
	<div id="toeEditPagesProductExampleSelection" style="display: none;">
		<h1><?php lang::_e('Example Product')?></h1>
		<?php if(!empty($this->allProducts)) {?>
			<label for="toeProductExample"><?php lang::_e('Choose product')?>: </label>
			<?php echo html::selectbox('productExample', array('options' => $this->allProducts, 
				'value' => $this->selectedProd,
				'attrs' => 'id="toeProductExample"'))?>
		<?php } else {
			lang::_e('You have no Products. Create them at first.');
		}?>
	</div>
</div>
<div id="toeEditPagesMsg"></div>
<div id="toeEditPagesTabsContent" style="float: left;">
	<ul>
		<?php foreach($this->editablePages as $key => $p) { ?>
		<li><a href="#toeEdit_<?php echo $key?>" class="toeEditPagesTabLink" id="toeEditPageTabLink_<?php echo $key?>" <?php if(!empty($p['loadHref'])) {?> rel="<?php echo $p['loadHref']?>" <?php }?>><?php lang::_e($p['title'])?></a></li>
		<?php }?>
	</ul>
	<?php foreach($this->editablePages as $key => $p) { ?>
	<div id="toeEdit_<?php echo $key?>" class="toePageExample"></div>
	<?php }?>
</div>
<div id="toeEditPagesAvailableWidgetsShell" class="toeSlidePanelShell">
	<div class="toeSlidePanelOpener" id="toeEditPagesAvailableWidgetsShell_opener"></div>
	<div class="toeSlidePanelLock"></div>
	<h1><?php lang::_e('Available widgets')?></h1>
	<div class="toeActiveWidgetsList">
	<?php foreach($this->widgetsListLogic as $lKey => $lLabel) { ?>
		<?php if(empty($this->categorizedWigets[ $lKey ]) && $lKey != 'readyWidgets') continue;?>
		<h3><?php lang::_e($lLabel)?></h3>

			<?php if($lKey == 'readyWidgets') { ?>
				<div class="toeReadyWidgetsList">
					<?php foreach($this->readyWidgetsTypes as $tKey => $tLabel) {?>
					<h3><?php lang::_e($tLabel)?></h3>
					<div class="toeWidgetsContainer">
						<?php foreach($this->categorizedWigets[ $tKey ] as $w) { ?>
							<div class="toeActiveWidget toeActiveWidget_<?php echo $w['id']?> portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all"
								name="<?php echo $w['name']?>"
								widgetId="<?php echo $w['id']?>">
									<div class="toeWidgetLabel ui-widget-header ui-corner-all"><?php echo $w['name']?></div>
							</div>
						<?php }?>
					</div>
					<?php }?>
				</div>
			<?php } else { ?>
				<div class="toeWidgetsContainer">
					<?php foreach($this->categorizedWigets[ $lKey ] as $w) { ?>
						<div class="toeActiveWidget toeActiveWidget_<?php echo $w['id']?> portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all"
							name="<?php echo $w['name']?>"
							widgetId="<?php echo $w['id']?>">
								<div class="toeWidgetLabel ui-widget-header ui-corner-all"><?php echo $w['name']?></div>
						</div>
					<?php }?>
				</div>
			<?php }?>

	<?php }?>
	</div>
</div>
