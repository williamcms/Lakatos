#HEAD

	<link rel="stylesheet" href="css/bootstrap-edit.css" />
	<link rel="stylesheet" href="summernote/dist/summernote.css">
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script> 
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>
	<script type="text/javascript" src="summernote/dist/summernote.js"></script>

	<script src="javascript/summernote-image-captionit.js"></script> <!-- Adiciona Legendas na foto -->

	<script>
		$(document).ready(function() {
		  $('#summernote').summernote({
		    height: 450,
		    tabsize: 2,
		    //Legendas na Foto
		    popover: {
		            image: [
		                ['custom', ['captionIt']],
		                ['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
		                ['float', ['floatLeft', 'floatRight', 'floatNone']],
		                ['remove', ['removeMedia']]
		            ],
		        },
		        captionIt:{
		            figureClass:'img-mediacontent',
		            figcaptionClass:'img-captioncontent',
		            captionText:'{Texto de espaço reservado para a legenda}'
		        }
		  });
		});
	</script>
<style>
	input, textarea{
		color: black !important;
	}
</style>


#INPUT

<textarea id="summernote"> </textarea>