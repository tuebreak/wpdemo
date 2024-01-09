<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Custom NavMenu Elementor Widget for AcademyXi.
 *
 * @since 1.0.0
 */
class Widget_Image_Before extends \Elementor\Widget_Base
{
    /**
     * Retrieve the widget name.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'image-before';
    }

    /**
     * Retrieve the widget title.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget title.
     */
    public function get_title()
    {
        return esc_html__('Image Before After', 'roofresto');
    }

    /**
     * Retrieve the widget icon.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return 'eicon-image';
    }

    /**
     * Retrieve the list of categories the widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * Note that currently Elementor supports only one category.
     * When multiple categories passed, Elementor uses the first one.
     *
     * @since 1.0.0
     * @access public
     * @return array Widget categories.
     */
    public function get_categories()
    {
        return ['oshea'];
    }

    /**
     * Register the widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls()
    {

        /*--------------------------------------------------------------
        # General
        --------------------------------------------------------------*/
        $this->start_controls_section(
            'section_general',
            [
                'label' => esc_html__('General', 'roofresto'),
            ]
        );
        $this->add_control(
            'title_before',
            [
                'label' => __( 'Image Title Before', 'roofresto' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __( 'Title', 'roofresto' ),
                'label_block' => true,
            ]
        );
        $this->add_control(
            'image_before',
            [
                'label' => esc_html__( 'Image Before', 'roofresto' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );
        $this->add_control(
            'title_after',
            [
                'label' => __( 'Image Title After', 'roofresto' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __( 'Title', 'roofresto' ),
                'label_block' => true,
            ]
        );
        $this->add_control(
            'image_after',
            [
                'label' => esc_html__( 'Image After', 'roofresto' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_title',
            [
                'label' => __('Title', 'roofresto'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'heading_color',
            [
                'label' => __('Text Color', 'roofresto'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .title_before' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .title_after' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'page_options_ex',
            [
                'label' => esc_html__( 'Settings', 'roofresto' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_before_font',
                'selector' => '{{WRAPPER}} .title_before',
                'label' => __('Title Before', 'roofresto'),
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_after_font',
                'selector' => '{{WRAPPER}} .title_after',
                'label' => __('Title After', 'roofresto'),
            ]
        );
        $this->end_controls_section();

    }

    /**
     * Render the widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $title_before = $settings['title_before'];
        $title_after = $settings['title_after'];
        ?>
        <div class="list-image-container">
            <div class="image-container">
                <div class="title-container title_before"><?= $settings['title_before'] ?></div>
                <div class="title-container title_after"><?= $settings['title_after'] ?></div>
                <img class="image-before slider-image" src="<?= $settings['image_before']['url']; ?>">
                <img class="image-after slider-image" src="<?= $settings['image_after']['url']; ?>">
            </div>
            <input
              type="range"
              min="0"
              max="100"
              value="50"
              aria-label="Percentage of before photo shown"
              class="slider"
            />
            <div class="slider-line" aria-hidden="true"></div>
            <div class="slider-button" aria-hidden="true">
                <svg class="click-left" width="11" height="14" viewBox="0 0 11 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M-3.0598e-07 7L10.5 0.937823L10.5 13.0622L-3.0598e-07 7Z" fill="white"/>
                </svg>
                <svg  class="click-right" width="10" height="13" viewBox="0 0 10 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 6.5L0.25 12.1292L0.250001 0.870834L10 6.5Z" fill="white"/>
                </svg>
            </div>
            <div class="slider-line slider-line-bottom" aria-hidden="true"></div>
        </div>
    <?php
    }
}