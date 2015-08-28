<?php
/*
Plugin Name: Google Analytics Manager
Plugin URI: http://wordpress.org/extend/plugins/simplegamanager/
Description: Enables <a href="http://www.google.com/analytics/" target="_blank">Google Analytics</a> on all pages.
Version: 1.0.0
Author: Justin Rains
Author URI: http://portalplanet.net/about/plugins/gamanager/
*/

if (!defined('WP_CONTENT_URL'))
      define('WP_CONTENT_URL', get_option('siteurl').'/wp-content');
if (!defined('WP_CONTENT_DIR'))
      define('WP_CONTENT_DIR', ABSPATH.'wp-content');
if (!defined('WP_PLUGIN_URL'))
      define('WP_PLUGIN_URL', WP_CONTENT_URL.'/plugins');
if (!defined('WP_PLUGIN_DIR'))
      define('WP_PLUGIN_DIR', WP_CONTENT_DIR.'/plugins');

function activate_gamanager() {
  add_option('analytics_id', 'UA-xxxxxxxxx');
}

function deactive_gamanager() {
  delete_option('analytics_id');
}

function admin_init_gamanager() {
  register_setting('gamanager', 'analytics_id');
}

function admin_menu_gamanager() {
  add_options_page('Google Analytics Manager', 'Google Analytics Manager', 'manage_options', 'gamanager', 'options_page_gamanager');
}

function options_page_gamanager() {
  include(WP_PLUGIN_DIR.'/simple-google-analytics-manager/options.php');  
}

function gamanager() {
  $tag_id = get_option('analytics_id');
?>
<!-- Google Analytics Manager -->
<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(['_setAccount', '<?php echo $tag_id;?>']);
_gaq.push(['_trackPageview']);
(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
</script>
<!-- End Simple Google Analytics Manager -->
<?php
}

register_activation_hook(__FILE__, 'activate_gamanager');
register_deactivation_hook(__FILE__, 'deactive_gamanager');

if (is_admin()) {
  add_action('admin_init', 'admin_init_gamanager');
  add_action('admin_menu', 'admin_menu_gamanager');
}

//if (!is_admin()) {
  add_action('wp_head', 'gamanager');
//}

?>
