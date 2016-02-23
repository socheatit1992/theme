<?php  
/*
 * Template Name: Page with Right sidebar
 */
?>

<?php get_header(); ?>
<div id="sidebar-page" class="row">
    <div id="category" class="main-content nine columns">
        <h2><?php the_title(); ?></h2>
        <div class="product-text">
            <?php if(have_posts()) : while(have_posts()) : the_post(); ?>
                <?php the_content(); ?>
            <?php endwhile; ?>
            <?php else : ?>
                <p><?php lang::_e('Sorry, but nothing found');?>.</p>
            <?php endif; ?>
        </div>
    </div>
    
    <div id="sidebar" class="three columns">
        <?php if ( frame::_()->getModule('pages_editor')->isActiveSidebar( 'pagesidebar' ) ) : ?>
            <?php frame::_()->getModule('pages_editor')->dynamicSidebar( 'pagesidebar' ); ?>
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