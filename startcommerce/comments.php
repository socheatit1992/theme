	<div id="comments">
	<?php if ( post_password_required() ) : ?>
		<p class="nopassword"><?php lang::_e( 'This post is password protected. Enter the password to view any comments.' ); ?></p>
	</div><!-- #comments -->
	<?php
			return;
		endif;
	?>

	<?php if ( have_comments() ) : ?>
		<h2 id="comments-title">
			<?php
				printf( _n( 'One review for &ldquo;%2$s&rdquo;', '%1$s reviews on &ldquo;%2$s&rdquo;', get_comments_number() ),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
		</h2>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<nav id="comment-nav-above">
			<h1 class="assistive-text"><?php lang::_e( 'Comment navigation'); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( lang::_( '&larr; Older Reviews') ); ?></div>
			<div class="nav-next"><?php next_comments_link( lang::_( 'Newer Reviews &rarr;') ); ?></div>
		</nav>
		<?php endif; ?>

		<ol class="commentlist">
			<?php wp_list_comments('type=comment&callback=mytheme_comment'); ?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<div id="comment-nav-below">
			<h1 class="assistive-text"><?php lang::_e( 'Review navigation'); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( lang::_( '&larr; Older Reviews') ); ?></div>
			<div class="nav-next"><?php next_comments_link( lang::_( 'Newer Reviews &rarr;') ); ?></div>
		</div>
		<?php endif; // check for comment navigation ?>
    <hr class="wave-line" style="margin-top:20px;" />
	<?php elseif ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="nocomments"><?php lang::_e( 'Reviews are closed.'); ?></p>
	<?php endif; ?>
<?php if ( comments_open( $id ) ) : ?>
	<div id="respond">
        <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
            <div id="cancel-comment-reply">
                <small><?php cancel_comment_reply_link() ?></small>
            </div>
            <?php if ( $user_ID ) : ?>

            <p>
                <?php printf(lang::_('You logged as %s.'), '<a href="'.get_option('siteurl').'/wp-admin/profile.php">'.$user_identity.'</a>'); ?>
                <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php lang::_e('Exit') ?>"><?php lang::_e('Exit »'); ?></a>
            </p>

            <?php else : ?>
            
            <div class="row">
                <div class="four columns">
                    <input class="four columns" type="text" name="author" id="author" value="<?php echo $comment_author; ?>" tabindex="1" placeholder="<?php lang::_e('Nickname (Required)'); ?>" />
                </div>
                
                <div class="four columns">
                    <input class="four columns" type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" tabindex="2" placeholder="<?php lang::_e('Email (Required)'); ?>" />
                </div>
                
                <div class="four columns end">
                    <input class="four columns" type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" tabindex="3" placeholder="<?php lang::_e('Website'); ?>" />
                </div>
            </div>
            <?php endif; ?>
            <?php comment_id_fields(); ?>

            <div class="row no-margin">
                <textarea class="twelve columns" name="comment" id="comment" tabindex="4" placeholder="<?php lang::_e('Review text'); ?>"></textarea>
            </div>
            
            <p>
                <input name="submit" type="submit" id="submit" tabindex="5" value="<?php echo attribute_escape(lang::_('Post Review')); ?>" />
            </p>
            <?php do_action('comment_form', $post->ID); ?>

        </form>
    </div>
<?php endif; ?>
</div><!-- #comments -->
