<?php
function buddyforms_remote_admin_settings_sidebar_metabox(){
    add_meta_box('buddyforms_remote', __("Remote",'buddyforms'), 'buddyforms_remote_admin_settings_sidebar_metabox_html', 'buddyforms', 'advanced', 'low');
}

function buddyforms_remote_admin_settings_sidebar_metabox_html(){
    global $post, $buddyforms;

    if($post->post_type != 'buddyforms')
        return;

    $buddyform = get_post_meta(get_the_ID(), '_buddyforms_options', true);

    $form_setup = array();

    $remote = 'off';
    if(isset($buddyform['remote']))
        $remote = $buddyform['remote'];

    $form_setup[] = new Element_Checkbox("<p>" . __('Enabled Remote to generate new endpoinds and the toggle for this form. You need to save the form onece to generate the new endpoints and toggle embed codes.', 'buddyforms') . "</p>", "buddyforms_options[remote]", array("remote" => "Enable Remote"), array('value' => $remote));

    $form_setup[] = new Element_HTML(__('', 'buddyforms'));

    if($remote != 'off'){

      $form_setup[] = new Element_HTML('
            <br><p><b>Toggle Embed Codes</b></p>
          ');

      $attached_page  = get_post($buddyform['attached_page']);
      $attached_page  = $attached_page->post_name;

      $form_slug = $buddyform['slug'];

      $url = get_bloginfo('url') . '/' . $attached_page . '/bf-api/' . $form_slug . '?action=create';
      $url = "<script type='text/javascript' src='" . $url . "'></script>";
      $form_setup[] = new Element_HTML(' Create embed code: <input type="text" onFocus="this.focus();this.select()" value="' . $url . '" />');

      $url = get_bloginfo('url') . '/' . $attached_page . '/bf-api/' . $form_slug . '?action=view';
      $url = "<script type='text/javascript' src='" . $url . "'></script>";
      $form_setup[] = new Element_HTML(' View embed code: <input type="text" onFocus="this.focus();this.select()" value="' . $url . '" />');

      $form_setup[] = new Element_HTML('
          <br><p><b>URL Endponds</b></p>
          <p>You can use URL endpoints to display your forms in iframes. Two new buttons have been added to the publish sitebar metabox</p>
          ');

      $form_setup[] = new Element_HTML('
          <br><p><b>Tip</b></p>
          <p>Select "Display the User\'s Post List " in the Form Setup "After Submission" options will generate a closed workflow and enable posting and endeting within the Toggle or iFrame</p>
          ');

    }

    foreach($form_setup as $key => $field){
        echo '<div class="buddyforms_field_label">' . $field->getLabel() . '</div>';
        echo '<div class="buddyforms_field_description">' . $field->getShortDesc() . '</div>';
        echo '<div class="buddyforms_form_field">' . $field->render() . '</div>';
    }

}
add_filter('add_meta_boxes','buddyforms_remote_admin_settings_sidebar_metabox');

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
