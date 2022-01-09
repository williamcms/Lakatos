$(document).ready(function(){
	$('#password, #password2').on('input', function(e){
		if($('#password').val() !== $('#password2').val()){
			$('#password').css('border', '1px solid var(--warning)');
			$('#password').css('box-shadow', '0 0 3px 2px var(--warning)');
			$('#password2').css('border', '1px solid var(--warning)');
			$('#password2').css('box-shadow', '0 0 3px 2px var(--warning)');
		}else{
			$('#password').css('border', '1px solid var(--green)');
			$('#password').css('box-shadow', '0 0 3px 2px var(--green)');
			$('#password2').css('border', '1px solid var(--green)');
			$('#password2').css('box-shadow', '0 0 3px 2px var(--green)');
			$('#confirmPassword').html('');
			$('#confirmPassword2').html('');
		}
		if($('#password').val().length < 6 || $('#password2').val().length < 6){
			$('#confirmPassword').html('A senha deve possuir no mínimo 6 caracteres');
			$('#confirmPassword2').html('A senha deve possuir no mínimo 6 caracteres');
		}
		if($('#password').val() !== $('#password2').val()){
			$('#confirmPassword').html('As senhas não coincidem');
			$('#confirmPassword2').html('As senhas não coincidem');
		}
	});
});