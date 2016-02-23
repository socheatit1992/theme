<!DOCTYPE html>
<html>
    <head>
        <title><?php bloginfo('name'); ?> <?php wp_title(); ?></title>
        <link rel="stylesheet" href="<?php echo bloginfo('template_directory').'/functions/placeholder/user-placeholder.css'; ?>" />
    
        <?php if (get_option('scom_google_font_name') != '') { ?>
        <link id="gFontName-css" rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=<?php echo get_option('scom_google_font_name'); ?>&subset=latin,cyrillic-ext" />
        <?php } else { ?>
            <link id="gFontName" href='http://fonts.googleapis.com/css?family=Ubuntu:500italic&subset=latin,cyrillic-ext' rel='stylesheet' type='text/css'>
        <?php } ?>
       
        <style type="text/css">
        <?php 
        if (get_option('scom_google_font_name') != '') { ?>
           h1 { font-family: <?php echo get_option('scom_google_font_name'); ?>;}
        <?php } ?>
        </style>
    </head>
    <body>
        <div id="container">
            <div id="social">
                <?php if (get_option('scom_twitter') <> '') : ?>
                    <a href="http://twitter.com/<?php echo get_option('scom_twitter'); ?>" target="_blank"><img src="<?php echo bloginfo('template_directory').'/functions/placeholder/img/twitter.png'; ?>" alt="" /></a>
                    <?php endif; ?>
                    <?php if (get_option('scom_facebook') <> '') : ?>
                    <a href="<?php echo get_option('scom_facebook'); ?>" target="_blank"><img src="<?php echo bloginfo('template_directory').'/functions/placeholder/img/facebook.png'; ?>" alt="" /></a>
                    <?php endif; ?>
                    <?php if (get_option('scom_gplus') <> '') : ?>
                    <a href="<?php echo get_option('scom_gplus'); ?>" target="_blank"><img src="<?php echo bloginfo('template_directory').'/functions/placeholder/img/google.png'; ?>" alt="" /></a>
                    <?php endif; ?>
            </div>
        </div>
    </body>
</html>