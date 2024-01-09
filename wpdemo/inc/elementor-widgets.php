<?php

/**
 * Elementor Additions
 */
if ( class_exists( '\Elementor\Plugin' ) ) :

	// add setting for page
	function add_elementor_page_settings_controls( \Elementor\Core\Base\Document $document ) {
		$document->add_control(
			'header_transparent',
			[
				'label' => __( 'Header Transparent', 'elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'elementor' ),
				'label_on' => __( 'On', 'elementor' ),
				'selectors' => [
					'{{WRAPPER}} #masthead' => 'position: absolute;top: 0;left: 0;width: 100%;',
				],
				'separator' => 'before',
			]
		);
		$document->add_control(
			'menu_color',
			[
				'label' => __( 'Menu Color', 'elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .hfe-nav-menu__layout-horizontal .hfe-nav-menu>li:not(.btn-link) a.hfe-menu-item' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .hfe-nav-menu-icon svg' => 'fill: {{VALUE}}',
				],
				'condition' => [
					'header_transparent' => 'yes',
				],
			]
		);
		$document->add_control(
			'menu_color_hover',
			[
				'label' => __( 'Menu Color Hover', 'elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .hfe-nav-menu__layout-horizontal .hfe-nav-menu>li:not(.btn-link) a.hfe-menu-item:hover' => 'color: {{VALUE}} !important;',
				],
				'condition' => [
					'header_transparent' => 'yes',
				],

			]
		);
		$document->add_control(
			'menu_mobile_color',
			[
				'label' => __( 'Menu Color Mobile', 'elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'(tablet){{WRAPPER}} .hfe-nav-menu__layout-horizontal .hfe-nav-menu>li:not(.btn-link) a.hfe-menu-item' => 'color: {{VALUE}} !important;',
				],
				'condition' => [
					'header_transparent' => 'yes',
				],
			]
		);
	}
	add_action( 'elementor/element/wp-page/document_settings/before_section_end', 'add_elementor_page_settings_controls' );

	/**
	 * Register Elementor category to this theme
	 * 
	 * @param \Elementor\Elements_Manager $elements_manager Elements manager instance.
	 */
	function oshea_register_elementor_categories( $elements_manager ) {
		$elements_manager->add_category(
			'oshea',
			[
				'title' => esc_html__( "O'Shea Elementor", 'receive-sms' ),
				'icon'  => 'eicon-font',
			]
		);
	}
	add_action( 'elementor/elements/categories_registered', 'oshea_register_elementor_categories' );

	/**
	 * Register Elementor widgets
	 */
	function oshea_register_elementor_widgets() {
		// Include the required files
		$elementor_widget_dir   = get_stylesheet_directory() . '/inc/elementor-widgets/';
		$elementor_widget_files = scandir( $elementor_widget_dir );
		foreach( $elementor_widget_files as $file ) {
			$file_path = trailingslashit( $elementor_widget_dir ) . $file;
			if ( is_file( $file_path ) ) {
				require_once $file_path;
			}
		}
		// Register widgets
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widget_Blog_List() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widget_Image_Before() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new CustomOurResults() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new TestimonialsList() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Postcode_Location() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Gallery_Services());
	}
	add_action( 'elementor/widgets/widgets_registered', 'oshea_register_elementor_widgets' );

endif; // End Elementor Additions
