<?php get_header(); ?>
<div id="search-page">

    <h2><?php lang::_e('Search results for: '); echo $_GET['s']; ?></h2>
    <div id="category" class="main-content">
        <div class="items">
        
        <?php if(have_posts()) : while(have_posts()) : the_post(); ?>
            <div class="item <?php echo 'type_'.$post->post_type; ?>">
              <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
              <?php the_content(); ?>
            </div>
        <?php endwhile; ?>
        <?php else : ?>
             <p><?php lang::_e('Sorry, but nothing found, try again with another request');?>.</p>
        <?php endif; ?>
        </div>
    </div>
    
    <div id="sidebar">
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