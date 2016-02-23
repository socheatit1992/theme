<?php get_header(); ?>
<div id="blogpost-page">
    <?php if ( frame::_()->getModule('pages_editor')->isActiveSidebar( 'breadcrumbs' ) ) : ?>
        <?php frame::_()->getModule('pages_editor')->dynamicSidebar( 'breadcrumbs' ); ?>
    <?php endif; ?>
    <div class="clear"></div>
    
    <h2><?php single_cat_title(); ?></h2>
    <div id="blogpost" class="main-content nine columns">
        <div class="items row">
            <?php if(have_posts()) : while(have_posts()) : the_post(); ?>
                <?php get_template_part( 'content', 'posts' ); ?>
            <?php endwhile; ?>
            <?php else : ?>
                 <p><?php lang::_e('Sorry, but nothing found');?>.</p>
            <?php endif; ?>
        </div>
    </div>
    
    <div id="sidebar" class="three columns">
        <?php if ( frame::_()->getModule('pages_editor')->isActiveSidebar( 'sidebar' ) ) : ?>
            <?php frame::_()->getModule('pages_editor')->dynamicSidebar( 'sidebar' ); ?>
        <?php endif; ?>
    </div>
    
    <div class="clear"></div>
    <div class="sort-line">
        <?php 
        if(class_exists('frame') && frame::_()->getModule('pagination')) {
            frame::_()->getModule('pagination')->getView()->display(array('nav_id' => 'pagination', 'show' => array('navigation')));
        }?>
    </div>
</div>
<div class="clear"></div>
<?php get_footer(); ?>