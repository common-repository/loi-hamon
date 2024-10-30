<?php
add_shortcode("woo_loi_hamon_fax","woo_loi_hamon_fax");
add_shortcode("woo_loi_hamon_adresse","woo_loi_hamon_adresse");
add_shortcode("woo_loi_hamon_email","woo_loi_hamon_email");
function woo_loi_hamon_email($atts){
	$c=get_option("config");
	return str_replace("@","(a)",$c['email']);	
}
function woo_loi_hamon_fax($atts){
	$c=get_option("config");
	return $c["fax"];	
}
function woo_loi_hamon_adresse($atts){
	$c=get_option("config");
	return "&laquo; ".$c['societe'].", ".$c['adresse']." - ".$c['cp']." ".$c['ville']." &raquo;";	
}
add_shortcode("woo_loi_hamon_formulaire","woo_loi_hamon_formulaire_retraction_html");
function woo_loi_hamon_formulaire_retraction_html($atts){
	if(isset($_POST['valid'])){
		$message= '<p>Demande de rétractation effectuée le '.strip_tags($_POST['date_demande']).'</p>';
		$message.= '<p>Voici le détails de cette demande : <br />';
		$message.= '<strong>Nom/Prénom</strong> : '.ucwords(strtolower(strip_tags($_POST['nom']).' '.strip_tags($_POST['prenom']))).'<br />';		
		$message.= '<strong>Email</strong> : '.strip_tags($_POST['email']).'<br />';		
		$message.= '<strong>Téléphone</strong> : '.strip_tags($_POST['telephone']).'<br />';		
		$message.= '<strong>Numéro de commande</strong> : '.strip_tags($_POST['commande']).'<br />';		
		$message.= '<strong>Date de commande</strong> : '.strip_tags($_POST['date_commande']).'<br />';		
		$message.= '<strong>Motif de la demande</strong> : <br />'.strip_tags($_POST['motif']);		
		$message.='</p>';
		$formulaire='<div class="succes" id="retract_ok"><strong>Votre demande de rétractation a bien été envoyée, vous allez recevoir un email de confirmation d\'envoi dans les plus brefs délais.<strong></div>';
		require( 'class-retractation-email.php' );
		$retract = new WC_Retractation_Email();
		$retract->trigger(utf8_decode($message),strip_tags($_POST['email']));
	}else{
		$formulaire = '<form action="#retract_ok" method="post" class="retractation">';
		$formulaire.= '<p><label><span class="label">*Nom</span> : <input type="text" name="nom" required="required" /></label></p>';
		$formulaire.= '<p><label><span class="label">*Prénom</span> : <input type="text" name="prenom" required="required" /></label></p>';
		$formulaire.= '<p><label><span class="label">*Email</span> : <input type="text" name="email" required="required" /></label></p>';
		$formulaire.= '<p><label><span class="label">*Téléphone</span> : <input type="text" name="telephone" required="required" /></label></p>';
		$formulaire.= '<p><label><span class="label">*Numéro de commande</span> : <input type="text" name="commande" required="required" /></label></p>';
		$formulaire.= '<p><label><span class="label">*Date commande</span> : <input type="date" name="date_commande" required="required" /></label></p>';
		$formulaire.= '<p><label><span class="label">*Date de la demande</span> :
		<input type="text" name="date_demande" value="'.date('d/m/Y H:i').'" readonly="readonly" /></label></p>';
		$formulaire.= '<p><label><span class="label">Motif de la demande</span> :
		<textarea name="motif"></textarea></label></p>';
		$formulaire.= '<p><input type="submit" name="valid" value="Valider et envoyer ma demande de rétractation immédiatement" /><div class="alert">En cliquant sur le bouton ci-dessus, je confirme envoyer une demande de rétractation dans la pleine possession de mes moyens.</div></p>';
		$formulaire.="</form><p>Les champs marqués d'une étoile sont obligatoires !</p>";
		$formulaire.= '<style type="text/css">.retractation .label{ display:inline-block;width:180px;} </style>';
	}
	return $formulaire;	
}
?>