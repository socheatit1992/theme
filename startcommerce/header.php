<?php 
    if(!class_exists('frame')) { 
        global $current_user;
        get_currentuserinfo(); 
        if ( is_user_logged_in() and current_user_can('manage_options')){
            require_once (TEMPLATEPATH . '/functions/placeholder/admin-placeholder-page.php'); 
            exit(); 
        } else {
            require_once (TEMPLATEPATH . '/functions/placeholder/user-placeholder-page.php'); 
            exit(); 
        }
    } 
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
 <head>
   <title><?php bloginfo('name'); ?> <?php wp_title(); ?></title>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width" />
   
   <!-- Foundation including -->
   <link rel="stylesheet" type="text/css" href="<?php echo bloginfo('template_directory').'/functions/foundation/css/app.css'; ?>" media="screen" />
   <link rel="stylesheet" type="text/css" href="<?php echo bloginfo('template_directory').'/functions/foundation/css/foundation.css'; ?>" media="screen" />
   <link rel="stylesheet" type="text/css" href="<?php echo bloginfo('template_directory').'/functions/css/flexslider.css'; ?>" media="screen" />
   
   <script type="text/javascript" src="<?php echo bloginfo('template_directory').'/functions/foundation/js/foundation.min.js'; ?>"></script>
   <script type="text/javascript" src="<?php echo bloginfo('template_directory').'/functions/foundation/js/jquery.foundation.accordion.js'; ?>"></script>
   <script type="text/javascript" src="<?php echo bloginfo('template_directory').'/functions/foundation/js/jquery.foundation.navigation.js'; ?>"></script>
   <script type="text/javascript" src="<?php echo bloginfo('template_directory').'/functions/foundation/js/modernizr.foundation.js'; ?>"></script>
   <script type="text/javascript" src="<?php echo bloginfo('template_directory').'/functions/foundation/js/app.js'; ?>"></script>
   <!-- End Foundation including -->   
   
   <script type="text/javascript" src="<?php echo bloginfo('template_directory').'/js/jquery.easing.1.3.js'; ?>"></script>
   <script type="text/javascript" src="<?php echo bloginfo('template_directory').'/js/jquery.flexslider-min.js'; ?>"></script>
   <script type="text/javascript" src="<?php echo bloginfo('template_directory').'/js/jquery.autocolumnlist.js'; ?>"></script>
   <script type="text/javascript" src="<?php echo bloginfo('template_directory').'/js/jquery.validate.js'; ?>"></script>
   <script type="text/javascript" src="<?php echo bloginfo('template_directory').'/js/jquery.cookie.js'; ?>"></script>
   <?php if(get_option('scom_live_settings') == 'on'): ?>
       <script type="text/javascript" src="<?php echo bloginfo('template_directory').'/functions/livesettings/js/colorpicker.js'; ?>"></script>
       <script type="text/javascript" src="<?php echo bloginfo('template_directory').'/functions/livesettings/js/eye.js'; ?>"></script>
       <script type="text/javascript" src="<?php echo bloginfo('template_directory').'/functions/livesettings/js/utils.js'; ?>"></script>
   <?php endif; ?>
   <script type="text/javascript" src="<?php echo bloginfo('template_directory').'/js/theme.js'; ?>"></script>
   
   <!-- IE Fix -->
   <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
   <![endif]-->
   
   <link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" media="screen" />
   
   <link rel="icon" href="<?php echo bloginfo('template_directory').'/favicon.ico'; ?>" type="image/x-icon">
   <link rel="shortcut icon" href="<?php echo bloginfo('template_directory').'/favicon.ico'; ?>" type="image/x-icon">
   
   <?php wp_head(); ?>
   
   <?php if (get_option('scom_google_font_name') != '') { ?>
        <link id="gFontName-css" rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=<?php echo get_option('scom_google_font_name'); ?>&subset=latin,cyrillic-ext" />
    <?php } else { ?>
        <link id="gFontName" href='http://fonts.googleapis.com/css?family=Ubuntu:500italic&amp;subset=latin,cyrillic-ext' rel='stylesheet' type='text/css'>
   <?php } ?>
   
   <style type="text/css">
    <?php 
    if (get_option('scom_google_font_name') != '') { ?>
       h1, h2, h3, .special_font, .slider-text h2, #shop-name, .info-block em, .text-left { font-family: <?php echo get_option('scom_google_font_name'); ?>;}
    <?php } ?>
    
    <?php if (get_option('scom_content_font_name') != '') { ?>
       body {font-family: <?php echo get_option('scom_content_font_name'); ?>;}
    <?php } ?>
    
    <?php if (get_option('scom_bgimg') != '') { ?>
       body {<?php echo get_option('scom_bgimg'); ?>}
    <?php } ?>
    
    <?php if (get_option('scom_bgcol') != '') { ?>
       body {background-color:<?php echo get_option('scom_bgcol'); ?> !important;}
    <?php } ?>
    
    #startslider {
        <?php $data = get_option(OPTIONS); ?>
        width:<?php if($data['width'] != '') {echo $data['width']*1 - 30;} else {echo '835';}?>px !important;
        height:<?php if($data['height'] != '') {echo $data['height']*1 - 30;} else {echo '400';}?>px !important;
    }
    </style>
   <?php echo get_option('scom_gcode'); ?>
 </head>
 <body class="frontend">
	<div id="container" class="row">
        <?php 
            if (utils::isMobile() == false) {
                if(get_option('scom_live_settings') == 'on') require_once (TEMPLATEPATH . '/functions/livesettings/live-block.php');
            }
        ?>
        <div id="header" class="row">
            <div id="corner"></div>
            <div id="logo" class="eight columns">
                <?php if (get_option('scom_only_text') != 'on'): ?>
                    <a href="<?php bloginfo('url'); ?>">
                        <?php 
                            if (get_option('scom_site_logo') != '') {
                                $src = get_option('scom_site_logo');
                            } else {
                                $src = get_bloginfo('template_directory').'/img/logo.png';
                            }
                            
                            $alt = 'alt="'.get_bloginfo('name').' - '.get_bloginfo('description').'"';                         
                        ?>
                        <img id="logo-img" src="<?php echo $src; ?>" <?php echo $alt; ?> />
                    </a>
                <?php else: ?>
                    <style type="text/css">
                        #shop-name {padding-left:0;}
                    </style>
                <?php endif; ?>
                
                <?php if (get_option('scom_only_image') != 'on'): ?>
                    <h1 id="shop-name"><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
                    <p id="shop-desc"><?php bloginfo('description'); ?></p>
                <?php endif; ?>
                
                <div id="shop-services">
                    <?php if ( frame::_()->getModule('pages_editor')->isActiveSidebar( 'cart' ) ) : ?>
                        <?php frame::_()->getModule('pages_editor')->dynamicSidebar( 'cart' ); ?>
                    <?php endif; ?>
                </div>
            </div><!-- End Logo -->
            
            <div id="shop-controls">
                <?php if ( frame::_()->getModule('pages_editor')->isActiveSidebar( 'currency' ) ) : ?>
                    <div id="currency-list">
                        <?php frame::_()->getModule('pages_editor')->dynamicSidebar( 'currency' ); ?>
                    </div>
                <?php endif; ?>
                <div id="search">
                    <form method="get" id="searchform" action="<?php bloginfo('url'); ?>">
                        <input type="text" value="" name="s" id="s" placeholder="<?php echo lang::_e('Search here'); ?>" />
                        <input type="submit" id="searchsubmit" value="" />
                    </form>
                </div>
                
                <div id="user" class="logged">
                    <?php global $current_user;
                          get_currentuserinfo(); 
                          if ( is_user_logged_in() ) :
                    ?>
                    <p><?php echo lang::_e('Welcome'); ?> <a href="<?php echo frame::_()->getModule('pages')->getLink(array('mod' => 'user', 'action' => 'getProfileHtml'))?>"><?php echo $current_user->user_login; ?></a>! <a href="<?php echo wp_logout_url( home_url() ); ?>" class="signout"><?php echo lang::_e('Sign out'); ?></a></p>
                    <?php else : ?>
                    <p><?php echo lang::_e('Welcome, visitor! You can'); ?> <a href="<?php echo frame::_()->getModule('pages')->getLink(array('mod' => 'user', 'action' => 'getLoginForm'))?>" id="loginFormPopup"><?php echo lang::_e('sign in'); ?></a> <?php echo lang::_e('or'); ?> <a href="<?php echo frame::_()->getModule('pages')->getLink(array('mod' => 'user', 'action' => 'getRegisterForm'))?>" class="signout"><?php echo lang::_e('register'); ?></a>.</p>                  
                    <?php endif; ?>
                </div>
                <div class="clear"></div>
			</div>
            <div class="clear"></div>
        </div><!-- End Header -->
        
        <div class="clear"></div>
        <div id="main-menu">
            <?php wp_nav_menu( array( 'theme_location' => 'main', 'container' => '', 'container_id' => '', 'fallback_cb' => 'wp_page_menu', 'menu_class' => '' ) ); ?>
        </div>
		<?php /*Mobile menu is not working as it should - show usual menu for all cases*/ ?>
        <?php //wp_nav_menu( array( 'theme_location' => 'main', 'walker' => new Walker_Nav_Menu_Dropdown(), 'items_wrap' => '<select class="mobile-menu"><option>'.lang::_('Select a page').'</option>%3$s</select>' ));?>
        <div class="clear"></div>