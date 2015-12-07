<?php
/*
 Plugin Name: BuddyForms Remote
 Plugin URI: http://buddyforms.com/downloads/buddyforms-hierarchical-posts/
 Description: BuddyForms Hierarchical Posts like Journal/logs
 Version: 1.0
 Author: Sven Lehnert
 Author URI: https://profiles.wordpress.org/svenl77
 License: GPLv2 or later
 Network: false

 *****************************************************************************
 *
 * This script is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 ****************************************************************************
 */
/**
* Custom Templates
*
*/
function bf_custom_templates( $template ) {
    global $buddyforms;

    if(!$buddyforms)
        return $template;

    $action          = get_query_var( 'bf_action' )          ? get_query_var( 'bf_action' ) : '';
    $form_slug       = get_query_var( 'bf_form_slug' )       ? get_query_var( 'bf_form_slug' ) : '';
    $post_id         = get_query_var( 'bf_post_id' )         ? get_query_var( 'bf_post_id' ) : '';
    $parent_post_id  = get_query_var( 'bf_parent_post_id' )  ? get_query_var( 'bf_parent_post_id' ) : '';
    $rev_id          = get_query_var( 'bf_rev_id' )          ? get_query_var( 'bf_rev_id' ) : '';


//    if(isset($_GET['bf-remote'])){
//        $remote = $_GET['bf-remote'];
//        $template = plugin_dir_path( __FILE__ ) .'templates/buddyforms/app-view.php';
//    }


    if(empty($action))
        return $template;

    if(empty($form_slug))
        return $template;

    if($action == 'api')
        $template = plugin_dir_path( __FILE__ ) .'templates/buddyforms/api-loader.php';

    if($action == 'remote_create'){
        $template = plugin_dir_path( __FILE__ ) .'templates/buddyforms/app-view.php';
        set_query_var('bf_action', 'create');
    }

    if($action == 'remote_view'){
        $template = plugin_dir_path( __FILE__ ) .'templates/buddyforms/app-view.php';
        set_query_var('bf_action', 'view');
    }

    if($action == 'remote_edit'){
        $template = plugin_dir_path( __FILE__ ) .'templates/buddyforms/app-view.php';
        set_query_var('bf_action', 'edit');
    }




    //$template = get_query_template( $post_type . '-' . $section );
    return $template;
}
add_action( 'template_include', 'bf_custom_templates' );

add_action('init', 'buddyforms_remote_rewrite_rules');
function buddyforms_remote_rewrite_rules($flush_rewrite_rules = FALSE){
    global $buddyforms;
    define('BUDDYFORMS_MODERATION', plugin_dir_url( __FILE__ ));
    if ( !is_admin() )
        return;

    if(!$buddyforms)
        return;

    foreach ($buddyforms as $key => $buddyform) {
        if(isset($buddyform['attached_page'])){
            $post_data = get_post($buddyform['attached_page'], ARRAY_A);
            add_rewrite_rule($post_data['post_name'].'/remote-create/([^/]+)/([^/]+)/?', 'index.php?pagename='.$post_data['post_name'].'&bf_action=remote_create&bf_form_slug=$matches[1]&bf_parent_post_id=$matches[2]', 'top');
            add_rewrite_rule($post_data['post_name'].'/remote-create/([^/]+)/?', 'index.php?pagename='.$post_data['post_name'].'&bf_action=remote_create&bf_form_slug=$matches[1]', 'top');
            add_rewrite_rule($post_data['post_name'].'/remote-view/([^/]+)/?', 'index.php?pagename='.$post_data['post_name'].'&bf_action=remote_view&bf_form_slug=$matches[1]', 'top');
            add_rewrite_rule($post_data['post_name'].'/remote-edit/([^/]+)/([^/]+)/?', 'index.php?pagename='.$post_data['post_name'].'&bf_action=remote_edit&bf_form_slug=$matches[1]&bf_post_id=$matches[2]', 'top');
            add_rewrite_rule($post_data['post_name'].'/remote-revision/([^/]+)/([^/]+)/([^/]+)/?', 'index.php?pagename='.$post_data['post_name'].'&bf_action=remote_revision&bf_form_slug=$matches[1]&bf_post_id=$matches[2]&bf_rev_id=$matches[3]', 'top');

            add_rewrite_rule($post_data['post_name'].'/bf-api/([^/]+)/?', 'index.php?pagename='.$post_data['post_name'].'&bf_action=api&bf_form_slug=$matches[1]', 'top');
        }
    }
    if($flush_rewrite_rules)
        flush_rewrite_rules();
}
add_filter('buddyforms_after_save_post_redirect', 'buddyforms_remote_after_save_post_redirect', 10, 1);

function buddyforms_remote_after_save_post_redirect($url){
    return str_replace('view', 'remote-view', $url);
}