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
function wpb_hide_admin_bar_init()
{
    add_settings_section(
        'wpb-hide-admin-bar-settings',          //$id
        null,                                   //$title
        'wpb_hide_admin_bar_settings_render',   //$callback
        'wp-basix-settings'                     //$page
    );
    add_settings_field(
        'wpb-hide-admin-bar-enable-field',      //$id
        null,                                   //$title
        'wpb_hide_admin_bar_checkbox_render',   //$callback
        'wp-basix-settings',                    //$page
        'wpb-hide-admin-bar-settings',          //section
        null                                    //$args
    );
    register_setting(
        'wp-basix-settings',                    //$option_group
        'wpb-hide-admin-bar-enable-field',      //$option_name
        null                                    //sanitize_callback
    );
}
add_action('admin_menu','wpb_hide_admin_bar_init');

/**
 * displays the main title for the module
 *
 * @param none
 * @return none
 */
function wpb_hide_admin_bar_settings_render()
{
    ?>
        <h2 class="wpb-module-title">Hide Admin Bar</h2>
    <?php
}

/**
 * renders the module fields for user interaction, under the settings
 * for this particular module
 *
 * @param none
 * @return none
 */
function wpb_hide_admin_bar_checkbox_render()
{
    ?>
        <table class="wpb-module-settings">
            <tr>
                <td>
                    <p class="wpb-module-description">
                        Hides the default 'Admin' bar present on the front-end when logged in.
                    </p>
                </td>
                <td class="wpb-module-fields-container">
                    <?php
                        $checked_status = (get_option('wpb-hide-admin-bar-enable-field') === "on" ? "checked=\"checked\"" : "");
                    ?>
                    <input type="checkbox" name="wpb-hide-admin-bar-enable-field" <?php echo $checked_status ?>>
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
function wpb_hide_admin_bar()
{
    if(get_option('wpb-hide-admin-bar-enable-field') === 'on') {
        add_filter('show_admin_bar', '__return_false', 10);
    }
    //dont change anything at this point. let the add_filter call apply
    //and return false, if needed.
    return true;
}
add_action('show_admin_bar','wpb_hide_admin_bar', 1);
?>