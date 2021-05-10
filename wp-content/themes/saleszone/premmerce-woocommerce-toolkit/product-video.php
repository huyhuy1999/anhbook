<?php
if (!defined('ABSPATH')) {
    exit;
}
global $product;

$counter = 0;
foreach ($urls as $url) :
    $urlArray = parse_url($url);
    $parseUrl = array();

    if (isset($urlArray['query'])) {
        parse_str($urlArray['query'], $parseUrl);
    }

    if ($urlArray['host'] == 'www.youtube.com' || $urlArray['host'] == 'youtu.be') {
        $thumbUrl = 'https://img.youtube.com/vi/' . (isset($parseUrl['v']) ? $parseUrl['v'] : trim($urlArray['path'], '/')) . '/0.jpg';
    } else if ($urlArray['host'] == 'vimeo.com') {
        $pathParts = explode('/', trim($urlArray['path'], '/'));
        $hash = unserialize(wp_remote_get('http://vimeo.com/api/v2/video/' . $pathParts[count($pathParts) - 1] . '.php'));

        $thumbUrl = $hash[0]['thumbnail_medium'];
    }
    ?>

    <li class="product-photo__thumb">
        <a href="<?php echo esc_url($thumbUrl); ?>" class="product-photo__thumb-item"
           data-product-photo-thumb="<?php echo esc_url($thumbUrl); ?>"
           data-product-photo-thumb-video="<?php echo esc_url(utf8_uri_encode($url)); ?>"
        >
            <img class="product-photo__img"
                 src="<?php echo esc_url($thumbUrl); ?>"
                 <?php ++$counter ?>
                 alt="<?php echo esc_attr($product->get_name()); ?> Video #<?php echo esc_attr($counter); ?>"
            >
        </a>
        <i class="product-photo__video-ico fa fa-youtube-play fa-lg"></i>
    </li>
<?php endforeach; ?>
