<?php
	require_once(ABSPATH .'wp-content/plugins/CartolineOL/funzioni_plugin.php');
	global $thumb_dir,$col_path,$directory;

	//Controllo richiesta aggiornamento nome
	if($_POST["modifica"]){
		if(strlen($_POST["_nuovo_file_"])>0){
			$msg=@rename(ABSPATH.$_POST["_file_"],ABSPATH.$thumb_dir.$_POST["_nuovo_file_"].".".col_get_file_ext($_POST["_file_"]))?"Il Nome della Cartolina &egrave; stato Modificato.":"ATTENZIONE: Nessuna Modifica Effettuata con Successo al nome della Cartolina.";
		}else{
			$msg='Attenzione devi inserire un nome all\'interno del campo modifica';
		}
	}
	//Controllo richiesta eliminazione
	if($_POST["elimina"]){
		$msg=unlink(ABSPATH.$_POST["_file_"])?"Eliminazione Effettuata.":"ATTENZIONE: Nessuna Eliminazione Effettuata con Successo.";
	}
	//Lista immagini da directory
	$page=isset($_REQUEST['p'])?intval($_REQUEST['p']):1;

	$files = new ListaFile;
	$files->path=col_fix_win_path($directory);
	$files->list=get_option('col_visiona_per_pagina');
	$files->extensions=get_option('col_tipi_file');
	$files->get_directory_files();
	$files->page=$page;
	$file_list=$files->get_directory_page();

	$view_page_url = "admin.php?page=CartolineOL/pag/index.php";
	$this_page_url = $view_page_url;

	if ($msg!='') : 
?>
<div id="message" class="updated fade"><p><strong><?php print $msg; ?></strong></p></div>
<?php
	endif;
?>
<center>
	<div id="structure">
		<h2>Visiona Cartoline</h2>
		Qu&igrave; sotto troverai tutte la cartoline caricate in precedenza.<br />
		Clicca sul nome del file per visionare la cartolina.<br />
		<br />
		<a href="?page=CartolineOL/pag/carico.php">Carica &raquo;</a>

		<div class="wrap" id="visione">
			<h2><?php _e("Ecco le Cartoline Caricate",'Gestione Cartoline'); ?></h2>
			<div>
<?php
	if($file_list){
		$bg_alternato="class='alternates'";
		foreach($file_list as $flno => $file){
			$view_url = "<a href=\"".get_option('siteurl')."/"."$thumb_dir"."$file[name]\" rel=\"lightbox[cartoline]\">{$file[name]}</a>";
			print "	<div $bg_alternato>";
			if(col_is_file_img($file[name])){
				$thumb_url = get_option('siteurl')."/".$thumb_dir.urlencode($file[name]);
				print "<div class=\"img_cartolina\"><img src=\"$thumb_url\" alt=\"Anteprima\" width='150' height='150' /></div>";
			}else{
				print "<div class=\"img_cartolina\">Anteprima non disponibile</div>";
			}
			$js_eli="onclick=\"if ( confirm('" . js_escape(sprintf(__("Sei sicuro di voler eliminare la Cartolina '%s' ?"), $file[name] )) . "') ) { document.forms.eli_._conse_.value = 'ok'; return true;}return false;\"";
			print "
					<div class=\"info_cartolina\">
						<div class=\"info\">
							<strong>Nome</strong>:<br />
							<span class=\"evi\">".substr("$file[name]",0,strpos("$file[name]","."))."</span><br />
							<strong>Link</strong>:<br />
							".$view_url."<br />
							<strong>Path Assoluto</strong>:<br />
							".get_option('siteurl')."/"."$thumb_dir"."$file[name]<br />
							<strong>Data Caricamento</strong>:<br />
							".col_format_data(date("F j, Y, g:i a",$file["time"]))."<br />
							<strong>Dimensione File</strong>:<br />
							".number_format($file["size"]/1024)." Kb<br />
							<form method=\"post\" action=\"\">
								<input type=\"hidden\" name=\"_file_\" value=\"".$thumb_dir."$file[name]\" />
								<div class=\"mod_\">
									<p class=\"submit\">
										<input type=\"text\" id=\"nuovo_file_\" name=\"_nuovo_file_\" value=\"\" />
										<input type=\"submit\" name=\"modifica\" id=\"butt_nuovo_file_\" value=\"Modifica Nome Cartolina\" />
									</p>
								</div>
							</form>
							<form id=\"eli_\" method=\"post\" action=\"\">
								<input type=\"hidden\" name=\"_file_\" value=\"".$thumb_dir."$file[name]\" />
								<input type=\"hidden\" name=\"_conse_\" value=\"\" />
								<div class=\"eli_\">
									<p class=\"submit\">
										<input name=\"elimina\" class=\"button delete\" type=\"submit\" value=\"Elimina\" ".$js_eli." />
									</p>
								</div>
							</form>
						</div>
					</div>
			";
			if ($bg_alternato=="class='alternates'"){
				$bg_alternato="class='alternates_'";
			}else{
				$bg_alternato="class='alternates'";
			}
			print "</div>\n\n";
		}
	}else{
		if($php_gd){
			print '<div>'.__('Ancora non ci sono cartoline caricate','Gestione Cartoline').'</div>';
		}else{
			print '<div>'.__('Ancora non ci sono cartoline caricate.','Gestione Cartoline').'</div>';
		}
	}
	if($files->tpages>1){
?>
			<div id="floor_">
				<div class="floor"><?php if ($page-1 > 0){?><a href="<?php print $this_page_url."&p=".($page-1)."&d=".$current_dir;?>" class="edit">Precedente</a><?php }else{ ?>&nbsp;<?php }?></div>
				<div class="floor"><?php  _e('Pagina','Gestione Cartoline'); ?> <?php print$page; ?> <?php _e('di','Gestione Cartoline');?> <?php print $files->tpages;?></div>
				<div class="floor"><?php if ($page+1 <= $files->tpages){?><a href="<?php print $this_page_url."&p=".($page+1);?>" class="edit">Prossima</a><?php }else{ ?>&nbsp;<?php }?></div>
			</div>
<?php
	}
?>
		</div>
</center>
