<?php
/*
Plugin Name: MobileShare
Plugin URI: https://tuxproject.de/projects/wp-mobileshare
Description: Enables the Web Share API, adds a sharing button to your WordPress.
Version: 20190101
Author: tux.
Author URI: https://tuxproject.de/blog
License: WTFPL

Yep, versioning scheme is yyyymm##, no reference to a day.
Counting builds makes more sense to me.
*/

// ------------------------
// General SQL field defaults
add_option('mobileshare_only_supported', 1);
add_option('mobileshare_also_pages', 0);
add_option('mobileshare_placement', 'below');

// ------------------------
// Shortcode
function wp_mobileshare_shortcode() {
    if (!wp_is_mobile()) { return; }

    $ret  = '<div id="mobileshare_button">';
    $ret .= '<img id="mobileshare_img" src="' . plugins_url( 'share.png', __FILE__ ) . '" style="float:left;width:20px;height:auto" />&nbsp;';
    $ret .= '<span id="mobileshare_desc">' . __("share this page", "wp-mobileshare") . '</span>';
    $ret .= '</div>';
    $ret .= '<br clear="both" />';
    return $ret;
}

// ------------------------
// The filter:
function wp_mobileshare_after_content($content) {
    if (get_option('mobileshare_also_pages') && is_page() || is_single()) {
        $content .= wp_mobileshare_shortcode();
    }
    
    return $content;
}

// ------------------------
// Set up the ACP
function wp_mobileshare_admin() {  
    include('wp-mobileshare-admin.php');  
}  
  
function wp_mobileshare_admin_action() {
    add_options_page("MobileShare", "MobileShare", 'manage_options', plugin_basename(__FILE__), "wp_mobileshare_admin");  
}

add_action('admin_menu', 'wp_mobileshare_admin_action');

// ------------------------
// Add meta links
function wp_mobileshare_plugin_actions( $links, $file ) {
    static $plugin;
    if (!$plugin) $plugin = plugin_basename(__FILE__);
 
    // create additional plug-in row
    if ($file == $plugin) {
        $links[] = '<strong><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=der_tuxman%40arcor%2ede&item_name=Donation%20for%20the%20MobileShare%20plugin&no_shipping=1&return=https%3a%2f%2ftuxproject%2ede%2fthx4donation%2f&cn=Note%20for%20me&tax=0&currency_code=EUR&bn=PP%2dDonationsBF&charset=UTF%2d8">' . __("Donate via PayPal", "wp-mobileshare") . '</a></strong>';
    }
    return $links;
}
add_filter('plugin_row_meta', 'wp_mobileshare_plugin_actions', 10, 2);

// ------------------------
// Add the filter:
if (get_option('mobileshare_placement') == "below") {
    add_filter('the_content', 'wp_mobileshare_after_content');
}

// ------------------------
// Register the shortcode:
add_shortcode('mobileshare', 'wp_mobileshare_shortcode');

// ------------------------
// Disable the button if not relevant:
function mobileshare_scripts() {
    if (get_option('mobileshare_also_pages') && is_page() || is_single()) {
?>
<style type="text/css">
    #mobileshare_button {
        display:block;
    }
</style>

<script type="text/javascript">
jQuery(function() {
    if (jQuery("#mobileshare_button").length) {
<?php
        if (get_option('mobileshare_only_supported')) {
?>
            if (!navigator.share) { jQuery("#mobileshare_button").hide(); }
<?php
        }
?>
        jQuery("#mobileshare_button").off("click").on("click", function() {
            navigator.share({
              title: jQuery("<textarea/>").html("<?php echo the_title(); ?>").val(),
              text: jQuery("<textarea/>").html("<?php echo the_excerpt(); ?>").val(),
              url: "<?php echo the_permalink(); ?>"
            })
        });
    }
});
</script>
<?php
    }
}

if (wp_is_mobile()) {
    add_action('wp_head', 'mobileshare_scripts');
}
?>