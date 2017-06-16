<?php

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}


function stock_declarer_tables_objets_sql($tables) {

	// Un champ pour stocker le stock :)
	$tables['spip_produits']['field']['stock'] = 'bigint(21) NOT NULL DEFAULT 0';
	$tables['spip_produits']['champs_editables'][] = 'stock';
	$tables['spip_produits']['champs_versionnes'][] = 'stock';

	// Un champ pour gérer l'activation ou non de la gestion des stock sur le produit
	$tables['spip_produits']['field']['gestion_stock'] = 'tinyint(1) NOT NULL DEFAULT 0';
	$tables['spip_produits']['champs_editables'][] = 'gestion_stock';
	$tables['spip_produits']['champs_versionnes'][] = 'gestion_stock';

	return $tables;
}
