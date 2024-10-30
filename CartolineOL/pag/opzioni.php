<?php
	//Controllo se effettuare Upload
	if($_POST["opzioni"]){
		$filename = ABSPATH."wp-content/plugins/CartolineOL/pag/setting.php";
		$contenuto1 = "<? ".chr(36)."num='".$_POST['visiona_per_pagina']."'; ?>";
		$handle1=fopen($filename,"w"); //apre il file
		fwrite($handle1, $contenuto1);
		fclose($handle1);
		$msg="Modifiche Effettuate con Successo.";
	}
	if ($msg!='') : 
?>
<div id="message" class="updated fade"><p><strong><?php print $msg; ?></strong></p></div>
<?php
	endif;
	include ABSPATH."wp-content/plugins/CartolineOL/pag/setting.php";
?>
<center>
	<div id="structure">
		<h2><?php _e("Preferenze",'Gestione Cartoline'); ?></h2>
		Da questo pannello potrai modificare le varie impostazioni di visualizzazione delle Cartoline.<br />
		<br />
		<div class="wrap" id="carico">
			<h2><?php _e("Modifica le Opzioni Disponibili",'Gestione Cartoline'); ?></h2>
			<form name="opzioni" method="post" action=""> 
				<div id="upl_file_">
					<?php _e('Numero di file Visualizzati per pagina','Gestione Immagini') ?>
				</div>
				<div id="upl_file_inpt_">
					<select name="visiona_per_pagina" id="visiona_per_pagina">
<?php
	for ($list_index = 4; $list_index <= 40; $list_index=$list_index+4){
		if ($list_index == $num){
			$selected = " selected='selected'";
		}else{
			$selected = '';
		}
		echo "\n\t<option value='$list_index' $selected>$list_index</option>";
	}
?>
					</select>
				</div>
				<br />
				<br />
				<p class="submit" id="bottone">
					<input type="hidden" name="action" value="update" />
					<input type="hidden" name="page_options" value="organizer_list_page,organizer_filetypes" /> 
					<input type="submit" name="opzioni" value="<?php _e('Modifica le Opzioni','Gestione Immagini') ?> &raquo;" />
				</p>
			</form>
		</div>
	</div>
</center>