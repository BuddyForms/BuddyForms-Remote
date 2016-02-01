
<?php show_admin_bar(false); ?>
<?php wp_head() ?>
<style>
    html {
        margin-top: 0px !important;
        background: #fafafa;
    }
    .buddyforms_posts_list ul.buddyforms-list li {
        padding: 10px;
        background: #fafafa;
    }
    .buddyforms_posts_list ul.buddyforms-list .item-status {
        text-shadow: none;
    }
    .buddyforms_posts_list ul.buddyforms-list li div.action {
        margin-top: 5px;
    }
    .buddyforms_posts_list ul.buddyforms-list .item-title a {
        color: #0c7572;
        font-size: 21px;
        font-weight: bold;
    }
    .buddyforms_posts_list a {
      color: #0c7572;
    }
    .buddyforms_posts_list {
      color: #2e2e2e;
      font-size: 15px;
    }
    .the_buddyforms_form {
    }
    form#loginform {
      margin: 20px 0;
    }
</style>
<script>
    jQuery('document').ready(function() {
        jQuery('.bf_edit_post').each(function(i, obj) {
            var str = this.toString();
            var res = str.replace("edit", "remote-edit");
            jQuery(obj).attr("href", res);
        });
        jQuery('.item-title a').each(function(i, obj) {
            var str = this.toString() + '?bf-remote=remote';
            var res = str.replace("edit", "remote");
            jQuery(obj).attr("target", '_blank');
        });
        jQuery('#editpost_<?php echo get_query_var('bf_form_slug'); ?>').append('<input type="hidden" name="remote" value="remote" />');
    });

</script>


<?php the_content()?>
<?php wp_footer() ?>
