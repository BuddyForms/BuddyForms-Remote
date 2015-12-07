<?php
/**
 * Created by PhpStorm.
 * User: svenl77
 * Date: 25.03.14
 * Time: 14:44
 */

/**
 * Create "BuddyForms Options" nav menu
 *
 * @package buddyforms
 * @since 0.1-beta
 */
function buddyforms_remote_create_sub_menu(){

    if (!session_id()) ;
    @session_start();

    add_submenu_page('edit.php?post_type=buddyforms', __('Remote', 'buddyforms'), __('Remote', 'buddyforms'), 'manage_options', 'bf_remote', 'bf_remote_screen');

}
add_action('admin_menu', 'buddyforms_remote_create_sub_menu');

function bf_remote_screen(){

    // Check that the user is allowed to update options
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.','buddyforms'));
    } ?>

    <div id="bf_admin_wrap" class="wrap">
        <?php include(BUDDYFORMS_INCLUDES_PATH . 'admin/admin-credits.php'); ?>
        <h2>BuddyForms Remote</h2>
        <p>With BuddyForms Remote you Forms can be used everywhere. On any site even non WordPress sites like any other self hosted cms or site, facebook or in your APP</p>

        <h3>Different integrations</h3>

        <p><b>URL End Point</b></p>
        <p>You can use URL EndPoints to display your form without your theme. This is perfect to use on FaceBook or in iFrames.</p>

        <p><b>Toggle Embed Code</b></p>
        <p>
            A Toggle is the most advanced and user frindly wjhy of writing. It is used by many Help Services to give users a quick access to support and get in contact.<br>
            Its used by many famoust Mail Provider like Google Inbox to write Mails<br>
            And its a super confortable why to ancounter your user to write. If on the main site or on any site. The Toggle Embad works everyWhere with just one line of code to embad ;)
        </p>

        <h3>Create Toggle Embed Code</h3>
        select form/select action

        http://buddyforms/sample-page/bf-api/sadsa/?action=create

    </div>

    <?php
}
