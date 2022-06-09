'use strict';

var formOn = (formOn = (num) => {
	$(`#form${num}`).fadeIn();
});
var formOff = (formOff = (num) => {
	$(`#form${num}`).fadeOut();
	reload();
});
var reload = (reload = () => {
	window.location = window.location;
});
var closeOnEsc = $(document).on('keydown', function(evt){
	if(evt.keyCode == 27){
		let overlay = $('.overlayform'),
			topIndex = 0;

		$.each(overlay, function(){
			topIndex = $(this);
		})
		topIndex.fadeOut();
	}
})
$(document).ready(function(){
	var darkMode = (() =>{
		if($('#darkmode').is(':checked')){
			$('body').addClass('darkmode');
		}
	})();
	var collapse = (() =>{
		if($('#collapse').is(':checked')){
			$('body').addClass('collapsed-menu');
		}
	})();
	var openMenu = $('.js--open-menu').on('click', function(){
		$('header, header button.js--open-menu').toggleClass('change');
		$('body').toggleClass('noscroll');
		// Atributos para Leitores de tela
		$x = $(this).hasClass('change');
		$(this).attr('aria-expanded', $x);
	});
	var closeMenu = $('main, header nav.menu ul li').on('click', function(){
		$('body').removeClass('noscroll');
		$('header, header button.js--open-menu').removeClass('change');
	})
	$('#password, #password2').on('input', function(e){
		if($('#password').val().length < 6 || $('#password2').val().length < 6){
			$('#confirmPassword').text('A senha deve possuir no mínimo 6 caracteres');
			$('#confirmPassword2').text('A senha deve possuir no mínimo 6 caracteres');

			$('#password').css('border', '1px solid var(--warning)');
			$('#password').css('box-shadow', '0 0 3px 2px var(--warning)');
			$('#password2').css('border', '1px solid var(--warning)');
			$('#password2').css('box-shadow', '0 0 3px 2px var(--warning)');
		}else if($('#password').val() !== $('#password2').val()){
			$('#confirmPassword').text('As senhas não coincidem');
			$('#confirmPassword2').text('As senhas não coincidem');

			$('#password').css('border', '1px solid var(--warning)');
			$('#password').css('box-shadow', '0 0 3px 2px var(--danger)');
			$('#password2').css('border', '1px solid var(--warning)');
			$('#password2').css('box-shadow', '0 0 3px 2px var(--danger)');
		}else{
			$('#password').css('border', '1px solid var(--green)');
			$('#password').css('box-shadow', '0 0 3px 2px var(--success)');
			$('#password2').css('border', '1px solid var(--green)');
			$('#password2').css('box-shadow', '0 0 3px 2px var(--success)');
			$('#confirmPassword').text('');
			$('#confirmPassword2').text('');
		}
	});
	//Range
	$('.range_input').on('input', function(e){
		$(this).prev().html(this.value);
	});
	//Summernote
	$('.summernote').summernote({
		height: 450,
		tabsize: 2,
		lang: 'pt-BR',
		toolbar: [
			['style', ['style']],
			['font', ['bold', 'italic', 'underline', 'strikethrough']],
			['font', ['superscript', 'subscript']],
			['font', ['clear']],
			['font', ['fontname', 'fontsize']],
			['font', ['color']],
			['para', ['paragraph']],
			['insert', ['table']],
			['insert', ['link','picture', 'video']],
			['misc', ['undo', 'redo']],
			['misc', ['fullscreen', 'codeview', 'help']],
		]
	});
});