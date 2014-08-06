<script>
  $(document).ready(function() {
    $(".popup-gallery").scroll(function() { 
      if ($(this).scrollTop() + $(this).height() == $(this).get(0).scrollHeight) {
        // a rolagem chegou ao fim, fazer algo aqui.
      }
    });
  });
</script>


			<div class="corpo">
				<?php
				
				$query = "SELECT nome,imagem,email_aluno,descricao FROM publicacao where acordo = 1 order by rand()";

				if(isset($_GET['grupo'])){
					$grupo = $_GET['grupo'];
					while( is_numeric($grupo) and strlen($grupo) < 3)
						$grupo = '0'.$grupo;

					$query = "SELECT nome,imagem,email_aluno,descricao FROM publicacao where groupName = '".$grupo."' and acordo = 1  order by rand()";
				}
				$result = mysql_query($query);
				while ($row = mysql_fetch_assoc($result)) {
			    ?>	

				<div class="popup-gallery">
					<a  title="<h3> Nome:     </h3>
					<p><?php echo $row['nome']; ?></p>
					<h3>Onde atua:</h3>
					<p><?php echo $row['email_aluno']; ?></p> 
					<h3>Meu território:</h3>
					<p><?php echo $row['descricao']; ?></p>" href="formulario/<?php echo $row['imagem']; ?> ">
					<img class="fotos" title ="<?php echo $row['nome']; ?>" src="formulario/<?php echo $row['imagem']; ?>">
					</a>
				</div>


			 <?php 
					}	
					?>	
			</div>
