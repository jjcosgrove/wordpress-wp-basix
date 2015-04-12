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
function wpb_disable_file_editing_init()
{
    add_settings_section(
        'wpb-disable-file-editing-settings',            //$id
        null,                                           //$title
        'wpb_disable_file_editing_settings_render',     //$callback
        'wp-basix-settings'                             //$page
    );
    add_settings_field(
        'wpb-disable-file-editing-enable-field',        //$id
        null,                                           //$title
        'wpb_disable_file_editing_fields_render',       //$callback
        'wp-basix-settings',                            //$page
        'wpb-disable-file-editing-settings',            //section
        null                                            //$args
    );
    register_setting(
        'wp-basix-settings',                            //$option_group
        'wpb-disable-file-editing-enable-field',        //$option_name
        null                                            //sanitize_callback
    );
}
add_action('admin_menu','wpb_disable_file_editing_init');

/**
 * displays the main title for the module
 *
 * @param none
 * @return none
 */
function wpb_disable_file_editing_settings_render()
{
    ?>
        <h2 class="wpb-module-title">Disable File Editing</h2>
    <?php
}

/**
 * renders the module fields for user interaction, under the settings
 * for this particular module
 *
 * @param none
 * @return none
 */
function wpb_disable_file_editing_fields_render()
{
    ?>
        <table class="wpb-module-settings">
            <tr>
                <td>
                    <p class="wpb-module-description">
                        Disables the ability to edit Theme/Plugin files via the UI.
                    </p>
                </td>
                <td class="wpb-module-fields-container">
                    <?php
                        $checked_status = (get_option('wpb-disable-file-editing-enable-field') === "on" ? "checked=\"checked\"" : "");
                    ?>
                    <input type="checkbox" name="wpb-disable-file-editing-enable-field" <?php echo $checked_status ?>>
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
function wpb_disable_file_editing()
{
    if(get_option('wpb-disable-file-editing-enable-field') === 'on') {
        define('DISALLOW_FILE_EDIT', true);
    }
}
add_action('admin_init','wpb_disable_file_editing');
?>