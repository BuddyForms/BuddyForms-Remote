<?php
/*
 Plugin Name: BuddyForms Remote
 Plugin URI: http://buddyforms.com/downloads/buddyforms-hierarchical-posts/
 Description: BuddyForms Remote provides your Forms where ever they are needed! Use BuddyForms Forms on any Website (WP and NON WP Sites) Inline or as Toggle.
 Version: 1.0.2
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

function buddyforms_remote_init() {
	define( 'BUDDYFORMS_REMOTE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
	define( 'BUDDYFORMS_REMOTE_PLUGIN_PATH', dirname( __FILE__ ) . '/' );

	require_once( BUDDYFORMS_REMOTE_PLUGIN_PATH . 'includes/admin/form-elements.php' );
	require_once( BUDDYFORMS_REMOTE_PLUGIN_PATH . 'includes/functions.php' );

}

add_action( 'init', 'buddyforms_remote_init' );

function buddyforms_remote_rewrite_rules( $flush_rewrite_rules = false ) {
	global $buddyforms;

	if ( ! is_admin() ) {
		return;
	}

	if ( ! $buddyforms ) {
		return;
	}

	foreach ( $buddyforms as $key => $buddyform ) {
		if ( isset( $buddyform['attached_page'] ) && isset( $buddyform['remote'] ) ) {
			$post_data = get_post( $buddyform['attached_page'], ARRAY_A );
			add_rewrite_rule( $post_data['post_name'] . '/remote-create/([^/]+)/([^/]+)/?', 'index.php?pagename=' . $post_data['post_name'] . '&bf_action=remote_create&bf_form_slug=$matches[1]&bf_parent_post_id=$matches[2]', 'top' );
			add_rewrite_rule( $post_data['post_name'] . '/remote-create/([^/]+)/?', 'index.php?pagename=' . $post_data['post_name'] . '&bf_action=remote_create&bf_form_slug=$matches[1]', 'top' );
			add_rewrite_rule( $post_data['post_name'] . '/remote-view/([^/]+)/?', 'index.php?pagename=' . $post_data['post_name'] . '&bf_action=remote_view&bf_form_slug=$matches[1]', 'top' );
			add_rewrite_rule( $post_data['post_name'] . '/remote-edit/([^/]+)/([^/]+)/?', 'index.php?pagename=' . $post_data['post_name'] . '&bf_action=remote_edit&bf_form_slug=$matches[1]&bf_post_id=$matches[2]', 'top' );
			add_rewrite_rule( $post_data['post_name'] . '/remote-revision/([^/]+)/([^/]+)/([^/]+)/?', 'index.php?pagename=' . $post_data['post_name'] . '&bf_action=remote_revision&bf_form_slug=$matches[1]&bf_post_id=$matches[2]&bf_rev_id=$matches[3]', 'top' );

			add_rewrite_rule( $post_data['post_name'] . '/bf-api/([^/]+)/?', 'index.php?pagename=' . $post_data['post_name'] . '&bf_action=api&bf_form_slug=$matches[1]', 'top' );
		}
	}
	if ( $flush_rewrite_rules ) {
		flush_rewrite_rules();
	}
}

add_action( 'init', 'buddyforms_remote_rewrite_rules' );

//
// Check the plugin dependencies
//
add_action('init', function(){

	// Only Check for requirements in the admin
	if(!is_admin()){
		return;
	}

	// Require TGM
	require ( dirname(__FILE__) . '/includes/resources/tgm/class-tgm-plugin-activation.php' );

	// Hook required plugins function to the tgmpa_register action
	add_action( 'tgmpa_register', function(){

		// Create the required plugins array
		$plugins = array(
			array(
				'name'              => 'BuddyForms',
				'slug'              => 'buddyforms',
				'required'          => true,
			),
		);

		$config = array(
			'id'           => 'buddyforms-tgmpa',  // Unique ID for hashing notices for multiple instances of TGMPA.
			'parent_slug'  => 'plugins.php',       // Parent menu slug.
			'capability'   => 'manage_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
			'has_notices'  => true,                // Show admin notices or not.
			'dismissable'  => false,               // If false, a user cannot dismiss the nag message.
			'is_automatic' => true,                // Automatically activate plugins after installation or not.
		);

		// Call the tgmpa function to register the required plugins
		tgmpa( $plugins, $config );

	} );
}, 1, 1);