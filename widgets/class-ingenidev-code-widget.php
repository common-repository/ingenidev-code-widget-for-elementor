<?php
class Ingenidev_Code_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'Ingenidev_Code_Widget';
    }

    public function get_title() {
        return __( 'Code Widget', 'ingenidev-code-widget-elementor' );
    }

    public function get_icon() {
        return 'eicon-code';
    }

    public function get_categories() {
        return [ 'basic' ];
    }
    
    public function render() {
        $settings = $this->get_settings_for_display();

        echo '<pre><code>' . esc_html($settings['text']) . '</code></pre>';
    
    }
    
    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'ingenidev_code_widget' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'text',
            [
                'label' => __( 'Text', 'ingenidev_code_widget' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'rows' => 10,
                'default' => __( 'Default text', 'ingenidev_copy_widget' ),
            ]
        );

        $this->add_control(
            'enable_copy',
            [
                'label' => __( 'Enable Copy', 'ingenidev_code_widget' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Yes', 'ingenidev_code_widget' ),
                'label_off' => __( 'No', 'ingenidev_code_widget' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();
    }


    protected function _content_template() {
        wp_enqueue_script(
            'copy-code', 
            plugins_url('js/ingenidev_ccwe_copy_code.js',__FILE__), 
            array(), 
            '1.0.0', 
            false 
        );
    }
}