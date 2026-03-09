<?php

if (!defined('ABSPATH')) exit;

function pixGetElementorTransformControls($element, $hide_in_top = false) {
    $options = [
        'none' 					=> 'Disabled',
        'pix-scale-in-sm' 	=> 'Small scale',
        'pix-scale-in' 		=> 'Normal scale',
        'pix-scale-in-lg' 	=> 'Large scale'
    ];
    if(PixfortCore::instance()->getThemeParam('advanced_transforms')) {
        $options['pix-advanced-transform'] = 'Advanced Transform';
    }
    $data = [
        'label' => __('Scroll effect', 'pixfort-core'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'options' => $options,
        'frontend_available' => true,
        'default' => 'none',
        // 'description' => 'Scroll effect will be applied in the live page (outside Elementor builder)',
    ];
    if($hide_in_top) {
        $data['hide_in_top'] = true;
    }
    $element->add_control(
        'pix_scale_in',
        $data
    );
    $element->add_control(
        'pix_scroll_effects_notice',
        [
            'type' => \Elementor\Controls_Manager::NOTICE,
            'notice_type' => 'warning',
            'dismissible' => true,
            'heading' => esc_html__( 'Scale Effects', 'textdomain' ),
            'content' => esc_html__( 'Scale effects are applied in the live page (outside Elementor builder).', 'textdomain' ),
            'condition' => [
                'pix_scale_in' => ['pix-scale-in-sm', 'pix-scale-in', 'pix-scale-in-lg'],
            ],
        ]
    );

    /*
    * Start Transform Controls
    */
    $element->add_control(
        'advanced_transform_start_popover',
        [
            'label' => esc_html__( 'Start', 'textdomain' ),
            'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
            'label_off' => esc_html__( 'Default', 'textdomain' ),
            'label_on' => esc_html__( 'Custom', 'textdomain' ),
            'return_value' => 'yes',
            'default' => '',
            'frontend_available' => true,
            'condition' => [
                'pix_scale_in' => 'pix-advanced-transform',
            ],
        ]
    );

    $element->start_popover();

    $element->add_control(
        'pix_transform_start_opacity',
        [
            'label' => __('Opacity', 'pixfort-core'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'default' => [
                'size' => 1,
                'unit' => 'x',
            ],
            'size_units' => ['x'],
            'range' => [
                'x' => [
                    'min' => 0,
                    'max' => 1,
                    'step' => 0.01,
                ],
            ],
            'frontend_available' => true,
            'render_type' => 'none',
            'condition' => [
                'pix_scale_in' => 'pix-advanced-transform',
                'advanced_transform_start_popover' => 'yes',
            ],
        ]
    );

    $element->add_control(
        'pix_transform_start_scale',
        [
            'label' => __('Scale', 'pixfort-core'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'default' => [
                'size' => 1,
                'unit' => 'x',
            ],
            'size_units' => ['x'],
            'range' => [
                'x' => [
                    'min' => 0,
                    'max' => 2,
                    'step' => 0.01,
                ],
            ],
            'separator' => 'before',
            'frontend_available' => true,
            'render_type' => 'none',
            'condition' => [
                'pix_scale_in' => 'pix-advanced-transform',
                'advanced_transform_start_popover' => 'yes',
            ],
        ]
    );
    // 2d or 3d rotate
    $element->add_control(
        'pix_transform_start_rotate_type',
        [
            'label' => __('Rotate type', 'pixfort-core'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
                '2d' => [
                    'title' => esc_html__( '2D', 'textdomain' ),
                    'icon' => 'pix-rotate-2d',
                ],
                '3d' => [
                    'title' => esc_html__( '3D', 'textdomain' ),
                    'icon' => 'pix-rotate-3d',
                ],
            ],
            'default' => '2d',
            'separator' => 'before',
            'frontend_available' => true,
            'render_type' => 'none',
            'condition' => [
                'pix_scale_in' => 'pix-advanced-transform',
                'advanced_transform_start_popover' => 'yes',
            ],
        ]
    );
    // 2D Rotate control
    $element->add_control(
        'pix_transform_start_rotate_2d',
        [
            'label' => __('Rotate', 'pixfort-core'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'default' => [
                'size' => 0,
                'unit' => 'deg',
            ],
            'size_units' => ['deg'],
            'range' => [
                'deg' => [
                    'min' => -360,
                    'max' => 360,
                ],
            ],
            'condition' => [
                'pix_transform_start_rotate_type' => '2d',
                'pix_scale_in' => 'pix-advanced-transform',
                'advanced_transform_start_popover' => 'yes',
            ],
            'frontend_available' => true,
            'render_type' => 'none',
        ]
    );

    // 3D Rotate control x, y, z
    $element->add_control(
        'pix_transform_start_rotate_3d_x',
        [
            'label' => __('X', 'pixfort-core'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'default' => [
                'size' => 0,
                'unit' => 'deg',
            ],
            'size_units' => ['deg'],
            'range' => [
                'deg' => [
                    'min' => -360,
                    'max' => 360,
                ],
            ],
            'condition' => [
                'pix_transform_start_rotate_type' => '3d',
                'pix_scale_in' => 'pix-advanced-transform',
                'advanced_transform_start_popover' => 'yes',
            ],
            'frontend_available' => true,
            'render_type' => 'none',
        ]
    );

    $element->add_control(
        'pix_transform_start_rotate_3d_y',
        [
            'label' => __('Y', 'pixfort-core'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'default' => [
                'size' => 0,
                'unit' => 'deg',
            ],
            'size_units' => ['deg'],
            'range' => [
                'deg' => [
                    'min' => -360,
                    'max' => 360,
                ],
            ],
            'condition' => [
                'pix_transform_start_rotate_type' => '3d',
                'pix_scale_in' => 'pix-advanced-transform',
                'advanced_transform_start_popover' => 'yes',
            ],
            'frontend_available' => true,
            'render_type' => 'none',
        ]
    );
    $element->add_control(
        'pix_transform_start_rotate_3d_z',
        [
            'label' => __('Z', 'pixfort-core'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'default' => [
                'size' => 0,
                'unit' => 'deg',
            ],
            'size_units' => ['deg'],
            'range' => [
                'deg' => [
                    'min' => -360,
                    'max' => 360,
                ],
            ],
            'condition' => [
                'pix_transform_start_rotate_type' => '3d',
                'pix_scale_in' => 'pix-advanced-transform',
                'advanced_transform_start_popover' => 'yes',
            ],
            'frontend_available' => true,
            'render_type' => 'none',
        ]
    );

    // offset x and y number controls
    $element->add_control(
        'pix_transform_start_offset_x',
        [
            'label' => __('Offset X', 'pixfort-core'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 0,
            'frontend_available' => true,
            'render_type' => 'none',
            'condition' => [
                'pix_scale_in' => 'pix-advanced-transform',
                'advanced_transform_start_popover' => 'yes',
            ],
        ]
    );
    $element->add_control(
        'pix_transform_start_offset_y',
        [
            'label' => __('Offset Y', 'pixfort-core'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 0,
            'frontend_available' => true,
            'render_type' => 'none',
            'separator' => 'after',
            'condition' => [
                'pix_scale_in' => 'pix-advanced-transform',
                'advanced_transform_start_popover' => 'yes',
            ],
        ]
    );

    // skew X number control 
    $element->add_control(
        'pix_transform_start_skew_x',
        [
            'label' => __('Skew X', 'pixfort-core'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 0,
            'separator' => 'before',
            'frontend_available' => true,
            'render_type' => 'none',
            'condition' => [
                'pix_scale_in' => 'pix-advanced-transform',
                'advanced_transform_start_popover' => 'yes',
            ],
        ]
    );
    // skew Y number control
    $element->add_control(
        'pix_transform_start_skew_y',
        [
            'label' => __('Skew Y', 'pixfort-core'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 0,
            'frontend_available' => true,
            'render_type' => 'none',
            'condition' => [
                'pix_scale_in' => 'pix-advanced-transform',
                'advanced_transform_start_popover' => 'yes',
            ],
        ]
    );

    
    

    $element->end_popover();

    /*
    * End Transform Controls
    */
    $element->add_control(
        'advanced_transform_end_popover',
        [
            'label' => esc_html__( 'End', 'textdomain' ),
            'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
            'label_off' => esc_html__( 'Default', 'textdomain' ),
            'label_on' => esc_html__( 'Custom', 'textdomain' ),
            'return_value' => 'yes',
            'default' => '',
            'frontend_available' => true,
            'condition' => [
                'pix_scale_in' => 'pix-advanced-transform',
            ],
        ]
    );

    $element->start_popover();

    $element->add_control(
        'pix_transform_end_opacity',
        [
            'label' => __('Opacity', 'pixfort-core'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'default' => [
                'size' => 1,
                'unit' => 'x',
            ],
            'size_units' => ['x'],
            'range' => [
                'x' => [
                    'min' => 0,
                    'max' => 1,
                    'step' => 0.01,
                ],
            ],
            'frontend_available' => true,
            'render_type' => 'none',
            'condition' => [
                'pix_scale_in' => 'pix-advanced-transform',
                'advanced_transform_end_popover' => 'yes',
            ],
        ]
    );

    $element->add_control(
        'pix_transform_end_scale',
        [
            'label' => __('Scale', 'pixfort-core'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'default' => [
                'size' => 1,
                'unit' => 'x',
            ],
            'size_units' => ['x'],
            'range' => [
                'x' => [
                    'min' => 0,
                    'max' => 2,
                    'step' => 0.01,
                ],
            ],
            'separator' => 'before',
            'frontend_available' => true,
            'render_type' => 'none',
            'condition' => [
                'pix_scale_in' => 'pix-advanced-transform',
                'advanced_transform_end_popover' => 'yes',
            ],
        ]
    );
    // 2d or 3d rotate
    $element->add_control(
        'pix_transform_end_rotate_type',
        [
            'label' => __('Rotate type', 'pixfort-core'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
                '2d' => [
                    'title' => esc_html__( '2D', 'textdomain' ),
                    'icon' => 'pix-rotate-2d',
                ],
                '3d' => [
                    'title' => esc_html__( '3D', 'textdomain' ),
                    'icon' => 'pix-rotate-3d',
                ],
            ],
            'default' => '2d',
            'separator' => 'before',
            'frontend_available' => true,
            'render_type' => 'none',
            'condition' => [
                'pix_scale_in' => 'pix-advanced-transform',
                'advanced_transform_end_popover' => 'yes',
            ],
        ]
    );
    // 2D Rotate control
    $element->add_control(
        'pix_transform_end_rotate_2d',
        [
            'label' => __('Rotate', 'pixfort-core'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'default' => [
                'size' => 0,
                'unit' => 'deg',
            ],
            'size_units' => ['deg'],
            'range' => [
                'deg' => [
                    'min' => -360,
                    'max' => 360,
                ],
            ],
            'condition' => [
                'pix_transform_end_rotate_type' => '2d',
                'pix_scale_in' => 'pix-advanced-transform',
                'advanced_transform_end_popover' => 'yes',
            ],
            'frontend_available' => true,
            'render_type' => 'none',
        ]
    );

    // 3D Rotate control x, y, z
    $element->add_control(
        'pix_transform_end_rotate_3d_x',
        [
            'label' => __('X', 'pixfort-core'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'default' => [
                'size' => 0,
                'unit' => 'deg',
            ],
            'size_units' => ['deg'],
            'range' => [
                'deg' => [
                    'min' => -360,
                    'max' => 360,
                ],
            ],
            'condition' => [
                'pix_transform_end_rotate_type' => '3d',
                'pix_scale_in' => 'pix-advanced-transform',
                'advanced_transform_end_popover' => 'yes',
            ],
            'frontend_available' => true,
            'render_type' => 'none',
        ]
    );

    $element->add_control(
        'pix_transform_end_rotate_3d_y',
        [
            'label' => __('Y', 'pixfort-core'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'default' => [
                'size' => 0,
                'unit' => 'deg',
            ],
            'size_units' => ['deg'],
            'range' => [
                'deg' => [
                    'min' => -360,
                    'max' => 360,
                ],
            ],
            'condition' => [
                'pix_transform_end_rotate_type' => '3d',
                'pix_scale_in' => 'pix-advanced-transform',
                'advanced_transform_end_popover' => 'yes',
            ],
            'frontend_available' => true,
            'render_type' => 'none',
        ]
    );
    $element->add_control(
        'pix_transform_end_rotate_3d_z',
        [
            'label' => __('Z', 'pixfort-core'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'default' => [
                'size' => 0,
                'unit' => 'deg',
            ],
            'size_units' => ['deg'],
            'range' => [
                'deg' => [
                    'min' => -360,
                    'max' => 360,
                ],
            ],
            'condition' => [
                'pix_transform_end_rotate_type' => '3d',
                'pix_scale_in' => 'pix-advanced-transform',
                'advanced_transform_end_popover' => 'yes',
            ],
            'frontend_available' => true,
            'render_type' => 'none',
        ]
    );

    // offset x and y number controls
    $element->add_control(
        'pix_transform_end_offset_x',
        [
            'label' => __('Offset X', 'pixfort-core'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 0,
            'frontend_available' => true,
            'render_type' => 'none',
            'condition' => [
                'pix_scale_in' => 'pix-advanced-transform',
                'advanced_transform_end_popover' => 'yes',
            ],
        ]
    );
    $element->add_control(
        'pix_transform_end_offset_y',
        [
            'label' => __('Offset Y', 'pixfort-core'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 0,
            'frontend_available' => true,
            'render_type' => 'none',
            'separator' => 'after',
            'condition' => [
                'pix_scale_in' => 'pix-advanced-transform',
                'advanced_transform_end_popover' => 'yes',
            ],
        ]
    );

    // skew X number control 
    $element->add_control(
        'pix_transform_end_skew_x',
        [
            'label' => __('Skew X', 'pixfort-core'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 0,
            'separator' => 'before',
            'frontend_available' => true,
            'render_type' => 'none',
            'condition' => [
                'pix_scale_in' => 'pix-advanced-transform',
                'advanced_transform_end_popover' => 'yes',
            ],
        ]
    );
    // skew Y number control
    $element->add_control(
        'pix_transform_end_skew_y',
        [
            'label' => __('Skew Y', 'pixfort-core'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 0,
            'frontend_available' => true,
            'render_type' => 'none',
            'condition' => [
                'pix_scale_in' => 'pix-advanced-transform',
                'advanced_transform_end_popover' => 'yes',
            ],
        ]
    );

    

    $element->end_popover();
}