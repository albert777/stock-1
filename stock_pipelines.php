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
				'label' => _T('stock:fieldset_stock')
			),
			'saisies' => array(
				array(
					'saisie' => 'input',
					'options' => array(
						'nom' => 'stock',
						'type' => 'number',
						'label' => _T('stock:titre_stock')
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
