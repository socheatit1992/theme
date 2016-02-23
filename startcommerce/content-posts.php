<?php
/**
 * The default template for displaying content
 */
?>

<article id="post-<?php the_ID(); ?>" class="item">
    <header class="entry-header">
        <?php if ( is_sticky() ) : ?>
            <hgroup>
                <h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( lang::_( 'Permalink to %s'), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                <h3 class="entry-format"><?php lang::_e( 'Featured' ); ?></h3>
            </hgroup>
        <?php else : ?>
        <a href="<?php the_permalink(); ?>"><h3 class="entry-title"><?php the_title(); ?></h3></a>
        <?php endif; ?>
    </header><!-- .entry-header -->
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
            <?php printf( lang::_( '<span class="%1$s"> in</span> %2$s'), 'entry-utility-prep entry-utility-prep-cat-links', $categories_list );
            $show_sep = true; ?>
        </span>
    </div><!-- .entry-meta -->
    <?php endif; // End if categories ?>
    <?php endif; // End if is_object_in_taxonomy( get_post_type(), 'category' ) ?>
    
    <hr class="wave-line" />
    
    <?php if ( is_search() ) : // Only display Excerpts for Search ?>
    <div class="entry-summary">
        <?php the_excerpt(); ?>
    </div><!-- .entry-summary -->
    <?php else : ?>
    <div class="entry-content">
        <div class="thumb">
            <a href="<?php the_permalink(); ?>">
                <?php echo get_the_post_thumbnail($post->ID, 'thumbnail', array('title' => '')); ?>
            </a>
        </div>
        <?php the_content( lang::_( 'Continue reading <span class="meta-nav">&rarr;</span>' ) ); ?>
        <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . lang::_( 'Pages:' ) . '</span>', 'after' => '</div>' ) ); ?>
    </div><!-- .entry-content -->
    <?php endif; ?>
    <div class="clear"></div>
</article><!-- #post-<?php the_ID(); ?> -->
<div class="clear"></div>
