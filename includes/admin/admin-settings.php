<?php

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
