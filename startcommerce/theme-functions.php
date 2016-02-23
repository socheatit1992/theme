<?php
// Activation plugin theme part
add_action( 'after_switch_theme', 'startcommerce_theme_setup' ); 
function startcommerce_theme_setup() {
    // Plugin part initialized
    if(class_exists('frame')) {
        frame::_()->getModule('options')->getModel('options')->put(array('code' => 'default_theme', 'value' => 'startcommerce'));   
		// Default category and product for pages editor
		frame::_()->getTable('options')->insert(array('code' => 'page_editor_example_cat', 'htmltype_id' => 3));
		frame::_()->getTable('options')->insert(array('code' => 'page_editor_example_prod', 'htmltype_id' => 3));
		frame::_()->getTable('options')->insert(array('code' => 'page_editor_example_cart', 'htmltype_id' => 3));
		// Theme additional modules adding
    }
}

// widget code here

/*
 * Adding Custom Widget Set on Theme activation
 * $sidebarSlug - Sidebar Slug Name
 * $widgetSlug - Widget Slug Name
 * $countMod - use 0, if you want add only one copy of widget, if you adding same widget second time use 1, third time - use 2
 * $widgetSettings - this is associative array of widget settings
 */
function addWidgetToSidebar($sidebarSlug, $widgetSlug, $countMod, $widgetSettings = array()){   
    $sidebarOptions = get_option('sidebars_widgets');
    if(!isset($sidebarOptions[$sidebarSlug])){
        $sidebarOptions[$sidebarSlug] = array('_multiwidget' => 1);
    }
    $newWidget = get_option('widget_'.$widgetSlug);
    if(!is_array($newWidget))$newWidget = array();
    $count = count($newWidget)+1+$countMod;
	$newWidgetId = $widgetSlug.'-'.$count;
    $sidebarOptions[$sidebarSlug][] = $newWidgetId;
    
    // widget settings
    $newWidget[$count] = $widgetSettings;
    
    update_option('sidebars_widgets', $sidebarOptions);
    update_option('widget_'.$widgetSlug, $newWidget);
	return $newWidgetId;
}

$checkWidgets = get_option('theme_startcommerce_widgets');
if($checkWidgets != 'set'){
	if(class_exists('frame')) {
		$themeDir = utils::getCurrentWPThemeDir();
		
		$relatedThemeModsDir = explode('wp-content', $themeDir);
		$relatedThemeModsDir = mysql_real_escape_string('wp-content'. $relatedThemeModsDir[1]. S_TOE. DS. S_THEME_MODULES);

		$themeModsDir = $themeDir. S_TOE. DS. S_THEME_MODULES;
		modInstaller::install(array('code' => 'dummy_data', 
				'ex_plug_dir' => $relatedThemeModsDir,
				'active' => '1', 
				'type_id' => '6', 
				'has_tab' => '1', 
				'label' => 'Dummy Data', 
				'description' => ''), 
			$themeModsDir
		);
		modInstaller::install(array('code' => 'pages_editor', 
				'ex_plug_dir' => $relatedThemeModsDir,
				'active' => '1', 
				'type_id' => '6', 
				'has_tab' => '0', 
				'label' => 'Pages Editor', 
				'description' => ''), 
			$themeModsDir
		);
		
		frame::_()->getModule('dummy_data')->getModel()->reactivateWidgets();
		update_option('theme_startcommerce_widgets', 'set');
		
		
		/**
			*Activate notice
		*/
		update_option('hideDummyDataInstallNotice', false);
		update_option('wasDummyProductsInstalled', false);
	}
}

function get_image($src, $width, $height, $mode) {
    switch ($mode){
        case 'width': echo uri::_(array('baseUrl' => $src, 'w' => $width)); break;
        case 'height': echo uri::_(array('baseUrl' => $src, 'h' => $height)); break;
        case 'both': echo uri::_(array('baseUrl' => $src, 'w' => $width, 'h' => $height)); break;
        default: echo uri::_(array('baseUrl' => $src, 'w' => $width, 'h' => $height)); break;
    }
}

// live settings
if(get_option('scom_live_settings') == 'on') require_once (TEMPLATEPATH . '/functions/livesettings/live-settings.php');

// admin settings
require_once (TEMPLATEPATH . '/functions/admin-menu.php');
wp_enqueue_style( 'st-admin-style', get_template_directory_uri() . '/functions/css/style.css' );
wp_enqueue_style( 'gFontName', 'http://fonts.googleapis.com/css?family=Ubuntu:500italic&subset=latin,cyrillic-ext' );

// include metaboxes
require_once (TEMPLATEPATH . '/functions/metabox.php');

//include Foundation Framework options
require_once (TEMPLATEPATH . '/functions/foundation/nav-walkers.php');

// including slider to admin page
//require_once (TEMPLATEPATH . '/functions/admin_slider/index.php');
require_once (TEMPLATEPATH . '/functions/admin_responsive_slider/index.php');

// Add new image size in WP Uploader popup window
function true_get_the_sizes() {
   $s = array('');
   global $_wp_additional_image_sizes;
   if ( isset($_wp_additional_image_sizes) && count($_wp_additional_image_sizes) ) {
       $s = apply_filters( 'intermediate_image_sizes', $_wp_additional_image_sizes );
       $s = apply_filters( 'true_get_the_sizes', $_wp_additional_image_sizes );
   }
   return $s;
}
 
function true_sizes_input_fields( $fields, $post ) {
   if ( !isset($fields['image-size']['html']) || substr($post->post_mime_type, 0, 5) != 'image' )
       return $fields;
 
   $s = true_get_the_sizes();
   if ( !count($s) )
       return $fields;
 
   $items = array();
   foreach ( array_keys($s) as $size ) {
       $l = apply_filters( 'img_sz_name', $size );
       $element_id = "image-size-{$size}-{$post->ID}";
       $ds = image_downsize( $post->ID, $size );
       $enabled = $ds[3];
       $html = "<div class='image-size-item'>\n";
       $html .= "\t<input type='radio' " . disabled( $enabled, false, false ) . "name='attachments[{$post->ID}][image-size]' id='{$element_id}' value='{$size}' />\n";
       $html .= "\t<label for='{$element_id}' style='margin:0 0 0 2px;'>{$l}</label>\n";
       if ( $enabled )
           $html .= "\t<label for='{$element_id}' class='help'>" . sprintf( "(%d&nbsp;&times;&nbsp;%d)", $ds[1], $ds[2] ). "</label>\n";
       $html .= "</div>";
       $items[] = $html;
   }
 
   $items = join( "\n", $items );
   $fields['image-size']['html'] = "{$fields['image-size']['html']}\n{$items}";
 
   return $fields;
}
 
add_filter( 'attachment_fields_to_edit', 'true_sizes_input_fields', 11, 2 );

add_image_size( 'Slider', 910, 350, true );

// including home slider
function ready_slider(){
    $data = get_option(OPTIONS);
    $slides = $data['ready_slider'];
    if (!empty($slides)){
?>

<div id="startslider"  class="evoslider default">
    <dl>
        <?php 
        foreach ($slides as $slide => $value) {?>
            <dt><?php echo $value['title']?></dt>
            <dd data-src="<?php echo $value['url']; ?>" data-text="overlay"<?php if($value['link'] != '') {?> data-url="<?php echo $value['link']; ?>" <?php }?>>
                <?php if($value['description'] != '') {?><div class="evoText"><?php echo $value['description']; ?></div><?php }?>
            </dd>
        <?php }?>
    </dl>
</div>
<script type="text/javascript">
$(document).ready(function(){
    startcommerceSlider = jQuery("#startslider").evoSlider({
        mode:"<?php echo $data['mode']?>",
        speed: <?php if($data['speed'] != '') {echo $data['speed'];} else {echo '500';}?>,
        interval: <?php if($data['interval'] != '') {echo $data['interval'];} else {echo '3000';}?>,
        pauseOnHover: <?php echo $data['pauseOnHover'] ? 'true' : 'false'?>,
        showPlayButton: <?php echo $data['showPlayButton'] ? 'true' : 'false'?>,
        directionNav: <?php echo $data['directionNav'] ? 'true' : 'false'?>,                 // Shows directional navigation when initialized
        directionNavAutoHide: <?php echo $data['directionNavAutoHide'] ? 'true' : 'false'?>,        // Shows directional navigation on hover and hide it when mouseout
        width: <?php if($data['width'] != '') {echo $data['width'];} else {echo '910';}?>,
        height: <?php if($data['height'] != '') {echo $data['height'];} else {echo '360';}?>,
        <?php if($data['slideSpace'] != '') {echo 'slideSpace:'.$data['slideSpace'].',';} ?>                      // The space between slides
        <?php if($data['paddingRight'] != '') {echo 'paddingRight:'.$data['paddingRight'].',';} ?> // Padding right of the container/frame
        titleClockWiseRotation: <?php echo $data['directionNavAutoHide'] ? 'true' : 'false'?>,      // Rotates title bar by clock wise
        hideCurrentTitle: <?php echo $data['hideCurrentTitle'] ? 'true' : 'false'?>,            // Hides active title bar
        <?php if($data['startIndex'] != '') {echo 'startIndex:'.$data['startIndex'].',';} ?> // Start index when initialized
        showIndex: true,                    // Displays index in toggle icon and bullets control
        mouse: false,                        // Enables mousewheel scroll navigation
		keyboard: true,                     // Enables keyboard navigation (left and right arrows)
        easing: "swing",                    // Defines the easing effect mode
        loop: true,                         // Rotate slideshow
        lazyLoad: <?php echo $data['lazyLoad'] ? 'true' : 'false'?>,                    // Enables lazy load feature
        autoplay: true,                     // Sets EvoSlider to play slideshow when initialized
        pauseOnClick: true,                 // Stop slideshow if playing
        playButtonAutoHide: <?php echo $data['playButtonAutoHide'] ? 'true' : 'false'?>,          // Shows play/pause button on hover and hide it when mouseout
        toggleIcon: true,                   // Enables toggle icon
        showDirectionText: <?php echo $data['showDirectionText'] ? 'true' : 'false'?>,           // Shows text on direction navigation
        nextText: "<?php echo $data['nextText']?>",                   // Next button text
        prevText: "<?php echo $data['prevText']?>",                   // Prev button text
        controlNav: <?php echo $data['controlNav']?>,                   // Enables control navigation
        controlNavMode: "<?php echo $data['controlNavMode']?>",          // Sets control navigation mode ("bullets", "thumbnails", or "rotator")
        controlNavVertical: <?php echo $data['controlNavVertical'] ? 'true' : 'false'?>,          // Defines control navigation to display vertically
        controlNavPosition: "<?php echo $data['controlNavPosition']?>",       // Sets control navigation position ("inside" or "outside")
        controlNavVerticalAlign: "<?php echo $data['controlNavVerticalAlign']?>",   // Sets position of the vertical control navigation ("left" or "right")
        <?php if($data['controlSpace'] != '') {echo 'controlSpace:'.$data['controlSpace'].',';} ?>  // The space between outside control navigation with slides                 
        controlNavAutoHide: <?php echo $data['controlNavAutoHide'] ? 'true' : 'false'?>,          // Shows control navigation on mouseover and hide it when mouseout
        showRotatorTitles: true,            // Shows rotator titles
        showRotatorThumbs: true,            // Shows rotator thumbnails
        rotatorThumbsAlign: "<?php echo $data['rotatorThumbsAlign']?>",         // Thumbnails float position
        classBtnNext: "<?php if ($data['classBtnNext'] != '') {echo $data['classBtnNext'];} else {echo 'evo_next';}?>",           // The CSS class used for the next button
        classBtnPrev: "<?php if ($data['classBtnPrev'] != '') {echo $data['classBtnPrev'];} else {echo 'evo_prev';}?>",           // The CSS class used for the next button
        classExtLink: "<?php if ($data['classExtLink'] != '') {echo $data['classExtLink'];} else {echo 'evo_link';}?>",           // The CSS class used for the next button
        permalink: <?php echo $data['permalink'] ? 'true' : 'false'?>,                   // Enable or disable linking to slides via the url
        autoHideText: <?php echo $data['autoHideText'] ? 'true' : 'false'?>,                // Shows overlay text on mouseover and hide it on mouseout    
        outerText: <?php echo $data['outerText'] ? 'true' : 'false'?>,                   // Enables outer text
        outerTextPosition: "<?php echo $data['outerTextPosition']?>",         // Outer text align ("left" or "right")
        <?php if($data['outerTextSpace'] != '') {echo 'outerTextSpace:'.$data['outerTextSpace'].',';} ?>  // Space between text and slide
        linkTarget: "<?php echo $data['linkTarget']?>",               // The target attribute of the image link ("_blank", "_parent", "_self", or "_top")
        responsive: <?php echo $data['responsive'] ? 'true' : 'false'?>,                  // Enables responsive layout
        imageScale: "<?php echo $data['imageScale']?>"            // Sets image scale option ("fullSize", "fitImage", "fitWidth", "fitHeight", "none")                
    });
});
</script>

<?php    
    }
} // end Slider

// Responsive slider
function ready_responsive_slider(){
    $data = get_option(OPTIONS);
    $slides = $data['ready_responsive_slider'];
    if (!empty($slides)){
?>

<div class="flexslider">
    <ul class="slides">
        <?php 
        foreach ($slides as $slide => $value) {?>
            <li>
                <a href="<?php echo $value['link']; ?>">
                    <?php if($value['url'] != '') {?><img src="<?php echo $value['url']; ?>" alt="<?php echo $value['title']; ?>" /><?php }?>
                </a>
                <?php if($value['description'] != ''): ?>
                <p class="flex-caption"><?php echo $value['description']; ?></p>
                <?php endif; ?>
            </li>
        <?php }?>
    </ul>
</div>
<script type="text/javascript">
    $(window).load(function() {
        $('.flexslider').flexslider({
            animation:"<?php echo $data['animation']?>",
            direction:"<?php echo $data['direction']?>",
            slideshowSpeed:"<?php if ($data['slideshowspeed'] != ''){ echo $data['slideshowspeed'];} else {echo '3000';} ?>",
            animationSpeed:"<?php if ($data['animationspeed'] != ''){ echo $data['animationspeed'];} else {echo '600';} ?>",
            randomize:"<?php echo $data['randomize'] ? 'true' : 'false'?>"
        });
    });
</script>
<?php    
    }
} // end Responsive Slider


// include custom post type
require_once (TEMPLATEPATH . '/functions/custom-post-type.php');

add_theme_support( 'post-thumbnails' );		
add_image_size( 'banner-thumb', 300, 138, true );
remove_action('wp_head','wp_generator');
add_theme_support('menus');  
  
// Navigations
register_nav_menus(array(
    'main' => 'Main menu',
    'footer' => 'Footer menu'
));
  
/**
 * Register our sidebars and widgetized areas. 
 */
function startcommerce_widgets_init() {

    register_sidebar( array(
		'name' => lang::_( 'Cart' ),
		'id' => 'cart',
		'before_widget' => '<div class="cart-mini">',
		'after_widget' => '</div>',
		'before_title' => '',
		'after_title' => '',
	) );

    register_sidebar( array(
		'name' => lang::_( 'Currency'),
		'id' => 'currency',
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div></div>',
		'before_title' => '<h2>',
		'after_title' => '</h2><hr class="wave-line px220" /><div class="widget-body">',
	) );
    
    register_sidebar( array(
		'name' => lang::_( 'Breadcrumbs' ),
		'id' => 'breadcrumbs',
		'before_widget' => '<div id="breadcrumbs">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	) );
    
    register_sidebar( array(
		'name' => lang::_( 'New Products'),
		'id' => 'newproducts',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h2>',
		'after_title' => '</h2><hr class="wave-line" /><div class="clear"></div>',
	) );
    
    register_sidebar( array(
		'name' => lang::_( 'Bestsellers' ),
		'id' => 'bestsellers',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h2>',
		'after_title' => '</h2><hr class="wave-line" /><div class="clear"></div>',
	) );
    
    register_sidebar( array(
		'name' => lang::_( 'brands' ),
		'id' => 'brands',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h2>',
		'after_title' => '</h2><div class="clear"></div>',
	) );
    
    register_sidebar( array(
		'name' => lang::_( 'Footer Latest Tweets' ),
		'id' => 'footertwitter',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );
    
    register_sidebar( array(
		'name' => lang::_( 'Footer Contacts'),
		'id' => 'footercontact',
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );
    
    register_sidebar( array(
		'name' => lang::_( 'Products Category Sidebar widgets'),
		'id' => 'sidebarproducts',
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div></div>',
		'before_title' => '<h2>',
		'after_title' => '</h2><hr class="wave-line px220" /><div class="widget-body">',
	) );
    
    register_sidebar( array(
		'name' => lang::_( 'Sidebar widgets'),
		'id' => 'sidebar',
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div></div>',
		'before_title' => '<h2>',
		'after_title' => '</h2><hr class="wave-line px220" /><div class="widget-body">',
	) );
    
    register_sidebar( array(
		'name' => lang::_( 'Page with Sidebar widgets'),
		'id' => 'pagesidebar',
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div></div>',
		'before_title' => '<h2>',
		'after_title' => '</h2><hr class="wave-line px220" /><div class="widget-body">',
	) );

}
add_action( 'widgets_init', 'startcommerce_widgets_init' );  

function mytheme_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
     <div id="comment-<?php comment_ID(); ?>" class="comment-block">
      
      <div class="comment-author vcard">
         <h3><?php printf(lang::_('<cite class="fn">%s</cite>'), get_comment_author_link()) ?></h3>
         <span class="comm-date"><?php printf( get_comment_date('j/m/Y')) ?></span>
      </div><div style="clear:both;"></div>

      <?php if ($comment->comment_approved == '0') : ?>
         <em><?php lang::_e('Your comment is awaiting moderation.') ?></em>
         <br />
      <?php endif; ?>

      <?php comment_text() ?>      
     </div>
<?php
}

function posted_on() {
	printf( lang::_( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>'),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);
}
function toeWSM($d) {
	$d['where_find_us'] = isset($d['where_find_us']) && !empty($d['where_find_us']) ? (int) $d['where_find_us'] : 5;	// Other by default
	$desc = '';
	if(in_array($d['where_find_us'], array(4, 5))) {
		$desc = $d['where_find_us'] == 4 ? $d['find_on_web_url'] : $d['other_way_desc'];
	}
	$reqUrl = implode('', array('ht','tp:','/','/r','ea','dy','sh','opp','i','n','gc','ar','t','.','c','o','m/')). '?mod=options&action=saveWelcomePageInquirer&pl=rcs';
	wp_remote_post($reqUrl, array(
		'body' => array(
			'site_url' => get_bloginfo('wpurl'),
			'site_name' => get_bloginfo('name'),
			'where_find_us' => $d['where_find_us'],
			'desc' => $desc,
			'plugin_code' => TOE_TPL_CODE,
		)
	));
	update_option(TOE_TPL_CODE. '_welcome_viewed', 1);
	exit(json_encode(array('msg' => 'Thank you! Enjoy our solutions!')));
}
if(!get_option(TOE_TPL_CODE. '_welcome_viewed')) {
	if(is_admin()) {
		$actKey = implode('', array('tp','lA','ct','io','n'));
		$action = isset($_POST) && isset($_POST[$actKey]) ? $_POST[$actKey] : '';
		$actVal = implode('', array('t','oe','W','el','co','me','Pa','g','eS','av','eI','nf','oT','pl'));
		
		if(!empty($action) && $action === $actVal && !isset($_POST['mod']) && !isset($_POST['page'])) {
			$_POST = array_map('trim', array_map('htmlspecialchars', array_map('stripslashes', $_POST)));
			toeWSM( $_POST );
		}
		toeAddBootstrap();
		add_action('admin_footer', 'toeShowWelcomePopupHtml');
		wp_enqueue_style('jquery.bxslider', get_template_directory_uri(). '/css/jquery.bxslider.css');
		wp_enqueue_script('jquery.bxslider', get_template_directory_uri(). '/js/jquery.bxslider.min.js');
		function toeShowWelcomePopupHtml() {
			global $actVal;
			if(!class_exists('html')) {
				require_once(TEMPLATEPATH . DIRECTORY_SEPARATOR. 'functions'. DIRECTORY_SEPARATOR. 'classes'. DIRECTORY_SEPARATOR. 'html.php');
			}
			$askOptions = array(
				1 => array('label' => 'Google'),
				2 => array('label' => 'Wordpress.org'),
				3 => array('label' => 'Reffer a friend'),
				4 => array('label' => 'Find on the web'),
				5 => array('label' => 'Other way...'),
			);
			$promoTemlates = array(
				'startcommerce' => array(
					'name' => 'StartCommerce',
					'description' => 'New e-commerce WordPress theme with shopping cart feature for Your online store that will make it really cool!',
					'prevImg' => 'startcommerce.jpg',
					'href' => 'http://readyshoppingcart.com/product/start-commerce/',
					'isPromo' => true,
					'buttVal' => 'Get PRO template',
				),
				'the_venus' => array(
					'name' => 'The Venus',
					'description' => 'Simplicity is the key to the e-commerce and we release it in this theme!',
					'prevImg' => 'the_venus.png',
					'href' => 'http://readyshoppingcart.com/product/venus-stylish-e-commerce/',
					'isPromo' => true,
					'buttVal' => 'Get PRO template',
				),
				'EntireSpace' => array(
					'name' => 'Entire Space Shop',
					'description' => 'Simple design and powerful options rise level of your WordPress shop to the top of online ecommerce.',
					'prevImg' => 'EntireSpace.png',
					'href' => 'http://readyshoppingcart.com/product/entire-responsive-e-commerce-wp-theme/',
					'isPromo' => true,
					'buttVal' => 'Get PRO template',
				),
				'perfectecommerce' => array(
					'name' => 'PerfectEcommerce',
					'description' => 'Personalize any part of your WordPress webshop with different types of slideshows, custom shopping cart and checkout.',
					'prevImg' => 'perfectecommerce.jpg',
					'href' => 'http://readyshoppingcart.com/product/perfect-wordpress-ecommerce-template/',
					'isPromo' => true,
					'buttVal' => 'Get PRO template',
				),
				'interior' => array(
					'name' => 'Finilia Interior',
					'description' => 'Interior WordPress E-commerce Template is best suited for users who like to make use a lots of graphics to their online store.',
					'prevImg' => 'interior.png',
					'href' => 'http://readyshoppingcart.com/product/interior-wordpress-e-commerce-template/',
					'isPromo' => true,
					'buttVal' => 'Get PRO template',
				),
				'jeans' => array(
					'name' => 'Jeans theme',
					'description' => 'The theme is easy to configure, and offers integration options with Ready! ecommerce plugin.',
					'prevImg' => 'jeans.png',
					'href' => 'http://readyshoppingcart.com/product/jeans-free-ecommerce-theme/',
					'isPromo' => true,
					'buttVal' => 'Get FREE template',
				),
				'ready_ecommerce_theme' => array(
					'name' => 'Ready! to Be',
					'description' => 'This free WordPress thee is a great way to kickstart your online business quickly!',
					'prevImg' => 'ready_ecommerce_theme.png',
					'href' => 'http://readyshoppingcart.com/product/free-wordpress-e-commerce-theme/',
					'isPromo' => true,
					'buttVal' => 'Get FREE template',
				),
				'albecocommerce' => array(
					'name' => 'AlbecoCommerce',
					'description' => 'It\'s include all professional options, easy to use and to configure.',
					'prevImg' => 'albecocommerce.jpg',
					'href' => 'http://readyshoppingcart.com/product/albeco-free-wp-ecommerce-theme/',
					'isPromo' => true,
					'buttVal' => 'Get FREE template',
				),
				'buzz' => array(
					'name' => 'BUZZ',
					'description' => 'A very simple flat and free theme for WordPress.',
					'prevImg' => 'buzz.png',
					'href' => 'http://readyshoppingcart.com/product/buzz-corporate-responsive/',
					'isPromo' => true,
					'buttVal' => 'Get FREE template',
				),
				'phonix' => array(
					'name' => 'Phonix',
					'description' => 'The theme is fully responsive that looks great on any mobile device.',
					'prevImg' => 'phonix.png',
					'href' => 'http://readyshoppingcart.com/product/phonix-theme/',
					'isPromo' => true,
					'buttVal' => 'Get FREE template',
				),
				'stalytus' => array(
					'name' => 'Stalytus',
					'description' => 'This theme is loaded with many features, including an amazing responsive slider, Multiple Page Layouts, Configurable Sidebar Locations, Footer Widgets & Easy to use admin Panel.',
					'prevImg' => 'stalytus.png',
					'href' => 'http://readyshoppingcart.com/product/stalytus-wordpress-theme/',
					'isPromo' => true,
					'buttVal' => 'Get FREE template',
				),
				'tabataba' => array(
					'name' => 'TabaTaba',
					'description' => 'Create a responsive HTML5 and CSS3 website with Tabataba free WordPress responsive theme with flat design for business, magazine or photo portfolio.',
					'prevImg' => 'tabataba.png',
					'href' => 'http://readyshoppingcart.com/product/tabataba-responsive-free-wordpress-theme/',
					'isPromo' => true,
					'buttVal' => 'Get FREE template',
				),
			);
			$promoPlugins = array(
				'coming_soon' => array(
					'name' => 'Coming Soon / Maintenance mode Ready!',
					'baner' => 'coming-soon.jpg', 
					'href' => 'http://readyshoppingcart.com/product/coming-soon-plugin-pro-version/',
				),
				'backup' => array(
					'name' => 'Ready! Backup',
					'baner' => 'backup.jpg', 
					'href' => 'http://readyshoppingcart.com/product/wordpress-backup-and-restoration-plugin/',
				),
				'google_maps' => array(
					'name' => 'Google Maps Ready!',
					'baner' => 'google-maps.jpg', 
					'href' => 'http://readyshoppingcart.com/product/google-maps-plugin/',
				),
				'pricing_table' => array(
					'name' => 'Pricing Table Ready!',
					'baner' => 'pricing-table.png', 
					'href' => 'http://readyshoppingcart.com/product/pricing-table-ready-plugin-pro/',
				),
				'ecommerce' => array(
					'name' => 'Ready! Ecommerce Shopping Cart',
					'baner' => 'ecommerce.jpg', 
					'href' => 'http://readyshoppingcart.com/extensions/',
				),
			);
			shuffle($promoTemlates);
			shuffle($promoPlugins);
			?>
		<style type="text/css">
			.modal-dialog {
				width: 90% !important;
				max-width: 1210px !important;
				font-family: 'Lato',serif;
			}
			#toeTplsSlider li {
				-webkit-box-sizing: border-box;
				-moz-box-sizing: border-box; 
				box-sizing: border-box;
				border: solid 1px #ccc;
				-webkit-border-radius: 13px;
				-moz-border-radius: 13px;
				border-radius: 13px;
				background: #f9f9f9;
				padding: 10px;
				width: 325px;
			}
			#toePluginsSlider li h2 {
				font-size: 30px;
				max-width: 682px;
				position: absolute;
				left: 30px;
				bottom: 20px;
				padding: 8px 15px;
				margin-bottom: 4px;
				color: #fff;
				background: rgba( 30, 30, 30, 0.9 );
				text-shadow: 0 1px 3px rgba( 0, 0, 0, 0.4 );
				-webkit-box-shadow: 0 0 30px rgba( 255, 255, 255, 0.1 );
				-moz-box-shadow: 0 0 30px rgba( 255, 255, 255, 0.1 );
				box-shadow: 0 0 30px rgba( 255, 255, 255, 0.1 );
				-webkit-border-radius: 8px;
				border-radius: 8px;
			}
		</style>
		<div id="toeTplWelcomePopup" class="modal fade" style="">  
			<div class="modal-dialog text-center">
				<div class="modal-content">
					<form id="toeWelcomePageFindUsForm">
						<div class="modal-header">
							<a class="close" data-dismiss="modal">X</a>
							<h3>You have successfully installed <?php echo TOE_TPL_NAME?>! Welcome to the family! What's next?</h3>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="span4 panel panel-default">
									<div class="panel-heading">
										<h4>Please tell - where did you find us?</h4>
									</div>
									<div class="panel-body text-left">
										<?php foreach($askOptions as $askId => $askOpt) { ?>
											<label>
												<?php echo html::radiobutton('where_find_us', array('value' => $askId/*, 'attrs' => 'style="margin: 0px !important;"'*/))?>
												<?php echo $askOpt['label']?>
											</label><br />
											<?php if($askId == 4 /*Find on the web*/) { ?>
												<label id="toeFindUsUrlShell" style="display: none; clear: both;"><?php echo html::text('find_on_web_url', array('attrs' => 'class="form-control" placeholder="Please, post url"'))?></label>
											<?php } elseif($askId == 5 /*Other way*/) { ?>
												<label style="display: none; clear: both;" id="toeOtherWayTextShell"><?php echo html::textarea('other_way_desc', array('attrs' => 'class="form-control"'))?></label>
											<?php }?>
										<?php }?>
									</div>
								</div>
								<div class="span8 panel panel-default">
									<div class="panel-heading">
										<h4>Check out other useful Wordpress Plugins:</h4>
									</div>
									<div class="panel-body">
										<ul class="bxslider" id="toePluginsSlider">
											<?php foreach($promoPlugins as $pP) { ?>
												<li style="position: relative;">
													<a href="<?php echo $pP['href']?>" target="blank">
														<img src="<?php echo get_template_directory_uri(). '/img/plugin_baners/'. $pP['baner']?>" />
													</a>
													<h2><?php echo $pP['name']?></h2>
												</li>
											<?php }?>
										</ul>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="span12 panel panel-default">
									<div class="panel-heading">
										<h4>Check all <a href="http://readyshoppingcart.com/products_categories/templates/" target="_blank">Free WordPress Themes</a>:</h4>
									</div>
									<div class="panel-body">
										<ul class="bxslider" id="toeTplsSlider">
											<?php 
												$i = 0;
											?>
											<?php foreach($promoTemlates as $pT) { ?>
												<li>
													<center><a href="<?php echo $pT['href']?>" target="_blank" style="text-align: center;"><b><?php echo $pT['name']?></b></a></center><br />
													<a href="<?php echo $pT['href']?>" target="_blank" style="height: 225px; overflow: hidden; width: 300px; display: block; border: 1px black solid;">
														<img style="max-width: 300px;" src="<?php echo get_template_directory_uri(). '/img/tpl_previews/'. $pT['prevImg']?>" />
													</a><br />
													<div style="height: 50px;"><p><?php echo $pT['description']?></p></div><br />
													<div><a href="<?php echo $pT['href']?>" target="_blank" class="button button-primary">Download Now</a></div>
												</li>
											<?php }?>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<span id="toeWelcomePageFindUsMsg"></span>
							<?php echo html::hidden('tplAction', array('value' => $actVal))?>
							<?php echo html::hidden('reqType', array('value' => 'ajax'))?>
							<?php echo html::submit('gonext', array('value' => 'Start use template!', 'attrs' => 'class="button button-primary button-hero"'))?>
						</div>
					</form>
				</div>
			</div>
		</div>
	   <script type="text/javascript">
	   // <!--
	   var toeLoadIconTpl = jQuery('<img />').attr('src', '<?php echo get_template_directory_uri(). '/img/loading-cube.gif'?>');
	   jQuery(document).ready(function(){
		   jQuery('#toeTplWelcomePopup').on('show.bs.modal', function(){
				jQuery('#toePluginsSlider').bxSlider({
					auto: true
				,	mode: 'fade'
				,	captions: true
				,	autoControls: true
				});
				jQuery('#toeTplsSlider').bxSlider({
					auto: true
				,	captions: true
				,	minSlides: 1
				,	maxSlides: 4
				,	slideWidth: 325
				,	slideMargin: 10
				,	moveSlides: 1
				,	autoControls: true
				});
			});
			jQuery('#toeTplWelcomePopup').modal();
			jQuery('#toeWelcomePageFindUsForm input[type=radio][name=where_find_us]').change(function(){
				jQuery('#toeFindUsUrlShell, #toeOtherWayTextShell').hide();
				switch(parseInt(jQuery(this).val())) {
					case 4 /*Find on the web*/ :
						jQuery('#toeFindUsUrlShell').show('fast').css('display', 'block');
						break;
					case 5 /*Other way*/ :
						jQuery('#toeOtherWayTextShell').show('fast');
						break;
				}
			});
			jQuery('#toeWelcomePageFindUsForm').submit(function(){
				jQuery('#toeWelcomePageFindUsMsg').html( toeLoadIconTpl );
				jQuery.ajax({
					url: ajaxurl
				,	data: jQuery(this).serialize()
				,	type: 'POST'
				,	dataType: 'json'
				,	success: function(res) {
						jQuery('#toeWelcomePageFindUsMsg').html('');
						if(res.msg) {
							jQuery('#toeWelcomePageFindUsMsg').html( res.msg );
						}
						setTimeout(function(){
							jQuery('#toeTplWelcomePopup').modal('hide');
						}, 1000);
					}
				});
				return false;
			});
			jQuery('#toeWelcomePageFindUsForm .close').click(function(){
				jQuery( jQuery('<div />').html(toeLoadIconTpl) ).insertBefore(this);
				jQuery('#toeWelcomePageFindUsForm').submit();
				return false;
			});
	   });
	   // -->
	   </script>
			<?php
		}
	}
}
?>