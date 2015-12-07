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

function buddyforms_remote_init(){
    define('BUDDYFORMS_REMOTE_PLUGIN_URL', plugin_dir_url( __FILE__ ));
    define('BUDDYFORMS_REMOTE_PLUGIN_PATH', dirname(__FILE__) . '/');

    require_once( BUDDYFORMS_REMOTE_PLUGIN_PATH . 'includes/admin/admin-settings.php' );
    require_once( BUDDYFORMS_REMOTE_PLUGIN_PATH . 'includes/rewrite-roles.php' );

}
add_action('init', 'buddyforms_remote_init');


function buddyforms_remote_rewrite_rules($flush_rewrite_rules = FALSE){
    global $buddyforms;

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
add_action('init', 'buddyforms_remote_rewrite_rules');
/**
 * add the query vars
 *
 * @package BuddyForms
 * @since 0.3 beta
 */
add_filter('query_vars', 'buddyforms_remote_query_vars');
function buddyforms_remote_query_vars($query_vars){

    if(is_admin())
        return $query_vars;

    $query_vars[] = 'bf_remote_action';

    return $query_vars;
}
