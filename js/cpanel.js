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
		colors: [
			['#000000', '#424242', '#636363', '#9C9C94', '#CEC6CE', '#EFEFEF', '#F7F7F7', '#FFFFFF'], 
			['#FF0000', '#FF9C00', '#FFFF00', '#00FF00', '#00FFFF', '#0000FF', '#9C00FF', '#FF00FF'], 
			['#F7C6CE', '#FFE7CE', '#FFEFC6', '#D6EFD6', '#CEDEE7', '#CEE7F7', '#D6D6E7', '#E7D6DE'], 
			['#E79C9C', '#FFC69C', '#FFE79C', '#B5D6A5', '#A5C6CE', '#9CC6EF', '#B5A5D6', '#D6A5BD'], 
			['#E76363', '#F7AD6B', '#FFD663', '#94BD7B', '#73A5AD', '#6BADDE', '#8C7BC6', '#C67BA5'], 
			['#CE0000', '#E79439', '#EFC631', '#6BA54A', '#4A7B8C', '#3984C6', '#634AA5', '#A54A7B'], 
			['#9C0000', '#B56308', '#BD9400', '#397B21', '#104A5A', '#085294', '#311873', '#731842'], 
			['#630000', '#7B3900', '#846300', '#295218', '#083139', '#003163', '#21104A', '#4A1031'],
			['#033B58', '#2187BD']
		],
		colorsName: [
			['Black', 'Tundora', 'Dove Gray', 'Star Dust', 'Pale Slate', 'Gallery', 'Alabaster', 'White'], 
			['Red', 'Orange Peel', 'Yellow', 'Green', 'Cyan', 'Blue', 'Electric Violet', 'Magenta'], 
			['Azalea', 'Karry', 'Egg White', 'Zanah', 'Botticelli', 'Tropical Blue', 'Mischka', 'Twilight'], 
			['Tonys Pink', 'Peach Orange', 'Cream Brulee', 'Sprout', 'Casper', 'Perano', 'Cold Purple', 'Careys Pink'], 
			['Mandy', 'Rajah', 'Dandelion', 'Olivine', 'Gulf Stream', 'Viking', 'Blue Marguerite', 'Puce'], 
			['Guardsman Red', 'Fire Bush', 'Golden Dream', 'Chelsea Cucumber', 'Smalt Blue', 'Boston Blue', 'Butterfly Bush', 'Cadillac'], 
			['Sangria', 'Mai Tai', 'Buddha Gold', 'Forest Green', 'Eden', 'Venice Blue', 'Meteorite', 'Claret'], 
			['Rosewood', 'Cinnamon', 'Olive', 'Parsley', 'Tiber', 'Midnight Blue', 'Valentino', 'Loulou'],
			['Brand Color', 'Lighter Brand Color']
		],
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