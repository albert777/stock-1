<?php
/**
 * Fonctions utiles au plugin Stock de produit
 *
 * @plugin     Stock de produit
 * @copyright  2017
 * @author     Phenix
 * @licence    GNU/GPL
 * @package    SPIP\Stock\Fonctions
 */

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

include_spip('inc/stock');
function balise_STOCK_dist($p) {
	$id_produit = champ_sql('id_produit', $p);
	$p->code = "stock($id_produit)";
	return $p;
}

function filtre_stock_verifier_dispo_dist($id_produit, $quantite) {
	if (stock_verifier_dispo($id_produit, $quantite)) {
		return ' ';
	} else {
		return '';
	}
}


function filtre_stock_commande_verifier_dispo_dist($id_commande) {
	if (stock_commande_verifier_dispo($id_commande)) {
		return ' ';
	} else {
		return '';
	}
}
