<?php

/**
 * Plugin Name: ingenidev Code Widget for Elementor
 * Plugin URI: https://ingenidev.com/code-element-widget-for-elementor/
 * Description: Simple Code Widget for Elementor.
 * Version: 1.0.1
 * Author: ingenidev
 * Author URI: https://ingenidev.com/
 * Text Domain: ingenidev-code-widget-for-elementor
 * License: GPL v2 or later
 */

if (!defined('ABSPATH'))
    exit;



function ingenidev_inject_copy_js() {
        wp_enqueue_script(
            'copy-code', 
            plugins_url('js/ingenidev_ccwe_copy_code.js', __FILE__), 
            array(), 
            '1.0.0', 
            true 
        );
        wp_enqueue_style(
            'code-widget', 
            plugins_url('css/code-widget.css', __FILE__), 
            array(), 
            '1.0.0' 
        );
    }    

function ingenidev_ccwe_register_code_widget_elementor()
{
    // Require the widget file
    require_once(__DIR__ . '/widgets/class-ingenidev-code-widget.php');
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Ingenidev_Code_Widget() );

}

add_action('elementor/init', 'ingenidev_ccwe_register_code_widget_elementor');
add_action('wp_enqueue_scripts', 'ingenidev_inject_copy_js');

register_activation_hook(__FILE__, 'ingenidev_ccwe_activate');

function ingenidev_ccwe_activate()
{
    add_option('ingenidev_ccwe_welcome_displayed', false);
}

add_action('admin_notices', 'ingenidev_ccwe_welcome_message');


function ingenidev_ccwe_welcome_message()
{
    if (!get_option('ingenidev_ccwe_welcome_displayed') && is_admin() && current_user_can('manage_options')) {
        ?>
        <div class="notice notice-success is-dismissible" id="ingenidev-welcome-notice">
        <img src="<?php echo esc_url( plugin_dir_url(__FILE__) . 'code-widget-for-elementor-icon.png' ); ?>" style="width: 32px; height: 32px; margin-right: 10px;" alt="" />
            <p><?php esc_html_e('Welcome! Thank you for installing ingenidev Code Widget for Elementor Plugin!', 'ingenidev_ccwe'); ?></p>
            <button type="button" class="notice-dismiss" id="ingenidev-dismiss-notice"></button>
        </div>
        <?php
        wp_enqueue_script(
            'dismiss-notice', 
            plugin_dir_url(__FILE__) . '/js/ingenidev_ccwe_dismiss_notice.js', 
            array('jquery'), 
            '1.0.0', 
            true 
        );
        wp_localize_script('dismiss-notice', 'ingenidev_ccwe_ajax_obj', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'action' => 'ingenidev_ccwe_dismiss_welcome_notice'
        ));
        update_option('ingenidev_ccwe_welcome_displayed', true);
    }
}


add_action('wp_ajax_ingenidev_ccwe_dismiss_welcome_notice', 'ingenidev_ccwe_dismiss_welcome_notice');

function ingenidev_ccwe_dismiss_welcome_notice()
{
    update_option('ingenidev_ccwe_welcome_displayed', true);
    wp_die();
}

add_action('wp_dashboard_setup', 'ingenidev_ccwe_custom_dashboard_widgets');

function ingenidev_ccwe_custom_dashboard_widgets()
{
    global $wp_meta_boxes;
    wp_add_dashboard_widget('ingenidev-welcome-widget', 'ingenidev, Code Widget for Elementor Plugin', 'ingenidev_ccwe_custom_dashboard_help');
}

function ingenidev_ccwe_custom_dashboard_help()
{
    ?>
    <p>Thank you for installing our Plugin. This Plugin is specific to Elementor. Should you encounter any issues, please do not hesitate to contact us.</p>
    <?php
}

register_uninstall_hook(__FILE__, 'ingenidev_ccwe_uninstall');

function ingenidev_ccwe_uninstall()
{
    delete_option('ingenidev_ccwe_welcome_displayed');
}

