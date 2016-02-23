<?php
/**
 * The template for displaying content in the single.php template
 */
?>

<article id="post-<?php the_ID(); ?>" class="product-text product-single-txt twelve columns">
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>

		<?php if ( 'post' == get_post_type() ) : ?>
            <?php $show_sep = false; ?>
            <?php if ( is_object_in_taxonomy( get_post_type(), 'category' ) ) : // Hide category text when not supported ?>
            <?php
                /* translators: used between list items, there is a space after the comma */
                $categories_list = get_the_category_list( ', ' );
                if ( $categories_list ):
            ?>
            <div class="entry-meta">
                <?php posted_on(); ?>
                <span class="cat-links">
                    <?php printf( lang::_( '<span class="%1$s"> in</span> %2$s' ), 'entry-utility-prep entry-utility-prep-cat-links', $categories_list );
                    $show_sep = true; ?>
                </span>
            </div><!-- .entry-meta -->
            <?php endif; // End if categories ?>
            <?php endif; // End if is_object_in_taxonomy( get_post_type(), 'category' ) ?>
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
        <div class="thumb">
            <?php echo get_the_post_thumbnail($post->ID, 'thumbnail', array('title' => '')); ?>
        </div>
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . lang::_( 'Pages:') . '</span>', 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

</article>
