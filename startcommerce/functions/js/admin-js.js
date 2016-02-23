function scCancelColorPicker(){
  var oldColor = jQuery("#colorpicker").attr('old-color');
  if (oldColor) {
    jQuery.farbtastic("#colorpicker").setColor(oldColor);
    jQuery("#colorpicker").hide();
  }
}

jQuery(document).ready(function(){ 
    jQuery( "#rm_tabs" ).tabs();
    
    // change preview bg
	jQuery('a.body-change').click(function(event){
        event.preventDefault();
        var imgUrl = jQuery(this).attr('href');
        jQuery('#live-prev').css({'background-image':"url('"+imgUrl+"')", "background-attachment":"fixed", "background-position":"top center", "background-attachment":"fixed", "background-repeat":"repeat"});
        jQuery('#bg-img').val('background-image:url('+imgUrl+'); background-attachment:fixed; background-position:0 50%; background-attachment:fixed; background-repeat:repeat;');
   });
   
   // headings font
	jQuery('#hfont').change(function(){
        var selectors = '#prev-head p';
        var gFontVal = jQuery("option:selected", this).val();
		var gFontName = gFontVal.split(':');
		if (jQuery('head').find('link#gFontName-css').length < 1){
			jQuery('head').append('<link id="gFontName-css" rel="stylesheet" type="text/css" href="" />');
		}
		if (jQuery('head').find('style#gFontStyles').length < 1){
			jQuery('head').append('<style id="gFontStyles" type="text/css"></style>');
		}
		jQuery('link#gFontName-css').attr({href:'http://fonts.googleapis.com/css?family=' + gFontVal+'&subset=latin,cyrillic-ext'});
		jQuery('style#gFontStyles').html(selectors + ' { font-family:"' + gFontName[0] + '", "Trebuchet MS", Arial, "Helvetica CY", "Nimbus Sans L", sans-serif !important; }');
        jQuery('#goo-font').val('<link id="gFontName-css" rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family='+gFontVal+'&subset=latin,cyrillic-ext" />');
        var theme_selectors = 'h1, h2, h3, .slider-text h2, #shop-name, .info-block em, .text-left';
        jQuery('#head-font').val(theme_selectors + ' { font-family:"' + gFontName[0] + '", "Trebuchet MS", Arial, "Helvetica CY", "Nimbus Sans L", sans-serif !important; }');
    });
    
    // paragraph
	jQuery('#pfont').change(function(){
		var pfontVal = jQuery("#pfont option:selected").val();
		if (jQuery('head').find('style#cFontStyles').length < 1){
			jQuery('head').append('<style id="cFontStyles" type="text/css"></style>');
		}
		jQuery('style#cFontStyles').text('#prev-content p { font-family:' + pfontVal + ' !important; }');
        jQuery('#cont-font').val('body { font-family:' + pfontVal + ' !important; }');
	});
    
    jQuery('#choose-this').click(function(event){
        event.preventDefault();
        jQuery('#scom_bgimg').val( jQuery('#bg-img').val() );
        jQuery('#scom_bgcol').val( jQuery('#bg-color').val() );
        //alert('New Background Image is activated. Don\'t forget Save settings!');
        jQuery(this).after('<p class="informer">New Background Image is activated. Don\'t forget Save settings!</p>');
        jQuery('.informer').delay(1500).slideUp('fast');
    });
    
    jQuery('#head-save').click(function(event){
        event.preventDefault();
        jQuery('#scom_google_font').val( jQuery('#goo-font').val() );
        jQuery('#scom_google_font_name').val( jQuery('#hfont').val() );
        jQuery(this).after('<p class="informer">New Heading Font Style is activated. Don\'t forget Save settings!</p>');
        jQuery('.informer').delay(1500).slideUp('fast');
    });
    
    jQuery('#cont-save').click(function(event){
        event.preventDefault();
        jQuery('#scom_content_font_name').val( jQuery('#pfont').val() );
        jQuery(this).after('<p class="informer">New Content Font Style is activated. Don\'t forget Save settings!</p>');
        jQuery('.informer').delay(1500).slideUp('fast');
    });
    
    jQuery('#reset-all').click(function(){
        event.preventDefault();
        jQuery('#scom_bgimg').val('');
        jQuery('#scom_bgcol').val('');
        jQuery('#scom_google_font_name').val('');
        jQuery('#scom_content_font_name').val('');
        jQuery(this).after('<p class="informer">All custom settings was successfully reset. Don\'t forget Save settings!</p>');
        jQuery('.informer').delay(1500).slideUp('fast');
    });
    
    // Color picker. (Farbtastic.

      jQuery("body").append("<div id='colorpicker'></div>");
      jQuery("#colorpicker").farbtastic(".colorpicker:first").prepend("<span class='ui-icon ui-icon-check'></span>");
      jQuery('.colorpicker').each(function(){
            jQuery.farbtastic("#colorpicker").linkTo(jQuery(this));
      });
      jQuery('.colorpicker').focus(function() {
            jQuery("#colorpicker").hide();
            jQuery.farbtastic("#colorpicker").linkTo(jQuery(this));
            jQuery("#colorpicker").attr('old-color', jQuery.farbtastic("#colorpicker").color);
            var offset = jQuery(this).offset();
            jQuery("#colorpicker").css('left', offset.left - 68).css('top', offset.top + 20).fadeIn(400);
            jQuery(this).attr('value', jQuery.farbtastic("#colorpicker").color);
      });
      jQuery("#colorpicker .ui-icon-check").click(function(){
            jQuery("#colorpicker").hide();
            var BgCol = jQuery(".colorpicker").css('background-color');
            jQuery('#live-prev').css({'background-color':BgCol});
            jQuery("#bg-color").val(jQuery(".colorpicker").css('background-color'));
      });
      jQuery('.colorpicker').live('click',function(){
            jQuery("#colorpicker").attr('old-color', jQuery.farbtastic("#colorpicker").color);
            jQuery("#colorpicker").show();
      });
      jQuery('.colorpicker').keydown(function(event) {
            // Esc.
            if (event.keyCode == 27) {scCancelColorPicker()}
            // Enter.
            if (event.keyCode == 13) {
              jQuery("#colorpicker .ui-icon-check").click();
              event.preventDefault();
            }
            // Space.
            if (event.keyCode == 32) {jQuery("#colorpicker").show();}
      });    
});