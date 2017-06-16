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

/**
 * Verifier si une quantité est disponible dans le stock d'un produit
 *
 * @param int $id_produit
 * @param int $quantite
 * @access public
 * @return bool
 */
function stock_verifier_dispo($id_produit, $quantite) {

	// Récupérons le stock actuel du produit
	$stock = sql_getfetsel('stock', 'spip_produits', 'gestion_stock=1 AND id_produit='.$id_produit);
	if ($stock) {
		$new_stock = intval($stock) - intval($quantite);

		if ($new_stock < 0) {
			return false;
		}
	}

	return true;
}
