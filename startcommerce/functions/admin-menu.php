<?php

function AdminLiveInit() {
// Live Settings Script for admin
wp_register_script( 'admin-live-tabs', get_template_directory_uri() . '/functions/js/tabs.js');
wp_enqueue_script(  'admin-live-tabs' );

wp_register_script( 'admin-live-script', get_template_directory_uri() . '/functions/js/admin-js.js');
wp_enqueue_script(  'admin-live-script' );

wp_enqueue_script('media-upload');
wp_enqueue_script('thickbox');
wp_enqueue_script('site-logo', get_template_directory_uri().'/functions/js/siteLogo.js');
}
if ($_REQUEST['page'] == 'theme_settings'){
    add_action('admin_footer', 'AdminLiveInit');
}

add_action('admin_menu', 'scom_create_menu');

function scom_create_menu() {
    $path = get_bloginfo('template_directory').'/';
    add_menu_page('StartCommerce Theme Settings', 'StartCommerce Settings', 'administrator', 'theme_settings', 'scom_settings_page', $path.'img/theme.png');
	if(class_exists('frame') && frame::_()->getModule('pages_editor')) {
		frame::_()->getModule('pages_editor')->addLicensedThemeMenu(array('file' => 'theme_settings'));
	}
    add_action( 'admin_init', 'register_mysettings' );
}

function register_mysettings() {
    // Page options
    register_setting( 'scom-settings-group', 'scom_gmap_html' );
    register_setting( 'scom-settings-group', 'scom_gcode' );
    
    // Footer options
    register_setting( 'scom-settings-group', 'scom_footer' );
    register_setting( 'scom-settings-group', 'scom_twitter' );
    register_setting( 'scom-settings-group', 'scom_facebook' );
    register_setting( 'scom-settings-group', 'scom_gplus' );
    
    // Design options
    register_setting( 'scom-settings-group', 'scom_site_logo' );
    register_setting( 'scom-settings-group', 'scom_only_image' );
    register_setting( 'scom-settings-group', 'scom_only_text' );
    register_setting( 'scom-settings-group', 'scom_bgimg' );
    register_setting( 'scom-settings-group', 'scom_bgcol' );
    register_setting( 'scom-settings-group', 'scom_google_font_name' );
    register_setting( 'scom-settings-group', 'scom_content_font_name' );	
    register_setting( 'scom-settings-group', 'scom_live_settings' );	
}

function scom_settings_page() {
?>

<h2><?php lang::_e('StartCommerce Theme Settings'); ?></h2>
<div class="rm_wrap">
    <form method="post" action="options.php" class="rm_opts">

    <?php settings_fields('scom-settings-group'); ?>
    <div id="rm_tabs">
        <ul>
            <li><a href="#rm_pages"><?php lang::_e('Pages Options'); ?></a></li>
            <li><a href="#rm_footer"><?php lang::_e('Footer and Social Options'); ?></a></li>
            <li><a href="#rm_design"><?php lang::_e('Design Options'); ?></a></li>
        </ul>
        
        <div id="rm_pages">
            <h3><?php lang::_e('Contact Page Settings'); ?></h3>
            <div class="rm_input rm_text">
                <label for="scom_gmap_html"><?php lang::_e('Google Maps HTML Code'); ?></label>
                <textarea name="scom_gmap_html" id="scom_gmap_html" style="height:120px;">
                <?php echo esc_attr(get_option('scom_gmap_html')); ?>
                </textarea>
                <small><?php lang::_e('Paste here HTML map code here. <br /> Set frame Width to 436px, Height - as you wish.'); ?></small><div class="clearfix"></div>
            </div>
            
            <h3><?php lang::_e('Google Analitics'); ?></h3>
            <div class="rm_input rm_text">
                <label for="scom_gcode"><?php lang::_e('Google Analitics Code'); ?></label>
                <textarea name="scom_gcode" id="scom_gcode" style="height:120px;">
                <?php echo esc_attr(get_option('scom_gcode')); ?>
                </textarea>
                <small><?php lang::_e('Would be placed in header.'); ?></small><div class="clearfix"></div>
            </div>
        </div>
        <div id="rm_footer">
            <div class="rm_input rm_text">
                <label for="scom_footer"><?php lang::_e('Footer Copyright Text'); ?></label>
                <input name="scom_footer" id="scom_footer" type="text" value="<?php echo esc_attr(get_option('scom_footer')); ?>" />
                <small><?php lang::_e('Copyright text in the site footer.'); ?></small><div class="clearfix"></div>
            </div>

            <div class="rm_input rm_text">
                <label for="scom_twitter"><?php lang::_e('Your Twitter name'); ?></label>
                <input name="scom_twitter" id="scom_twitter" type="text" value="<?php echo esc_attr(get_option('scom_twitter')); ?>" />
                <small><?php lang::_e('Enter only your nickname.'); ?></small><div class="clearfix"></div>
            </div>

            <div class="rm_input rm_text">
                <label for="scom_facebook"><?php lang::_e('Your Facebook link'); ?></label>
                <input name="scom_facebook" id="scom_facebook" type="text" value="<?php echo esc_attr(get_option('scom_facebook')); ?>" />
                <small><?php lang::_e('Enter your facebook page link.'); ?></small><div class="clearfix"></div>
            </div>

            <div class="rm_input rm_text">
                <label for="scom_gplus"><?php lang::_e('Your Google plus link'); ?></label>
                <input name="scom_gplus" id="scom_gplus" type="text" value="<?php echo esc_attr(get_option('scom_gplus')); ?>" />
                <small><?php lang::_e('Enter your Google plus page link.'); ?></small><div class="clearfix"></div>
            </div>                                          
        </div>
        <div id="rm_design">
            <h2><?php lang::_e('Site logo'); ?></h2>
            <table class="form-table">
                <tr>
					<td>
                        <input id="site-logo" class="regular-text" type="hidden" name="scom_site_logo" value="<?php echo esc_attr(get_option('scom_site_logo')); ?>" />
                        <img id="image-logo" src="<?php echo esc_attr(get_option('scom_site_logo')); ?>" alt="<?php lang::_e('Site Logo')?>" /><br />
                        <input class="button" id="btn-upload-logo" type="button" value="<?php lang::_e('Select an image');?>" />
                        <input class="button" id="btn-delete-logo" type="button" value="<?php lang::_e('Delete image');?>" />
                        <p class="description"><?php lang::_e('You can upload PNG, JPG or GIF image');?></p>
                        
                        <div class="rm_input rm_checkbox">
                            <label for="scom_only_image"><?php lang::_e('Show only logo image'); ?></label>
                            <input name="scom_only_image" id="scom_only_image" type="checkbox" <?php if(get_option('scom_only_image') == 'on') echo "checked='checked'"; ?> />
                            <small><?php lang::_e('Show only image logo, without site name and description (SEO friendly).'); ?></small><div class="clearfix"></div>
                        </div>
                        
                        <div class="rm_input rm_checkbox">
                            <label for="scom_only_text"><?php lang::_e('Show only text logo'); ?></label>
                            <input name="scom_only_text" id="scom_only_text" type="checkbox" <?php if(get_option('scom_only_text') == 'on') echo "checked='checked'"; ?> />
                            <small><?php lang::_e('Show only text logo, without image logo.'); ?></small><div class="clearfix"></div>
                        </div>
                    </td>
				</tr>
            </table>
            
            <h2><?php lang::_e('Background Style'); ?></h2>
            <div class="left-bar">
                <h4><?php lang::_e('Images'); ?></h4>
                <a class="body-change" title="Click to preview" href="<?php echo bloginfo('template_directory').'/functions/livesettings/img/1.jpg'; ?>">
                    <img src="<?php echo bloginfo('template_directory').'/functions/livesettings/img/thumbs/1.png'; ?>" />
                </a>
                <a class="body-change" title="Click to preview" href="<?php echo bloginfo('template_directory').'/functions/livesettings/img/2.jpg'; ?>">
                    <img src="<?php echo bloginfo('template_directory').'/functions/livesettings/img/thumbs/2.png'; ?>" />
                </a>
                <a class="body-change" title="Click to preview" href="<?php echo bloginfo('template_directory').'/functions/livesettings/img/3.jpg'; ?>">
                    <img src="<?php echo bloginfo('template_directory').'/functions/livesettings/img/thumbs/3.png'; ?>" />
                </a>
                <a class="body-change" title="Click to preview" href="<?php echo bloginfo('template_directory').'/functions/livesettings/img/4.jpg'; ?>">
                    <img src="<?php echo bloginfo('template_directory').'/functions/livesettings/img/thumbs/4.png'; ?>" />
                </a>
                <a class="body-change" title="Click to preview" href="<?php echo bloginfo('template_directory').'/functions/livesettings/img/5.jpg'; ?>">
                    <img src="<?php echo bloginfo('template_directory').'/functions/livesettings/img/thumbs/5.png'; ?>" />
                </a>
                <a class="body-change" title="Click to preview" href="<?php echo bloginfo('template_directory').'/functions/livesettings/img/6.jpg'; ?>">
                    <img src="<?php echo bloginfo('template_directory').'/functions/livesettings/img/thumbs/6.png'; ?>" />
                </a>
                <a class="body-change" title="Click to preview" href="<?php echo bloginfo('template_directory').'/functions/livesettings/img/7.jpg'; ?>">
                    <img src="<?php echo bloginfo('template_directory').'/functions/livesettings/img/thumbs/7.png'; ?>" />
                </a>
                <a class="body-change" title="Click to preview" href="<?php echo bloginfo('template_directory').'/functions/livesettings/img/8.jpg'; ?>">
                    <img src="<?php echo bloginfo('template_directory').'/functions/livesettings/img/thumbs/8.png'; ?>" />
                </a>
                <a class="body-change" title="Click to preview" href="<?php echo bloginfo('template_directory').'/functions/livesettings/img/9.jpg'; ?>">
                    <img src="<?php echo bloginfo('template_directory').'/functions/livesettings/img/thumbs/9.png'; ?>" />
                </a>
                <a class="body-change" title="Click to preview" href="<?php echo bloginfo('template_directory').'/functions/livesettings/img/10.jpg'; ?>">
                    <img src="<?php echo bloginfo('template_directory').'/functions/livesettings/img/thumbs/10.png'; ?>" />
                </a>
                <a class="body-change" title="Click to preview" href="<?php echo bloginfo('template_directory').'/functions/livesettings/img/11.jpg'; ?>">
                    <img src="<?php echo bloginfo('template_directory').'/functions/livesettings/img/thumbs/11.png'; ?>" />
                </a>
                <a class="body-change" title="Click to preview" href="<?php echo bloginfo('template_directory').'/functions/livesettings/img/12.jpg'; ?>">
                    <img src="<?php echo bloginfo('template_directory').'/functions/livesettings/img/thumbs/12.png'; ?>" />
                </a>
                <a class="body-change" title="Click to preview" href="<?php echo bloginfo('template_directory').'/functions/livesettings/img/13.jpg'; ?>">
                    <img src="<?php echo bloginfo('template_directory').'/functions/livesettings/img/thumbs/13.png'; ?>" />
                </a>
                <a class="body-change" title="Click to preview" href="<?php echo bloginfo('template_directory').'/functions/livesettings/img/14.jpg'; ?>">
                    <img src="<?php echo bloginfo('template_directory').'/functions/livesettings/img/thumbs/14.png'; ?>" />
                </a>
                <a class="body-change" title="Click to preview" href="<?php echo bloginfo('template_directory').'/functions/livesettings/img/15.jpg'; ?>">
                    <img src="<?php echo bloginfo('template_directory').'/functions/livesettings/img/thumbs/15.png'; ?>" />
                </a>
                <a class="body-change" title="Click to preview" href="<?php echo bloginfo('template_directory').'/functions/livesettings/img/16.jpg'; ?>">
                    <img src="<?php echo bloginfo('template_directory').'/functions/livesettings/img/thumbs/16.png'; ?>" />
                </a>
                <a class="body-change" title="Click to preview" href="<?php echo bloginfo('template_directory').'/functions/livesettings/img/17.jpg'; ?>">
                    <img src="<?php echo bloginfo('template_directory').'/functions/livesettings/img/thumbs/17.png'; ?>" />
                </a>
                <a class="body-change" title="Click to preview" href="<?php echo bloginfo('template_directory').'/functions/livesettings/img/18.jpg'; ?>">
                    <img src="<?php echo bloginfo('template_directory').'/functions/livesettings/img/thumbs/18.png'; ?>" />
                </a>
                <a class="body-change" title="Click to preview" href="<?php echo bloginfo('template_directory').'/functions/livesettings/img/19.jpg'; ?>">
                    <img src="<?php echo bloginfo('template_directory').'/functions/livesettings/img/thumbs/19.png'; ?>" />
                </a>
                <a class="body-change" title="Click to preview" href="<?php echo bloginfo('template_directory').'/functions/livesettings/img/20.jpg'; ?>">
                    <img src="<?php echo bloginfo('template_directory').'/functions/livesettings/img/thumbs/20.png'; ?>" />
                </a>
                <div class="clear"></div>
                
                <h4><?php lang::_e('Patterns'); ?></h4>
                <a class="body-change" title="Click to preview" href="<?php echo bloginfo('template_directory').'/functions/livesettings/img/patterns/1.png'; ?>">
                    <img src="<?php echo bloginfo('template_directory').'/functions/livesettings/img/patterns/thumbs/1.png'; ?>" />
                </a>
                <a class="body-change" title="Click to preview" href="<?php echo bloginfo('template_directory').'/functions/livesettings/img/patterns/2.png'; ?>">
                    <img src="<?php echo bloginfo('template_directory').'/functions/livesettings/img/patterns/thumbs/2.png'; ?>" />
                </a>
                <a class="body-change" title="Click to preview" href="<?php echo bloginfo('template_directory').'/functions/livesettings/img/patterns/3.png'; ?>">
                    <img src="<?php echo bloginfo('template_directory').'/functions/livesettings/img/patterns/thumbs/3.png'; ?>" />
                </a>
                <a class="body-change" title="Click to preview" href="<?php echo bloginfo('template_directory').'/functions/livesettings/img/patterns/4.png'; ?>">
                    <img src="<?php echo bloginfo('template_directory').'/functions/livesettings/img/patterns/thumbs/4.png'; ?>" />
                </a>
                <a class="body-change" title="Click to preview" href="<?php echo bloginfo('template_directory').'/functions/livesettings/img/patterns/5.png'; ?>">
                    <img src="<?php echo bloginfo('template_directory').'/functions/livesettings/img/patterns/thumbs/5.png'; ?>" />
                </a>
                <a class="body-change" title="Click to preview" href="<?php echo bloginfo('template_directory').'/functions/livesettings/img/patterns/6.png'; ?>">
                    <img src="<?php echo bloginfo('template_directory').'/functions/livesettings/img/patterns/thumbs/6.png'; ?>" />
                </a>
                <a class="body-change" title="Click to preview" href="<?php echo bloginfo('template_directory').'/functions/livesettings/img/patterns/7.png'; ?>">
                    <img src="<?php echo bloginfo('template_directory').'/functions/livesettings/img/patterns/thumbs/7.png'; ?>" />
                </a>
                <a class="body-change" title="Click to preview" href="<?php echo bloginfo('template_directory').'/functions/livesettings/img/patterns/8.png'; ?>">
                    <img src="<?php echo bloginfo('template_directory').'/functions/livesettings/img/patterns/thumbs/8.png'; ?>" />
                </a>
                <a class="body-change" title="Click to preview" href="<?php echo bloginfo('template_directory').'/functions/livesettings/img/patterns/9.png'; ?>">
                    <img src="<?php echo bloginfo('template_directory').'/functions/livesettings/img/patterns/thumbs/9.png'; ?>" />
                </a>
                <a class="body-change" title="Click to preview" href="<?php echo bloginfo('template_directory').'/functions/livesettings/img/patterns/10.png'; ?>">
                    <img src="<?php echo bloginfo('template_directory').'/functions/livesettings/img/patterns/thumbs/10.png'; ?>" />
                </a>
                <a class="body-change" title="Click to preview" href="<?php echo bloginfo('template_directory').'/functions/livesettings/img/patterns/11.png'; ?>">
                    <img src="<?php echo bloginfo('template_directory').'/functions/livesettings/img/patterns/thumbs/11.png'; ?>" />
                </a>
                <a class="body-change" title="Click to preview" href="<?php echo bloginfo('template_directory').'/functions/livesettings/img/patterns/12.png'; ?>">
                    <img src="<?php echo bloginfo('template_directory').'/functions/livesettings/img/patterns/thumbs/12.png'; ?>" />
                </a>
                <div class="clear"></div>
                <h4 style="margin-top:28px;"><?php lang::_e('Custom Background Color'); ?></h4>
                <input type="text" name="" id="live-colorpicker" class="colorpicker" value="" />
                
            </div>
            <div class="right-bar">
                <h4><?php lang::_e('Preview Area'); ?></h4>
                <div id="live-prev">
                    <div id="site-place"></div>
                </div>
                <a href="#" id="choose-this" class="button-primary"><?php lang::_e('Set it to background'); ?></a>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
            <hr style="margin-top:25px;" />
            <h2><?php lang::_e('Font Style'); ?></h2>
            <div class="left-bar">
                <h4><?php lang::_e('Headings - Google Font'); ?></h4>
                <select name="hfont" id="hfont">
                    <?php $GoogleFontsArray = Array ("Abel", "Abril Fatface", "Aclonica", "Acme", "Actor", "Adamina", "Advent Pro",
                        "Aguafina Script", "Aladin", "Aldrich", "Alegreya", "Alegreya SC", "Alex Brush", "Alfa Slab One", "Alice",
                        "Alike", "Alike Angular", "Allan", "Allerta", "Allerta Stencil", "Allura", "Almendra", "Almendra SC", "Amaranth",
                        "Amatic SC", "Amethysta", "Andada", "Andika", "Angkor", "Annie Use Your Telescope", "Anonymous Pro", "Antic",
                        "Antic Didone", "Antic Slab", "Anton", "Arapey", "Arbutus", "Architects Daughter", "Arimo", "Arizonia", "Armata",
                        "Artifika", "Arvo", "Asap", "Asset", "Astloch", "Asul", "Atomic Age", "Aubrey", "Audiowide", "Average",
                        "Averia Gruesa Libre", "Averia Libre", "Averia Sans Libre", "Averia Serif Libre", "Bad Script", "Balthazar",
                        "Bangers", "Basic", "Battambang", "Baumans", "Bayon", "Belgrano", "Belleza", "Bentham", "Berkshire Swash",
                        "Bevan", "Bigshot One", "Bilbo", "Bilbo Swash Caps", "Bitter", "Black Ops One", "Bokor", "Bonbon", "Boogaloo",
                        "Bowlby One", "Bowlby One SC", "Brawler", "Bree Serif", "Bubblegum Sans", "Buda", "Buenard", "Butcherman",
                        "Butterfly Kids", "Cabin", "Cabin Condensed", "Cabin Sketch", "Caesar Dressing", "Cagliostro", "Calligraffitti",
                        "Cambo", "Candal", "Cantarell", "Cantata One", "Cardo", "Carme", "Carter One", "Caudex", "Cedarville Cursive",
                        "Ceviche One", "Changa One", "Chango", "Chau Philomene One", "Chelsea Market", "Chenla", "Cherry Cream Soda",
                        "Chewy", "Chicle", "Chivo", "Coda", "Coda Caption", "Codystar", "Comfortaa", "Coming Soon", "Concert One",
                        "Condiment", "Content", "Contrail One", "Convergence", "Cookie", "Copse", "Corben", "Cousine", "Coustard",
                        "Covered By Your Grace", "Crafty Girls", "Creepster", "Crete Round", "Crimson Text", "Crushed", "Cuprum", "Cutive",
                        "Damion", "Dancing Script", "Dangrek", "Dawning of a New Day", "Days One", "Delius", "Delius Swash Caps", 
                        "Delius Unicase", "Della Respira", "Devonshire", "Didact Gothic", "Diplomata", "Diplomata SC", "Doppio One", 
                        "Dorsa", "Dosis", "Dr Sugiyama", "Droid Sans", "Droid Sans Mono", "Droid Serif", "Duru Sans", "Dynalight",
                        "EB Garamond", "Eater", "Economica", "Electrolize", "Emblema One", "Emilys Candy", "Engagement", "Enriqueta",
                        "Erica One", "Esteban", "Euphoria Script", "Ewert", "Exo", "Expletus Sans", "Fanwood Text", "Fascinate", "Fascinate Inline",
                        "Federant", "Federo", "Felipa", "Fjord One", "Flamenco", "Flavors", "Fondamento", "Fontdiner Swanky", "Forum",
                        "Francois One", "Fredericka the Great", "Fredoka One", "Freehand", "Fresca", "Frijole", "Fugaz One", "GFS Didot",
                        "GFS Neohellenic", "Galdeano", "Gentium Basic", "Gentium Book Basic", "Geo", "Geostar", "Geostar Fill", "Germania One",
                        "Give You Glory", "Glass Antiqua", "Glegoo", "Gloria Hallelujah", "Goblin One", "Gochi Hand", "Gorditas",
                        "Goudy Bookletter 1911", "Graduate", "Gravitas One", "Great Vibes", "Gruppo", "Gudea", "Habibi", "Hammersmith One",
                        "Handlee", "Hanuman", "Happy Monkey", "Henny Penny", "Herr Von Muellerhoff", "Holtwood One SC", "Homemade Apple",
                        "Homenaje", "IM Fell DW Pica", "IM Fell DW Pica SC", "IM Fell Double Pica", "IM Fell Double Pica SC",
                        "IM Fell English", "IM Fell English SC", "IM Fell French Canon", "IM Fell French Canon SC", "IM Fell Great Primer",
                        "IM Fell Great Primer SC", "Iceberg", "Iceland", "Imprima", "Inconsolata", "Inder", "Indie Flower", "Inika",
                        "Irish Grover", "Istok Web", "Italiana", "Italianno", "Jim Nightshade", "Jockey One", "Jolly Lodger", "Josefin Sans",
                        "Josefin Slab", "Judson", "Julee", "Junge", "Jura", "Just Another Hand", "Just Me Again Down Here", "Kameron",
                        "Karla", "Kaushan Script", "Kelly Slab", "Kenia", "Khmer", "Knewave", "Kotta One", "Koulen", "Kranky", "Kreon",
                        "Kristi", "Krona One", "La Belle Aurore", "Lancelot", "Lato", "League Script", "Leckerli One", "Ledger", "Lekton",
                        "Lemon", "Lilita One", "Limelight", "Linden Hill", "Lobster", "Lobster Two", "Londrina Outline", "Londrina Shadow",
                        "Londrina Sketch", "Londrina Solid", "Lora", "Love Ya Like A Sister", "Loved by the King", "Lovers Quarrel",
                        "Luckiest Guy", "Lusitana", "Lustria", "Macondo", "Macondo Swash Caps", "Magra", "Maiden Orange", "Mako", "Marck Script",
                        "Marko One", "Marmelad", "Marvel", "Mate", "Mate SC", "Maven Pro", "Meddon", "MedievalSharp", "Medula One", "Merriweather",
                        "Metal", "Metamorphous", "Michroma", "Miltonian", "Miltonian Tattoo", "Miniver", "Miss Fajardose", "Modern Antiqua",
                        "Molengo", "Monofett", "Monoton", "Monsieur La Doulaise", "Montaga", "Montez", "Montserrat", "Moul", "Moulpali",
                        "Mountains of Christmas", "Mr Bedfort", "Mr Dafoe", "Mr De Haviland", "Mrs Saint Delafield", "Mrs Sheppards",
                        "Muli", "Mystery Quest", "Neucha", "Neuton", "News Cycle", "Niconne", "Nixie One", "Nobile", "Nokora", "Norican",
                        "Nosifer", "Nothing You Could Do", "Noticia Text", "Nova Cut", "Nova Flat", "Nova Mono", "Nova Oval", "Nova Round",
                        "Nova Script", "Nova Slim", "Nova Square", "Numans", "Nunito", "Odor Mean Chey", "Old Standard TT", "Oldenburg",
                        "Oleo Script", "Open Sans", "Open Sans Condensed", "Orbitron", "Original Surfer", "Oswald", "Over the Rainbow",
                        "Overlock", "Overlock SC", "Ovo", "Oxygen", "PT Mono", "PT Sans", "PT Sans Caption", "PT Sans Narrow", "PT Serif",
                        "PT Serif Caption", "Pacifico", "Parisienne", "Passero One", "Passion One", "Patrick Hand", "Patua One", "Paytone One",
                        "Permanent Marker", "Petrona", "Philosopher", "Piedra", "Pinyon Script", "Plaster", "Play", "Playball", "Playfair Display",
                        "Podkova", "Poiret One", "Poller One", "Poly", "Pompiere", "Pontano Sans", "Port Lligat Sans", "Port Lligat Slab",
                        "Prata", "Preahvihear", "Press Start 2P", "Princess Sofia", "Prociono", "Prosto One", "Puritan", "Quantico",
                        "Quattrocento", "Quattrocento Sans", "Questrial", "Quicksand", "Qwigley", "Radley", "Raleway", "Rammetto One",
                        "Rancho", "Rationale", "Redressed", "Reenie Beanie", "Revalia", "Ribeye", "Ribeye Marrow", "Righteous", "Rochester",
                        "Rock Salt", "Rokkitt", "Ropa Sans", "Rosario", "Rosarivo", "Rouge Script", "Ruda", "Ruge Boogie", "Ruluko",
                        "Ruslan Display", "Russo One", "Ruthie", "Sail", "Salsa", "Sancreek", "Sansita One", "Sarina", "Satisfy", "Schoolbell",
                        "Seaweed Script", "Sevillana", "Shadows Into Light", "Shadows Into Light Two", "Shanti", "Share", "Shojumaru",
                        "Short Stack", "Siemreap", "Sigmar One", "Signika", "Signika Negative", "Simonetta", "Sirin Stencil", "Six Caps",
                        "Slackey", "Smokum", "Smythe", "Sniglet", "Snippet", "Sofia", "Sonsie One", "Sorts Mill Goudy", "Special Elite",
                        "Spicy Rice", "Spinnaker", "Spirax", "Squada One", "Stardos Stencil", "Stint Ultra Condensed", "Stint Ultra Expanded",
                        "Stoke", "Sue Ellen Francisco", "Sunshiney", "Supermercado One", "Suwannaphum", "Swanky and Moo Moo", "Syncopate",
                        "Tangerine", "Taprom", "Telex", "Tenor Sans", "The Girl Next Door", "Tienne", "Tinos", "Titan One", "Trade Winds",
                        "Trocchi", "Trochut", "Trykker", "Tulpen One", "Ubuntu", "Ubuntu Condensed", "Ubuntu Mono", "Ultra", "Uncial Antiqua",
                        "UnifrakturCook", "UnifrakturMaguntia", "Unkempt", "Unlock", "Unna", "VT323", "Varela", "Varela Round", "Vast Shadow",
                        "Vibur", "Vidaloka", "Viga", "Voces", "Volkhov", "Vollkorn", "Voltaire", "Waiting for the Sunrise", "Wallpoet",
                        "Walter Turncoat", "Wellfleet", "Wire One", "Yanone Kaffeesatz", "Yellowtail", "Yeseva One", "Yesteryear", "Zeyada"
                    ); 
                    
                    foreach ($GoogleFontsArray as $font) {
                        if ($font == get_option('scom_google_font_name')) {$selected = ' selected="selected"';} else {$selected = '';}
                        echo '<option value="'.$font.'" '.$selected.'>'.$font.'</option>';
                    }
                    ?>
                </select>
                <br />
                <a href="#" id="head-save" class="button-primary"><?php lang::_e('Save new heading Font Style'); ?></a>
                
                <h4><?php lang::_e('Content font'); ?></h4>
                <select name="pfont" id="pfont">
                    <?php $ContentFontsArray = Array ("Arial, Helvetica, sans-serif", "'Arial Black', Gadget, sans-serif", "'Bookman Old Style', serif",
                        "'Calibri', sans-serif", "'Cambria', 'Times New Roman', serif", "'Century Gothic',verdana,arial,helvetica,sans-serif",
                        "'Comic Sans MS', cursive", "Courier, monospace", "Garamond, serif", "Georgia, serif", "Impact, Charcoal, sans-serif",
                        "'Lucida Console', Monaco, monospace", "'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
                        "'MS Sans Serif', Geneva, sans-serif", "'MS Serif', 'New York', sans-serif", "'Palatino Linotype', 'Book Antiqua', Palatino, serif",
                        "Symbol, sans-serif", "Tahoma, Geneva, sans-serif", "'Times New Roman', Times, serif", "'Trebuchet MS', Helvetica, sans-serif",
                        "Verdana, Geneva, sans-serif"
                        );
                        foreach ($ContentFontsArray as $font) {
                            if ($font == get_option('scom_content_font_name')) {$selected = ' selected="selected"';} else {$selected = '';}
                            echo '<option value="'.$font.'" '.$selected.'>'.$font.'</option>';
                        }
                    ?>
                </select>
                <br />
                <a href="#" id="cont-save" class="button-primary"><?php lang::_e('Save new content Font Style'); ?></a>
                <div class="clear"></div>
            </div>
            <div class="right-bar" style="height:auto;">
                <h4><?php lang::_e('Preview Area'); ?></h4>
                <div id="prev-head"><p>Sample Heading Text</p></div>
                <div id="prev-content"><p>Sample content text</p></div>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
            
            <div style="display:none;">
                <div class="left-bar">
                    background <input type="text" id="bg-img" /><br />
                    background color <input type="text" id="bg-color" /><br />
                    goo font <input type="text" id="goo-font" /><br />
                    head font <input type="text" id="head-font" /><br />
                    cont font <input type="text" id="cont-font" /><br />
                </div>
                <div class="right-bar" style="height:auto;">
                    background real <input type="text" name="scom_bgimg" id="scom_bgimg" value="<?php echo esc_attr(get_option('scom_bgimg')); ?>" /><br />
                    background color <input type="text" name="scom_bgcol" id="scom_bgcol" value="<?php echo esc_attr(get_option('scom_bgcol')); ?>" /><br />
                    google font name <input type="text" name="scom_google_font_name" id="scom_google_font_name" value="<?php echo esc_attr(get_option('scom_google_font_name')); ?>" /><br />
                    content font name <input type="text" name="scom_content_font_name" id="scom_content_font_name" value="<?php echo esc_attr(get_option('scom_content_font_name')); ?>" /><br />
                </div>
            </div>
            <div class="clear"></div>
            
            <div class="rm_input rm_checkbox">
                <label for="scom_live_settings"><?php lang::_e('Show Live settings on frontside'); ?></label>
                <input name="scom_live_settings" id="scom_live_settings" type="checkbox" <?php if(get_option('scom_live_settings') == 'on') echo "checked='checked'"; ?> />
                <small><?php lang::_e('Show Live settings block like on demo sites. Really, this option need only for demo sites.'); ?></small><div class="clearfix"></div>
            </div>
            
            <a href="#" class="button-secondary" id="reset-all"><?php lang::_e('Reset to default settings'); ?></a>
        </div>
        <div class="clear"></div>
        <p class="submit">
            <input type="submit" style="margin-left:17px;" class="button-primary" value="<?php lang::_e('Save settings') ?>"/>
            <input type="submit" style="margin-left:17px;" class="button-secondary" name="resetSidebarToDefault" value="<?php lang::_e('Reset sidebar position to default') ?>"/>
        </p>
    </div>

    </form>
</div>

<?php 
} 

if(isset($_POST) && !empty($_POST['resetSidebarToDefault'])) {
    update_option('theme_startcommerce_widgets', 'default');
}
?>
