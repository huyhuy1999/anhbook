<?php $count = count($args); ?>
<div class="tfwctool-compare-quickinfo" style="<?php echo ($count <= 0)?'display:none;':''; ?>">
	<div class="tfwctool-compare-quickinfo-inner">
		<div class="tfwctool-quick-porducts">
		<?php  if($args): foreach ($args as $key => $product) : ?>
			<div class="tfwc-comp-product the-product-<?php echo intval($product['id']); ?>">
				<?php 
					echo $product['remove']; 
					echo '<div class="tfwc-prd-image">'.$product['image'].'</div>';
					echo '<div class="tfwc-prd-title">'.$product['title'].'</div>';
				?>
			</div>
		<?php  endforeach; endif; ?>
		</div>
		<button class="tfwctool-quick-button" role="button">
			<span class="label"><?php esc_html_e( 'Compare', 'tfwctools' ); ?></span>
			<span class="count"><?php echo esc_html( number_format_i18n($count) ); ?></span>
		</button>
	</div>
</div>