<?php 
include('cfg/core.php');
include('cfg/users_class.php');

$account->sessionLogin();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<title><?php echo $website->title; ?>: Sustentabilidade</title>
	<?php require_once('header-cpainel.php'); ?>
</head>
<body>
	<?php include('hm_menu_cpanel.php'); ?>
<main class="chart">
	<h2 class="text-center pt-3">Gerenciamento de infográfico de Sustentabilidade</h2>
	<div class="card-box">
		<div class="row">
			<div class="col"><h4>Sustentabilidade</h4></div>
				<!-- <div class="col">
					<a href="#" class="button2 card_button-add" onclick="$('#SAVECHANGES').submit();">
					<span>Salvar</span></a>
				</div> -->
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
							<section data-type="0" class="pb-3 '.($row[0]['selected'] == 0 ? '' : 'd-none').'">
								<fieldset>
									<legend>Títulos</legend>

									<div class="form-group">
										<div class="input-group">
											<div class="input-group-append">
												<label class="input-group-text">Tipo de dado apresentado</label>
											</div>
											<input type="text" name="label" value="'. $row[0]['label'] .'" placeholder="# votos, # projetos" />
										</div>
										<span class="text-muted">Esse tipo de informação é exibido em alguns tipos de gráficos</span>
									</div>

									<div class="row">
										<div class="form-group input-group col">
											<div class="input-group-append">
												<label class="input-group-text">Título</label>
											</div>
											<input type="text" name="options_title_text" value="'. $row[0]['options_title_text'] .'" />
										</div>

										<div class="form-group input-group col">
											<div class="input-group-append">
												<label class="input-group-text">Topo</label>
											</div>
											<input type="number" min="1" step="1" name="options_title_padding_top" value="'. $row[0]['options_title_padding_top'] .'" />
										</div>

										<div class="form-group input-group col">
											<div class="input-group-append">
												<label class="input-group-text">Baixo</label>
											</div>
											<input type="number" min="1" step="1" name="options_title_padding_bottom" value="'. $row[0]['options_title_padding_bottom'] .'" />
										</div>

										<div class="form-group col-auto">
											<label class="switch">
												<input type="checkbox" name="options_title_display" '.($row[0]['options_title_display'] == true ? 'checked' : '').'/>
												<span class="slider"></span>
											</label>
										</div>
									</div>

									<div class="row">
										<div class="form-group input-group col">
											<div class="input-group-append">
												<label class="input-group-text">Subtítulo</label>
											</div>
											<input type="text" name="options_subtitle_text" value="'. $row[0]['options_subtitle_text'] .'" />
										</div>

										<div class="form-group input-group col">
											<div class="input-group-append">
												<label class="input-group-text">Topo</label>
											</div>
											<input type="number" min="1" step="1" name="options_subtitle_padding_top" value="'. $row[0]['options_subtitle_padding_top'] .'" />
										</div>

										<div class="form-group input-group col">
											<div class="input-group-append">
												<label class="input-group-text">Baixo</label>
											</div>
											<input type="number" min="1" step="1" name="options_subtitle_padding_bottom" value="'. $row[0]['options_subtitle_padding_bottom'] .'" />
										</div>

										<div class="form-group col-auto">
											<label class="switch">
												<input type="checkbox" name="options_subtitle_display" '.($row[0]['options_subtitle_display'] == true ? 'checked' : '').'/>
												<span class="slider"></span>
											</label>
										</div>
									</div>
									
								</fieldset>

								<fieldset>
									<legend>Dados</legend>

									<div class="row">
										<div class="form-group input-group col">
											<div class="input-group-append">
												<label class="input-group-text">Tipo de gráfico</label>
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
											<div class="input-group-append">
												<label class="input-group-text">Título</label>
											</div>
											<input type="text" name="dataset_label" value="'. $row[0]['dataset_label'] .'" />
										</div>
									</div><div class="dataFields">';

									for($i = 0; $i < count($gData); $i++){
										echo '<div class="row dataField">
												<div class="form-group input-group col">
													<div class="input-group-append">
														<label class="input-group-text">Nome</label>
													</div>
													<input type="text" name="labels[]" value="'. $gData[$i]['label'] .'" required/>
												</div>

												<div class="form-group input-group col">
													<div class="input-group-append">
														<label class="input-group-text">Valor</label>
													</div>
													<input type="number" name="dataset_data[]" value="'. $gData[$i]['data'] .'" required/>
												</div>

												<div class="form-group input-group col">
													<div class="input-group-append">
														<label class="input-group-text">Preenchimento</label>
													</div>
													<input type="color" name="dataset_colors[]" value="'. $gData[$i]['fColor'] .'" />
												</div>

												<div class="form-group input-group col">
													<div class="input-group-append">
														<label class="input-group-text">Cor da Borda</label>
													</div>
													<input type="color" name="dataset_borders_color[]" value="'. $gData[$i]['bColor'] .'" />
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
										Largura da Borda <span class="range_input_value">'. $row[0]['dataset_borders_width'] .'</span>/10
										<input type="range" min="0" max="10" value="'. $row[0]['dataset_borders_width'] .'" name="dataset_borders_width" class="range_input" />
									</div>
									<div class="form-group col">
										Arredondamento da Borda <span class="range_input_value">'. $row[0]['dataset_borders_radius'] .'</span>/10
										<input type="range" min="0" max="10" value="'. $row[0]['dataset_borders_radius'] .'" name="dataset_borders_radius" class="range_input" />
									</div>
								</div>
							</section>

							<!-- Image -->
							<section data-type="1" class="pb-3 '.($row[0]['selected'] == 1 ? '' : 'd-none').'">
								<fieldset>
									<legend>Imagem</legend>
									<div class="form-group input-group">
										<div class="input-group-append">
											<label class="input-group-text">Link da Imagem</label>
										</div>
										<input type="url" value="'. $row[0]['alt'] .'" name="alt" />
									</div>
								</fieldset>
							</section>

							<button name="SAVECHANGES" class="button2 btn-green"><span>Salvar</span></button>
						</form>
					</div>
				</div>';

			} else{
					echo '<div class="box-msg error">'.ERROR_QUERY_NORESULT.'</div>';
			}
		}

		if(isset($_POST['SAVECHANGES'])){
			$selected = $_POST['chart_type']; //string
			$label = $_POST['label']; // //string
			$options_title_text = $_POST['options_title_text']; // //string
			$options_title_padding_top = $_POST['options_title_padding_top']; //string
			$options_title_padding_bottom = $_POST['options_title_padding_bottom']; //string
			$options_title_display = isset($_POST['options_title_display']); //checkbox
			$options_subtitle_text = $_POST['options_subtitle_text']; //string
			$options_subtitle_padding_top = $_POST['options_subtitle_padding_top']; //string
			$options_subtitle_padding_bottom = $_POST['options_subtitle_padding_bottom']; //string
			$options_subtitle_display = isset($_POST['options_subtitle_display']); //checkbox
			$type = $_POST['type']; //string
			$dataset_label = $_POST['dataset_label']; //string
			$dataset_borders_width = $_POST['dataset_borders_width'];
			$dataset_borders_radius = $_POST['dataset_borders_radius'];
			$alt = $_POST['alt'];

			$labels_array = $_POST['labels']; //array
			$dataset_data_array = $_POST['dataset_data']; //array
			$dataset_colors_array = $_POST['dataset_colors']; //array
			$dataset_borders_color_array = $_POST['dataset_borders_color']; //array

			$labels = implode(',', $labels_array); //array
			$dataset_data = implode(',', $dataset_data_array); //array
			$dataset_colors = implode(',', $dataset_colors_array); //array
			$dataset_borders_color = implode(',', $dataset_borders_color_array); //array

			$conn->link = $conn->connect();
			if($stmt = $conn->link->prepare("UPDATE chart SET type = ?, label = ?, labels = ?, dataset_label = ?, dataset_data = ?, dataset_colors = ?, dataset_borders_color = ?, dataset_borders_width = ?, dataset_borders_radius = ?, options_title_display = ?, options_title_text = ?, options_title_padding_top = ?, options_title_padding_bottom = ?, options_subtitle_display = ?, options_subtitle_text = ?, options_subtitle_padding_top = ?, options_subtitle_padding_bottom = ?, selected = ?, alt = ? WHERE id = ?")){

				// It always updates the same row
				$id = 0;

				try{
					$stmt->bind_param('ssssssssissiissiiisi', $type, $label, $labels, $dataset_label, $dataset_data, $dataset_colors, $dataset_borders_color, $dataset_borders_width, $dataset_borders_radius, $options_title_display, $options_title_text, $options_title_padding_top, $options_title_padding_bottom, $options_subtitle_display, $options_subtitle_text, $options_subtitle_padding_top, $options_subtitle_padding_bottom, $selected, $alt, $id);
					$stmt->execute();
				}
				catch(Exception $e){
					throw new Exception('Erro ao conectar com a base de dados: '. $e);
				}
				echo '<script>reload();</script>';
			}
		}

	?>
	</div>
</main>
<?php include('cpanel_footer.php'); ?>
</body>
</html>