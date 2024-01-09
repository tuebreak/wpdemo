<?php

/**
 * Valorwide Elementor Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */



class TestimonialsList extends \Elementor\Widget_Base
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
		return 'Testimonials List';
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
		return esc_html__('Testimonials List', 'roof_resto');
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
		$Service_cate_list = [];

		$terms = get_terms(array(
			'taxonomy'   => 'category-testimonial',
			'hide_empty' => false,
		));
		foreach ($terms as $cate) {
			$Service_cate_list[$cate->term_id] = $cate->name;
		}
		$this->add_control(
			'select_cate',
			[
				'label' => __('Select Testimonials form', 'roof_resto'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => $Service_cate_list,
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
		$this->add_control(
			'posts_per_page',
			[
				'type' => \Elementor\Controls_Manager::NUMBER,
				'label' => esc_html__('Posts Per Page', 'roof_resto'),
				'defaut' => 3,
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
		$args = array(
			'post_type' => 'testimonials',
			'post_status' => 'publish',
			'tax_query' => array(
				array(
					'taxonomy' => 'category-testimonial',
					'field' => 'term_id',
					'terms' => $settings['select_cate'],
				)
			),
			'orderby' => $settings['orderby'],
			'order'     => $settings['order'],
			'posts_per_page' => $settings['posts_per_page'],
		);
		$the_query = new \WP_Query($args);
?>
		<section class="custom-testimonials">
			<h3 class="title"><?= $settings['heading_section'] ?></h3>
			<div class="container">
				<div class="list-testimonials">
					<?php if ($the_query->have_posts()) {
						while ($the_query->have_posts()) : $the_query->the_post();
					?>
							<div class="testimonials-item">
								<div class="icon-testimonials">
									<img src="<?= bloginfo('stylesheet_directory'); ?>/images/icon_test.svg" alt="icon">
								</div>
								<div class="content">
									<?php the_content(); ?>
								</div>
								<div class="bottom-content">
									<p><?= get_the_title() ?></p>
								</div>
							</div>
					<?php
						endwhile;
					}
					?>
				</div>
			</div>

		</section>
		<script>
			jQuery(document).ready(function($) {
				$('.custom-testimonials .list-testimonials').slick({
					infinite: true,
					slidesToShow: 3,
					arrows: false,
					autoplay: true,
					slidesToScroll: 1,
					responsive: [
						{
							breakpoint: 1024,
							settings: {
								slidesToShow: 2,
								slidesToScroll: 1,
							}
						},
						{
							breakpoint: 600,
							settings: {
								slidesToShow: 1,
								slidesToScroll: 1
							}
						}
					]
				});
			});
		</script>
<?php
	}
}
