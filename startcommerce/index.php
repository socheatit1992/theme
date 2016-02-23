<?php get_header(); ?>
<div class="main-content row">    
    <?php if(have_posts()) : while(have_posts()) : the_post(); ?>
        <?php the_content(); ?>
    <?php endwhile; ?>
    <?php else : ?>
         <p><?php lang::_e('Sorry, but nothing found');?>.</p>
    <?php endif; ?>
</div>

<div class="clear"></div>
<?php get_footer(); ?>