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
			'saisie' => 'fieldset',
			'options' => array(
				'nom' => 'stock_fields',
				'label' => _T('stock:fieldset_stock'),
				'afficher_si' => '@immateriel@==""'
			),
			'saisies' => array(
				array(
					'saisie' => 'case',
					'options' => array(
						'nom' => 'gestion_stock',
						'label' => _T('stock:activer_gestion_stock')
					)
				),
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
