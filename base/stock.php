<?php

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}


function stock_declarer_tables_objets_sql($tables) {

	$tables['spip_produits']['field']['stock'] = 'bigint(21) NOT NULL DEFAULT 0';
	$tables['spip_produits']['champs_editables'][] = 'stock';
	$tables['spip_produits']['champs_versionnes'][] = 'stock';

	return $tables;
}
