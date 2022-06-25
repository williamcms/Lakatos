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
		<p class="text-muted center">Não utilize vírgulas nos campos abaixo, isso causara erros no processamento dos dados!</p>
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

			class _data{
				public $_arr = array();

				public function get(){
					return $this->_arr;
				}

				public function __construct(){
					$data = func_get_args();

					foreach($data as $key => $value){
						$data[$key] = explode(',', $value);
					}

					foreach($data as $key => $value){
						foreach($value as $key1 => $value1){
							if($key == 0){
								$this->_arr[$key1]['label'] = trim($value1);
							}
							if($key == 1){
								$this->_arr[$key1]['data'] = trim($value1);
							}
							if($key == 2){
								$this->_arr[$key1]['fColor'] = trim($value1);
							}
							if($key == 3){
								$this->_arr[$key1]['bColor'] = trim($value1);
							}
						}
					}
				}
			}

			$data = new _data($row[0]['labels'], $row[0]['dataset_data'], $row[0]['dataset_colors'], $row[0]['dataset_borders_color'] );
			$gData = $data->get();

			if($stmt->num_rows > 0){
				echo '<div class="col-auto card-result-body w-100">
					<div class="card-result-top">
						<div class="card-result-title"></div>
					</div>

					<div class="card-result-content">
						<form method="POST" id="SAVECHANGES">
							<fieldset>
								<legend>Tipo</legend>
								<div class="form-group">
									<select name="chart_type">
										<option value="0" '.($row[0]['selected'] == 0 ? 'selected' : '').'>Gráfico</option>
										<option value="1" '.($row[0]['selected'] == 1 ? 'selected' : '').'>Imagem</option>
									</select>
									<p class="text-muted">Cuidado! Ao clicar em salvar, os formulários de ambos os tipos são salvos!</p>

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
											<input type="text" name="options_title_text" value="'. $row[0]['options_title_text'] .'" />
										</div>

										<div class="form-group input-group col">
											<div class="input-group-append input-group-text">
												<label>Topo</label>
											</div>
											<input type="number" min="1" step="1" name="options_title_padding_top" value="'. $row[0]['options_title_padding_top'] .'" />
										</div>

										<div class="form-group input-group col">
											<div class="input-group-append input-group-text">
												<label>Baixo</label>
											</div>
											<input type="number" min="1" step="1" name="options_title_padding_bottom" value="'. $row[0]['options_title_padding_bottom'] .'" />
										</div>

										<div class="form-group col-auto">
											<label class="switch">
												<input type="checkbox" name="options_title_display" '.($row[0]['options_title_display'] == true ? 'checked' : '').'>
												<span class="slider"></span>
											</label>
										</div>
									</div>

									<div class="row">
										<div class="form-group input-group col">
											<div class="input-group-append input-group-text">
												<label>Subtítulo</label>
											</div>
											<input type="text" name="options_subtitle_text" value="'. $row[0]['options_subtitle_text'] .'" />
										</div>

										<div class="form-group input-group col">
											<div class="input-group-append input-group-text">
												<label>Topo</label>
											</div>
											<input type="number" min="1" step="1" name="options_subtitle_padding_top" value="'. $row[0]['options_subtitle_padding_top'] .'" />
										</div>

										<div class="form-group input-group col">
											<div class="input-group-append input-group-text">
												<label>Baixo</label>
											</div>
											<input type="number" min="1" step="1" name="options_subtitle_padding_bottom" value="'. $row[0]['options_subtitle_padding_bottom'] .'" />
										</div>

										<div class="form-group col-auto">
											<label class="switch">
												<input type="checkbox" name="options_subtitle_display" '.($row[0]['options_subtitle_display'] == true ? 'checked' : '').'>
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
												<label>Tipo de gráfico</label>
											</div>
											<select name="type">
												<option value="line" '. ($row[0]['type'] == 'line' ? 'selected' : '') .'>Linhas</option>
												<option value="bar" '. ($row[0]['type'] == 'bar' ? 'selected' : '') .'>Barras</option>
												<option value="radar" '. ($row[0]['type'] == 'radar' ? 'selected' : '') .'>Radar</option>
												<option value="doughnut" '. ($row[0]['type'] == 'doughnut' ? 'selected' : '') .'>Rosquinha</option>
												<option value="pie" '. ($row[0]['type'] == 'pie' ? 'selected' : '') .'>Torta</option>
												<option value="polarArea" '. ($row[0]['type'] == 'polarArea' ? 'selected' : '') .'>Area Polar</option>
											</select>
										</div>
									</div>

									<div class="row">
										<div class="form-group input-group col">
											<div class="input-group-append input-group-text">
												<label>Título</label>
											</div>
											<input type="text" name="dataset_label" value="'. $row[0]['dataset_label'] .'" />
										</div>
									</div><div class="dataFields">';

									for($i = 0; $i < count($gData); $i++){
										echo '<div class="row dataField">
												<div class="form-group input-group col">
													<div class="input-group-append input-group-text">
														<label>Nome</label>
													</div>
													<input type="text" name="labels[]" value="'. $gData[$i]['label'] .'" required/>
												</div>

												<div class="form-group input-group col">
													<div class="input-group-append input-group-text">
														<label>Valor</label>
													</div>
													<input type="number" name="dataset_data[]" value="'. $gData[$i]['data'] .'" required/>
												</div>

												<div class="form-group input-group col">
													<div class="input-group-append input-group-text">
														<label>Preenchimento</label>
													</div>
													<input type="color" name="dataset_colors[]" />
													<input type="number" min="0" step="10" max="100" value="20" title="Opacidade" name="dataset_colors_opacity[]" value="'. $gData[$i]['fColor'] .'" />
												</div>

												<div class="form-group input-group col">
													<div class="input-group-append input-group-text">
														<label>Cor da Borda</label>
													</div>
													<input type="color" name="dataset_borders_color[]" />
													<input type="number" min="0" step="10" max="100" value="100" title="Opacidade" name="dataset_borders_color_opacity[]" value="'. $gData[$i]['bColor'] .'" />
												</div>
											</div>';
									}

									echo '</div><div class="d-block center p-3">
										<a role="button" class="button2 btn-primary d-inline" id="addmore"><span>Novo campo</span></a>
										<a role="button" class="button2 btn-danger d-inline" id="removelast"><span>Remover último campo</span></a>
									</div>
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