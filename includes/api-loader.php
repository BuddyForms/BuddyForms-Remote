/**
 * api-loader.js
 *
 * Inserts an Toggle into the DOM and calls the remote api. Set the action via a get parameter:
 * e.g http://www.example.com/?bf-remote=create
 *
 */

(function() {

// Localize jQuery variable
    var jQuery;

    /* Load jQuery if not present */
    if (window.jQuery === undefined || window.jQuery.fn.jquery !== '1.7.2')
    {
        var script_tag = document.createElement('script');
        script_tag.setAttribute("type","text/javascript");
        script_tag.setAttribute("src",
            "http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js");
        if (script_tag.readyState)
        {
            script_tag.onreadystatechange = function ()
            { // For old versions of IE
                if (this.readyState == 'complete' || this.readyState == 'loaded')
                {
                    scriptLoadHandler();
                }
            };
        }
        else
        {
            script_tag.onload = scriptLoadHandler;
        }

        (document.getElementsByTagName("head")[0] || document.documentElement).appendChild(script_tag);
    }
    else
    {
        // The jQuery version on the window is the one we want to use
        jQuery = window.jQuery;
        main();
    }

    /* Called once jQuery has loaded */
    function scriptLoadHandler()
    {
        jQuery = window.jQuery.noConflict(true);
        main();
    }

    /* Our Start function */
    function main()
    {
        jQuery(document).ready(function($)
        {
            var cssLink = $("<link rel='stylesheet' type='text/css' href='<?php echo BUDDYFORMS_REMOTE_PLUGIN_URL .'assets/toggle.css'; ?>'>");
            $("head").append(cssLink);

            /* Set 'height' and 'width' according to the content type */
            var iframeContent = '' +
                '<div id="bf-remote-tab"><div id="bf-remote-container">' +
                '<iframe style="height: 100%; width: 100%; "src="<?php

        global $buddyforms;
        $form_slug      = get_query_var( 'bf_form_slug' )       ? get_query_var( 'bf_form_slug' ) : '';
        $attached_page  = get_post($buddyforms[$form_slug]['attached_page']);
        $attached_page  = $attached_page->post_name;

        $api_action = 'create';
        if(isset($_GET['action']))
            $api_action = $_GET['action'];


        echo get_bloginfo('url') ?>/<?php echo $attached_page ?>/remote-<?php echo $api_action ?>/<?php echo $form_slug ?>/"></iframe>' +
                '</div><a class="bf-burger"><span>Toggle</span></a> </div>';
            $('body').append(iframeContent);

            $('document').ready(function() {
                $('#bf-remote-container').hide();
                $('#bf-remote-tab').click(function() {
                    $('#bf-remote-container').toggle();
                    $('#bf-remote-tab').toggleClass("bf-open");
                });
            });

    });
    }

})();


