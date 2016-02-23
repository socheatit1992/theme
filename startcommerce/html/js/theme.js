$(document).ready(function(){
    $("#language-list").attr("style","height:27px;");
    $("#currency-list").attr("style","height:27px;");
    $(".select").attr("style","height:27px;");

	$("#language-list").mouseenter(function() {
        $(this).stop(true).animate({width: 136, textIndent: 0, height: $("#language").height()+14}, 500);
    });
    
    $("#language-list").mouseleave(function() {
        $(this).animate({width: 40, textIndent: 50, height:27}, 500);
    });
    
    $("#currency-list").mouseenter(function() {
        $(this).stop(true).animate({width: 136, textIndent: 0, height: $("#currency").height()+7}, 500);
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
    $('.sub-menu').autocolumnlist({ columns: 2, min: 6 });
    
    // Rating
    $(".item-rating").each(function(){
        var starscount = parseInt( $(this).text() );
        var off = 5 - starscount;
        var text = "";
        for (i=1; i<=starscount; i++) {
            text += "<span class='star-on'></span>";
        }
        for (i=1; i<=off; i++) {
            text += "<span class='star-off'></span>";
        }
        $(this).html(text);
    });
    
    // Brands Carousel
    $('#brands').infiniteCarousel();
    
    // Menu Sub nav
    
    $(".sub-menu").each(function(){
        var elem = $(this).contents(".column");
        var count = elem.size();
        $(this).attr("style", "width:"+(191*count-1)+"px");
    });
    
    $("#main-menu li").hover(function() {
        $(this).contents("ul.sub-menu").stop(1,1).slideDown('fast').show();
    
        $(this).hover(function() {
        }, function(){
            $(this).parent().find("ul.sub-menu").delay(500).slideUp('fast');
        });
    });
    
    // gallery
    $("#single-gallery ul li a").mouseenter(function(e){        
        $(this).find("img").animate({opacity:0.7},300);
    });
    
    $("#single-gallery ul li a").mouseleave(function(){
        $(this).find("img").animate({opacity:1},300);
    });
    
    $(".back-img").attr("src",$("#single-gallery ul li:first-child a").attr("href"));
    $("#imgslider .back-img").load(function(){
        var top = $("#imgslider .back-img").height() - ($("#imgslider .back-img").height() / 2);
        var left = $("#imgslider .back-img").width() - ($("#imgslider .back-img").width() / 2);
        $("#imgslider .back-img").css({marginTop: "-"+top+"px", marginLeft: "-"+left+"px"});
    });
    
    $("#single-gallery ul li a").click(function(e){
        e.preventDefault();
        var src = $(this).attr("href");
        $("#imgslider .back-img").animate({opacity: 0}, 500, function(){
            $("#imgslider .back-img").attr("src", src);
            $("#imgslider .back-img").load(function(){
                var top = $("#imgslider .back-img").height() - ($("#imgslider .back-img").height() / 2);
                var left = $("#imgslider .back-img").width() - ($("#imgslider .back-img").width() / 2);
                $("#imgslider .back-img").css({marginTop: "-"+top+"px", marginLeft: "-"+left+"px"});
            });
            $("#imgslider .back-img").animate({opacity: 1},500);
        });        
    });
    
});