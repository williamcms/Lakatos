<footer>
	<div class="footer-wrapper">
		<div class="desc">
			<h4>A Lakatos</h4>
			<p>Reconhecida por seu padrão de qualidade, a Lakatos produz máquinas termoformadoras e moldes, de alto desempenho e com boa relação custo-benefício. A empresa atende diversos nichos de mercado... <a href="#aboutus">saiba mais</a>.</p>
		</div>
		<div class="contactus">
			<h4>Informações de contato</h4>
			<ul>
				<?php
				if($email->address){
					echo '<li><i class="fas fa-envelope"></i> <a href="mailto:'. $email->address .'" target="_blank">'. $email->address .'</a></li>';
				}
				if($location->phoneNumber){
					echo '<li><i class="fas fa-phone-square-alt"></i> <a href="https://wa.me/'. $location->phoneNumber .'" target="_blank">'. $location->phoneNumber .'</a></li>';
				}
				if($social->facebook){
					echo '<li><i class="fab fa-facebook-square"></i> <a href="'. $social->facebook .'" target="_blank">Lakatos</a></li>';
				}
				if($location->stAddress){
					echo '<li><i class="fas fa-map-marked"></i> '. $location->stAddress .' - CEP '. $location->postalCode .' '. $location->locality .', '. $location->region .' - '. $location->country .'</li>';
				}
				?>
			</ul>
		</div>
		<div class="social">
			<h4>Redes sociais</h4>
			<div class="social-icons-wrapper">
				<?php
				echo $social_link_instagram;
				echo $social_link_facebook;
				echo $social_link_twitter;
				echo $social_link_linkedin;
				echo $social_link_youtube;
				?>
			</div>
		</div>
	</div>
	<p class="center pt-5 italic">Website feito por <a href="https://www.linkedin.com/in/williambogik/">William</a> - 2022.</p>
</footer>