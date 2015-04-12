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
function wpb_enable_ids_init()
{
    add_settings_section(
        'wpb-enable-ids-settings',          //$id
        null,                               //$title
        'wpb_enable_ids_settings_render',   //$callback
        'wp-basix-settings'                 //$page
    );
    add_settings_field(
        'wpb-enable-ids-enable_field',      //$id
        null,                               //$title
        'wpb_enable_ids_fields_render',     //$callback
        'wp-basix-settings',                //$page
        'wpb-enable-ids-settings',          //section
        null                                //$args
    );
    register_setting(
        'wp-basix-settings',                //$option_group
        'wpb-enable-ids-enable_field',      //$option_name
        null                                //sanitize_callback
    );
}
add_action('admin_menu','wpb_enable_ids_init');

/**
 * displays the main title for the module
 *
 * @param none
 * @return none
 */
function wpb_enable_ids_settings_render()
{
    ?>
        <h2 class="wpb-module-title">Enable IDs</h2>
    <?php
}

/**
 * renders the module fields for user interaction, under the settings
 * for this particular module
 *
 * @param none
 * @return none
 */
function wpb_enable_ids_fields_render()
{
    ?>
        <table class="wpb-module-settings">
            <tr>
                <td>
                    <p class="wpb-module-description">
                        Adds an 'ID' column under both 'Posts' and 'Pages'. Useful when developing themes/plugins.
                    </p>
                </td>
                <td class="wpb-module-fields-container">
                    <?php
                        $checked_status = (get_option('wpb-enable-ids-enable_field') === "on" ? "checked=\"checked\"" : "");
                    ?>
                    <input type="checkbox" name="wpb-enable-ids-enable_field" <?php echo $checked_status ?>>
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
function wpb_enable_ids()
{
    if(get_option('wpb-enable-ids-enable_field') === 'on') {
        add_filter('manage_posts_columns', 'wpb_add_id_column');
        add_filter('manage_pages_columns', 'wpb_add_id_column');
        add_action('manage_posts_custom_column', 'wbp_id_column_handler', 10, 2);
        add_action('manage_pages_custom_column', 'wbp_id_column_handler', 10, 2);
    }
}
add_action('admin_init','wpb_enable_ids');

/**
 * adds a custom column for 'Featured Image'
 *
 * @param array $post_columns array of columns under 'Posts'
 * @return none
 */
function wpb_add_id_column($posts_columns)
{
    $posts_columns['item_id'] = _x('ID','item_id');
    return $posts_columns;
}

/**
 * renders the desired output, into the newly created column
 *
 * @param string $column_name the internal name of the current column
 * @param int $id the id of the post related to the current column entry
 * @return none
 */
function wbp_id_column_handler($column_name, $id)
{
    switch($column_name) {
    case 'item_id':
        echo $id;
        break;
    default:
        break;
    }
}
?>