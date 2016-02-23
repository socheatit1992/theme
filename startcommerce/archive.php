<?php get_header(); ?>   
<div class="row">
    <div id="category" class="main-content nine columns">
        <h2><?php if (is_page_template('template-categories.php') or is_page_template('template-brands.php')) { the_title();} else {single_cat_title();} ?></h2>
        <hr class="wave-line" />
        <div class="sort-line">
        <?php if(have_posts()) :?>
            <div class="items-view">
                <?php lang::_e('Show'); ?>: 
                <a href="#" class="change-to-grid-view <?php if($_COOKIE['catalogView'] == 'grid' || $_COOKIE['catalogView'] == null) echo 'current-catalog-view' ?>"><?php lang::_e('Grid View'); ?></a>
                <a href="#" class="change-to-list-view <?php if($_COOKIE['catalogView'] == 'list') echo 'current-catalog-view' ?>"><?php lang::_e('List View'); ?></a>
            </div>
            <?php 
            if(class_exists('frame') && frame::_()->getModule('pagination')) {
                frame::_()->getModule('pagination')->getView()->display(array('nav_id' => 'pagination', 'show' => array('navigation', 'perPage', 'ordering')));
            }?>
        <?php endif; ?>
        </div>
        <div class="clear"></div>
        
        <div class="items row">
            <?php if(have_posts()) : while(have_posts()) : the_post(); ?>
                  <?php the_content('Read more...'); ?>
            <?php endwhile; ?>
            <?php else : ?>
                 <p><?php lang::_e('Sorry, but nothing found');?>.</p>
            <?php endif; ?>
        </div>
        <div class="clear"></div>
        
        <div class="sort-line">
            <div class="items-view">
                <?php lang::_e('Show'); ?>: 
                <a href="#" class="change-to-grid-view <?php if($_COOKIE['catalogView'] == 'grid' || $_COOKIE['catalogView'] == null) echo 'current-catalog-view' ?>"><?php lang::_e('Grid View'); ?></a>
                <a href="#" class="change-to-list-view <?php if($_COOKIE['catalogView'] == 'list') echo 'current-catalog-view' ?>"><?php lang::_e('List View'); ?></a>
            </div>
            <?php 
            if(class_exists('frame') && frame::_()->getModule('pagination')) {
                frame::_()->getModule('pagination')->getView()->display(array('nav_id' => 'pagination', 'show' => array('navigation', 'perPage', 'ordering')));
            }?>
        </div>
        <div class="clear"></div>
    </div>
    
    <div id="sidebar" class="three columns">
        <?php if ( frame::_()->getModule('pages_editor')->isActiveSidebar( 'sidebarproducts' ) ) : ?>
            <?php frame::_()->getModule('pages_editor')->dynamicSidebar( 'sidebarproducts' ); ?>
        <?php endif; ?>
    </div>
    
    <div class="clear"></div>
    
    <?php if ( frame::_()->getModule('pages_editor')->isActiveSidebar( 'newproducts' ) ) : ?>
    <div id="new-products" class="row">
        <?php frame::_()->getModule('pages_editor')->dynamicSidebar( 'newproducts' ); ?>
    </div>
    <?php endif; ?>
</div>
<?php get_footer(); ?>