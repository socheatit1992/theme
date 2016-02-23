<?php get_header(); ?>
<div class="main-content single-page row">
    <?php if ( frame::_()->getModule('pages_editor')->isActiveSidebar( 'breadcrumbs' ) ) : ?>
        <?php frame::_()->getModule('pages_editor')->dynamicSidebar( 'breadcrumbs' ); ?>
    <?php endif; ?>
    <div class="clear"></div>
    
    <?php if(have_posts()) : while(have_posts()) : the_post(); ?>
        <?php get_template_part( 'content', 'single' ); ?>
    <?php endwhile; ?>
    <?php else : ?>
         <p><?php lang::_e('Sorry, but nothing found');?>.</p>
    <?php endif; ?>
    
    <div style="clear:both"></div>
    <div id="comment-block" class="row product-text">
        <hr class="wave-line" />
        <?php comments_template(); ?>
    </div>
    <div style="clear:both"></div>
</div>

<div class="clear"></div>
<?php get_footer(); ?>