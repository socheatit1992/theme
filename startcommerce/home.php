<?php get_header(); ?>
<?php frame::_()->getModule('pages_editor')->contentStart()?>
<div id="home-slider">
    <?php ready_responsive_slider(); ?>
</div><!-- End Home-slider -->
<div class="clear"></div>

<div id="info-blocks" class="row">
<?php 
$query = new WP_Query('post_type=page&meta_key=onhome&meta_value=1');
while($query->have_posts()){ $query->the_post(); ?>            
        <div class="info-block six column">
            <a href="<?php the_permalink(); ?>"><h2><?php the_title(); ?></h2></a>
            <em><?php echo get_post_meta( $post->ID, 'pageExcerpt', true ); ?></em>
            <div class="product-text">
                <?php the_content(); ?>
            </div>
        </div>
<?php } ?>  
<?php wp_reset_postdata(); ?> 

</div><!-- End info-blocks -->
<div class="clear"></div>

<?php if ( frame::_()->getModule('pages_editor')->isActiveSidebar( 'newproducts' ) ) : ?>
<div id="new-products" class="row">
    <?php frame::_()->getModule('pages_editor')->dynamicSidebar( 'newproducts' ); ?>
</div>
<?php endif; ?>

<div id="banners" class="row">
<?php
$query = new WP_Query('post_type=banners');
while($query->have_posts()){ $query->the_post(); ?>  
    <div class="banner four column">
        <?php 
            if (get_post_meta( $post->ID, 'another_link', true ) != '') {
                $bannerLink = get_post_meta( $post->ID, 'another_link', true );
            } else {
                $bannerLink = get_permalink($post->ID);
            }
        ?>
        <a href="<?php echo $bannerLink; ?>">
            <?php if (has_post_thumbnail($post->ID)) the_post_thumbnail('banner-thumb'); ?>
        </a>
    </div>
<?php } ?>  
<?php wp_reset_postdata(); ?> 
</div>
<div class="clear"></div>

<?php if ( frame::_()->getModule('pages_editor')->isActiveSidebar( 'bestsellers' ) ) : ?>
<div id="bestsellers" class="row">
    <?php frame::_()->getModule('pages_editor')->dynamicSidebar( 'bestsellers' ); ?>
</div>
<div class="clear"></div>
<?php endif; ?>

<?php if ( frame::_()->getModule('pages_editor')->isActiveSidebar( 'brands' ) ) : ?>
<div id="brandswidget" class="row">
    <?php frame::_()->getModule('pages_editor')->dynamicSidebar( 'brands' ); ?>
</div>
<div class="clear"></div>
<?php endif; ?>
<?php frame::_()->getModule('pages_editor')->contentEnd()?>
<?php get_footer(); ?>