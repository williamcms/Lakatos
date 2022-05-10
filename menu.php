<header>
	<div class="wrapper">
		<div class="language-wrapper">
			<div class="row">
				<div class="col">
					<ul class="info" aria-label="Informações de contato">
						<li><a href="mailto:info@lakatos.com"><i class="far fa-envelope"></i> info@lakatos.com</a></li>
						<li><a href="tel:551147043699"><i class="fas fa-phone"></i> +55 (11) 4704-3699</a></li>
					</ul>
				</div>
				<div class="col">
					<div class="language text-right">
						<a href="#"><img src="http://www.lakatos.com/images/flags/br.png" alt="Português" title="Português" width="16" height="11"></a>
						<a href="#"><img src="http://www.lakatos.com/images/flags/eua.png" alt="English" title="English" width="16" height="11"></a>
						<a href="#"><img src="http://www.lakatos.com/images/flags/esp.png" alt="Español" title="Español" width="16" height="11"></a>
					</div>
				</div>
			</div>
			
		</div>
		<div class="logo-wrapper">
			<img src="_prototype/images/logo.png" alt="logo" title="Lakatos | Termoformadoras" />
		</div>
		<nav class="menu" id="menubar">
			<button class="js--open-menu" role="none" aria-label="Abrir menu" aria-controls="navigation" aria-expanded="false">
		        <span></span>
		        <span></span>
		        <span></span>
		    </button>
			<ul role="menu" tabindex="-1" class="navigation" id="navigation">
				<li role="none" class="menuitem"><a href="./home" role="menuitem">Home</a></li>
				<li role="none" class="menuitem"><a href="./aboutus" role="menuitem">Sobre nós</a></li>
				<li role="none" class="menuitem"><a href="./aplicacoes" role="menuitem">Aplicações</a></li>
				<li role="none" class="menuitem"><a href="./maquinas" role="menuitem">Máquinas</a></li>
				<li role="none" class="menuitem"><a href="./moldes" role="menuitem">Moldes</a></li>
				<li role="none" class="menuitem"><a href="./contato" role="menuitem">Contato</a></li>
				<li role="none" class="menuitem"><a href="./contato#redesContato" role="menuitem">Redes de contato</a></li>
				<li role="none" class="menuitem"><a href="./blog" role="menuitem">Blog</a></li>
			</ul>
		</nav>
	</div>
</header>
<div class="whatsappButton" title="Fale Conosco">
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
</div>