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
function wpb_disable_auto_format_init()
{
    add_settings_section(
        'wpb-disable-auto-format-settings',         //$id
        null,                                       //$title
        'wpb_disable_auto_format_settings_render',  //$callback
        'wp-basix-settings'                         //$page
    );
    add_settings_field(
        'wpb-disable-auto-format-enable-field',     //$id
        null,                                       //$title
        'wpb_disable_auto_format_checkbox_render',  //$callback
        'wp-basix-settings',                        //$page
        'wpb-disable-auto-format-settings',         //section
        null                                        //$args
    );
    register_setting(
        'wp-basix-settings',                        //$option_group
        'wpb-disable-auto-format-enable-field',     //$option_name
        null                                        //sanitize_callback
    );
}
add_action('admin_menu','wpb_disable_auto_format_init');

/**
 * displays the main title for the module
 *
 * @param none
 * @return none
 */
function wpb_disable_auto_format_settings_render()
{
    ?>
        <h2 class="wpb-module-title">Disable Auto Format</h2>
    <?php
}

/**
 * renders the module fields for user interaction, under the settings
 * for this particular module
 *
 * @param none
 * @return none
 */
function wpb_disable_auto_format_checkbox_render()
{
    ?>
        <table class="wpb-module-settings">
            <tr>
                <td>
                    <p class="wpb-module-description">
                        Disables the in-built 'wpautop' filter which adds &lt;p&gt; and &lt;br&gt; tags to post content, i.e: the_content().
                    </p>
                </td>
                <td class="wpb-module-fields-container">
                    <?php
                        $checked_status = (get_option('wpb-disable-auto-format-enable-field') === "on" ? "checked=\"checked\"" : "");
                    ?>
                    <input type="checkbox" name="wpb-disable-auto-format-enable-field" <?php echo $checked_status ?>>
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
function wpb_disable_auto_format()
{
    if(get_option('wpb-disable-auto-format-enable-field') === 'on') {
        remove_filter('the_content', 'wpautop');
    }
}
add_action('admin_init','wpb_disable_auto_format');
?>