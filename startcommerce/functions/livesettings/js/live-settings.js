$(document).ready(function(){    				

    // change body bg
	$('a.body-change').click(function(event){
        event.preventDefault();
        var imgUrl = $(this).attr('href');
        $('body').css({'background-image':"url('"+imgUrl+"')", "background-attachment":"fixed", "background-position":"top center", "background-attachment":"fixed", "background-repeat":"repeat"});
    });
    
    // headings font
	$('#hfont').change(function(){
        var selectors = 'h1, h2, h3, .slider-text h2';
		var live = '#shop-name, .info-block em, .text-left';
        var gFontVal = $("option:selected", this).val();
		var gFontName = gFontVal.split(':');
		if ($('head').find('link#gFontName').length < 1){
			$('head').append('<link id="gFontName" rel="stylesheet" type="text/css" href="" />');
		}
		if ($('head').find('style#gFontStyles').length < 1){
			$('head').append('<style id="gFontStyles" type="text/css"></style>');
		}
		$('link#gFontName').attr({href:'http://fonts.googleapis.com/css?family=' + gFontVal+'&subset=latin,cyrillic-ext'});
		$('style#gFontStyles').html(selectors + ', ' + live + ' { font-family:"' + gFontName[0] + '", "Trebuchet MS", Arial, "Helvetica CY", "Nimbus Sans L", sans-serif !important; }');
	});
    
    // paragraph
	$('#pfont').change(function(){
		var pfontVal = $("#pfont option:selected").val();
		if ($('head').find('style#cFontStyles').length < 1){
			$('head').append('<style id="cFontStyles" type="text/css"></style>');
		}
		$('style#cFontStyles').text('body { font-family:' + pfontVal + ' !important; }');
	});
    
    $("#handler").click(function(){
        if ($(this).hasClass("close")){
            $(this).removeClass("close");
            $(this).addClass("edit");
            $(this).parent().animate({
                left:'-187px'
            },300);
        } else {
            $(this).removeClass("edit");
            $(this).addClass("close");
            $(this).parent().animate({
                left:'0px'
            },300);
        }
    });
    
    $('#handler').parent().delay(1000).animate({left:'-187px'}, 300, function(){
		$(this).find('#handler').removeClass('close').addClass('edit');
	});
    
    // colorpicker body background      
	$('.style-picker #bgColor').parent('a').ColorPicker({
		onChange:function(hsb, hex, rgb){
			$('.style-picker').find('#bgColor').css({backgroundColor:'#' + hex});
			$('body').css({backgroundColor:'#' + hex});
		},
		onSubmit:function(hsb, hex, rgb, el){
			$(el).find('#bgColor').css({backgroundColor:'#' + hex});
			$(el).find('#bgColor').attr({title:hex});
			$('body').css({backgroundColor:'#' + hex});
			$(el).ColorPickerHide();
		},
		onBeforeShow:function(){
		    var hex = $('.style-picker').find('#bgColor').attr('title');
			$(this).ColorPickerSetColor(hex); 
		}
	});
});