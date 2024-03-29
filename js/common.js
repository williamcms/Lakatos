$(document).ready(function(){
	'use strict';
	//Slickers
	$('.slick-carousel-dots').slick({
		lazyLoad: 'ondemand',
		autoplay: false,
		autoplaySpeed: 3000,
		dots: true,
		arrows: false,
		prevArrow: '<button class="slick-prev" aria-label="Anterior" type="button">Anterior</button>',
		nextArrow: '<button class="slick-next" aria-label="Próximo" type="button">Próximo</button>',
		lazyLoad: 'ondemand',
		slidesToShow: 1,
		slidesToScroll: 1
	});
	$('.slick-carousel-arrows').slick({
		lazyLoad: 'ondemand',
		autoplay: true,
		autoplaySpeed: 3000,
		dots: false,
		arrows: true,
		prevArrow: '<button class="slick-prev" aria-label="Anterior" type="button">Anterior</button>',
		nextArrow: '<button class="slick-next" aria-label="Próximo" type="button">Próximo</button>',
		lazyLoad: 'ondemand',
		slidesToShow: 1,
		slidesToScroll: 1
	});
	$('.slick-carousel-both').slick({
		lazyLoad: 'ondemand',
		autoplay: false,
		autoplaySpeed: 3000,
		dots: true,
		arrows: true,
		prevArrow: '<button class="slick-prev" aria-label="Anterior" type="button">Anterior</button>',
		nextArrow: '<button class="slick-next" aria-label="Próximo" type="button">Próximo</button>',
		lazyLoad: 'ondemand',
		slidesToShow: 1,
		slidesToScroll: 1
	});
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
	var menubar = (menubar = () =>{
		var b = $('#menubar'),
		m = b.find('button'),
		d = b.find('ul');
		if(isMobile()){
			d.attr('role', 'none');
			m.attr('role', 'menu');
		}else{
			d.attr('role', 'menu');
			m.attr('role', 'none');
		}
	})();
	var openMenu = $('.js--open-menu').on('click', function(){
		$('header nav.menu ul.navigation, header nav.menu > button.js--open-menu').toggleClass('change');
		$('body').toggleClass('noscroll');
		// Atributos para Leitores de tela
		let $x = $(this).hasClass('change');
		$(this).attr('aria-expanded', $x);
	});
	var closeMenu = $('main, header nav.menu ul li:not([aria-haspopup="true"])').on('click', function(){
		$('body').removeClass('noscroll');
		$('header nav.menu ul.navigation, header nav.menu > button.js--open-menu').removeClass('change');
	})
	var hideMenuOnScroll = (hideMenuOnScroll = () => {
		var top = 0;
		$(window).on("scroll", function() {
			$(window).scrollTop() > top && 1 < $(window).scrollTop() ? ($("header .wrapper").slideUp()) : $(window).scrollTop() === 0 ? ($("header .wrapper").slideDown()) : $("header .wrapper").slideDown();
			top = $(window).scrollTop();
		});
	})();
	var menuSubonMobile = $('ul > li.menuitem[aria-haspopup="true"]').on('click', function(evt){
		isMobile() && evt.target == $(this).find('a').get(0) && evt.preventDefault();
	});
	// Home - Play Video
	var playVideo = $('#playVideo').on('click', function(){
		var video = $('#homeVideo').get(0);

		if(video.paused){
			video.play();
			$(this).attr('aria-label', 'Pausar vídeo');
			$(this).attr('title', 'Pausar vídeo');
			$(this).find('span').text('Pausar vídeo');
			$(this).addClass('fas');
			$(this).parents('#home').removeClass('paused');
		}else{
			video.pause();	
			$(this).parents('#home').addClass('paused');
			$(this).removeClass('fas');
			$(this).attr('aria-label', 'Reproduzir vídeo');
			$(this).attr('title', 'Reproduzir vídeo');
			$(this).find('span').text('Reproduzir vídeo');
		}
	});
	// MouseOver in images
	var onMouseOver = $('img[mousein]').on({
		mouseenter: function(e){
			let h = $(this).attr('mousein');
			
			h != '' && $(this).attr('src', h)
		},
		mouseleave: function(e){
			let s = $(this).attr('mouseout');
			
			s != '' && $(this).attr('src', s)
		}
	});
	// WhatsappButton
	$('#whatsappButton, #whatsapp-outer-message').click(function(){
		$('#whatsapp-outer-message').css('display', 'none');
		$('#whatsapp-conversation').toggle('slow');
		$('#whatsapp-input-message').focus().val('Olá, Meu Nome é...');
	});	
	$('#whatsapp-input-message').on('input', function(){
		var href, splitArray;
		href = $('#whatsapp-link').attr('href');
		splitArray = href.split('&');
		splitArray[1] = $('#whatsapp-input-message').val();
		$('#whatsapp-input-message').autogrow();

		$('#whatsapp-link').attr('href', splitArray[0] + '&text=' + splitArray[1]);
	});
	// Contact options
	$('#fornecedoresContato').on('change', function(){
		let item = $(this).find(':selected').val(),
		infoOptions = $('form > .contact-options').find('div');

		$.each(infoOptions, function(){
			if($(this).hasClass(item)){
				$(this).show();
			}else{
				$(this).hide();
			}
		})
	})
});