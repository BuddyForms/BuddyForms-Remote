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


    ?>

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
    <?php
    $form_setup[] = new Element_HTML('
        <h3>Different integrations</h3>
        <p><b>URL End Point</b></p>
        <p>You can use URL EndPoints to display your form without your theme. This is perfect to create a FaceBook App or us in iFrames.</p>
        <p><b>Toggle Embed Code</b></p>
        <h3>Create Toggle Embed Code</h3>
        <p>Select the Form and Action</p>
        <br>
    <input type="hidden" value="<?php echo get_bloginfo(\'url\') ?>">
    <select id="buddyforms_toggle_form">
        <option value="none">Select Form</option>
    ');

     foreach ($buddyforms as $form_key => $form) {

        if(!isset($form['remote']))
            continue;

         $form_setup[] = new Element_HTML('   <option value="<?php echo $form_key ?>">' . $form['name'] . '</option>');
     }

    $form_setup[] = new Element_HTML('</select>
    <select id="buddyforms_toggle_action">
        <option value="none">Select Action</option>
        <option value="create">Create</option>
        <option value="view">View Post List</option>
    </select>
    <a id="buddyforms_toggle_generate" href="#" >Generate Embed Code</a>
    <br><br>
    <textarea rows="3" cols="100" id="buddyforms_toggle_result"></textarea>
    <p><i class="icon-check"></i> After Generate copy and paste the above code before the <code>&lt;/body&gt;</code> tag on your website.</p>');

    foreach($form_setup as $key => $field){
        echo '<div class="buddyforms_field_label">' . $field->getLabel() . '</div>';
        echo '<div class="buddyforms_field_description">' . $field->getShortDesc() . '</div>';
        echo '<div class="buddyforms_form_field">' . $field->render() . '</div>';
    }
}
add_filter('add_meta_boxes','buddyforms_remote_admin_settings_sidebar_metabox');
