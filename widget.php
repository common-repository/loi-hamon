<?php
class LoiHamon_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct(
			'woo_loi_hamon_widget_id', // Base ID
			'Woocommerce - Loi Hamon', // Name
			array( 'description' => "Widget pour afficher les informations obligatoires de la loi Hamon" ) // Args
		);	
	}
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		echo $args['before_title'] . "Droit de rétractation" . $args['after_title'];
		?>
        <p>Conformément à l'Article. L. 121-21. – Le consommateur dispose d'un délai de quatorze jours pour exercer son droit de rétractation.</p>
        <p>Pour exercer votre droit de rétractation <a href="<?php echo get_permalink( get_page_by_path( 'retractation_2014' ) ); ?>">cliquez ici</a></p>
        <p><strong>Paiements acceptés</strong><br /><?php
		$available_gateways=$GLOBALS['woocommerce']->payment_gateways->get_available_payment_gateways();
		$icons=array("bacs"=>plugin_dir_url(__FILE__)."/img/virement.png","cheque"=>plugin_dir_url(__FILE__)."/img/cheque.gif");
		foreach ( $available_gateways as $gateway ) {
			$icon=$gateway->icon;
			if(empty($icon)){
				$icon=$icons[$gateway->id];
			}
			echo "<img src='".$icon."' />";
		}
		?>
        </p>
		<?php
		echo $args['after_widget'];
	}

	public function form( $instance ) {
	}

	public function update( $new_instance, $old_instance ) {
		return $new_instance;
	}
}
function creation_woo_loi_hamon_widget() {
    register_widget( 'LoiHamon_Widget' );
}
add_action( 'widgets_init', 'creation_woo_loi_hamon_widget' );
?>