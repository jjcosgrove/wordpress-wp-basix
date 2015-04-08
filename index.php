<?php
/*
    Plugin Name: WP Basix
    Version: 1.0.0
    Plugin URI: http://www.wordpress.org/plugins/wp-basix
    Description: A WordPress plugin that allows users to enable/disable features by way of checkboxes.
    Author: Jonathan James Cosgrove
    Author URI: http://www.jjcosgrove.com
    License: GPLv2

    Copyright 2015 Jonathan James Cosgrove  (email: jjcosgrove.inbox@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * @package wp-basix
 * @author jjcosgrove
 * @version 1.0.0
 */

/**
 * adds a settings link under plugins in the main admin UI
 *
 * @param  array $links an array of the links to be shown
 * @return array $links the modified array of links to be shown
 */
function wpb_add_settings_link($links) { 
    $settings_link = '<a href="admin.php?page=wp-basix">Settings</a>'; 
    array_unshift($links, $settings_link); 
    return $links; 
}
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'wpb_add_settings_link');

/**
 * loads up the necessary custom scripts for WP Basix
 *
 * @param none
 * @return none
 */
function wpb_script_loader()
{
    wp_register_script('wpb-scripts', plugins_url('/js/script.js', __FILE__));
    wp_enqueue_script('wpb-scripts');
}
add_action('admin_print_scripts', 'wpb_script_loader');

/**
 * loads up the necessary custom styles for WP Basix
 *
 * @param none
 * @return none
 */
function wpb_style_loader()
{
    wp_register_style('wpb-styles', plugins_url('/css/style.css', __FILE__));
    wp_enqueue_style('wpb-styles');
}
add_action('admin_print_styles', 'wpb_style_loader');

/**
 * register a new page for WP Basix
 *
 * @param none
 * @return none
 */
function register_wp_basix_page()
{
    add_menu_page(
        'WP Basix',                 //$page_title
        'WP Basix',                 //$menu_title
        'manage_options',           //$capability
        'wp-basix',                 //$menu_slug
        'create_wp_basix_page',     //function
        null,                       //$icon_url
        null                        //$position
    );
}
add_action('admin_menu','register_wp_basix_page');

/**
 * renders the WP Basix page - outputs HTML
 *
 * @param none
 * @return none
 */
function create_wp_basix_page()
{
    ?>
        <h1 class="wpb-title">WP Basix - Settings</h1>
        <p class="wpb-description">
            Thank you for using WP Basix! I hope that you find it useful. Feel free to
            contact me with comments, feedback or suggestions.
        </p>
        <p class="wpb-contact">
            Email: <a href="mailto:jjcosgrove.inbox@gmail.com">jjcosgrove.inbox@gmail.com</a>
        </p>
        <hr>
        <?php if(isset($_GET['settings-updated'])){ ?>
            <div id="message" class="wpb-settings-updated updated">
                <p>
                    <strong><?php _e('Settings saved.') ?></strong>
                </p>
            </div>
        <?php } ?>
        <form method="post" action="options.php">
            <?php settings_fields('wp-basix-settings'); ?>
            <?php do_settings_sections('wp-basix-settings'); ?>
            <?php submit_button(); ?>
        </form>
    <?php
}

/**
 * recursively loads in additional modules from the 'modules' sub directory.
 * these are sorted before being 'required' to maintain consistent layout
 *
 * @param none
 * @return none
 */
function wpb_include_modules()
{
    $available_modules = glob(dirname(__FILE__) . '/modules/*.php');
    asort($available_modules);
    foreach($available_modules as $module) {
        require $module;
    }
}
add_action('init','wpb_include_modules');
?>