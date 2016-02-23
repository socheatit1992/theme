function closePopupWindow(){
    $('#toe_sub_screen').fadeOut(500);
}

$(document).ready(function(){
    $("#contactForm").validate();
    
    /* This will work in the future
    $("#language-list").attr("style","height:27px;");

	$("#language-list").mouseenter(function() {
        $(this).stop(true).animate({width: 136, textIndent: 0, height: $("#language").height()+14}, 500);
    });
    
    $("#language-list").mouseleave(function() {
        $(this).animate({width: 40, textIndent: 50, height:27}, 500);
    });
    */
    
    $("#currency-list").attr("style","height:27px;");
    $("#currency-list").mouseenter(function() {
        $(this).stop(true).animate({width: 80, textIndent: 0, height: $("#currency").height()+7}, 500);
    });
    
    $("#currency-list").mouseleave(function() {
        $(this).animate({width: 40, textIndent: 70, height:27}, 500);
    });
    
    $(".select").mouseenter(function() {
        $(this).stop(true).animate({height: $(this).contents("ul").height()+14}, 500);
    });
    
    $(".select").mouseleave(function() {
        $(this).animate({height:27}, 500);
    });
    
    $(".select li").click(function(){
        $(this).parent().contents(".current-list-item").html( $(this).html() );
        $(this).parent().parent().contents("input:hidden").val($(this).text());
    });
    
    // Menu columns
    $('.sub-menu, .children').autocolumnlist({ columns: 2, min: 6 });
    
    // Mobile menu
    $('.mobile-menu').change(function(){
        if($(this).val() != '') location = $(this).val();
    });
    
    $('.mobile-menu option').each(function(){
        if ($(this).val() == $(location).attr('href')) $(this).attr('selected', 'selected');
    });

    // Menu Sub nav
    
    $(".sub-menu, .children").each(function(){
        var elem = $(this).contents(".menu-col");
        var count = elem.size();
        $(this).attr("style", "width:"+(160*count-1)+"px");
    });
    
    $("#main-menu li").hover(function() {
        $(this).contents("ul.sub-menu, ul.children").stop(1,1).fadeIn('fast');
    
        $(this).hover(function() {
        }, function(){
            $(this).parent().find("ul.sub-menu, ul.children").fadeOut('fast');
        });
    });
    
    // Brands Carousel
    $('.brands-slider').flexslider({
        animation: "slide",
        animationLoop: true,
        itemWidth: 120,
        itemMargin: 12,
        directionNav: true,
        controlNav: false
    });

    // gallery
    $("#single-gallery ul li a").mouseenter(function(e){        
        $(this).find("img").animate({opacity:0.7},300);
    });
    
    $("#single-gallery ul li a").mouseleave(function(){
        $(this).find("img").animate({opacity:1},300);
    });
    
    $("#imgslider a").attr("href",$(".product_slider ul li:first-child a").attr("alt"));
    
    $("#single-gallery ul li a").click(function(e){
        e.preventDefault();
        var src = $(this).attr("href");
        var srcBig = $(this).attr("alt");
        
        $("#all-prod-images a").each(function(){
            var link = $(this).attr('href');
            if (link == srcBig) {
                $(this).attr("rel"," ");
            } else {
                $(this).attr("rel","lightbox[product]");
            }
        });
        
        $("#imgslider .back-img").animate({opacity: 0}, 250, function(){
            $("#imgslider .back-img").attr("src", src).delay(500);
            $("#imgslider a").attr("href", srcBig);
            $("#imgslider .back-img").animate({opacity: 1},250);
        });        
    });
    
    $("#imgslider a").hover(function() {
        $(this).find(".zoom").stop(1,1).animate({top:"37%", opacity:1},500);
    
        $(this).hover(function() {
        }, function(){
            $(this).find(".zoom").animate({top:"100%", opacity:0},300);;
        });
    });
    
    $('.change-to-list-view').click(function(e){
        e.preventDefault();
        $('.change-to-grid-view').removeClass('current-catalog-view');
        $('.change-to-list-view').each(function(){$(this).addClass('current-catalog-view');});
        $('.grid-item-view').hide();
        $('.list-item-view').fadeIn(700);
        $.cookie("catalogView", "list", {expires: 7, path: '/'});
    });
    
    $('.change-to-grid-view').click(function(e){
        e.preventDefault();
        $('.change-to-list-view').removeClass('current-catalog-view');
        $('.change-to-grid-view').each(function(){$(this).addClass('current-catalog-view');});
        $('.list-item-view').hide();
        $('.grid-item-view').fadeIn(700);
        $.cookie("catalogView", "grid", {expires: 7, path: '/'});
    });
    
    $('.current-catalog-view').click(function(e){e.preventDefault();});
    
    $('.items-list li .items-image-block a, .items .items-image-block a').mouseenter(function() {
        var $thisObj = $(this);
        $thisObj.parent().parent().find('a').css('color','#00A6DD');
    });
    
    $('.items-list li .items-image-block a, .items .items-image-block a').mouseleave(function() {
        var $thisObj = $(this);
        $thisObj.parent().parent().find('a').css('color','#FF7E00');
    });
    
});