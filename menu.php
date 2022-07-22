<header>
	<div class="wrapper">
		<div class="language-wrapper">
			<div class="row">
				<div class="col">
					<?php
						if($email->address || $location->phoneNumber){
							echo '<ul class="info" aria-label="Informações de contato">
								'. (isNotEmptyNull($email->address) ? 
								'<li><a href="mailto:'. $email->address .'"><i class="far fa-envelope"></i> '. $email->address .'</a></li>
								' : '') . (isNotEmptyNull($location->phoneNumber) ? '
								<li><a href="tel:'. $location->phoneNumber .'"><i class="fas fa-phone"></i> '. $location->phoneNumber .'</a></li>
								' : '') .'
							</ul>';
						}
						
					?>
				</div>
				<div class="col">
					<div class="language text-right">
						<a aria-label="Alterar idioma para Português (Brasil)" href="<?php echo url() . '/pt/' . getFileName(1); ?>">
							<img src="http://www.lakatos.com/images/flags/br.png" alt="Português" title="Português" width="16" height="11"></a>
						<a aria-label="Change language to English" href="<?php echo url() . '/en/' . getFileName(1); ?>">
							<img src="http://www.lakatos.com/images/flags/eua.png" alt="English" title="English" width="16" height="11"></a>
						<a aria-label="Alterar idioma para español" href="<?php echo url() . '/es/' . getFileName(1); ?>">
							<img src="http://www.lakatos.com/images/flags/esp.png" alt="Español" title="Español" width="16" height="11"></a>
					</div>
				</div>
			</div>
			
		</div>
		<div class="logo-wrapper">
			<img src="<?php echo url(); ?>/images/logo.png" alt="logo" title="Lakatos | Termoformadoras" />
		</div>
		<nav class="menu" id="menubar">
			<button class="js--open-menu" role="none" aria-label="Abrir menu" aria-controls="navigation" aria-expanded="false">
	            <span></span>
	            <span></span>
	            <span></span>
	        </button>
			<ul role="menu" tabindex="-1" class="navigation" id="navigation">
				<li role="none" class="menuitem"><a href="<?php echo url(); ?>/index#home" role="menuitem"><?php echo LANG_HOME_MENU_LINK1 ?></a></li>
				<li role="none" class="menuitem"><a href="<?php echo url(); ?>/sobre" role="menuitem"><?php echo LANG_HOME_MENU_LINK2 ?></a></li>
				<li role="none" class="menuitem"><a href="<?php echo url(); ?>/index#aplicacoes" role="menuitem"><?php echo LANG_HOME_MENU_LINK3 ?></a></li>
				<li role="none" class="menuitem" aria-haspopup="true">
					<a href="<?php echo url(); ?>/index#maquinas" role="menuitem"><?php echo LANG_HOME_MENU_LINK4 ?></a>
					<ul class="dropdown">
						<li><a href="<?php echo url(); ?>/maquinas/bobinas" role="menuitem"><?php echo LANG_HOME_MENU_LINK4_SUB1 ?></a></li>
						<li><a href="<?php echo url(); ?>/maquinas/chapas" role="menuitem"><?php echo LANG_HOME_MENU_LINK4_SUB2 ?></a></li>
					</ul>
				</li>
				<li role="none" class="menuitem"><a href="<?php echo url(); ?>/index#sustentabilidade" role="menuitem">Sustentabilidade</a></li>
				<li role="none" class="menuitem"><a href="<?php echo url(); ?>/index#blog" role="menuitem">Blog</a></li>
				<li role="none" class="menuitem"><a href="<?php echo url(); ?>/index#contato" role="menuitem">Contato</a></li>
				<li role="none" class="menuitem"><a href="<?php echo url(); ?>/index#redesContato" role="menuitem">Redes de contato</a></li>
			</ul>
		</nav>
	</div>
</header>
<?php
	if($widget->whatsapp == 1){
		echo '<div class="whatsappButton" title="Fale Conosco">
			<i class="fab fa-whatsapp" id="whatsappButton"></i>

			<div class="whatsapp-outer-message" id="whatsapp-outer-message">
				<p class="header">Lakatos</p>
				<p>Fale Conosco pelo Whatsapp</p>
			</div>

			<div class="whatsapp-conversation" id="whatsapp-conversation">
				<div class="header"><div class="photo"></div><div class="name">Lakatos</div></div>
				<div class="message-bubble"><textarea type="text" id="whatsapp-input-message" autofocus>Olá, Meu Nome é...</textarea></div>

				
				<a href="https://web.whatsapp.com/send?phone=<?php echo $location->cleanWhatsapp; ?>&text=Olá, Meu Nome é..." id="whatsapp-link" target="_blank" class="send-message">
					<span>Enviar Mensagem</span>
					<i class="fas fa-paper-plane"></i>
				</a>
			</div>
		</div>';
	}