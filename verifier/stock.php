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

	// Récupérons le stock actuel du produit
	$stock = sql_getfetsel('stock', 'spip_produits', 'gestion_stock=1 AND id_produit='.$id_produit);
	if ($stock) {
		$new_stock = intval($stock) - intval($valeur);

		if ($new_stock < 0) {
			return _T('stock:erreur_stock_insuffisant');
		}
	}

	return '';
}
