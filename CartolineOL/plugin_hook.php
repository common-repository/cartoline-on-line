<?php
/*
Plugin Name: CartolineOL
Plugin URI: http://www.arkosoft.it/
Description: Plugin per l'invio di cartoline online per info <a href="http://www.arkosoft.it/contatti.html">qui</a>
Version: 1.2
Author: Arkosoft Staff
Author URI: http://www.arkosoft.it/
*/

//Include delle funzioni del plugin
include_once("funzioni_plugin.php");
include_once("lettore_file.php");

//Installazione col [Cartoline OnLine]
col_install_col();

//Call all'aggiunta pagine
add_action('admin_menu', 'col_set_pag');
add_action('admin_head','col_inizializzazione');
add_action('admin_head','col_add_css_head');
add_action('wp_head', 'col_add_js_head');
add_action('wp_head', 'col_add_css_head');

//Creazione Cartella "cartoline/" in Uploads
col_crea_dir(ABSPATH.'/'.get_option('upload_path').'/cartoline/');

//Se il Blog non utilizza il PermaLink lo Setta Standard
/*
if(get_option('permalink_structure')==''){
	update_option('permalink_structure','/%category%/%postname%/', 20, 'yes');
}
*/

//Per inviare le cartoline bisogna essere loggati e registrati quindi setto l'opzione adatta
update_option("comment_registration", '1', 20, 'yes');

//Creo la Pagina per la visualizzazione esterna
col_pagine_al_db();
?>
