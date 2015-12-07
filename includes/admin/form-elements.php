<?php
function buddyforms_remote_admin_settings_sidebar_metabox(){
    add_meta_box('buddyforms_remote', __("Remote",'buddyforms'), 'buddyforms_remote_admin_settings_sidebar_metabox_html', 'buddyforms', 'side', 'low');
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


    $form_setup[] = new Element_Checkbox("<b>" . __('Enable Remote', 'buddyforms') . "</b>", "buddyforms_options[remote]", array("remote" => "Remote"), array('value' => $remote, 'shortDesc' => __('If Remote is enabled all needed ent pints will be generated and the Form can be used to create a Toggle', 'buddyforms')));

    foreach($form_setup as $key => $field){
        echo '<div class="buddyforms_field_label">' . $field->getLabel() . '</div>';
        echo '<div class="buddyforms_field_description">' . $field->getShortDesc() . '</div>';
        echo '<div class="buddyforms_form_field">' . $field->render() . '</div>';
    }
}
add_filter('add_meta_boxes','buddyforms_remote_admin_settings_sidebar_metabox');
