<?php

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

function stock_upgrade($nom_meta_base_version, $version_cible) {

	$maj['create'] = array(
	    array('maj_tables', array('spip_produits'))
	);

	include_spip('base/upgrade');
	maj_plugin($nom_meta_base_version, $version_cible, $maj);
}

/**
 * Fonction de désinstallation du plugin Stock.
 *
 * @param string $nom_meta_base_version
 *     Nom de la meta informant de la version du schéma de données du plugin installé dans SPIP
 * @return void
 * */
function stock_vider_tables($nom_meta_base_version) {

	effacer_meta($nom_meta_base_version);
}
