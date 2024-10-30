<?php
 
if ( ! defined( 'ABSPATH' ) ) exit;
 
/**
 * Ajout de l'email de retractation
 *
 * @since 0.1
 * @extends \WC_Email
 */
if(!class_exists("WC_Email")){
	require dirname(__FILE__).'/../woocommerce/includes/abstracts/abstract-wc-email.php';
}
class WC_Retractation_Email extends WC_Email {
 	var $contenu="vide";
	public function __construct(){
		$this->id = 'wc_retractation';
		
		$this->title = 'Demande de rétractation';
		
		$this->description = 'Email de confirmation de l\'envoi de rétractation';
		
		$this->subject = 'Demande de rétractation de la boutique {site_title}';
		$this->heading = 'Votre demande a été envoyée ce jour au service gérant les rétractations';
		
		$this->template_html  = 'modele_email.php';
		$this->template_plain = 'modele_email.php';
		$this->template_base = dirname(__FILE__)."/emails/";
		
		parent::__construct();
		
		$this->recipient = $this->get_option( 'email' );
		
		if ( ! $this->recipient )
			$this->recipient = get_option( 'admin_email' );
	}
	public function get_content_html() {
		ob_start();
		woocommerce_get_template( $this->template_html, array(
			'email_contenu' => $this->contenu,
			'email_heading' => $this->get_heading()
		),$this->template_base,$this->template_base);
		return ob_get_clean();
	}
	public function get_content_plain() {
		ob_start();
		woocommerce_get_template( $this->template_plain, array(
			'email_contenu' => $this->contenu,
			'email_heading' => $this->get_heading()
		),$this->template_base,$this->template_base);
		return ob_get_clean();
	}
	public function trigger( $contenu,$utilisateur ) {
		$this->contenu = $contenu;
		$this->send( $utilisateur, $this->get_heading(), $this->get_content(), $this->get_headers(), $this->get_attachments() );
		$this->send( $this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments() );
	}
} 