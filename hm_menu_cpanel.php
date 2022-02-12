<?php
	if($browser->isMobile()){
		$menu_aria = 'false';
		echo '<div class="hm_menu" id="hm_menu" aria-controls="hm_menu_items" aria-expanded="false" onclick="toggleMenu(this);">
			    <div class="bar1"></div>
			    <div class="bar2"></div>
			    <div class="bar3"></div>
			</div>';
	} else{
		$menu_aria = 'true';
	}
    echo '<!-- Extra Config -->';
    if(isset($_SESSION['extra-config_nightMode'])){
        echo '<style>
            body, .modalform{
                color: var(--white);
                background: var(--dark);
            }
            input, textarea{
                background: #DDD;
            }
            input[type="range"], input[type=range]:focus{
                background: var(--white);
            }
            .card-result-body{
                color: var(--white);
                background: #313131;
            }
            .card-box{
                background: var(--menu-bg-color);
            }
        </style>';
    }
?>

<nav name="menu" id="hm_menu_items" aria-expanded="<?php echo $menu_aria; ?>">
    <img src="images/logo.png" class="menu-logo">
    <ul>
        <a href="./cp-home"><li <?php if($account->getFileName() == 'cp-home.php') echo 'class="currentPage"'; ?>>HOME</li></a>
        <a href="./cp-users"><li <?php if($account->getFileName() == 'cp-users.php') echo 'class="currentPage"'; ?>>CONTAS</li></a>
        <a href="./cp-uploads"><li <?php if($account->getFileName() == 'cp-uploads.php') echo 'class="currentPage"'; ?>>UPLOADS</li></a>
        <a href="./cp-partners"><li <?php if($account->getFileName() == 'cp-partners.php') echo 'class="currentPage"'; ?>>PARCEIROS</li></a>
        <a href="./cp-extra"><li <?php if($account->getFileName() == 'cp-extra.php') echo 'class="currentPage"'; ?>>EXTRA</li></a>
        <a href="./cp-cfg"><li <?php if($account->getFileName() == 'cp-cfg.php') echo 'class="currentPage"'; ?>>CONFIGS</li></a>
        <a href="?sair"><li>SAIR</li></a>
    </ul>
</nav>
<?php if(isset($_GET['sair'])) $account->logout(); ?>