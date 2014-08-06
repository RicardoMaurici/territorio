<?php
require 'head.php';
header('Content-Type: text/html; charset=UTF-8');

?>
<!-- TEXTO INTRODUTÓRIO PARA CADASTRO DA FOTO -->
<div class="row">
<?php
require 'header.php';
?>
	<div class="col-md-offset-1 col-lg-4 texto">
		<h1 class="enviarfoto">Eu e meu território</h1>
		<p class="nome">O território é mais do que um simples local
			geográfico, pois implica o espaço da convivência social e da mediação
			material que permite que os sujeitos trabalhem, habitem, circulem,
			relacionem-se, divirtam-se. O território ganha, com isso, um valor
			simbólico para os sujeitos, pois possibilita a comunhão com o lugar e
			com os que nele vivem, o que faz com que nesse espaço as pessoas se
			reconheçam, construam suas redes sociais, sua identidade. Com isso,
			pode-se falar de TERRITORIALIDADE como um sentimento de
			pertencimento, sendo a base para a identidade pessoal e social.</p>
	</div>
	<div class="col-md-offset-1 col-md-5 col-lg-5 formulario">
		<h1 class="enviarfoto">Enviar sua foto</h1>
		<!-- FORMULÁRIO DE CADASTRO DA FOTO-->
		<form id="centro" action="formulario/form_dados.php" method="post"
			enctype="multipart/form-data">

			<p>
				Quem é você? (nome)<br> <input type="text" name="nome" size="40"
					class="form-control" maxlength="100"
					value="<?php echo $_SESSION['nomeCompleto'];?>" required>
			</p>
			<p>
				Onde atua?<br> <input type="text" name="email" size="120" maxlength="120"
					class="form-control" required>
			</p>
			<p>
				Conte-nos do seu território<br>
				<textarea name="mensagem" maxlength="1024" rows="7" cols="42" required></textarea>
			</p>
			<br>
			<!-- AREA ONDE CARREGA A FOTO PARA RECORTE-->
			<div class="wrap">
				<img id="uploadPreview" style="display: none;" />
				<p class="alert alert-danger">Antes de enviar a foto por favor
					selecione com o mouse a área da foto</p>
				<input id="uploadImage" type="file" accept="image/jpeg"
					name="upload" required /> 
					<input type="checkbox" name="terms" id="terms" onchange="activateButton(this)"><a href="">Aceita os termos e condições?</a><br>
					<input type="submit" value="enviar" id="submit" name="submit"
					style="margin-bottom: 90px;"> <input type="hidden" id="x" name="x" />
				<input type="hidden" id="y" name="y" /> <input type="hidden" id="w"
					name="w" /> <input type="hidden" id="h" name="h" />
		
		</form>
	</div>
</div>
</div>
<!-- FIM DO ROW E COMEÇO DO RODAPÉ-->
<div id="footer">
	<div class="caixa">
		<a class="cadast" a href="./index.php">Página inicial</a>
	</div>
</div>
<!--DIV QUE MOSTRA A MENSAGEM DE SUCESSO AO ENVIAR A FOTO-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog"
	aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel"></h4>
			</div>
			<div class="modal-body">
				<h4 style="text-align: center;">Enviado com sucesso!</h4>
				Abra sua foto na página inicial e verifique se os dados estão
				corretos, em caso de erro repita o procedimento de envio. O sistema
				iá sobrescrever seus dados.
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
			</div>
		</div>
	</div>
</div>
<!-- SCRIPTS QUE FAZEM O UPLOAD PREVIEW DA FOTO-->
<script>
 function disableSubmit() {
  document.getElementById("submit").disabled = true;
 }

  function activateButton(element) {

      if(element.checked) {
        document.getElementById("submit").disabled = false;
       }
       else  {
        document.getElementById("submit").disabled = true;
      }

  }
</script>
<script type="text/javascript">
// set info for cropping image using hidden fields
// set info for cropping image using hidden fields
function setInfo(i, e) {
// Get on screen image
var screenImage = $("#uploadPreview");

// Create new offscreen image to test
var theImage = new Image();
theImage.src = screenImage.attr("src");

// Get accurate measurements from that.
var imageWidth = theImage.width;

//Get width of resized image
var scaledimagewidth = document.getElementById("uploadPreview").width;

if ( imageWidth > scaledimagewidth){ var ar = imageWidth/scaledimagewidth;}
else { var ar = 1;}
$('#x').val(e.x1*ar);
$('#y').val(e.y1*ar);
$('#w').val(e.width*ar);
$('#h').val(e.height*ar);
}

$(document).ready(function() {
var p = $("#uploadPreview");

// prepare instant preview
$("#uploadImage").change(function(){
// fadeOut or hide preview
p.fadeOut();

// prepare HTML5 FileReader
var oFReader = new FileReader();
oFReader.readAsDataURL(document.getElementById("uploadImage").files[0]);

oFReader.onload = function (oFREvent) {
p.attr('src', oFREvent.target.result).fadeIn();
};
});

// implement imgAreaSelect plug in (http://odyniec.net/projects/imgareaselect/)
$('img#uploadPreview').imgAreaSelect({
// set crop ratio (optional)
aspectRatio: '1:1',
onSelectEnd: setInfo
});
});

</script>
</body>
</html>
<!--SE A FOTO FOR ENVIADA COM SUCESSO CHAMA O TEXTO-->
<?php
if (isset ( $_GET ['mensagem'] )) {
	
	if ($_GET ['mensagem'] == 'ok') {
		?>


<script type="text/javascript">
        $('#myModal').modal('show');
        
      </script>
<?php
	}
}
?>
