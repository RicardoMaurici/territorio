<?php
require 'setup.php';
require 'password_compat-master/lib/password.php';
error_reporting ( E_ALL );
ini_set ( 'error_reporting', E_ALL );
global $SESSION, $CFG;

if ($_SERVER ['REQUEST_METHOD'] === 'POST')
	validaDados ();

function validaDados() {
	if (isset ( $_FILES ['upload'], $_POST ['mensagem'], $_POST ['email'], $_POST ['nome'] )) {
		
		$valid_exts = array (
				'jpeg',
				'jpg',
				'png',
				'gif' 
		);
		$max_file_size = 4000 * 1024; // 00kb
		$nw = $nh = 200; // image with # height
		
		if (isset ( $_FILES ['upload'] )) {
			if (! $_FILES ['upload'] ['error'] && $_FILES ['upload'] ['size'] < $max_file_size) {
				$ext = strtolower ( pathinfo ( $_FILES ['upload'] ['name'], PATHINFO_EXTENSION ) );
				if (in_array ( $ext, $valid_exts )) {
					$path = 'arquivos_upload/' . uniqid () . '.' . $ext;
					$size = getimagesize ( $_FILES ['upload'] ['tmp_name'] );
					
					$x = ( int ) $_POST ['x'];
					$y = ( int ) $_POST ['y'];
					$w = ( int ) $_POST ['w'] ? $_POST ['w'] : $size [0];
					$h = ( int ) $_POST ['h'] ? $_POST ['h'] : $size [1];
					
					$data = file_get_contents ( $_FILES ['upload'] ['tmp_name'] );
					$vImg = imagecreatefromstring ( $data );
					$dstImg = imagecreatetruecolor ( $nw, $nh );
					imagecopyresampled ( $dstImg, $vImg, 0, 0, $x, $y, $nw, $nh, $w, $h );
					imagejpeg ( $dstImg, $path );
					imagedestroy ( $dstImg );
		
					if (inserir ( $_POST ['nome'], $_POST ['email'], $_POST ['mensagem'], $path, $_SESSION ['userid'], $_SESSION ['groupid'], $_SESSION ['groupName'] )) {
						?><script type="text/javascript">

                                location.href = '..?grupo='+<?php echo "'".$_SESSION['groupName']."'" ?>;
                                </script>
<?php
					} else {
						?><script type="text/javascript">
                                                    alert('Erro ao salvar dados');
                                                    location.href = '..?envia=true';
                                </script>
<?php
					}
				} else {
					echo 'unknown problem!';
				}
			} else {
				echo 'file is too small or large';
			}
		} else {
			echo 'file not set';
		}
	} else {
		?><script type="text/javascript">

                            alert('Erro ao preencher formulário');
                            header('Location:..?envia=true');
            </script>
<?php
	}
}
function inserir($nome, $email, $mensagem, $upload, $id_usuario, $groupid, $groupName) {
	require_once 'conecta.php';

	$nome = mysql_escape_string($nome);
	$email = mysql_escape_string($email);
	$mensagem = mysql_escape_string($mensagem);
	$groupName = mysql_escape_string($groupName);

	$nome = str_replace("\"", "'", $nome);
	$email = str_replace("\"", "'", $email);
	$mensagem = str_replace("\"", "'", $mensagem);

	// pesquisando se tem outros cadastros do usuário
	$consulta = mysql_query ( "SELECT * FROM publicacao WHERE id_usuario = " . $id_usuario );
	$consultaM = mysql_fetch_array ( $consulta );
	if (mysql_num_rows ( $consulta ) == 0)
		$query = "INSERT into publicacao(nome, imagem, email_aluno, descricao, id_usuario, idgroup, groupName, acordo) VALUES('" . $nome . "','" . $upload . "','" . $email . "','" . $mensagem . "'," . $id_usuario . "," . $groupid . ",'".$groupName."',1);";
	else
		$query = "UPDATE publicacao SET nome = '" . $nome . "', imagem = '" . $upload . "', email_aluno = '" . $email . "',
							 descricao = '" . $mensagem . "', idgroup = " . $groupid . ", groupName = '" . $groupName . "', acordo = 1 
							 			where id_usuario = " . $id_usuario;
	if (mysql_query ( $query ))
		return true;
	return false;
}
?>