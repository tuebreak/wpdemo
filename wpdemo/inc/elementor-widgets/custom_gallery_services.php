<?php

class Gallery_Services extends \Elementor\Widget_Base
{

	/**
	 * Get widget name.
	 * Retrieve button widget name.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name()
	{
		return 'custom_gallery_services';
	}

	/**
	 * Get widget title.
	 * Retrieve button widget title.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title()
	{
		return esc_html__('Gallery_Services', 'roof_resto');
	}

	/**
	 * Get widget icon.
	 * Retrieve button widget icon.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon()
	{
		return 'eicon-favorite';
	}

	/**
	 * Get widget categories.
	 * Retrieve the list of categories the button widget belongs to.
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since  2.0.0
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories()
	{
		return ['roof_resto-category'];
	}

	/**
	 * Register button widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since  1.0.0
	 * @access protected
	 */
	protected function register_controls()
	{
		$this->start_controls_section(
			'custom_our_results',
			[
				'label' => esc_html__('Gallery_Services', 'roof_resto'),
			]
		);
		$this->add_control(
			'orderby',
			[
				'label' => esc_html__('Orderby', 'roof_resto'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'date' => esc_html__('Date', 'roof_resto'),
					'name' => esc_html__('Name', 'roof_resto'),
				],
				'defaut' => esc_html__('Date', 'roof_resto')
			]
		);
		$this->add_control(
			'order',
			[
				'label' => esc_html__('Order', 'roof_resto'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'desc' => esc_html__('DESC', 'roof_resto'),
					'asc' => esc_html__('ASC', 'roof_resto'),
				],
				'defaut' => esc_html__('ASC', 'roof_resto')
			]
		);
		$this->end_controls_section();
	}

	/**
	 * Render button widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since  1.0.0
	 * @access protected
	 */
	protected function render()
	{
		$settings = $this->get_settings_for_display();
		$dataPost = get_posts(
			array(
				'post_type' => 'services',
				'post_status' => 'publish',
				'posts_per_page' => -1,
				'orderby' => $settings['orderby'],
				'order'     => $settings['order']
			)
		);
		//var_dump($dataPost);
?>
		<?php if ($dataPost) : ?>
			<?php foreach ($dataPost as $item) : ?>
				<?php if (have_rows('gallery_services', $item->ID)) :  ?>
					<h4 class="title-gallery"> <?= $item->post_title ?> </h4>
					<section class="custom_our_results gallery-services">
						<div class="list_images">
							<?php while (have_rows('gallery_services', $item->ID)) : the_row();
								$images_before = get_sub_field('before_image', $item->ID);
								$images_after = get_sub_field('after_image', $item->ID);
								$caption_image = get_sub_field('caption_images', $item->ID);

							?>
								<?php if (($images_before != NULL) && ($images_before != NULL)) : ?>
									<div class="image_our_results">
										<div class="content_box">
											<div class="image_before">
												<span class="title-before"><?= __('Before') ?></span>
												<img src="<?= $images_before['url'] ?>" alt="Image_before">
											</div>
											<div class="image_after">
												<span class="title-after"><?= __('After') ?></span>
												<img src="<?= $images_after['url'] ?>" alt="Image_after">
											</div>
										</div>
										<?php if ($caption_image) : ?>
											<div class="caption_image">
												<h4><?= __('Service/project description') ?></h4>
												<p><?= $caption_image ?></p>
											</div>
										<?php endif ?>
									</div>
								<?php endif ?>
							<?php endwhile; ?>
						</div>
					</section>
				<?php endif ?>
			<?php endforeach; ?>
		<?php endif ?>
		<script>
			jQuery(document).ready(function($) {
				$('.custom_our_results.gallery-services .list_images').slick({
					infinite: false,
					slidesToScroll: 1,
					slidesToShow: 1,
					arrows: true,
					autoplay: true,
					autoplaySpeed: 5000,
					variableWidth: false,
					responsive: [{
							breakpoint: 767,
							settings: {
								arrows: false,
								variableWidth: false,
							}
						}

					]
				})
			})
		</script>
<?php
	}
}
