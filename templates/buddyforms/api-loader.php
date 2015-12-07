/**
 * wp-widget.js
 *
 * Inserts an iframe into the DOM and calls the remote embed plugin
 * via a get parameter:
 * e.g http://www.example.com/?embed=posts
 * This is intercepted by the remote 'WordPress Widget Embed' plugin
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
            var cssLink = $("<link rel='stylesheet' type='text/css' href='<?php echo BUDDYFORMS_MODERATION .'assets/toggle.css'; ?>'>");
            $("head").append(cssLink);

<!--            var jsLink = $("<script type='text/javascript' src='--><?php //echo BUDDYFORMS_MODERATION .'assets/toggle.js'; ?><!--'>");-->
<!--            $("head").append(jsLink);-->

            /* Set 'height' and 'width' according to the content type */
            var iframeContent = '' +
                '<div id="bf-remote-tab"><div id="bf-remote-container">' +
                '<iframe style="height: 100%; width: 100%; "src="http://buddyforms/sample-page/remote-<?php echo $_GET['action'] ?>/sadsa/"></iframe>' +
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


