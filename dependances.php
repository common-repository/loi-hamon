<?php
register_activation_hook( __FILE__, 'dependances' );
 
function dependances()
{
  require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
  if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ){
    require_once ( WP_PLUGIN_DIR . '/woocommerce/woocommerce.php' );
  }else{
    deactivate_plugins( __FILE__);
    exit ('Erreur : Veuillez installer l\'extension Woocommerce!');
   }
}


?>