<table class="free-vs-pro-table">
	<thead>
		<tr>
			<th></th>
			<th><?php echo esc_html($theme->get('Name')); ?></th>
			<th><?php echo esc_html($theme->get('Name')).' '.esc_html__('Pro', 'newstore'); ?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>
				<h3><?php esc_html_e('WooCommerce Compatible', 'newstore'); ?></h3>
				<p><?php esc_html_e('Best suitable theme for online store', 'newstore'); ?></p>
			</td>
			<td><span class="dashicons-before dashicons-yes"></span></td>
			<td><span class="dashicons-before dashicons-yes"></span></td>
		</tr>
		<tr>
			<td>
				<h3><?php esc_html_e('Header Slider', 'newstore'); ?></h3>
				<p><?php esc_html_e('Show of your product, servies on responsive slider', 'newstore'); ?></p>
			</td>
			<td><span class="dashicons-before dashicons-yes"></span><br><?php esc_html_e('Basic', 'newstore') ?></td>
			<td><span class="dashicons-before dashicons-yes"></span> <br><?php esc_html_e('(Select Diffrent Images for Desktop, Mobile & Tablet)', 'newstore') ?></td>
		</tr>
		<tr>
			<td>
				<h3><?php esc_html_e('FrontPage Sections', 'newstore'); ?></h3>
				<p><?php esc_html_e('Slider, Services, About Us, Subscribe, Contact Us, Shop, Team, Testimonail, Brand, Blog', 'newstore'); ?></p>
			</td>
			<td><span class="dashicons-before dashicons-yes"></span></td>
			<td><span class="dashicons-before dashicons-yes"></span><br><?php esc_html_e('Advance Live 17+(Pre Built) and Unlimited Section by Shortcode and widgets', 'newstore') ?></td>
		</tr>
		<tr>
			<td>
				<h3><?php esc_html_e('Page Templates', 'newstore'); ?></h3>
			</td>
			<td><span class="dashicons-before dashicons-yes"></span><br><?php esc_html_e('Limited', 'newstore') ?></td>
			<td><span class="dashicons-before dashicons-yes"></span><br><?php esc_html_e('15+ Page Templates for (Contact, About, Portfolio etc..) Page', 'newstore') ?></td>
		</tr>
		<tr>
			<td>
				<h3><?php esc_html_e('Video Tutorials', 'newstore'); ?></h3>
			</td>
			<td><span class="dashicons-before dashicons-yes"></span><br></td>
			<td><span class="dashicons-before dashicons-yes"></span><br></td>
		</tr>
		<tr>
			<td>
				<h3><?php esc_html_e('Support', 'newstore'); ?></h3>
			</td>
			<td><span class="dashicons-before dashicons-yes"></span><br></td>
			<td><span class="dashicons-before dashicons-yes"></span><br>Live Chat</td>
		</tr>
		<tr>
			<td>
				<h3><?php esc_html_e('Blog Slider', 'newstore'); ?></h3>
			</td>
			<td><span class="dashicons-before dashicons-no-alt"></span></td>
			<td><span class="dashicons-before dashicons-yes"></span> <br><?php esc_html_e('(Select Diffrent Images for Desktop, Mobile & Tablet)', 'newstore') ?></td>
		</tr>
		<tr>
			<td>
				<h3><?php esc_html_e('Shop Slider', 'newstore'); ?></h3>
			</td>
			<td><span class="dashicons-before dashicons-no-alt"></span></td>
			<td><span class="dashicons-before dashicons-yes"></span> <br><?php esc_html_e('(Select Diffrent Images for Desktop, Mobile & Tablet)', 'newstore') ?></td>
		</tr>
		<tr>
			<td>
				<h3><?php esc_html_e('FrontPage Section Reorder', 'newstore'); ?></h3>
			</td>
			<td><span class="dashicons-before dashicons-no-alt"></span></td>
			<td><span class="dashicons-before dashicons-yes"></span></td>
		</tr>
		<tr>
			<td>
				<h3><?php esc_html_e('Portfolio', 'newstore'); ?></h3>
			</td>
			<td><span class="dashicons-before dashicons-no-alt"></span></td>
			<td><span class="dashicons-before dashicons-yes"></span></td>
		</tr>
		<tr>
			<td>
				<h3><?php esc_html_e('Pricing Plans Section', 'newstore'); ?></h3>
				<p><?php esc_html_e('Home page pricing plans section to show your plans', 'newstore'); ?></p>
			</td>
			<td><span class="dashicons-before dashicons-no-alt"></span></td>
			<td><span class="dashicons-before dashicons-yes"></span><br><?php esc_html_e('(one click add, reorder)', 'newstore'); ?></td>
		</tr>
		<tr>
			<td>
				<h3><?php esc_html_e('Customizable Colors', 'newstore'); ?></h3>
				<p><?php esc_html_e('Select Colors of your choice for content on your site', 'newstore'); ?></p>
			</td>
			<td><span class="dashicons-before dashicons-yes"></span><br>(Limited)</td>
			<td><span class="dashicons-before dashicons-yes"></span></td>
		</tr>
	</tbody>
	<tfoot>
		<th></th>
		<th colspan="2">
			<?php if (!empty($this->pro_link)):?>
			<a class="button button-primary button-big" href="<?php echo esc_url($this->pro_link); ?>" target="_blank"><?php esc_html_e('Get NewStore  Pro Now', 'newstore');?></a>
			<?php endif; ?>
		</th>
	</tfoot>
</table>