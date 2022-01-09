$(document).ready(function(){
	//Fecha a notificação
	$('#closeEmailNotification').on('click', function(e){
		$('#successEmailNotification').css('opacity', '0');
	});
	//Range
	$('#range_input').on('input', function(e){
		$('#range_input_value').html(this.value);
	});
	$('#range_input2').on('input', function(e){
		$('#range_input_value2').html(this.value);
	});
	$('#password').on('input', function(e){
		if($('#password').val() !== $('#password2').val()){
			$('#password2').css('border', '1px solid var(--warning)');
			$('#password2').css('box-shadow', '0 0 3px 2px var(--warning)');
			$('#confirmPassword').html('(As senhas não coincidem)');
			$('#confirmPassword2').html('(As senhas não coincidem)');
		}else{
			$('#password2').css('border', '1px solid var(--green)');
			$('#password2').css('box-shadow', '0 0 3px 2px var(--green)');
			$('#confirmPassword').html('<span></span>');
			$('#confirmPassword2').html('<span></span>');
		}
	});
	$('#password2').on('input', function(e){
		if($('#password').val() !== $('#password2').val()){
			$('#password2').css('border', '1px solid var(--warning)');
			$('#password2').css('box-shadow', '0 0 3px 2px var(--warning)');
			$('#confirmPassword').html('(As senhas não coincidem)');
			$('#confirmPassword2').html('(As senhas não coincidem)');
		}else{
			$('#password2').css('border', '1px solid var(--green)');
			$('#password2').css('box-shadow', '0 0 3px 2px var(--green)');
			$('#confirmPassword').html('<span></span>');
			$('#confirmPassword2').html('<span></span>');
		}
	});
});