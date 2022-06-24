<?php 
include('cfg/core.php');
include('cfg/users_class.php');

$account->sessionLogin();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<title><?php echo $website->title; ?>: Home</title>
	<?php require_once('header-cpainel.php'); ?>
</head>
<body>
	<?php include('hm_menu_cpanel.php'); ?>
<main class="chart">
	<h2 class="text-center pt-3">Gerenciamento de infográfico de Sustentabilidade</h2>
	<div class="card-box">
		<div class="row">
			<div class="col"><h4>Sustentabilidade</h4></div>
			<div class="col">
				<a href="#" class="button2 card_button-add" onclick="$('#SAVECHANGES').submit();">
				<span>Salvar</span></a>
			</div>
		</div>
		<div class="row">
		
		</div>
	</div>
	<div class="row card-box-results">
	<?php
		$conn->link = $conn->connect();

		if($stmt = $conn->link->prepare("SELECT * FROM chart LIMIT 1")){
			try{
				$stmt->execute();
				$row = get_result($stmt);
			}
			catch(Exception $e){
				throw new Exception('Erro ao conectar com a base de dados: '. $e);
			}

			if($stmt->num_rows > 0){
				for($i = 0; $i < $stmt->num_rows; $i++){
					echo '<div class="col-auto card-result-body w-100">
						<div class="card-result-top">
							<div class="card-result-title"></div>
						</div>

						<div class="card-result-content">
							<form method="POST" id="SAVECHANGES">
								<fieldset>
									<legend>Tipo</legend>
									<div class="form-group">
										<select>
											<option value="0">Gráfico</option>
											<option value="1">Imagem</option>
										</select>
									</div>
								</fieldset>

								<!-- Chart -->
								<div data-type="0">
									<fieldset>
										<legend>Títulos</legend>

										<div class="row">
											<div class="form-group input-group col">
												<div class="input-group-append input-group-text">
													<label>Título</label>
												</div>
												<input type="text" name="options_title_text" />
											</div>

											<div class="form-group input-group col">
												<div class="input-group-append input-group-text">
													<label>Topo</label>
												</div>
												<input type="number" min="1" step="1" name="options_title_padding_top" />
											</div>

											<div class="form-group input-group col">
												<div class="input-group-append input-group-text">
													<label>Baixo</label>
												</div>
												<input type="number" min="1" step="1" name="options_title_padding_bottom" />
											</div>

											<div class="form-group col-auto">
												<label class="switch">
													<input type="checkbox" name="options_title_display" checked>
													<span class="slider"></span>
												</label>
											</div>
										</div>

										<div class="row">
											<div class="form-group input-group col">
												<div class="input-group-append input-group-text">
													<label>Subtítulo</label>
												</div>
												<input type="text" name="options_subtitle_text" />
											</div>

											<div class="form-group input-group col">
												<div class="input-group-append input-group-text">
													<label>Topo</label>
												</div>
												<input type="number" min="1" step="1" name="options_subtitle_padding_top" />
											</div>

											<div class="form-group input-group col">
												<div class="input-group-append input-group-text">
													<label>Baixo</label>
												</div>
												<input type="number" min="1" step="1" name="options_subtitle_padding_bottom" />
											</div>

											<div class="form-group col-auto">
												<label class="switch">
													<input type="checkbox" name="options_subtitle_display">
													<span class="slider"></span>
												</label>
											</div>
										</div>
										
									</fieldset>

									<fieldset>
										<legend>Dados</legend>

										<div class="row">
											<div class="form-group input-group col">
												<div class="input-group-append input-group-text">
													<label>Título</label>
												</div>
												<input type="text" name="dataset_label" />
											</div>											
										</div>

										<div class="dataFields">
											<div class="row dataField">
												<div class="form-group input-group col">
													<div class="input-group-append input-group-text">
														<label>Nome</label>
													</div>
													<input type="text" name="labels[]" />
												</div>

												<div class="form-group input-group col">
													<div class="input-group-append input-group-text">
														<label>Valor</label>
													</div>
													<input type="number" name="dataset_data[]" />
												</div>

												<div class="form-group input-group col">
													<div class="input-group-append input-group-text">
														<label>Preenchimento</label>
													</div>
													<input type="color" name="dataset_colors[]" />
													<input type="number" min="0" step="10" max="100" value="20" title="Opacidade" name="dataset_colors_opacity[]" />
												</div>

												<div class="form-group input-group col">
													<div class="input-group-append input-group-text">
														<label>Cor da Borda</label>
													</div>
													<input type="color" name="dataset_borders_color[]" />
													<input type="number" min="0" step="10" max="100" value="100" title="Opacidade" name="dataset_borders_color_opacity[]" />
												</div>
											</div>
										</div>

										<a role="button" class="button2 btn-primary" id="addmore"><span>Novo campo</span></a>
									</fieldset>

									<div class="row">
											<div class="form-group col">
												Largura da Borda <span class="range_input_value">1</span>/10
												<input type="range" min="0" max="10" value="1" name="dataset_borders_width" class="range_input">
											</div>
											<div class="form-group col">
												Arredondamento da Borda <span class="range_input_value">0</span>/10
												<input type="range" min="0" max="10" value="0" name="data_dataset_borders_radius" class="range_input">
											</div>
									</div>

									<button name="SAVECHANGES" class="button2 btn-success"><span>Salvar</span></button>
								</div>

								<!-- Image -->
								<div data-type="1">

								</div>
							</form>
						</div>
					</div>';
				}

			} else{
					echo '<div class="box-msg error">'.ERROR_QUERY_NORESULT.'</div>';
			}
		}

	?>
	</div>
</main>
<?php include('cpanel_footer.php'); ?>
</body>
</html>