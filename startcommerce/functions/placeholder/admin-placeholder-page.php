<!DOCTYPE html>
<html>
    <head>
        <title><?php bloginfo('name'); ?> <?php wp_title(); ?></title>
        <link rel="stylesheet" href="<?php echo bloginfo('template_directory').'/functions/placeholder/admin-placeholder.css'; ?>" />
        <link rel="stylesheet" href="<?php echo bloginfo('template_directory').'/functions/placeholder/accordeon.css'; ?>" />
        
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo bloginfo('template_directory').'/functions/placeholder/js/jquery-ui-1.8.18.custom.min.js'; ?>"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                // Accordion
                $("#maq").accordion({ header: "h3", autoHeight: true  });
                
                $('a').each(function(){
                    $(this).attr('target', '_blank');
                });
            });
        </script>
    </head>
    <body>
        <div id="container" class="index-page">
		<div id="header-wrapper">    
			<div id="header">
				<div id="logo">
                    <a href="<?php bloginfo('url'); ?>">
                        <span id="logo-part1">Ready!</span>
                        <span id="logo-part2">Ecommerce Wordpress</span>
                        <span id="logo-part3">plugin</span>
                        <img src="<?php echo bloginfo('template_directory').'/functions/placeholder/img/logo.png'; ?>" alt="" />
                    </a>
                </div>

				<div style="clear:both;"></div>
				
				<ul id="main-menu">
					<li><a href="http://readyshoppingcart.com/"">Home</a></li>
					<li><a href="http://readyshoppingcart.com/extensions/">Extension</a></li>
                    <li><a href="http://readyshoppingcart.com/products_categories/templates/">E-commerce Themes</a></li>
					<li><a href="http://readyshoppingcart.com/download/">Download</a></li>
					<li><a href="http://readyshoppingcart.com/contacts/">Contacts</a></li>
				</ul>
				<div style="clear:both;"></div>
				
			</div><!-- End header -->
			<div style="clear:both;"></div>
		</div>

        <div id="content-wrapper">
            <div id="content">
                
                <div id="maq">
                    <h2>Sorry, we can't display your site for several reasons</h2>
                    <div>
                        <h3><a href="#">You have the Ready! E-commerce Wordpress plugin, but you can not activate it</a></h3>
                        <div><p>Don't worry, that everything works, you just need to activate the Ready! E-commerce Wordpress plugin on this page <a href="<?php bloginfo('url'); ?>/wp-admin/plugins.php">Admin page -> Plugins</a></p></div>
                    </div>
                    <div>
                        <h3><a href="#">You don't have the Ready! E-commerce Wordpress plugin</a></h3>
                        <div>
                            <h4>Select one of the most suitable options for you:</h4>
                            <p><img src="<?php echo bloginfo('template_directory').'/functions/placeholder/img/more-li.png'; ?>" /> You can download a free version of the Ready! E-commerce Wordpress plugin <a href="http://wordpress.org/extend/plugins/ready-ecommerce/">here</a> or on our <a href="http://readyshoppingcart.com/download/">website</a>.</p>
                            <p><img src="<?php echo bloginfo('template_directory').'/functions/placeholder/img/more-li.png'; ?>" />  If you need a licensed version of the plug-in and add-on modules that will enable your online business more effectively - click on <a href="http://readyshoppingcart.com/extensions/">this link</a> and choose all that you need.</p>
                        </div>
                    </div>
                </div>
                
                <div style="clear:both;"></div>    
                
            </div><!-- End content -->
        </div>
    </div><!-- End Container -->
    </body>
</html>