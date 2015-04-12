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
function wpb_enable_clean_search_init()
{
    add_settings_section(
        'wpb-enable-clean-search-settings',         //$id
        null,                                       //$title
        'wpb_enable_clean_search_settings_render',  //$callback
        'wp-basix-settings'                         //$page
    );
    add_settings_field(
        'wpb-enable-clean-search-enable-field',     //$id
        null,                                       //$title
        'wpb_enable_clean_search_checkbox_render',  //$callback
        'wp-basix-settings',                        //$page
        'wpb-enable-clean-search-settings',         //section
        null                                        //$args
    );
    register_setting(
        'wp-basix-settings',                        //$option_group
        'wpb-enable-clean-search-enable-field',     //$option_name
        null                                        //sanitize_callback
    );
}
add_action('admin_menu','wpb_enable_clean_search_init');

/**
 * displays the main title for the module
 *
 * @param none
 * @return none
 */
function wpb_enable_clean_search_settings_render()
{
    ?>
        <h2 class="wpb-module-title">Enable Clean Search</h2>
    <?php
}

/**
 * renders the module fields for user interaction, under the settings
 * for this particular module
 *
 * @param none
 * @return none
 */
function wpb_enable_clean_search_checkbox_render()
{
    ?>
        <table class="wpb-module-settings">
            <tr>
                <td>
                    <p class="wpb-module-description">
                        Replaces the default '?s=term' search query with the cleaner: '/search/term/'. Must have permalinks enabled.
                    </p>
                </td>
                <td class="wpb-module-fields-container">
                    <?php
                        $checked_status = (get_option('wpb-enable-clean-search-enable-field') === "on" ? "checked=\"checked\"" : "");
                    ?>
                    <input type="checkbox" name="wpb-enable-clean-search-enable-field" <?php echo $checked_status ?>>
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
function wpb_enable_clean_search()
{
    if(get_option('wpb-enable-clean-search-enable-field') === 'on') {
        add_action('template_redirect', 'wpb_custom_rewrite_search', 10);
    }
}
add_action('template_redirect','wpb_enable_clean_search', 1);

/**
 * rewrite rules for 's'
 * @return None
 */
function wpb_custom_rewrite_search() {
    global $wp_rewrite;
    if ( !isset( $wp_rewrite ) || !is_object( $wp_rewrite ) || !$wp_rewrite->using_permalinks() )
        return;

    $search_base = $wp_rewrite->search_base;
    if ( is_search() && !is_admin() && strpos( $_SERVER['REQUEST_URI'], "/{$search_base}/" ) === false ) {
        wp_redirect( home_url( "/{$search_base}/" . urlencode(get_query_var('s'))));
        exit();
    }
}

?>