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
    global $buddyforms;

    // Check that the user is allowed to update options
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.','buddyforms'));
    } ?>

    <script>

        jQuery(document).ready(function (){
            jQuery(document).on( "click", '#buddyforms_toggle_generate', function( event ) {

                var form_slug = jQuery('#buddyforms_toggle_form').val();
                if(form_slug == 'none'){
                    alert('Please Select a form');
                    return false;
                }

                var bf_action = jQuery('#buddyforms_toggle_action').val();
                if(bf_action == 'none'){
                    alert('Please Select a Action');
                    return false;
                }

                jQuery.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: {"action": "buddyforms_remote_toggle_generate", "form_slug": form_slug, "bf_action": bf_action },
                    success: function(data){
                        if(data != 0)
                            jQuery("textarea#buddyforms_toggle_result").text(data);

                    },
                    error: function (request, status, error) {
                        alert(request.responseText);
                    }
                });
            });
        });
    </script>

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
        <p>Select the Form and Action</p>
        <br>
        <?php


        ?>
        <input type="hidden" value="<?php echo get_bloginfo('url') ?>">
        <select id="buddyforms_toggle_form">
            <option value="none">Select Form</option>
            <?php foreach ($buddyforms as $form_key => $form) {

                if(!isset($form['remote']))
                    continue;
                ?>
                <option value="<?php echo $form_key ?>"><?php echo $form['name'] ?></option>
            <?php } ?>
        </select>
        <select id="buddyforms_toggle_action">
            <option value="none">Select Action</option>
            <option value="create">Create</option>
            <option value="view">View Post List</option>
        </select>
        <a id="buddyforms_toggle_generate" href="#" >Generate Embed Code</a>
        <br><br>
        <textarea rows="3" cols="100" id="buddyforms_toggle_result"></textarea>
        <p><i class="icon-check"></i> After Generate copy and paste the above code before the <code>&lt;/body&gt;</code> tag on your website.</p>
    </div>

    <?php
}

function buddyforms_remote_toggle_generate(){
    global $buddyforms;

    if(!isset($_POST['form_slug']) || $_POST['form_slug'] == 'none')
        return;
    if(!isset($_POST['bf_action']) || $_POST['bf_action'] == 'none')
        return;

    $form_slug      = $_POST['form_slug'];
    $bf_action      = $_POST['bf_action'];

    $attached_page  = get_post($buddyforms[$form_slug]['attached_page']);
    $attached_page  = $attached_page->post_name;

    $url = get_bloginfo('url') . '/' . $attached_page . '/bf-api/' . $form_slug . '?action=' . $bf_action;

    echo "<script type='text/javascript' src='" . $url . "'></script>";
    die();
}
add_action('wp_ajax_buddyforms_remote_toggle_generate', 'buddyforms_remote_toggle_generate');


function buddyforms_remote_add_button_to_submit_box() {
    global $post;

    if (get_post_type($post) != 'buddyforms')
        return;

    $buddyform = get_post_meta($post->ID, '_buddyforms_options', true);

    if(!isset($buddyform['remote']))
        return;

    $attached_page_permalink = isset($buddyform['attached_page']) ? get_permalink($buddyform['attached_page']) : '';

    echo '<a class="button button-large bf_button_action" href="'.$attached_page_permalink . 'remote-view/' . $post->post_name . '/" target="_new">'.__('View Remote Posts', 'buddyforms').'</a>
    <a class="button button-large bf_button_action" href="'.$attached_page_permalink . 'remote-create/' . $post->post_name . '/" target="_new">'.__('View Remote Form', 'buddyforms').'</a>';


}
add_action( 'post_submitbox_start', 'buddyforms_remote_add_button_to_submit_box' );
