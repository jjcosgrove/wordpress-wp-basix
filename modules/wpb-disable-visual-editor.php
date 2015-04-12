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
function wpb_disable_visual_editor_init()
{
    add_settings_section(
        'wpb-disable-visual-editor-settings',           //$id
        null,                                           //$title
        'wpb_disable_visual_editor_settings_render',    //$callback
        'wp-basix-settings'                             //$page
    );
    add_settings_field(
        'wpb-disable-visual-editor-enable-field',       //$id
        null,                                           //$title
        'wpb_disable_visual_editor_checkbox_render',    //$callback
        'wp-basix-settings',                            //$page
        'wpb-disable-visual-editor-settings',           //section
        null                                            //$args
    );
    register_setting(
        'wp-basix-settings',                            //$option_group
        'wpb-disable-visual-editor-enable-field',       //$option_name
        null                                            //sanitize_callback
    );
}
add_action('admin_menu','wpb_disable_visual_editor_init');

/**
 * displays the main title for the module
 *
 * @param none
 * @return none
 */
function wpb_disable_visual_editor_settings_render()
{
    ?>
        <h2 class="wpb-module-title">Disable Visual Editor</h2>
    <?php
}

/**
 * renders the module fields for user interaction, under the settings
 * for this particular module
 *
 * @param none
 * @return none
 */
function wpb_disable_visual_editor_checkbox_render()
{
    ?>
        <table class="wpb-module-settings">
            <tr>
                <td>
                    <p class="wpb-module-description">
                        Disables the in-built visual editor, forcing users to use the HTML editor.
                    </p>
                </td>
                <td class="wpb-module-fields-container">
                    <?php
                        $checked_status = (get_option('wpb-disable-visual-editor-enable-field') === "on" ? "checked=\"checked\"" : "");
                    ?>
                    <input type="checkbox" name="wpb-disable-visual-editor-enable-field" <?php echo $checked_status ?>>
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
function wpb_disable_visual_editor()
{
    if(get_option('wpb-disable-visual-editor-enable-field') === 'on') {
        add_filter('user_can_richedit', '__return_false', 10);
    }
}
add_action('user_can_richedit','wpb_disable_visual_editor', 1);
?>