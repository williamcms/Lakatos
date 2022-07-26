<?php 
	require_once('cfg/core.php');

	if(isset($_GET['pagename'])){
		$pagename = explode('.', $_GET['pagename'])[0];

		$conn->link = $conn->connect();
		if($stmt = $conn->link->prepare("SELECT * FROM packaging WHERE pack_pagename = ? LIMIT 1")){
			try{
				$stmt->bind_param('s', $pagename);
				$stmt->execute();
				$row = get_result($stmt);

				// if($_SESSION['lang'] != 'pt_BR'){
				// 	$row[0]['mac_title'] = ($_SESSION['lang'] == 'en_US' ? $row[0]['mac_title_en'] : $row[0]['mac_title_es']);
				// 	$row[0]['mac_short_desc'] = ($_SESSION['lang'] == 'en_US' ? $row[0]['mac_short_desc_en'] : $row[0]['mac_short_desc_es']);
				// 	$row[0]['mac_desc'] = ($_SESSION['lang'] == 'en_US' ? $row[0]['mac_desc_en'] : $row[0]['mac_desc_es']);
				// }
			}
			catch(Exception $e){
				throw new Exception('Erro ao conectar com a base de dados: '. $e);
			}
		}
	}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<title><?php echo $website->title .': '. (isset($pagename) && $stmt->num_rows ? $row[0]['pack_goal'] : 'Embalagens') ?></title>
	<?php require_once('header-front.php'); ?>
</head>
<body>
	<?php require_once('menu.php'); ?>

	<main class="packaging">
		<?php
			if(isset($_GET['pagename']) && $stmt->num_rows){
				$pack_id = $row[0]['pack_id'];
				if($stmt2 = $conn->link->prepare("SELECT * FROM application_packaging WHERE appack_pack = ? ORDER BY appack_id ASC")){
					try{
						$stmt2->bind_param('i', $pack_id);
						$stmt2->execute();
						$pack_ids = get_result($stmt2);
					}
					catch(Exception $e){
						throw new Exception('Erro ao conectar com a base de dados: '. $e);
					}
				}

				if($stmt3 = $conn->link->prepare("SELECT * FROM machine_packaging WHERE mp_pack = ?")){
					try{
						$stmt3->bind_param('i', $pack_id);
						$stmt3->execute();
						$machinesToPackaging = get_result($stmt3);
					}
					catch(Exception $e){
						throw new Exception('Erro ao conectar com a base de dados: '. $e);
					}
				}

				$machines_ids_query = '';
				for($i = 0; $i < $stmt3->num_rows; $i++) {
					$machines_ids_query .= ($i == 0 ? 'SELECT * FROM machines WHERE mac_active = 1 AND (mac_id = '.$machinesToPackaging[$i]['mp_mac'] : ' OR mac_id = '. $machinesToPackaging[$i]['mp_mac']);
				}
				$machines_ids_query .= ')';

				if($stmt4 = $conn->link->prepare($machines_ids_query)){
					try{
						$stmt4->execute();
						$machines_result = get_result($stmt4);
					}
					catch(Exception $e){
						throw new Exception('Erro ao conectar com a base de dados: '. $e);
					}
				}
				echo '<article class="product">
						<section class="image">
							'. (!$browser->isMobile() ? '<picture style="background: url('. $row[0]['pack_banner'] .') no-repeat;"></picture>' : 
								'<picture><img src="'. $row[0]['pack_banner'] .'" alt="'. $row[0]['pack_name'] .'" /></picture>') .'
						</section>

						<section class="info">
							<div class="title pt-3 pl-3 pr-4">
								<h1>'. $row[0]['pack_goal'] .'</h1>
								<h2>'. $row[0]['pack_name'] .'</h2>
							</div>

							<div class="description row">
								<div class="col">
									'. $row[0]['pack_desc'] .'
								</div>

								<div class="col-auto">';
									echo '<div class="d-flex"><span class="bold">Dimensões</span>:&nbsp;<div class="text">'. $row[0]['pack_sizes'] .'</div></div>';
									echo '<div class="d-flex"><span class="bold">Cavidades</span>:&nbsp;<div class="text">'. $row[0]['pack_holes'] .'</div></div>';
									echo '<div class="d-flex"><span class="bold">Ciclos</span>:&nbsp;<div class="text">'. $row[0]['pack_cicles'] .'</div></div>';

							echo '</div>
							</div>

						</section>';

						if($stmt3->num_rows > 0){
							echo '<section class="related">
								<div class="title pt-3 pl-3 pr-4">
									<h2>Máquinas</h2>
								</div>
								<div class="slick-carousel-arrows" data-slick=\'{"slidesToShow": 3, "responsive": [{"breakpoint": 831, "settings":{"slidesToShow": 1}}]}\'>';

								for($i = 0; $i < $stmt4->num_rows; $i++){
									echo '<div class="item"><figure class="image"><a href="./'. $machines_result[$i]['mac_pagename'] .'">';
									echo '<img src="'. $machines_result[$i]['mac_image'] .'" alt="" width="" height="" />';
									echo '<figcaption class="title center bold">'. $machines_result[$i]['mac_name'] .'&nbsp;&nbsp;&#10148;</figcaption></a></figure>';
									echo '</div>';
								}

							echo '</div>
							</section>';
						}
					echo '</article>';
			}else{
				$type = (isset($_GET['type']) ? $_GET['type'] : 'bobinas');

				$conn->link = $conn->connect();
				if($stmt = $conn->link->prepare("SELECT * FROM packaging WHERE pack_active = 1")){
					try{
						$stmt->execute();
						$row = get_result($stmt);
					}
					catch(Exception $e){
						throw new Exception('Erro ao conectar com a base de dados: '. $e);
					}
				}
				echo '<article class="products">
					<section class="banner">
						<figure class="chapas"><figcaption class="right"><h1>Embalagens</h1></figcaption></figure>
					</section>

					<section class="list">
						<div class="d-flex">';
						for($i = 0; $i < $stmt->num_rows; $i++){
							echo '<figure>
								<a href="'. url() .'/embalagem/'. $row[$i]['pack_pagename'] .'" class="d-flex">
								<img src="'. $row[$i]['pack_image'] .'" alt="" width="" height="" />
								<figcaption>
									<h3>'. $row[$i]['pack_goal'] .'</h3>
									<p><span class="bold">Nome do molde</span>: '. $row[$i]['pack_name'] .'</p>
									<p><span class="bold">Dimensões</span>: '. $row[$i]['pack_sizes'] .'</p>
									<p><span class="bold">Cavidades</span>: '. $row[$i]['pack_holes'] .'</p>
									<p><span class="bold">Ciclo</span>: '. $row[$i]['pack_cicles'] .'</p>
								</figcaption></a>
							</figure>';
						}
					echo '</div>
					</section>
				</article>';

				include_once('contact_section.php');
			}
		?>
	</main>

	<?php require_once('footer.php'); ?>
</body>
</html>