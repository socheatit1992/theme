<?php
/**
 * The template used for displaying page content in page.php
 */
?>

<article id="post-<?php the_ID(); ?>" class="product-text twelve columns">
    <?php if (!frame::_()->getModule('pages')->isCart() &&
              !frame::_()->getModule('pages')->isCheckoutStep1() &&
              !frame::_()->getModule('pages')->isCheckoutStep2() &&
              !frame::_()->getModule('pages')->isCheckoutStep3() ): ?>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->
    <?php endif; ?>

	<div class="entry-content">
		<?php the_content(); ?>
    </div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->
