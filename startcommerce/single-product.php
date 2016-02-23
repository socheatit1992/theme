<?php get_header(); ?>
<div class="main-content single-page">
    
    <?php if(have_posts()) : while(have_posts()) : the_post(); ?>
        <div class="product-text">
          <?php the_content('Read more...'); ?>
        </div>
    <?php endwhile; ?>
    <?php else : ?>
         <p><?php lang::_e('Sorry, but nothing found');?>.</p>
    <?php endif; ?>
</div>

<div class="clear"></div>
<?php get_footer(); ?>