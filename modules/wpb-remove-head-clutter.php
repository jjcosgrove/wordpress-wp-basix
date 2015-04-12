<?php
/**
 * @package wp-basix
 * @author jjcosgrove
 * @version 1.0.0
 */

/**
 * sets up the settings sections/fields for this module and registers them.
 * titles are 'null' since its overly cluttered with them and not required.
 *
 * @param none
 * @return none
 */
function wpb_remove_head_clutter_init()
{
    add_settings_section(
        'wpb-remove-head-clutter-settings',         //$id
        null,                                       //$title
        'wpb_remove_head_clutter_settings_render',  //$callback
        'wp-basix-settings'                         //$page
    );
    add_settings_field(
        'wpb-remove-head-clutter-enable-field',     //$id
        null,                                       //$title
        'wpb_remove_head_clutter_checkbox_render',  //$callback
        'wp-basix-settings',                        //$page
        'wpb-remove-head-clutter-settings',         //section
        null                                        //$args
    );
    register_setting(
        'wp-basix-settings',                        //$option_group
        'wpb-remove-head-clutter-enable-field',     //$option_name
        null                                        //sanitize_callback
    );
}
add_action('admin_menu','wpb_remove_head_clutter_init');

/**
 * displays the main title for the module
 *
 * @param none
 * @return none
 */
function wpb_remove_head_clutter_settings_render()
{
    ?>
        <h2 class="wpb-module-title">Remove &lt;HEAD&gt; Clutter</h2>
    <?php
}

/**
 * renders the module fields for user interaction, under the settings
 * for this particular module
 *
 * @param none
 * @return none
 */
function wpb_remove_head_clutter_checkbox_render()
{
    ?>
        <table class="wpb-module-settings">
            <tr>
                <td>
                    <p class="wpb-module-description">
                        Removes lots of items from the &lt;HEAD&gt; tags on the front-end.
                    </p>
                    <button class="wpb-module-more-info">More Info</button>
                    <ul class="wpb-module-more-info-details wpb-list">
                        <li>Removes Feed Links</li>
                        <li>Removes Rel Links</li>
                        <li>Removes Version Queries: ?ver=</li>
                        <li>Removes WP Generator Info</li>
                        <li>Removes WP Shortlinks</li>
                        <li>And more...</li>
                    </ul>
                </td>
                <td class="wpb-module-fields-container">
                    <?php
                        $checked_status = (get_option('wpb-remove-head-clutter-enable-field') === "on" ? "checked=\"checked\"" : "");
                    ?>
                    <input type="checkbox" name="wpb-remove-head-clutter-enable-field" <?php echo $checked_status ?>>
                </td>
            </tr>
        </table>
        <hr>
    <?php
}

/**
 * checks if the user enabled this module and if so, performs the necessary
 * actions to enable it within the UI/back-end
 *
 * @param none
 * @return none
 */
function wpb_remove_head_clutter()
{
    if(get_option('wpb-remove-head-clutter-enable-field') === 'on') {
        remove_action('wp_head', 'adjacent_posts_rel_link', 10);
        remove_action('wp_head', 'feed_links', 2);
        remove_action('wp_head', 'feed_links_extra', 3);
        remove_action('wp_head', 'index_rel_link', 10);
        remove_action('wp_head', 'parent_post_rel_link', 10);
        remove_action('wp_head', 'rel_canonical', 10);  
        remove_action('wp_head', 'rsd_link', 10);
        remove_action('wp_head', 'start_post_rel_link', 10);
        remove_action('wp_head', 'wlwmanifest_link', 10);
        remove_action('wp_head', 'wp_generator', 10);
        remove_action('wp_head', 'wp_shortlink_wp_head', 10);

        add_action('wp_print_scripts', 'wpb_scripts_remove_version_info', 10);
        add_action('wp_print_footer_scripts', 'wpb_scripts_remove_version_info', 10);
        add_action('admin_print_styles', 'wpb_styles_remove_version_info', 10);
        add_action('wp_print_styles', 'wpb_styles_remove_version_info', 10);
    }
}
add_action('wp_head','wpb_remove_head_clutter',1);

/**
 * scans through all scripts and removes the version info
 *
 * @param none
 * @return none
 */
function wpb_scripts_remove_version_info()
{
    global $wp_scripts;
    if (!is_a($wp_scripts, 'WP_Scripts' )) {
        return;
    }
    foreach ($wp_scripts->registered as $handle => $script) {
        $wp_scripts->registered[$handle]->ver = null;
    }
}

/**
 * scans through all styles and removes the version info
 *
 * @param none
 * @return none
 */
function wpb_styles_remove_version_info()
{
    global $wp_styles;
    if (!is_a($wp_styles, 'WP_Styles' )) {
        return;
    }
    foreach ($wp_styles->registered as $handle => $style) {
        $wp_styles->registered[$handle]->ver = null;
    }
}
?>