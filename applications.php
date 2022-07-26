<?php 
	require_once('cfg/core.php');

	if(isset($_GET['pagename'])){
		$pagename = explode('.', $_GET['pagename'])[0];

		$conn->link = $conn->connect();
		if($stmt = $conn->link->prepare("SELECT * FROM applications WHERE ap_name = ? LIMIT 1")){
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
	<title><?php echo $website->title .': '. (isset($pagename) && $stmt->num_rows ? $row[0]['ap_name'] : 'Embalagens') ?></title>
	<?php require_once('header-front.php'); ?>
</head>
<body>
	<?php require_once('menu.php'); ?>

	<main class="applications">
		<?php
			if(isset($_GET['pagename']) && $stmt->num_rows){
				$ap_id = $row[0]['ap_id'];
				if($stmt2 = $conn->link->prepare("SELECT * FROM application_packaging WHERE appack_ap = ? ORDER BY appack_id ASC")){
					try{
						$stmt2->bind_param('i', $ap_id);
						$stmt2->execute();
						$appack_ids = get_result($stmt2);
					}
					catch(Exception $e){
						throw new Exception('Erro ao conectar com a base de dados: '. $e);
					}
				}

				$packaging_ids_query = '';
				for($i = 0; $i < $stmt2->num_rows; $i++) {
					$packaging_ids_query .= ($i == 0 ? 'SELECT * FROM packaging WHERE pack_active = 1 AND (pack_id  = '.$appack_ids[$i]['appack_pack'] : ' OR pack_id  = '. $appack_ids[$i]['appack_pack']);
				}
				$packaging_ids_query .= ')';

				if($stmt3 = $conn->link->prepare($packaging_ids_query)){
					try{
						$stmt3->execute();
						$packaging_result = get_result($stmt3);
					}
					catch(Exception $e){
						throw new Exception('Erro ao conectar com a base de dados: '. $e);
					}
				}
				echo '<article class="product">
						<section class="image">
							'. (!$browser->isMobile() ? '<picture style="background: url('. $row[0]['ap_banner'] .') no-repeat;"></picture>' : 
								'<picture><img src="'. $row[0]['ap_banner'] .'" alt="'. $row[0]['pack_name'] .'" /></picture>') .'
						</section>

						<section class="info">
							<div class="title pt-3 pl-3 pr-4">
								<h1>'. $row[0]['ap_name'] .'</h1>
							</div>

							<div class="description row">
								<div class="col">
									'. $row[0]['ap_desc'] .'
								</div>
							</div>

						</section>';

						if($stmt2->num_rows > 0){
							echo '<section class="related">
								<div class="title pt-3 pl-3 pr-4">
									<h2>Máquinas</h2>
								</div>
								<div class="slick-carousel-arrows" data-slick=\'{"slidesToShow": 3, "responsive": [{"breakpoint": 831, "settings":{"slidesToShow": 1}}]}\'>';

								for($i = 0; $i < $stmt3->num_rows; $i++){
									echo '<div class="item"><figure class="image"><a href="'. url() .'/embalagem/'. $packaging_result[$i]['pack_pagename'] .'">';
									echo '<img src="'. $packaging_result[$i]['pack_image'] .'" alt="" width="" height="" />';
									echo '<figcaption class="title center bold">'. $packaging_result[$i]['pack_goal'] .'&nbsp;&nbsp;&#10148;</figcaption></a></figure>';
									echo '</div>';
								}

							echo '</div>
							</section>';
						}
					echo '</article>';
			}else{
				$type = (isset($_GET['type']) ? $_GET['type'] : 'bobinas');

				$conn->link = $conn->connect();
				if($stmt = $conn->link->prepare("SELECT * FROM applications WHERE ap_active = 1")){
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
						<figure class="chapas"><figcaption class="right"><h1>Aplicações</h1></figcaption></figure>
					</section>

					<section class="list">
						<div class="d-flex">';
						for($i = 0; $i < $stmt->num_rows; $i++){
							echo '<figure>
								<a href="'. url() .'/aplicacao/'. $row[$i]['ap_name'] .'">
								<img src="'. $row[$i]['ap_image'] .'" alt="" width="" height="" />
								<figcaption>
									<h3>'. $row[$i]['ap_name'] .'</h3>
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