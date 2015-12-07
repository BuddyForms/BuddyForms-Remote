<?php

/**
 * Custom Templates
 *
 */
function buddyforms_remote_templates( $template ) {
    global $buddyforms;

    if(!$buddyforms)
        return $template;

    $action          = get_query_var( 'bf_action' )          ? get_query_var( 'bf_action' ) : '';
    $form_slug       = get_query_var( 'bf_form_slug' )       ? get_query_var( 'bf_form_slug' ) : '';
    $post_id         = get_query_var( 'bf_post_id' )         ? get_query_var( 'bf_post_id' ) : '';
    $parent_post_id  = get_query_var( 'bf_parent_post_id' )  ? get_query_var( 'bf_parent_post_id' ) : '';
    $rev_id          = get_query_var( 'bf_rev_id' )          ? get_query_var( 'bf_rev_id' ) : '';


    if(isset($_GET['bf-remote'])){
        $remote = $_GET['bf-remote'];
        $template = plugin_dir_path( __FILE__ ) .'templates/buddyforms/app-view.php';
    }


    if(empty($action))
        return $template;

    if(empty($form_slug))
        return $template;

    if($action == 'api')
        $template = BUDDYFORMS_REMOTE_PLUGIN_PATH . 'includes/api-loader.php';

    if($action == 'remote_create'){
        $template = BUDDYFORMS_REMOTE_PLUGIN_PATH . 'templates/buddyforms/app-view.php';
        set_query_var('bf_action', 'create');
        set_query_var('bf_remote_action', $action);
    }

    if($action == 'remote_view'){
        $template = BUDDYFORMS_REMOTE_PLUGIN_PATH . 'templates/buddyforms/app-view.php';
        set_query_var('bf_action', 'view');
        set_query_var('bf_remote_action', $action);
    }

    if($action == 'remote_edit'){
        $template = BUDDYFORMS_REMOTE_PLUGIN_PATH . 'templates/buddyforms/app-view.php';
        set_query_var('bf_action', 'edit');
        set_query_var('bf_remote_action', $action);
    }


    //$template = get_query_template( $post_type . '-' . $section );
    return $template;
}
add_action( 'template_include', 'buddyforms_remote_templates');


function buddyforms_remote_after_save_post_redirect($url){

    if(!isset($_POST['remote']))
        return $url;

    return str_replace('view', 'remote-view', $url);

}
add_filter('buddyforms_after_save_post_redirect', 'buddyforms_remote_after_save_post_redirect', 10, 1);