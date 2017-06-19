<?php
/**
 * Utilisations de pipelines par Stock de produit
 *
 * @plugin     Stock de produit
 * @copyright  2017
 * @author     Phenix
 * @licence    GNU/GPL
 * @package    SPIP\Stock\Pipelines
 */

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

function stock_formulaire_saisies($flux) {

	if ($flux['args']['form'] == 'editer_produit') {
		$flux['data'][] = array(
			'saisie' => 'case',
			'options' => array(
				'nom' => 'gestion_stock',
				'label_case' => _T('stock:activer_gestion_stock'),
				'li_class' => 'pleine_largeur',
				'valeur_oui' => 1,
				'afficher_si' => '@immateriel@==""'
			)
		);

		$flux['data'][] = array(
			'saisie' => 'fieldset',
			'options' => array(
				'nom' => 'stock_fields',
				'label' => _T('stock:fieldset_stock'),
				'afficher_si' => '@immateriel@==""&&@gestion_stock@=="1"'
			),
			'saisies' => array(
				array(
					'saisie' => 'input',
					'options' => array(
						'nom' => 'stock',
						'type' => 'number',
						'label' => _T('stock:champ_stock_label')
					),
					'verifier' => array(
						'type' => 'entier',
						'options' => array(
							'min' => 0
						)
					)
				)
			)
		);
	}

	return $flux;
}

function stock_affiche_milieu($flux) {

	if ($exec = trouver_objet_exec($flux['args']['exec'])
		and $exec['edition'] == false
		and $exec['type'] == 'produit'
	) {
		$id_produit = intval($flux['args']['id_produit']);
		$texte = recuperer_fond('prive/squelettes/info/stock_affiche_milieu', array('id_produit' => $id_produit));
	}

	if (isset($texte)) {
		if ($p = strpos($flux['data'], '<!--affiche_milieu-->')) {
			$flux['data'] = substr_replace($flux['data'], $texte, $p, 0);
		} else {
			$flux['data'] .= $texte;
		}
	}

	return $flux;
}

function stock_post_edition($flux) {

	if ($flux['args']['table'] == table_objet_sql('commande')
		and $flux['args']['action'] == 'instituer'
		and $flux['args']['statut_ancien'] == 'encours'
		and $flux['data']['statut'] == 'paye'
	) {
		// on va réduire les stock car la commande va être envoyée.
		$id_commande = $flux['args']['id_objet'];

		// On récupère le détail de la commande
		$objets = stock_produits_commande($id_commande);

		foreach ($objets as $objet) {
			$quantite = $objet['quantite'];

			// supprimer la quantité vendue de la commande
			sql_update(
				'spip_produits',
				array('stock' => 'stock-'.$quantite),
				'id_produit='.intval($objet['id_objet']).' AND gestion_stock=1'
			);
		}
	}

	return $flux;
}
