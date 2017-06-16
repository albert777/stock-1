<?php

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

function verifier_stock_dist($valeur, $options = array()) {
	$id_produit = intval($options['id_produit']);

	// Vérifier qu'on a bien un nombre
	$verifier = charger_fonction('verifier', 'inc');
	if ($decimal = $verifier($valeur, 'decimal', array('min' => 1))) {
		return $decimal;
	}

	include_spip('stock_fonctions');
	if (!stock_verifier_dispo($id_produit, $valeur)) {
		return _T('stock:erreur_stock_insuffisant');
	}

	return '';
}
