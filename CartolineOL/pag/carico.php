<?php
	
	require_once(ABSPATH .'wp-content/plugins/CartolineOL/funzioni_plugin.php');
	$directory = ABSPATH.'wp-content/uploads/cartoline/';
	//Controllo se effettuare Upload
	if($_POST["carico"]){
		$sovrascrivi=isset($_POST['sovrascrivi'])?true:false;
		if($_FILES['upload_file']['tmp_name']!=''){
			if(strpos(strtolower(get_option('col_tipi_file')),strtolower(col_get_file_ext($_FILES['upload_file']['name'])))===false){
				$msg = __('Tipo di file non consentito','Gestione Cartoline');
			}else{
				if(is_writable(col_fix_win_path($directory))){
					$file_creato = col_fix_win_path($directory.'/'.col_pulisci_stringa($_FILES['upload_file']['name']));
					if(is_file($file_creato)){
						if($sovrascrivi){
							if(is_writable($file_creato)){
								@unlink($file_creato);
								if(move_uploaded_file($_FILES['upload_file']['tmp_name'], $file_creato)){
									@chmod($file_creato,0666);
									$msg = __('File Caricato','Gestione Cartoline');
								}else{
									$msg = __('Errore nel caricamento del File','Gestione Cartoline');
								}
							}else{
								$msg = __('Il file precedente non pu&ograve; essere rinominato','Gestione Cartoline');
							}
						}else{
							$msg = __('Il File &egrave; gi&agrave; esistente','Gestione Cartoline');
						}
					}else{
						if(move_uploaded_file($_FILES['upload_file']['tmp_name'], $file_creato)){
							@chmod($file_creato,0666);
							$msg = __('File Caricato','Gestione Cartoline');
						}else{
							$msg = __('Errore nel caricamento del File','Gestione Cartoline');
						}
					}
				}else{
					$msg = __('La cartella di destinazione non &egrave; modificabile','Gestione Cartoline');
				}
			}
		}else{
			$msg = __('Seleziona un file da caricare','Gestione Cartoline');
		}
	};
?>
		<center>
<?php if ($msg!='') : ?>
			<div id="message" class="updated fade"><p><?php print $msg; ?></p></div>
<?php endif; ?>
			<div id="structure">
				<h2>Gestione Cartoline</h2>
				Tutte le cartoline verranno salvate nella cartella <strong><?php print $directory;?></strong>
				<br />
				<form name="frm_up" id="frm_up" method="post" action="" enctype="multipart/form-data"> 
					<div class="wrap" id="carico">
						<h2><?php _e('Carica Cartoline','Gestione Cartoline'); ?></h2>
						<div id="upl_file_">
							<?php _e('Seleziona il file da caricare :','Gestione Cartoline'); ?>
						</div>
						<div id="upl_file_inpt_">
							<input type="file" name="upload_file" id="upload_file" />
						</div>
						<br />
						<br />
						<div>
							<input type="checkbox" name="sovrascrivi" value="1" />
							<label for="sovrascrivi"><?php _e('Sovrascrivi il file se &egrave; gi&agrave; esistente','Gestione Cartoline'); ?></label>
						</div>
						<p class="submit">
							<input type="submit" name="carico" value="<?php _e('Carica','Gestione Cartoline') ?> &raquo;" />
						</p>
					</div>
				</form>
				<a href="?page=CartolineOL/pag/index.php">&laquo; Visiona le Cartoline Caricate</a>
			</div>
		</center>
