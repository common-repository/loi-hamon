<?php
if ( ! defined( 'ABSPATH' ) ) exit;?>

<?php do_action( 'woocommerce_email_header', $email_heading ); ?>
<?php echo $email_contenu ?>
<?php do_action( 'woocommerce_email_footer' ); ?>
