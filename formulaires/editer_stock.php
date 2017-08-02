<?php

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

function formulaires_editer_stock_charger_dist($id_produit) {

	// Récupération du stock actuel du produit
	include_spip('inc/stock');
	$stock = stock($id_produit);

	// Contexte du formulaire.
	$contexte = array(
		'stock' => $stock
	);

	return $contexte;
}

/**
 *	Fonction de vérification, cela fonction avec un tableau d'erreur.
 *	Le tableau est formater de la sorte:
 *	if (!_request('NomErreur')) {
 *		$erreurs['message_erreur'] = '';
 *		$erreurs['NomErreur'] = '';
 *	}
 *	Pensez à utiliser _T('info_obligatoire'); pour les éléments obligatoire.
 */
function formulaires_editer_stock_verifier_dist($id_produit) {
	$erreurs = array();

	return $erreurs;
}

function formulaires_editer_stock_traiter_dist($id_produit) {
	//Traitement du formulaire.

	// Donnée de retour.
	return array(
		'editable' => true,
		'message_ok' => '',
		'redirect' => ''
	);
}
