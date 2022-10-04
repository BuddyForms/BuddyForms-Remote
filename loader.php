<?php
/*
 Plugin Name: BuddyForms Remote
 Plugin URI: https://themekraft.com/products/remote-embed-forms/
 Description: BuddyForms Remote provides your Forms where ever they are needed! Use BuddyForms Forms on any Website (WP and NON WP Sites) Inline or as Toggle.
 Version: 1.0.7
 Author: ThemeKraft
 Author URI: http://themekraft.com/
 License: GPLv2 or later
 Network: false
 Text Domain: buddyforms

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
		if ( ! defined( 'BUDDYFORMS_PRO_VERSION' ) ) {
			$plugins['buddyforms'] = array(
				'name'     => 'BuddyForms',
				'slug'     => 'buddyforms',
				'required' => true,
			);


			$config = array(
				'id'           => 'buddyforms-tgmpa',
				// Unique ID for hashing notices for multiple instances of TGMPA.
				'parent_slug'  => 'plugins.php',
				// Parent menu slug.
				'capability'   => 'manage_options',
				// Capability needed to view plugin install page, should be a capability associated with the parent menu used.
				'has_notices'  => true,
				// Show admin notices or not.
				'dismissable'  => false,
				// If false, a user cannot dismiss the nag message.
				'is_automatic' => true,
				// Automatically activate plugins after installation or not.
			);

			// Call the tgmpa function to register the required plugins
			tgmpa( $plugins, $config );
		}
	} );
}, 1, 1);

// Create a helper function for easy SDK access.
function buddyforms_remote_fs() {
	global $buddyforms_remote_fs;

	if ( ! isset( $buddyforms_remote_fs ) ) {
		// Include Freemius SDK.
		if ( file_exists( dirname( dirname( __FILE__ ) ) . '/buddyforms/includes/resources/freemius/start.php' ) ) {
			// Try to load SDK from parent plugin folder.
			require_once dirname( dirname( __FILE__ ) ) . '/buddyforms/includes/resources/freemius/start.php';
		} else if ( file_exists( dirname( dirname( __FILE__ ) ) . '/buddyforms-premium/includes/resources/freemius/start.php' ) ) {
			// Try to load SDK from premium parent plugin folder.
			require_once dirname( dirname( __FILE__ ) ) . '/buddyforms-premium/includes/resources/freemius/start.php';
		}

		$buddyforms_remote_fs = fs_dynamic_init( array(
			'id'                  => '406',
			'slug'                => 'buddyforms-remote',
			'type'                => 'plugin',
			'public_key'          => 'pk_0aa7668f249f147c023c5d2ed884c',
			'is_premium'          => true,
			'is_premium_only'     => true,
			'has_paid_plans'      => true,
			'is_org_compliant'    => false,
			'parent'              => array(
				'id'         => '391',
				'slug'       => 'buddyforms',
				'public_key' => 'pk_dea3d8c1c831caf06cfea10c7114c',
				'name'       => 'BuddyForms',
			),
			'menu'                => array(
				'slug'           => 'edit.php?post_type=buddyforms',
				'support'        => false,
			),
			'bundle_license_auto_activation' => true,
		) );
	}

	return $buddyforms_remote_fs;
}

function buddyforms_remote_fs_is_parent_active_and_loaded() {
	// Check if the parent's init SDK method exists.
	return function_exists( 'buddyforms_core_fs' );
}

function buddyforms_remote_fs_is_parent_active() {
	$active_plugins_basenames = get_option( 'active_plugins' );

	foreach ( $active_plugins_basenames as $plugin_basename ) {
		if ( 0 === strpos( $plugin_basename, 'buddyforms/' ) ||
		     0 === strpos( $plugin_basename, 'buddyforms-premium/' )
		) {
			return true;
		}
	}

	return false;
}

function buddyforms_remote_fs_init() {
	if ( buddyforms_remote_fs_is_parent_active_and_loaded() ) {
		// Init Freemius.
		buddyforms_remote_fs();

		// Parent is active, add your init code here.
	} else {
		// Parent is inactive, add your error handling here.
	}
}

if ( buddyforms_remote_fs_is_parent_active_and_loaded() ) {
	// If parent already included, init add-on.
	buddyforms_remote_fs_init();
} else if ( buddyforms_remote_fs_is_parent_active() ) {
	// Init add-on only after the parent is loaded.
	add_action( 'buddyforms_core_fs_loaded', 'buddyforms_remote_fs_init' );
} else {
	// Even though the parent is not activated, execute add-on for activation / uninstall hooks.
	buddyforms_remote_fs_init();
}