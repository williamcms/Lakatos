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
});
//Aguarda o determinado elemento carregar
//Exemplo de uso:
//waitForElm('.selector').then((elm) =>{
//});
function waitForElm(selector){
	return new Promise(resolve =>{
		if(!!$(selector).length){
			return resolve($(selector));
		}

		const observer = new MutationObserver(mutations =>{
			if($(selector)){
				resolve($(selector));
				observer.disconnect();
			}
		});

		observer.observe(document.body, {
			childList: true,
			subtree: true
		});
	});
}
// IsMobile
var isMobile = (isMobile = () => {
	let mobile = false; //initiate as false
	// device detection
	if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) 
		|| /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) { 
		mobile = true;
	}
	return mobile;
});
var getLangs = (getLangs = () =>{
	let progressbar = $('#allLangsProgress > .progress-bar');
	// Inserir Código para pegar textos

	$('#allLangsProgress').removeClass('d-none');

	var progressInterval = setInterval(function(){
		let increment = parseInt(progressbar.attr('aria-increment')),
			value = parseInt(progressbar.attr('aria-valuenow')) + increment,
			valueMax = parseInt(progressbar.attr('aria-valuemax'));

		progressbar.attr('aria-valuenow', value);
		progressbar.css('width', `${value}%`);
		progressbar.text(`${value}%`);

		if(value >= valueMax){
			clearInterval(progressInterval);
			// $('#formAllLangs').submit();
		}
	}, 200);
});
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
	$('.icon-selector').on('change', function(){
		$(this).parent().find('img').prop('src', $(this).find(':selected').data('image'));
	});
	waitForElm('.icon-selector > :selected').then((elm) =>{
		$('.icon-selector').trigger('change');
	});
	$('.icon-selector-group > .input-group-text').on('click', function(){
		let x = $(this).next().attr('size');
		$(this).next().attr('size', (x == 8 ? 0 : 8));
	})
	$('main.chart #addmore').on('click', function(){
		let dataField = $('.dataField').eq(0),
			dataFields = $(this).parents('fieldset').find('.dataFields');

		dataFields.append($(dataField).clone());

		dataFields.find('.dataField:last-of-type').find('input:nth-child(1), input:nth-child(2)').val('')
		dataFields.find('.dataField:last-of-type').find('input:nth-child(4)').val(20)
		dataFields.find('.dataField:last-of-type').find('input:nth-child(5)').val(100)
	});
	$('main.chart #removelast').on('click', function(){
		let dataField = $('.dataField'),
			dataFields = $(this).parents('fieldset').find('.dataFields');

		dataField.length > 1 && dataFields.find('.dataField:last-of-type').remove();
	});
	$('.dataFields > .dataField input').on('change keyup', function(){
		$(this).val($(this).val().replace(/,/g, "."));
	})
	$('#SAVECHANGES select[name="chart_type"]').on('change', function(){
		let type = $(this).find(':selected').val();

		$.each($('section[data-type]'), function(){
			if($(this).attr('data-type') == type){
				$(this).removeClass('d-none');
			}else{
				$(this).addClass('d-none');
			}
		});
	});
	$('input.nosymbolinput').on('change keyup', function(){
		if(!!$(this).data('copy')){
			let copy = `input[name="${$(this).data('copy')}"]`;

			$(copy).val($(this).val().replace(/[~`!@#$%^&*()+={}\[\];:\'\"<>.,\/\\\? _]/g, '-'))
		}else{
			$(this).val($(this).val().replace(/[~`!@#$%^&*()+={}\[\];:\'\"<>.,\/\\\? _]/g, '-'))
		}
	});
	$('.lang-selector > [data-lang]').on('click', function(){
		$(this).closest('.form-group').find('[data-lang]').removeClass('selected');
		$(this).addClass('selected');

		$(this).closest('.form-group').find(`[data-thislang]`).addClass('d-none');
		$(this).closest('.form-group').find(`[data-thislang="${$(this).data('lang')}"]`).removeClass('d-none');
	});
});