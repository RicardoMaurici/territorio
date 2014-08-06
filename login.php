<?php
require 'formulario/setup.php';
require 'formulario/password_compat-master/lib/password.php';
header('Content-Type: text/html; charset=utf-8');
error_reporting ( E_ALL );
ini_set ( 'error_reporting', E_ALL );

global $SESSION, $CFG;

if (isset ($_POST ['user'], $_POST ['password'] )) {
	
	$moodle = new MoodleLogin ( $CFG->getMoodleCursoID(), $_POST['user'], $_POST['password'], $CFG->getMoodleTablePrefix() );

	if ($moodle->isValidUser()) {
		$SESSION->setNomecompleto ( $moodle->getFullUserName () );
		$SESSION->setUserid ( $moodle->getUserId () );
		$SESSION->setGroupid($moodle->getGroupId());
		$SESSION->setGroupName($moodle->getGroupName());
		$SESSION->saveAll();
		include 'formulario.php';
		die();
	} else {
		?><script type="text/javascript">
                    alert('Usuário ou senha inválidos. Tente novamente');
                    location.href = "./?envia=true";
        </script><?php
	}
}

?>

<style>
#logon {
	width: 270px;
	margin: 0 auto;
	margin-top: 120px;
}
</style>
<form id="logon" action="login.php" method="post">
	<label for="inputEmail">Usuário(AVEA)</label> <input id="inputEmail"
		type="text" name="user" size="40" class="form-control" required
		placeholder="Usuário AVEA..." /> <label for="inputPassword">Senha</label>
	<input id="inputPassword" type="password" name="password" size="40"
		class="form-control" required placeholder="Digite a sua senha..." /> <label>
		<input type="checkbox" /> Lembrar senha
	</label>
	<button type="submit">Acessar</button>
</form>