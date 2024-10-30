<?php
/*
Tutte le funzioni del Plugin
*/

//Dichiarazione variabili
$tipi_img_supp=array("jpg","jpeg","gif","png","bmp");

//Aggiunta Pagine Plugin nel pannello di Amministrazione
function col_set_pag() {
	// Add a new top-level menu (ill-advised):
	add_menu_page('Gestione Cartoline','Gestione Cartoline',10,"CartolineOL/pag/index.php");
	add_submenu_page("CartolineOL/pag/index.php",'Visiona Cartoline','Visiona Cartoline', 10, 'CartolineOL/pag/index.php');
	add_submenu_page("CartolineOL/pag/index.php",'Carica Cartoline','Carica Cartoline', 10, 'CartolineOL/pag/carico.php');
	add_submenu_page("CartolineOL/pag/index.php",'Preferenze','Preferenze', 10, 'CartolineOL/pag/opzioni.php');
}

//Installazione Cartoline OnLine
function col_install_col(){
	add_option('col_installato', '1','Installato', 'yes');
	add_option('col_versione', '1.1','Versione', 'yes');
	add_option('col_visiona_per_pagina', '4','File per Pagina', 'yes');
	add_option('col_tipi_file', 'jpg jpeg gif png bmp','Tipi File', 'yes');
	add_option('col_dim_vista','160','Dimensione Immagine Vista Esterna', 'yes');
}
//Aggiunta Foglio di Stile
function col_add_js_head(){
	global $col_path_,$user_ID,$user_identity;
	print "
		<script language=\"javascript\">
			function col_aggiorna(){ 
				document.getElementById(\"col_contenuto\").innerHTML = \"<iframe frameborder='0' id='vis_cartoline' src='".get_option('siteurl').$col_path_."/wp-content/plugins/CartolineOL/funct/vis_ext.php?ABSPATH=".ABSPATH."&up=".get_option('upload_path')."&np=".get_option('col_visiona_per_pagina')."&ext=".get_option('col_tipi_file')."&siteurl=".get_settings('siteurl')."&col_dim_vista=".get_option('col_dim_vista')."&user_identity=".$user_identity."&blogname=".get_option('blogname')."'/>\";
				clearInterval(x);
			}
			x=setTimeout(\"col_aggiorna()\", 1500);
		</script>
	";
}
function col_add_css_head(){
	global $col_path_,$user_ID,$user_identity;
	print "<link rel=\"stylesheet\" href=\"".get_option('siteurl')."/wp-content/plugins/CartolineOL/css/stile.css\" type=\"text/css\" />\n";
	print "<link rel=\"stylesheet\" href=\"".get_option('siteurl')."/wp-content/plugins/CartolineOL/css/lightbox.css\" type=\"text/css\" media=\"screen\" />\n";/*
	print "<script src=\"".get_option('siteurl').$col_path_."/wp-content/plugins/CartolineOL/js/prototype.js\" type=\"text/javascript\"></script>\n";
	print "<script src=\"".get_option('siteurl').$col_path_."/wp-content/plugins/CartolineOL/js/scriptaculous.js?load=effects\" type=\"text/javascript\"></script>\n";
	print "<script src=\"".get_option('siteurl').$col_path_."/wp-content/plugins/CartolineOL/js/lightbox.js\" type=\"text/javascript\"></script>\n";*/
}
//Controllo sul file per capire se è immagine
function col_is_file_img($nome_file){
	global $tipi_img_supp;
	if (in_array(col_get_tipo_img($nome_file), $tipi_img_supp)) { 
		return true;
	}else{
		return false;
	}
}
//Inizializzo le variabili del plugin
function col_inizializzazione(){
	//Creo le variabili globali
	global $directory,$col_path,$thumb_dir,$col_invio_op_path;

	//Setto la cartella del plugin.
	$col_path = ABSPATH.'wp-content/plugins/CartolineOL/';

	//Setto la cartella di upload.
	$directory = ABSPATH.'wp-content/uploads/cartoline/';

	//Setto la cartella di upload.
	$thumb_dir = 'wp-content/uploads/cartoline/';

	//Path per lo script di invio e-mail
	$col_invio_op_path = ABSPATH.'wp-content/plugins/CartolineOL/funct/invio_op.php';
}
//Trasforma le path windows per l'upload
function col_fix_win_path($path){
	$path = str_replace("\\","/",$path);
	$path = str_replace("//","/",$path);
	$path = str_replace("//","/",$path);
	$path = str_replace("//","/",$path);
	if(substr($path, -1)=='/'){
		$path = substr($path,0,strlen($path)-1);
	}
	return $path;
}
//Creazione directory
function col_crea_dir($path_){
	if(!is_dir($path_)){
		$crea_dir = col_fix_win_path($path_);
		if(@mkdir($crea_dir,0777)){
			@chmod($crea_dir,0777);
			$msg = 'Cartella Creata';
		}else{
			$msg = 'Creazione della Cartella non Riuscita';
		}
	}else{
		$msg = 'La Cartella &egrave; gi&agrave; esistente';
	}
	return $msg;
}
//Formattazione Data all'Italiana
function col_format_data($data){
	$comodo=split(" ",$data);
	foreach($comodo as $val){
		$val=str_replace(","," ",$val);
	};
	switch(strtolower($comodo[0])){
		case 'january':$comodo[0]='Gennaio';break;
		case 'february':$comodo[0]='Febbraio';break;
		case 'march':$comodo[0]='Marzo';break;
		case 'april':$comodo[0]='Aprile';break;
		case 'may':$comodo[0]='Maggio';break;
		case 'june':$comodo[0]='Giugno';break;
		case 'july':$comodo[0]='Luglio';break;
		case 'august':$comodo[0]='Agosto';break;
		case 'september':$comodo[0]='Settembre';break;
		case 'october':$comodo[0]='Ottobre';break;
		case 'november':$comodo[0]='Novembre';break;
		case 'december':$comodo[0]='Dicembre';break;
	};
	if($comodo[4]=='pm'){
		$comodo_=split(":",$comodo[3]);
		$comodo_[0]=$comodo_[0]+12;
		$comodo[3]=$comodo_[0].':'.$comodo_[1];
	}
	$data=$comodo[1].$comodo[0]." ".$comodo[2]." alle ".$comodo[3];
	return $data;
}
function col_pagine_al_db(){
	global $wpdb;
	//Controllo se le pagina "Invio Cartolina" è presente nel database
	$check = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_status='publish' AND post_name='invia-cartolina'");
		
	//Se la pagina "Invio Cartolina" non è stata trovata viene creats
	if (!$check) {	
		$post_author = 1;
		$post_date = current_time('mysql');
		$post_date_gmt = current_time('mysql', 1);
		$post_content = "Seleziona la cartolina che ti piace ed inviala tramite mail a chi vuoi.<br /><div id=\"col_contenuto\"></div><br />Invia la tua Cartolina OnLine !!!<br /> <small><a href=\"http://cartolineonline.pluginwordpress.org/\">Plugin</a> per Wordpress sviluppato da <strong>Arkosoft</strong>&quot;</small><br /><br />";
		$post_title = "Invia Cartolina";
		$post_status = "publish";
		$comment_status = "open";
		$ping_status = "open";
		$post_type = "page";
		
		$post_data = compact('post_author', 'post_date', 'post_date_gmt', 'post_content', 'post_title', 'post_status', 'comment_status', 'ping_status', 'post_type');
			
		$sql1 = wp_insert_post($post_data);
				
		$maxid = $wpdb->get_var("SELECT MAX(ID) FROM $wpdb->posts");
		$sqlpost2cat = "INSERT INTO $wpdb->post2cat (post_id, category_id) VALUES ('$maxid','1')";
		$sql2= "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) VALUES ('$maxid','_wp_page_template',default)";
		$sql3 = $wpdb->query($sql2);
	}
}
//Funzione per riconoscere l'estensione del file
function col_get_file_ext($nome_file){
	return strrev(substr(strrev($nome_file),0,strpos(strrev($nome_file),'.')));
}

function col_get_tipo_img($nome_file){
	$file_info=pathinfo($nome_file);
	return strtolower($file_info['extension']);
}
	
function col_crea_nomefile($path,$nome_file){
	if(substr($path,-1)=='/'){
		return $path.$nome_file;
	}else{
		return $path.'/'.$nome_file;
	}
}
	
function col_apri_file_img($path,$nome_file){
	$image_file_type = col_get_tipo_img($nome_file);
		
	if($image_file_type=="gif"){
		 return imagecreatefromgif(col_crea_nomefile($path,$nome_file)); 
	}elseif($image_file_type=="png"){
		 return imagecreatefrompng(col_crea_nomefile($path,$nome_file)); 
	}elseif($image_file_type=="jpg" || $image_file_type=="jpeg"){
		 return imagecreatefromjpeg(col_crea_nomefile($path,$nome_file)); 
	}
}

function col_crea_img($width,$height){
	if (function_exists("imagecreatetruecolor")){
		return imagecreatetruecolor($width,$height);
	}else{
		return imagecreate($width,$height);
	}
}

function col_pulisci_stringa($source){
	$source=sanitize_file_name($source);
	return $source;
}
?>
