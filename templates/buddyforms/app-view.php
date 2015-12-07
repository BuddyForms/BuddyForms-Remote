
<?php show_admin_bar(false); ?>
<?php wp_head() ?>
<style>
    html {
        margin-top: 0px !important;
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


    });

</script>
<?php the_content()?>
<?php wp_footer() ?>