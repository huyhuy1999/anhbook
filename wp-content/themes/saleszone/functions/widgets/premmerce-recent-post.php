<?php

/**
 * Class PremmerceRecentPost
 */
class PremmerceRecentPost extends WP_Widget
{

    /**
     * @var array
     */
    private $orderSettingsDefault;

    function __construct()
    {

        $this->orderSettingsDefault = array(
            'date' => esc_html__('Order by date', 'saleszone'),
            'rand' => esc_html__('Random order', 'saleszone'),
            'comment_count' => esc_html__('Order by comment count', 'saleszone'),
            'menu_order' => esc_html__('Order by position', 'saleszone'),
            'author' => esc_html__('Order by author', 'saleszone')
        );

        parent::__construct(
            'saleszone_recent_post',
            esc_html__('Premmerce recent post', 'saleszone'),
            array('description' => 'Recent post advanced')
        );

    }

    /**
     * FRONT
     */
    function widget($args, $instance)
    {
        $title = apply_filters('widget_title', $instance['title']);
        $activeCategoryId = isset($instance['category']) ? $instance['category'] : '';

        $postQuantity = isset($instance['post_quantity']) ? $instance['post_quantity'] : '';
        $ConsiderSubcategories = isset($instance['post_consider_subcategories']) ? $instance['post_consider_subcategories'] : '';
        $showDate = isset($instance['post_show_date']) ? $instance['post_show_date'] : '';
        $showImage = isset($instance['post_show_image']) ? $instance['post_show_image'] : '';
        $activeOrder = isset($instance['order']) ? $instance['order'] : '';
        $key = $ConsiderSubcategories ? 'cat' : 'category__in';

        remove_filter('posts_clauses', array(wc()->query, 'order_by_popularity_post_clauses'));

        $allowed_html = array_merge(
            saleszone_svg_allowed_html(),
            saleszone_get_allowed_html('widget')
        );

        $latestPosts = new WP_Query(array(
            'post_type' => 'post',
            $key => $activeCategoryId,
            'posts_per_page' => $postQuantity,
            'orderby' => $activeOrder
        ));

        ?>

        <?php echo wp_kses($args['before_widget'] ,$allowed_html); ?>
        <?php echo wp_kses($args['before_title'] ,$allowed_html); ?>

        <?php if (!empty($title)) : ?>
        <?php echo esc_html($title); ?>
        <div class="pc-section-secondary__viewall">
            <a href="<?php echo esc_url(get_category_link($activeCategoryId)); ?>" class="pc-section-secondary__hlink">
                <?php esc_html_e('View all', 'saleszone'); ?>
            </a>
        </div>
        <?php endif; ?>

        <?php echo wp_kses($args['after_title'] ,$allowed_html); ?>

        <?php wc_get_template('../parts/widgets/premmerce-recent-post.php', array(
            'query' => $latestPosts,
            'showDate' => $showDate,
            'showImage' => $showImage
        )); ?>

        <?php

        echo wp_kses($args['after_widget'] ,$allowed_html);
    }

    /**
     * Admin
     */
    function form($instance)
    {
        $title = isset($instance['title']) ? $instance['title'] : __('Recent post', 'saleszone');
        $categories = get_categories(array('hide_empty' => 0));
        $activeCategoryId = isset($instance['category']) ? $instance['category'] : '';
        $postQuantity = isset($instance['post_quantity']) ? $instance['post_quantity'] : '';
        $ConsiderSubcategories = isset($instance['post_consider_subcategories']) ? $instance['post_consider_subcategories'] : '';
        $showDate = isset($instance['post_show_date']) ? $instance['post_show_date'] : '';
        $showImage = isset($instance['post_show_image']) ? 'checked' : '';
        $activeOrder = isset($instance['order']) ? $instance['order'] : '';
        ?>

        <!-- Title -->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                <?php esc_html_e('Title', 'saleszone'); ?>:
            </label>
            <input class="widefat"
                   id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>"
                   type="text"
                   value="<?php echo esc_attr($title); ?>">
        </p>

        <!-- Post Category -->
        <?php if (count($categories) > 0) : ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('category')); ?>">
                <?php esc_html_e('Category', 'saleszone'); ?>:
            </label>
            <select class="widefat" name="<?php echo esc_attr($this->get_field_name('category')); ?>"
                    id="<?php echo esc_attr($this->get_field_id('category')); ?>">
                <?php foreach ($categories as $category) : ?>
                    <option value="<?php echo esc_attr($category->cat_ID); ?>" <?php echo $activeCategoryId == $category->cat_ID ? 'selected' : '' ?> >
                        <?php echo esc_html($category->name); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>
    <?php endif; ?>

        <!-- Order by -->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('order')); ?>">
                <?php esc_html_e('Order by', 'saleszone'); ?>:
            </label>
            <select class="widefat" name="<?php echo esc_attr($this->get_field_name('order')); ?>"
                    id="<?php echo esc_attr($this->get_field_id('category')); ?>">
                <?php foreach ($this->orderSettingsDefault as $key => $value) : ?>
                    <option value="<?php echo esc_attr($key); ?>" <?php echo $activeOrder == $key ? 'selected' : '' ?> >
                        <?php echo esc_html($value); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>

        <!-- Number of posts to show -->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('post_quantity')); ?>">
                <?php esc_html_e('Number of posts to show', 'saleszone'); ?>:
            </label>
            <input id="<?php echo esc_attr($this->get_field_id('post_quantity')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('post_quantity')); ?>"
                   type="number"
                   class="tiny-text"
                   value="<?php echo esc_attr($postQuantity); ?>"
            >
        </p>

        <!-- Consider subcategories -->
        <p>
            <input id="<?php echo esc_attr($this->get_field_id('post_consider_subcategories')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('post_consider_subcategories')); ?>"
                   type="checkbox"
                <?php echo $ConsiderSubcategories ? 'checked' : '' ?>
            >
            <label for="<?php echo esc_attr($this->get_field_id('post_consider_subcategories')); ?>">
                <?php esc_html_e('Consider subcategories', 'saleszone'); ?> ?
            </label>
        </p>

        <!-- Show post date -->
        <p>
            <input id="<?php echo esc_attr($this->get_field_id('post_show_date')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('post_show_date')); ?>"
                   type="checkbox"
                <?php echo $showDate ? 'checked' : '' ?>
            >
            <label for="<?php echo esc_attr($this->get_field_id('post_show_date')); ?>">
                <?php esc_html_e('Display post date', 'saleszone'); ?> ?
            </label>
        </p>

        <!-- Show post image -->
        <p>
            <input id="<?php echo esc_attr($this->get_field_id('post_show_image')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('post_show_image')); ?>"
                   type="checkbox"
                <?php echo esc_attr($showImage); ?>
            >
            <label for="<?php echo esc_attr($this->get_field_id('post_show_image')); ?>">
                <?php esc_html_e('Display post image', 'saleszone'); ?> ?
            </label>
        </p>

        <?php
    }

    /**
     * Admin save
     */
    function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['category'] = (!empty($new_instance['category'])) ? $new_instance['category'] : '';
        $instance['order'] = (!empty($new_instance['order'])) ? $new_instance['order'] : '';
        $instance['post_quantity'] = (!empty($new_instance['post_quantity'])) ? $new_instance['post_quantity'] : '';
        $instance['post_consider_subcategories'] = (!empty($new_instance['post_consider_subcategories'])) ? $new_instance['post_consider_subcategories'] : '';
        $instance['post_show_date'] = (!empty($new_instance['post_show_date'])) ? $new_instance['post_show_date'] : '';
        $instance['post_show_image'] = (!empty($new_instance['post_show_image'])) ? $new_instance['post_show_image'] : '';

        return $instance;
    }

}
if(!function_exists('saleszone_register_recent_post_widget')){
    function saleszone_register_recent_post_widget(){
        register_widget('PremmerceRecentPost');
    }
}
add_action('widgets_init', 'saleszone_register_recent_post_widget');