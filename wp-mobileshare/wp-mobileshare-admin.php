<?php
/*
MobileShare ACP, version 20190101
Made with love.
*/

if ($_POST['uninstall'] == '1') {
    // delete settings
    delete_option('mobileshare_only_supported');
    delete_option('mobileshare_also_pages');
    delete_option('mobileshare_placement');
?>
    <div class="updated"><p><strong><?php _e("MobileShare has successfully been uninstalled. Thank you for staying with us.", "wp-mobileshare"); ?></strong></p></div>  
<?php
} elseif ($_POST['savesettings'] == '1') {
    // save settings
    $only_supported = $_POST['mobileshare_only_supported'];
    $also_pages     = $_POST['mobileshare_also_pages'];
    $placement      = $_POST['mobileshare_placement'];

    update_option('mobileshare_only_supported', $only_supported);
    update_option('mobileshare_also_pages', $also_pages);
    update_option('mobileshare_placement', $placement);
  
?>
    <div class="updated"><p><strong><?php _e("Your settings have been saved.", "wp_mobileshare"); ?></strong></p></div>  
<?php
} else {
    // read settings
    $only_supported = get_option('mobileshare_only_supported');
    $also_pages     = get_option('mobileshare_also_pages');
    $placement      = get_option('mobileshare_placement');
}
?>

<div class="wrap">
    <h2><?php _e("MobileShare Settings", "wp-mobileshare"); ?></h2>

    <div id="poststuff" class="metabox-holder has-right-sidebar">
        <div class="stuffbox">
            <h3><?php _e("General Options", "wp-mobileshare"); ?></h3>
            <div class="inside">
                <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
                
                <p>
                <strong><?php _e("Placement", "wp-mobileshare") ?>:</strong><br />
                    <input type="radio" id="pc_of" name="mobileshare_placement" value="off"<?php if ($placement == "off") { ?> checked="checked"<?php } ?> /> <label for="pc_of"><?php _e("off", "wp-mobileshare"); ?></label><br />
                    <input type="radio" id="pc_be" name="mobileshare_placement" value="below"<?php if ($placement == "below") { ?> checked="checked"<?php } ?> /> <label for="pc_be"><?php _e("below articles", "wp-mobileshare"); ?></label><br />
                    <?php _e("You can also use the <tt>[mobileshare]</tt> shortcode if you prefer manual placement.", "wp-mobileshare"); ?>
                    <br />
                    <br />
                    <label>
                        <input type="checkbox" name="mobileshare_also_pages" <?php if ($also_pages) { ?>checked="checked" <?php } ?>/>
                        <?php _e("Also add the sharing button to pages (only articles if disabled)", "wp-mobileshare"); ?>
                    </label>
                </p>

                <p>
                <strong><?php _e("Hide for unsupported browsers", "wp-mobileshare") ?>:</strong><br />
                    <label>
                        <input type="checkbox" name="mobileshare_only_supported" <?php if ($only_supported) { ?>checked="checked" <?php } ?>/>
                        <?php _e("Yes, please.", "wp-mobileshare"); ?>
                    </label>
                </p>

                <input class="button" type="submit" value="<?php _e("Save settings", "wp-mobileshare"); ?> &raquo;" name="submit" />
                <input type="hidden" name="savesettings" value="1">
                </form>
            </div>
        </div>
        
        <div class="stuffbox">
            <h3 id="styling"><?php _e("Styling Info", "wp-mobileshare"); ?></h3>
            <div class="inside">
                <p><?php _e("As of today, this plug-in is kept as simple as possible. If you want to adjust the styling to your theme, you should probably add custom CSS styles for <tt>#mobileshare_button</tt> (the wrapper DIV).", "wp-mobileshare"); ?></p>
            </div>
        </div>

        <div class="stuffbox">
            <h3 id="uninstall"><?php _e("Uninstall", "wp-mobileshare"); ?></h3>
            <div class="inside">
                <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
                    <p><?php _e("This button removes all database entries for this plug-in. Please use it <strong>before</strong> disabling it.", "wp-mobileshare"); ?></p>
                    <input type="hidden" name="uninstall" value="1">
                    <input class="button" type="submit" value="<?php _e("Delete all options", "wp-mobileshare"); ?> &raquo;" />
                </form>
            </div>
        </div>
    </div>
</div>