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
 * Retrouve tout les produits d'une commande qui possède une gestion des stocks
 *
 * @param int $id_commande
 * @access public
 * @return array
 */
function stock_produits_commande($id_commande) {
	return sql_allfetsel(
		'id_objet as id_produit, quantite',
		'spip_commandes_details',
		'objet='.sql_quote('produits').' AND id_commande='.intval($id_commande)
	);
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
	$stock = sql_getfetsel('stock', 'spip_produits', 'gestion_stock=1 AND id_produit='.intval($id_produit));
	if ($stock != null) {
		// Calculer le nouveau stock
		$new_stock = intval($stock) - intval($quantite);

		if ($new_stock < 0) {
			return false;
		}
	}

	return true;
}

/**
 * Vérifier la disponibilité des stock en fonction de la commande
 *
 * @param int $id_commande
 * @access public
 * @return bool
 */
function stock_commande_verifier_dispo($id_commande) {

	$produits = stock_produits_commande($id_commande);

	$erreur = true;
	// On vérifie les stocks pour tout les produit de la commande :
	foreach ($produits as $produit) {
		$erreur = stock_verifier_dispo($produit['id_produit'], $produit['quantite']);
		if (!$erreur) {
			return $erreur;
		}
	}

	return $erreur;
}

function filtre_stock_commande_verifier_dispo_dist($id_commande) {
	if (stock_commande_verifier_dispo($id_commande)){
		return ' ';
	} else {
		return '';
	}
}