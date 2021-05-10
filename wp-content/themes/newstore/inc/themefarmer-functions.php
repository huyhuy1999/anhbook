<?php
function newstore_blog_header_image() {
	$header_image = get_header_image();
	if (!empty($header_image)) {
		?>
		<div class="header-image-container">
			<img src="<?php header_image();?>" class="page-header-image img-responsive"/>
			<div class="overlay">
				<table>
					<tr>
						<td class="align-middle">
							<?php newstore_the_header_page_title();?>
						</td>
					</tr>
				</table>
			</div>
		</div>
	<?php
}
}
add_action('newstore_before_blog_post', 'newstore_blog_header_image');
add_action('newstore_before_shop', 'newstore_blog_header_image');

function newstore_the_header_page_title() {
	$description = '';
	if (is_home()) {
		$title       = get_bloginfo('name');
		$description = get_bloginfo('description');
	} elseif (function_exists('is_woocommerce') && is_woocommerce()) {
		$title = woocommerce_page_title(false);
	} elseif (is_category()) {
		$title       = str_replace('category:', '', get_the_archive_title());
		$description = get_the_archive_description();
	} elseif (is_tag()) {
		$title       = str_replace('tag:', '', get_the_archive_title());
		$description = get_the_archive_description();
	} elseif (is_archive()) {
		$title       = str_replace('archives:', '', get_the_archive_title());
		$description = get_the_archive_description();
	} elseif (is_search()) {
		$title = sprintf(__('Search Results for : %s', 'newstore'), get_search_query());
	} elseif (is_404()) {
		$title = sprintf(__('Error 404  : Page Not Found', 'newstore'));
	} elseif (is_single()) {
		$title = get_the_title();
	} else {
		$title = get_the_title();
	}

	if (!empty($title)) {
		echo '<h1 class="main-header-title">' . wp_kses_post($title) . '</h1>';
	}

	if (!empty($description)) {
		echo '<p class="main-header-description">' . wp_kses_post($description) . '</p>';
	}
}

function newstore_get_social_block() {
	$new_tab = get_theme_mod('themefarmer_social_new_tab', true);
	$socials = get_theme_mod('themefarmer_socials');
	?>
    <ul class="header-topbar-links">
        <?php if ($socials): foreach ($socials as $key => $social): ?>
	            <?php if (!empty($social['link']) && !empty($social['icon'])): ?>
	            <li><a href="<?php echo esc_url($social['link']); ?>"  <?php echo absint($new_tab) ? 'target="_blank"' : ''; ?>><i class="fa <?php echo esc_attr($social['icon']); ?>"></i></a></li>
	            <?php endif;?>
        <?php endforeach;endif;?>
    </ul>
    <?php
}

function newstore_get_contact_block() {
	$top_phone = get_theme_mod('newstore_top_phone');if (!empty($top_phone)): ?>
    <span class="contact-item contact-mobile"><span class="contact-link"><a href="tel:<?php echo esc_attr($top_phone); ?>"><i class="fa fa-phone-square"></i> <?php echo esc_html($top_phone); ?></a></span></span>
    <?php endif;?>
    <?php $top_email = get_theme_mod('newstore_top_email');if (!empty($top_email)): ?>
    <span class="contact-item contact-email"><span class="contact-link"><a href="mailto:<?php echo esc_attr($top_email); ?>"><i class="fa fa-envelope"></i> <?php echo esc_html($top_email); ?></a></span></span>
    <?php endif;?>
    <?php $top_address = get_theme_mod('newstore_top_address');if (!empty($top_address)): ?>
    <span class="contact-item contact-email"><span class="contact-link"><i class="fa fa-location-arrow"></i> <?php echo esc_html($top_address); ?></span></span>
    <?php endif;

}

function newstore_post_navigation() {
	?>
	<div id="newstore-post-nav" class="navigation">
		<?php $prevPost = get_previous_post(true);
	if ($prevPost): ?>
		<div class="nav-box previous">
		<?php $prevthumbnail = get_the_post_thumbnail($prevPost->ID, array(100, 100));?>
		<?php previous_post_link('%link', $prevthumbnail . '<h3 class="nav-title">%title</h3>', TRUE);?>
		</div>
		<?php endif;?>
		<?php $nextPost = get_next_post(true);
	if ($nextPost): ?>
		<div class="nav-box next">
		<?php $nextthumbnail = get_the_post_thumbnail($nextPost->ID, array(100, 100));?>
		<?php next_post_link('%link', '<h3 class="nav-title">%title</h3>' . $nextthumbnail, TRUE);?>
		</div>
		<?php endif;?>
		<div class="clearfix"></div>
	</div><!--#newstore-post-nav div -->
	<div class="clearfix"></div>
<?php
}

function newstore_excerpt_more($more) {
	if (is_admin()) {
		return $more;
	}

	return '...';
}
add_filter('excerpt_more', 'newstore_excerpt_more');
function newstore_excerpt_length($length) {

	if (is_admin()) {
		return $length;
	}
	return 20;
}
add_filter('excerpt_length', 'newstore_excerpt_length', 999);

function newstore_comment_form_fields($fields) {
	if (class_exists('WooCommerce') && is_product()) {
		return $fields;
	}

	$fields['author'] = '<div class="form-group col-sm-4 cmt-f"><input type="text" class="form-control" id="name" name="author" placeholder="' . esc_attr__('Full Name', 'newstore') . '"></div>';
	$fields['email']  = '<div class="form-group col-sm-4"><input type="email" class="form-control" id="email" name="email" placeholder="' . esc_attr__('Your Email Address', 'newstore') . '"></div>';
	$fields['url']    = '<div class="form-group col-sm-4 cmt-l"><input type="text" class="form-control" id="url" name="url" placeholder="' . esc_attr__('Website', 'newstore') . '"></div>';
	return $fields;
}
add_filter('comment_form_fields', 'newstore_comment_form_fields');

function newstore_comment_form_defaults($defaults) {
	if (class_exists('WooCommerce') && is_product()) {
		return $defaults;
	}

	$defaults['submit_field']   = '<div class="form-group col-12">%1$s %2$s</div>';
	$defaults['comment_field']  = '<div class="form-group col-12"><textarea class="form-control" rows="5" id="comment" name="comment" placeholder="' . esc_attr__('Message', 'newstore') . '"></textarea></div>';
	$defaults['title_reply_to'] = esc_html__('Post Your Reply Here To %s', 'newstore');
	$defaults['class_submit']   = 'btn btn-theme';
	$defaults['label_submit']   = esc_html__('SUBMIT COMMENT', 'newstore');
	$defaults['class_form']     = esc_attr($defaults['class_form']) . ' row';
	$defaults['title_reply']    = esc_html__('Leave A Comment', 'newstore');
	$defaults['role_form']      = 'form';

	return $defaults;

}
add_filter('comment_form_defaults', 'newstore_comment_form_defaults');

function newstore_comment($comment, $args, $depth) {
	// get theme data.
	global $comment_data;
	// translations.
	$leave_reply = $comment_data['translation_reply_to_coment'] ? $comment_data['translation_reply_to_coment'] : __('Reply', 'newstore');?>
        <div class="the-comment">
            <div class="img-thumbnail">
            <?php echo get_avatar($comment, $size = '80'); ?>
            </div>
            <div class="comment-data">
                <div class="comment-items">
                    <h4 class="comment-item comment-author"><?php comment_author();?></h4>
                    <span class="comment-item comment-replay-link"><?php comment_reply_link(array_merge($args, array('reply_text' => '<i class="fa fa-reply"></i> ' . $leave_reply, 'depth' => $depth, 'max_depth' => $args['max_depth'])))?></span>
                    <?php if ($comment->comment_approved == '0'): ?>
                    <em class="comment-item comment-awaiting-moderation"><?php esc_html_e('Your comment is awaiting moderation.', 'newstore');?></em>
                    <?php endif;?>
                </div>
                <div class="comment-text"><?php comment_text();?></div>
                <h5 class="comment-item comment-date">
                    <?php if (('d M  y') == get_option('date_format')): ?>
                    <?php comment_date('F j, Y');?>
                    <?php else: ?>
                    <?php comment_date();?>
                    <?php endif;?>
                    <?php esc_html_e('at', 'newstore');?>&nbsp;<?php comment_time('g:i a');?>
                </h5>
            </div>
        </div>
        <?php
}

function newstore_register_required_plugins() {
	/*
		 * Array of plugin arrays. Required keys are name and slug.
		 * If the source is NOT from the .org repo, then source is also required.
	*/
	$plugins = array(

		array(
			'name'     => 'Elementor Page Builder',
			'slug'     => 'elementor',
			'required' => false,
		),
		array(
			'name'     => 'ThemeFarmer Companion',
			'slug'     => 'themefarmer-companion',
			'required' => false,
		),
		array(
			'name'     => 'WooCommerce Tools',
			'slug'     => 'woo-tools',
			'required' => false,
		),
		array(
			'name'     => 'Contact Form 7',
			'slug'     => 'contact-form-7',
			'required' => false,
		),
		array(
			'name'     => 'One Click Demo Import',
			'slug'     => 'one-click-demo-import',
			'required' => false,
		),
		array(
			'name'     => 'WooCommerce',
			'slug'     => 'woocommerce',
			'required' => false,
		),
	);

	/*
		 * Array of configuration settings. Amend each line as needed.
		 *
		 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
		 * strings available, please help us make TGMPA even better by giving us access to these translations or by
		 * sending in a pull-request with .po file(s) with the translations.
		 *
		 * Only uncomment the strings in the config array if you want to customize the strings.
	*/
	$config = array(
		'id'           => 'newstore', // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '', // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true, // Show admin notices or not.
		'dismissable'  => true, // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '', // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false, // Automatically activate plugins after installation or not.
		'message'      => '', // Message to output right before the plugins table.
	);

	tgmpa($plugins, $config);
}

add_action('tgmpa_register', 'newstore_register_required_plugins');


function newstore_nav_description( $item_output, $item, $depth, $args ) {
    if ( !empty( $item->description ) ) {
        $item_output = str_replace( $args->link_after . '</a>', '<span class="menu-item-description">' . $item->description . '</span>' . $args->link_after . '</a>', $item_output );
    }
 
    return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'newstore_nav_description', 50, 4 );

function newstore_add_custom_styles(){
	$blog_content_width = get_theme_mod( 'newstore_blog_content_width', 70);
	$blog_content_width = absint( $blog_content_width );
	$custom_css ="";
	if(!empty($blog_content_width) && $blog_content_width != 70){
		$sidebar_width = 100 - $blog_content_width;
		$custom_css = "
			main#main.site-main:not(.wc-site-main){
				-ms-flex: 0 0 {$blog_content_width}%;
			    flex: 0 0 {$blog_content_width}%;
			    max-width: {$blog_content_width}%;
			}
			aside#secondary.sidebar-widget-area.widget-area:not(.woocommerce-widget-area){
				-ms-flex: 0 0 {$sidebar_width}%;
			    flex: 0 0 {$sidebar_width}%;
			    max-width: {$sidebar_width}%;	
			}
		";
	}
	$custom_css = apply_filters( 'newstore_inline_css', $custom_css);
	wp_add_inline_style( 'newstore-style', $custom_css);
}
add_action('wp_enqueue_scripts', 'newstore_add_custom_styles', 31);

