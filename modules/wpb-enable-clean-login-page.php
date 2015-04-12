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
function wpb_enable_clean_login_page_init()
{
    add_settings_section(
        'wpb-enable-clean-login-page-settings',         //$id
        null,                                           //$title
        'wpb_enable_clean_login_page_settings_render',  //$callback
        'wp-basix-settings'                             //$page
    );
    add_settings_field(
        'wpb-enable-clean-login-page-enable-field',     //$id
        null,                                           //$title
        'wpb_enable_clean_login_page_checkbox_render',  //$callback
        'wp-basix-settings',                            //$page
        'wpb-enable-clean-login-page-settings',         //section
        null                                            //$args
    );
    register_setting(
        'wp-basix-settings',                            //$option_group
        'wpb-enable-clean-login-page-enable-field',     //$option_name
        null                                            //sanitize_callback
    );
}
add_action('admin_menu','wpb_enable_clean_login_page_init');

/**
 * displays the main title for the module
 *
 * @param none
 * @return none
 */
function wpb_enable_clean_login_page_settings_render()
{
    ?>
        <h2 class="wpb-module-title">Enable Clean Login Page</h2>
    <?php
}

/**
 * renders the module fields for user interaction, under the settings
 * for this particular module
 *
 * @param none
 * @return none
 */
function wpb_enable_clean_login_page_checkbox_render()
{
    ?>
        <table class="wpb-module-settings">
            <tr>
                <td>
                    <p class="wpb-module-description">
                        Cleans up the wp-login page for a nicer finish.
                    </p>
                    <button class="wpb-module-more-info">More Info</button>
                    <ul class="wpb-module-more-info-details wpb-list">
                        <li>Removes Links</li>
                        <li>Removes Branding</li>
                        <li>Sets Background White</li>
                    </ul>
                </td>
                <td class="wpb-module-fields-container">
                    <?php
                        $checked_status = (get_option('wpb-enable-clean-login-page-enable-field') === "on" ? "checked=\"checked\"" : "");
                    ?>
                    <input type="checkbox" name="wpb-enable-clean-login-page-enable-field" <?php echo $checked_status ?>>
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
function wpb_enable_clean_login_page()
{
    if(get_option('wpb-enable-clean-login-page-enable-field') === 'on') {
        add_action('login_enqueue_scripts', 'wpb_customize_login_screen', 10);
    }
}
add_action('login_enqueue_scripts','wpb_enable_clean_login_page',1);

/**
 * custom styling for the login page
 *
 * @param none
 * @return none
 */
function wpb_customize_login_screen()
{ 
    ?>
        <style type="text/css">
            body{
                background-color: #fff;
            }
            #login h1,#login #nav, #backtoblog {
                display: none;
            }
            #loginform{
                top: -25px;
                margin-top: 50%;
                position: relative;
            }
        </style>
    <?php 
}
?>