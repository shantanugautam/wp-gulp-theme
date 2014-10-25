<?php

/*
Disable Default Dashboard Widgets
*/
function disable_default_dashboard_widgets() {
    global $wp_meta_boxes;
    // unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
    // bbpress
    unset($wp_meta_boxes['dashboard']['normal']['core']['bbp-dashboard-right-now']);
    // yoast seo
    unset($wp_meta_boxes['dashboard']['normal']['core']['yoast_db_widget']);
    // gravity forms
    unset($wp_meta_boxes['dashboard']['normal']['core']['rg_forms_dashboard']);
}
add_action('wp_dashboard_setup', 'disable_default_dashboard_widgets', 999);


/*
Remove Customer Welcome Panel
*/
remove_action('welcome_panel', 'wp_welcome_panel');


/*
Remove WP Logo for dash of logged in user
*/
function remove_wp_logo( $wp_admin_bar ) {
    $wp_admin_bar->remove_node('wp-logo');
}
add_action('admin_bar_menu', 'remove_wp_logo', 999);


/*
Remove Custom Help section from dashbaord
*/
add_filter( 'contextual_help', 'mytheme_remove_help_tabs', 999, 3 );
function mytheme_remove_help_tabs($old_help, $screen_id, $screen){
    $screen->remove_help_tabs();
    return $old_help;
}
add_filter('screen_options_show_screen', '__return_false');


/*
CUSTOM ADMIN LOGIN LOGO
*/
function my_custom_login_logo()
{
    echo '<style  type="text/css"> h1 a {  background-image:url(' . get_bloginfo('template_directory') . '/library/images/mmg-logo-circle.svg)  !important; } </style>';
}
add_action('login_head',  'my_custom_login_logo');


/*
CUSTOM ADMIN LOGIN LOGO & ALT TEXT
*/
// function change_wp_login_title()
// {
//     echo '<p>Login</p>'; // OR ECHO YOUR OWN ALT TEXT
// }
// add_filter('login_headertitle', 'change_wp_login_title');



/*
CUSTOM ADMIN DASHBOARD HEADER LOGO
*/
function custom_admin_logo()
{
    echo '<style type="text/css">#header-logo { background-image: url(' . get_bloginfo('template_directory') . '/library/images/mmg-logo-circle.svg) !important; }</style>';
}
add_action('admin_head', 'custom_admin_logo');



/*
Admin footer modification
*/
function remove_footer_admin ()
{
    echo '<span id="footer-thankyou">Developed by <a href="http://sgautam.info" target="_blank">Shantanu Gautam</a></span>';
}
add_filter('admin_footer_text', 'remove_footer_admin');





function change_adminbar_css() {
    wp_register_style( 'add-admin-stylesheet', get_template_directory_uri() .  '/library/admin/css/style.css');
    wp_enqueue_style( 'add-admin-stylesheet' );
}

add_action( 'admin_enqueue_scripts', 'change_adminbar_css' );



function my_admin_theme_style()
{
    wp_enqueue_style('my-admin-style', get_template_directory_uri() . '/library/admin/css/style.css');
}

add_action('admin_enqueue_scripts', 'my_admin_theme_style');


// if (is_admin) {
//     add_action( 'wp_enqueue_scripts', 'change_adminbar_css' );
// }



add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets');

function my_custom_dashboard_widgets()
{
    global $wp_meta_boxes;
    wp_add_dashboard_widget('custom_help_widget', 'Theme Support', 'custom_dashboard_help');
}

function custom_dashboard_help()
{
    echo '<p>Welcome to your frontend application! Need help? Contact the developer <a href="mailto:shan@matchmovegames.com">here</a>.</p>';
}


/*
Custom Copyright message
*/
function comicpress_copyright()
{
    global $wpdb;
    $copyright_dates = $wpdb->get_results("SELECT YEAR(min(post_date_gmt)) AS firstdate, YEAR(max(post_date_gmt)) AS lastdate FROM $wpdb->posts WHERE post_status = 'publish'");
    $output = '';
    if($copyright_dates) {
        $copyright = "&copy; " . $copyright_dates[0]->firstdate;
        if($copyright_dates[0]->firstdate != $copyright_dates[0]->lastdate) {
            $copyright .= '-' . $copyright_dates[0]->lastdate;
        }
        $output = $copyright;
    }
    return $output;
}


/*
Disable Search
*/
function fb_filter_query( $query, $error = true ) {

if ( is_search() ) {
    $query->is_search = false;
    $query->query_vars[s] = false;
    $query->query[s] = false;

    // to error
    if ( $error == true )
        $query->is_404 = true;
    }
}

add_action( 'parse_query', 'fb_filter_query' );
add_filter( 'get_search_form', create_function( '$a', "return null;" ) );


/*
Custom performance metrics on footer
*/
function performance( $visible = false )
{
    $stat = sprintf(  '%d queries in %.3f seconds, using %.2fMB memory',
        get_num_queries(),
        timer_stop( 0, 3 ),
        memory_get_peak_usage() / 1024 / 1024
        );

    echo $visible ? $stat : "<!-- {$stat} -->" ;
}

add_action( 'wp_footer', 'performance', 20 );


/*
remove unnecessary header info
 */
function remove_header_info()
{
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'start_post_rel_link');
    remove_action('wp_head', 'index_rel_link');
    remove_action('wp_head', 'adjacent_posts_rel_link');         // for WordPress <  3.0
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head'); // for WordPress >= 3.0
}
add_action('init', 'remove_header_info');


// /*
// remove extra CSS that 'Recent Comments' widget injects
// */
// function remove_recent_comments_style()
// {
//     global $wp_widget_factory;
//     remove_action('wp_head', array(
//         $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
//         'recent_comments_style'
//     ));
// }
// add_action('widgets_init', 'remove_recent_comments_style');



/*
Add custom editor styles
*/
add_editor_style('/library/admin/css/style.css');


/*
Custom CSS for the login page
*/
function wpfme_loginCSS()
{
    echo '<link rel="stylesheet" type="text/css" href="'.get_bloginfo('template_directory').'/library/css/login.css"/>';
}
add_action('login_head', 'wpfme_loginCSS');


// Call the google CDN version of jQuery for the frontend
// Make sure you use this with wp_enqueue_script('jquery'); in your header
function wpfme_jquery_enqueue()
{
    wp_deregister_script('jquery');
    wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js", false, null);
    wp_enqueue_script('jquery');
}
if (!is_admin()) add_action("wp_enqueue_scripts", "wpfme_jquery_enqueue", 11);


/*
Obscure the login message
*/
function wpfme_login_obscure()
{
    return '<strong>Sorry</strong>: Think you have gone wrong somwhere!';
}
add_filter( 'login_errors', 'wpfme_login_obscure' );


/*
Disable the theme / plugin text editor in Admin
*/
// define('DISALLOW_FILE_EDIT', true);


/*
Disable redundant theme items
*/
function sc_remove_menus()
{
    // setup the global menu variable
    global $menu;
    // this is an array of the menu item names we wish to remove
    $restricted = array( __('Links'),__('Tools'),__('Comments'), __('Media'));
    end ($menu);
    while (prev($menu))
    {
        $value = explode(' ',$menu[key($menu)][0]);
        if(in_array($value[0] != NULL?$value[0]:"" , $restricted))
        {
            unset($menu[key($menu)]);
        }
    }
}
// hook into the action that creates the menu
add_action('admin_menu', 'sc_remove_menus');

function ya_do_it_admin_bar_remove() {
        global $wp_admin_bar;

        /* **edit-profile is the ID** */
        $wp_admin_bar->remove_menu('edit-profile');
 }

add_action('wp_before_admin_bar_render', 'ya_do_it_admin_bar_remove', 0);
