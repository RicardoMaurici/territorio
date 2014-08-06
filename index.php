<?php
require_once 'formulario/conecta.php';
require_once 'formulario/config.php';
require 'head.php';
?>

		<div class="container">
			<?php include "header.php" ;
						
			 //$envia=5;
			 if (isset($_REQUEST['envia']) && $_REQUEST['envia']==true) {
				include "login.php";
			} else {
				   include "galeria.php";
				}
			?>
		</div>
		

		<div id="footer">
			<div id="cadastro">
				<div class="caixa">
				<?php if (isset($_REQUEST['envia']) && $_REQUEST['envia']==true) {
					    echo '<a class="cadast" a href="index.php">Página inicial</a>';
					} else {
					   echo '<a class="cadast" href="?envia=true">Envie sua foto</a>';
					};?>
				</div>
			</div>
		</div>


		<script type="text/javascript">
				$(document).ready(function() {
				$('.popup-gallery').magnificPopup({
					delegate: 'a',
					type: 'image',
					tLoading: 'Loading image #%curr%...',
					mainClass: 'mfp-img-mobile',
					gallery: {
						enabled: true,
						navigateByImgClick: true,
						preload: [0,1] // Will preload 0 - before current, and 1 after the current image
					},
					image: {
						tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
						titleSrc: function(item) {
							return item.el.attr('title');
						}
					}
				});
			});
		</script>
		<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-47045455-6', 'auto');
  ga('send', 'pageview');

</script>

</body>
</html>