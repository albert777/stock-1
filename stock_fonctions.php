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
 * Calcul le stock d'un produit. On prend en compte les éventuel commande avec
 * le statut "encours" afin de leur réserver les produits
 *
 * @param int $id_produit
 * @access public
 * @return int
 */
function stock($id_produit) {

	// Récupérons le stock actuel du produit
	$stock = sql_getfetsel('stock', 'spip_produits', 'gestion_stock=1 AND id_produit='.intval($id_produit));

	// On supprime également du stock les éventuel éléments qui serait dans des commandes "encours"
	// Une commande en cours réserve donc une partie des éléments du stock pour elle.
	$encours = sql_getfetsel(
		'SUM(quantite) AS nb',
		'spip_commandes_details AS cd
		INNER JOIN spip_commandes AS c ON cd.id_commande = c.id_commande',
		'objet='.sql_quote('produits').' AND id_objet='.intval($id_produit).' AND c.statut='.sql_quote('encours')
	);

	$stock = intval($stock) - intval($encours);

	return $stock;
}

function balise_STOCK_dist($p) {
	$id_produit = champ_sql('id_produit', $p);
	$p->code = "stock($id_produit)";
	return $p;
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

	// Si la gestion des stock n'est pas activée pour le produit on renvoie true
	$gestion = sql_getfetsel('gestion_stock', 'spip_produits', 'id_produit='.intval($id_produit));
	if (!$gestion) {
		return true;
	}

	$stock = stock($id_produit);

	// Calculer le nouveau stock
	$new_stock = intval($stock) - intval($quantite);

	if ($new_stock < 0) {
		return false;
	}

	return true;
}

function filtre_stock_verifier_dispo_dist($id_produit, $quantite) {
	if (stock_verifier_dispo($id_produit, $quantite)) {
		return ' ';
	} else {
		return '';
	}
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
	if (stock_commande_verifier_dispo($id_commande)) {
		return ' ';
	} else {
		return '';
	}
}
