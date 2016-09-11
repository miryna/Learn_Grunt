<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to ideustheme_walker_comment() which is
 * located in the inc/Ideustheme_Walker_Comment.php file.
 *
  */
?>

<?php
	// File Security Check
	if ( ! defined( 'ABSPATH' ) ) { exit; }

	/*
	 * If the current post is protected by a password and
	 * the visitor has not yet entered the password we will
	 * return early without loading the comments.
	 */
	if ( post_password_required() || ( !comments_open() && 0 == get_comments_number() ) ) {
		return;
	}
?>

    <section class="l-comments">
      <div class="b-comments" id="comments">


	<?php if ( have_comments() ) : ?>

			<div class="b-comments__title"><?php printf( _nx( '1 Comment', '%1$s Comments', get_comments_number(), 'comments title', 'ideustheme' ), number_format_i18n( get_comments_number() ) ); ?>
        <span class="separator">
        </span>
      </div>


		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav class="b-comments__navigation" role="navigation" id="comments-nav-above" >
			<h1 class="b-comments__assistiveText"><?php _e( 'Comment navigation', 'ideustheme' ); ?></h1>
			<div class="b-comments__navPrevious"><?php previous_comments_link( __( '&larr; Older Comments', 'ideustheme' ) ); ?></div>
			<div class="b-comments__navNext"><?php next_comments_link( __( 'Newer Comments &rarr;', 'ideustheme' ) ); ?></div>
		</nav><!-- .b-comments__navigation -->
		<?php endif; // check for comment navigation ?>

		<ul class="b-comments__list">
			<?php
				/* Loop through and list the comments. Tell wp_list_comments()
				 * to use ideustheme_comment() to format the comments.
				 */

			wp_list_comments( array( 'callback' => 'ideustheme_walker_comment' ) );

			?>
		</ul><!-- .b-commentList -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav role="navigation" id="comments-nav-below" class="b-comments__navigation">
        <h1 class="b-comments__assistiveText"><?php _e( 'Comment navigation', 'ideustheme' ); ?></h1>
        <div class="b-comments__navPrevious"><?php previous_comments_link( __( '&larr; Older Comments', 'ideustheme' ) ); ?></div>
        <div class="b-comments__navNext"><?php next_comments_link( __( 'Newer Comments &rarr;', 'ideustheme' ) ); ?></div>
		</nav><!-- .b-comments__navigation -->
		<?php endif; // check for comment navigation ?>

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="b-comments__noComments"><?php _e( 'Comments are closed.', 'ideustheme' ); ?></p>
	<?php endif; ?>

	<?php
	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	$required_text = sprintf( ' ' . __('Required fields are marked %s', 'ideustheme'), '<span class="b-comments__required">*</span>' );

	$comment_form_args = array(

		'title_reply' => '',

		'title_reply_to' => '',

    'class_form' => 'b-comments__form',

		'fields'	=> apply_filters( 'comment_form_default_fields', array(

			'author' => '<div class="b-comments__formFields"><span class="b-comments__formAuthor">' . '<label class="b-comments__assistiveText" for="author">' . __( '', 'ideustheme' ) . '</label><input id="author" name="author" type="text" placeholder="' . __( 'Name&#42;', 'ideustheme' ) . '" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></span>',

			'email' => '<span class="b-comments__formEmail"><label class="b-comments__assistiveText" for="email">' . __( '', 'ideustheme' ) . '</label><input id="email" name="email" type="text" placeholder="' . __( 'Email&#42;', 'ideustheme' ) . '" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></span>',

			'url' => '<span class="b-comments__formUrl"><label class="b-comments__assistiveText" for="url">' . __( '', 'ideustheme' ) . '</label><input id="url" name="url" type="text" placeholder="' . __( 'Website', 'ideustheme' ) . '" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></span></div>'

			)
		),

		'comment_field'	=> '<p class="b-comments__formTextarea"><label class="b-comments__assistiveText" for="comment">' . __( '', 'ideustheme' ) . '</label><textarea id="comment" placeholder="' . __( 'Comment', 'ideustheme' ) . '" name="comment" cols="45" rows="5" aria-required="true"></textarea></p>',

		'comment_notes_after' => '<p class="b-comments__formAllowedTags text-small wf-mobile-hidden">' . sprintf( __( '<span>You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes:</span> %s ', 'ideustheme' ), ' <code>' . allowed_tags() . '</code>' ) . '</p>',

		'must_log_in' => '<p class="b-comments__mustLogIn text-small">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'ideustheme' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',

		'logged_in_as' => '<p class="b-comments__loggedInAs text-small">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'ideustheme' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',

		'comment_notes_before' => '<p class="b-comments__commentNotes text-small">' . __( 'Your email address will not be published.', 'ideustheme' ) . ( $req ? $required_text : '' ) . '</p>',

    'title_reply_before' => '<h3 id="reply-title" class="b-comments__replyTitle">',

    'submit_field' => '<p class="b-comments__formSubmit">%1$s %2$s</a>',
	);
	?>

	<?php comment_form( $comment_form_args ); ?>


      </div> <!-- b-comments -->
    </section>

