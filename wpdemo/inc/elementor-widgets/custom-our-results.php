<?php

class CustomOurResults extends \Elementor\Widget_Base
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
		return 'custom_our_results';
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
		return esc_html__('Custom Our Results', 'roof_resto');
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
				'label' => esc_html__('Custom Our Results', 'roof_resto'),
			]
		);
		$this->add_control(
			'heading_section',
			[
				'label' => esc_html__('Heading Section', 'roof_resto'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__('Enter your Heading Section', 'roof_resto'),
				'label_block' => true
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
?>
		<section class="custom_our_results">
			<h3 class="title"><?= $settings['heading_section'] ?></h3>
				<div class="list_images">
						<?php if (have_rows('gallery_services')) : ?>
							<?php while (have_rows('gallery_services')) : the_row();
									$images_before = get_sub_field('before_image', get_the_ID());
									$images_after = get_sub_field('after_image', get_the_ID());
									$caption_image = get_sub_field('caption_images', get_the_ID());
							?>
								<?php if(($images_before != NULL) && ($images_before != NULL)) : ?>
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
										<?php if($caption_image) : ?>
											<div class="caption_image">
												<p><?= $caption_image ?></p>
											</div>
										<?php endif ?>
									</div>
								<?php endif ?>
							<?php endwhile; ?>	
						<?php endif ?>	
				</div>
		</section>
		<script>
			jQuery(document).ready(function($) {
				$('.custom_our_results .list_images').slick({
					infinite: false,
					slidesToScroll: 1,
					slidesToShow: 1,
					arrows: false,
					autoplay: true,
					autoplaySpeed: 5000,
					variableWidth: true,
					responsive: [{
							breakpoint: 1024,
							settings: {
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
