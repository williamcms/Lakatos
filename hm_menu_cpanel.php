<?php

	if(isset($_SESSION['extra-config_nightMode']) == true){
		echo '<input name="darkmode" id="darkmode" type="checkbox" checked hidden>';
	}
	if(isset($_SESSION['extra-config_collapse']) || isset($_GET['collapse'])){
		isset($_GET['collapse']) == false && isset($_SESSION['extra-config_collapse']) == false && $_GET['collapse'] = false;
		isset($_GET['collapse']) == false && isset($_SESSION['extra-config_collapse']) == true && $_GET['collapse'] = true;
		if($_GET['collapse'] == 'true'){
			$_SESSION['extra-config_collapse'] = true;
			echo '<input name="collapse" id="collapse" type="checkbox" checked hidden>';
		}else{
			unset($_SESSION['extra-config_collapse']);
		}
	}
?>
<header>
	<button class="js--open-menu" role="none" aria-label="Abrir menu" aria-controls="navigation" aria-expanded="false">
		<span class="bar1"></span>
		<span class="bar2"></span>
		<span class="bar3"></span>
	</button>
	<nav class="menu" id="menubar">
		<ul role="menu" tabindex="-1" class="navigation" id="navigation">
			<li><img src="images/logo.png" class="menu-logo"></li>
			<li><img src="favicon-32x32.png" class="menu-logo-collapsed"></li>
			<li>
				<ul class="personal-card">
					<li>Olá, <span class="highlight"><?php echo $_SESSION['username']; ?></span></li>
					<li>
						<ul>
							<li class="settings"><a href="./cp-extra"><i class="fa-solid fa-gear icon-only"><span>Preferências</span></i></a></li>
							<li class="collapse-menu"><a href="?collapse=<?php echo (isset($_GET['collapse']) ? ($_GET['collapse'] == 'true' ? 'false' : 'true') : 'true'); ?>"><i class="fa-solid fa-bars-staggered icon-only"><span>Diminuir Menu</span></i></a></li>
							<li class="signout"><a href="?sair"><i class="fa-solid fa-arrow-right-from-bracket icon-only"><span>Sair</span></i></a></li>
						</ul>
					</li>
				</ul>
			</li>
			<li <?php if($account->getFileName() == 'cp-home.php') echo 'class="currentPage"'; ?>>
				<a href="./cp-home">
					<i class="fa-solid fa-house"></i> <span>Home</span>
				</a>
			</li>
			<li <?php if($account->getFileName() == 'cp-users.php') echo 'class="currentPage"'; ?>>
				<a href="./cp-users">
					<i class="fa-solid fa-users"></i> <span>Contas</span>
				</a>
			</li>
			<li <?php if($account->getFileName() == 'cp-uploads.php') echo 'class="currentPage"'; ?>>
				<a href="./cp-uploads">
					<i class="fa-solid fa-file-arrow-up"></i> <span>Uploads</span>
				</a>
			</li>
			<li <?php if($account->getFileName() == 'cp-partners.php') echo 'class="currentPage"'; ?>>
				<a href="./cp-partners">
					<i class="fa-solid fa-handshake"></i> <span>Clientes</span>
				</a>
			</li>
			<li <?php if($account->getFileName() == 'cp-machines.php') echo 'class="currentPage"'; ?>>
				<a href="./cp-machines">
					<i class="fa-solid fa-robot"></i> <span>Máquinas</span>
				</a>
			</li>
			<li <?php if($account->getFileName() == 'cp-applications.php') echo 'class="currentPage"'; ?>>
				<a href="./cp-applications">
					<i class="fa-solid fa-circle-nodes"></i> <span>Aplicações</span>
				</a>
			</li>
			<li <?php if($account->getFileName() == 'cp-cfg.php') echo 'class="currentPage"'; ?>>
				<a href="./cp-cfg">
					<i class="fa-solid fa-gears"></i> <span>Configurações</span>
				</a>
			</li>
		</ul>
	</nav>
</header>
<?php if(isset($_GET['sair'])) $account->logout(); ?>