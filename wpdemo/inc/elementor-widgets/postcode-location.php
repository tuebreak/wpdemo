<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Custom Locator Elementor Widget for AcademyXi.
 *
 * @since 1.0.0
 */
class Postcode_Location extends \Elementor\Widget_Base
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
        return 'locator';
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
        return esc_html__('Locator', 'roofresto');
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
        return 'eicon-wordpress';
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

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'roofresto'),
            ]
        );
        $this->add_control(
            'title', [
                'label' => esc_html__('Title', 'roofresto'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('Enter your title', 'roofresto'),
            ]
        );
        $this->add_control(
            'desc', [
                'label' => esc_html__('Button Text Description', 'roofresto'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => esc_html__('Enter your description', 'roofresto'),
            ]
        );
        $this->add_control(
            'placeholder', [
                'label' => esc_html__('Placeholder', 'roofresto'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('Enter your placeholder', 'roofresto'),
            ]
        );
        $this->add_control(
            'submit', [
                'label' => esc_html__('Submit', 'roofresto'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('Enter your submit', 'roofresto'),
            ]
        );
        $this->add_control(
            'result_yes', [
                'label' => esc_html__('Result Yes', 'roofresto'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => esc_html__('Enter your result yes', 'roofresto'),
            ]
        );
        $this->add_control(
            'result_no', [
                'label' => esc_html__('Result No', 'roofresto'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => esc_html__('Enter your result no', 'roofresto'),
            ]
        );
        $this->add_control(
            'postcodes', [
                'label' => esc_html__('Postcodes', 'roofresto'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => esc_html__('Enter your Postcodes', 'roofresto'),
            ]
        );
        $this->end_controls_section();

    }

    /**
     * Render the widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function render()
    {
        $atts = $this->get_settings_for_display();
        $css_class = array('roofresto-locator');
        ?>
        <div class="<?= esc_attr(implode(' ', $css_class)); ?>">
            <?php if ($atts['title']): ?>
                <h4 class="title"><?= wp_specialchars_decode($atts['title']); ?></h4>
            <?php endif; ?>
            <?php if ($atts['desc']): ?>
                <div class="desc"><p><?= wp_specialchars_decode($atts['desc']); ?></p></div>
            <?php endif; ?>
            <?php
            $postcodesNew = explode("\n", str_replace("\r", "", $atts['postcodes']));
            foreach ($postcodesNew as $key => $value) {
            	$postcodesNew[$value] = $value;
            	unset($postcodesNew[$key]);
            }
            ?>
            <form class="service-finder-form" action="" autocomplete="off"
                  data-postcodes="<?= esc_attr(json_encode($postcodesNew)); ?>">
                <input class="service-finder-input" type="text"
                       placeholder="<?= !empty($atts['placeholder']) ? esc_attr($atts['placeholder']) : esc_attr__('You\'re postcode...', 'roofresto'); ?>">
                <input class="service-finder-go" type="submit"
                       value="<?= !empty($atts['submit']) ? esc_attr($atts['submit']) : esc_attr__('locate', 'roofresto'); ?>">
            </form>
            <div class="service-finder-result service-finder-result-yes">
                <?= !empty($atts['result_yes']) ? wp_specialchars_decode($atts['result_yes']) : esc_html__('Yes, O\'Shea can assist you.', 'roofresto'); ?>
            </div>
            <div class="service-finder-result service-finder-result-no">
                <?= !empty($atts['result_no']) ? wp_specialchars_decode($atts['result_no']) : esc_html__('No, unfortunately you are out of our reach.', 'roofresto'); ?>
            </div>
        </div>
        <?php
    }
}