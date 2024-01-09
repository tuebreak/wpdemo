<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Custom NavMenu Elementor Widget for AcademyXi.
 *
 * @since 1.0.0
 */
class Widget_Blog_List extends \Elementor\Widget_Base
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
        return 'blog-list';
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
        return esc_html__('Blog List', 'minnippi');
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
        return 'eicon-post-list';
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
            'number_product',
            [
                'label' => esc_html__( 'Number post', 'roofresto' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 20,
                'step' => 1,
                'default' => 6,
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
        $number_product = $settings[ 'number_product' ];
        ?>
        <input type="hidden" class="number-product" name="" value="<?= $number_product ?>">
        <div class="st-list-blog">
            <div class="dropdow-option">
                <ul class="show-cat show-cate-navigation">
                    <li class='button active' custom-value=''><?= __( 'All', 'roofresto' ) ?></li>
                    <?php $args = [
                        'hide_empty' => 0,
                        'taxonomy'  => 'category',
                        'post_type' => 'post',
                        'post_status'    => 'publish',
                        'orderby'   => 'name',
                        'order'     => 'ASC'
                    ]; 
                    $cates = get_categories( $args );
                    ?>
                    <?php foreach ($cates as $cate): ?>
                    <?php 
                        $args_posts = array(
                            'category'     => $cate->term_id,
                            'post_status'  => 'publish',
                            'numberposts'  => 1,
                        );
                        $posts_in_category = get_posts($args_posts);
                    ?>
                    <?php if ($posts_in_category): ?>
                        <li class="button" custom-value="<?php echo $cate->slug; ?>">
                            <?php echo $cate->name ?>
                        </li>
                    <?php endif ?>
                    <?php endforeach ?>
                </ul>
            </div>
            <div class="post-type-navigation"></div>
        </div>
        <script type="text/javascript">
            jQuery(document).ready(function () {
                var url = '<?= admin_url("admin-ajax.php") ?>';
                var element = jQuery('.st-list-blog .post-type-navigation');
                var number_product = jQuery('input.number-product').val();
                var data = {
                    'action': 'pageBlogNavi',
                    'number_product': number_product
                };
                jQuery.post( url, data, function( json ) {
                    if ( json ) {
                        element.html(json.data.html);
                    }
                });
                jQuery('.dropdow-option .show-cate-navigation li').click(function(e) {
                    e.preventDefault();
                    var option = jQuery(this).attr('custom-value');
                    jQuery('.dropdow-option .show-cate-navigation li').removeClass('active');
                    jQuery(this).addClass('active');
                    var data = {
                        'action': 'pageBlogNavi',
                        'show': option,
                        'number_product': number_product
                    };
                    jQuery.post( url, data, function( json ) {
                        if ( json ) {
                            element.html(json.data.html);
                        }
                    });
                });
                jQuery(document).on('click', '.page-numbers', function(e) {
                    e.preventDefault();
                    var option = jQuery('.dropdow-option .show-cate-navigation li.active').attr('custom-value');
                    var curen_page = jQuery(this).attr('data-paged');
                    var load = parseInt(curen_page);
                    var data = {
                        'action': 'pageBlogNavi',
                        'show': option,
                        'load': load,
                        'number_product': number_product
                    };
                    jQuery.post( url, data, function( json ) {
                        if ( json ) {
                            element.html(json.data.html);
                        }
                    });
                    jQuery('.page-numbers').removeClass('active');
                    jQuery(this).addClass('active');
                    jQuery('html, body').animate({
                        scrollTop: jQuery('.st-list-blog').offset().top
                    }, 0);
                });
            });
        </script>
    <?php
    }
}