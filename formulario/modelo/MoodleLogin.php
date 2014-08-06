<?php

/**
 * Classe de verificação de usuários no moodle. Pode ser usada em sistemas externos ao moodle
 * para controlar o login, liberando-o apenas para alunos de um determinado curso do moodle.
 *
 * @author murillo
 * 
 */
class MoodleLogin {

    private $courseid;
    private $database;
    private $username;
    private $passwd;
    private $tablePrefix;

    public function __construct($courseid, $username, $passwd, $tablePrefix) {
        require 'config.php';
        $this->tablePrefix = $tablePrefix;
        $this->username = $username;
        $this->passwd = $passwd;
        $this->courseid = $courseid;
        $this->database = new MySQL($moodle_host, $moodle_user, $moodle_pass, $moodle_db);
        
    }

    /**
     * Verifica se o conjunto {nomedeusuario,senha} identifica um aluno do curso atribuído na classe.
     * @return boolean true, se o nome de usuário e senha corresponderem aos de um aluno, false caso contrário.
     */
    public function isValidUser() {
        try {

            $contexto = 6164;
            $sql = "select id, password from {$this->tablePrefix}user where username='{$this->username}';";
            $id = mysql_fetch_assoc($this->database->sql($sql));

            if (password_verify($this->passwd, $id['password'])) {
                $sql = "select * from {$this->tablePrefix}role_assignments where contextid={$contexto} and userid='{$id['id']}'";
                if (mysql_num_rows($this->database->sql($sql)) == 0)
                    return false;
                else
                    return true;
            } else {
                return false;
            }
        } catch (UndefinedCourseException $ex) {
            echo "Erro interno de configuração. Impossível encontrar o contexto do curso";
            die(1);
        }
    }

    /**
     * Verifica se o nome de usuário passado como parâmetro no construtor corresponde ao de um aluno do curso especificado na classe.
     * @return boolean true, caso o nome de usuário seja de um aluno, false caso contrário.
     */
    public function isValidLogin() {
        $sql = "select * from {$this->tablePrefix}user u join {$this->tablePrefix}course_display cd on cd.userid = u.id where u.username = '{$this->username}' and cd.course={$this->courseid}";
        if (mysql_num_rows($this->database->sql($sql)) == 0)
            return false;
        else
            return true;
    }

    /**
     * Retorna o roleid do usuário. O roleid permite identificar se o usuário é um aluno ou não dentro do contexto do moodle.
     * @return int Um número inteiro indicando o roleid do usuário | Exception caso o usuário não possua roleid  ou não seja um usuário válido
     */
    public function getRoleId() {
        
        if ($this->isValidUser()) {
            
            try {
                $contexto = $this->getContextId();
                $roleid = "select roleid from {$this->tablePrefix}role_assignments where userid={$this->getUserId()} and contextid={$contexto}";
                $roleid = mysql_fetch_array($this->database->sql($roleid));
                return $roleid['roleid'];
            } catch (UndefinedCourseException $ex) {
                echo "Erro interno de configuração. Impossível encontrar o contexto do curso";
                die(1);
            }
        } else {
            throw new InvalidUserException("Roleid não encontrado.");
        }
        
    }

    /**
     * Retorna o id de curso setado no construtor da classe.
     * @return int indicando o id do curso que se está usando.
     */
    public function getCourseid() {
        return $this->courseid;
    }

    /**
     * Retorna o nome do usuário (p.ex.: João da Silva).
     * @return string Nome do usuário | Exception Caso não seja um usuário válido.
     */
    public function getFullUserName() {
       if ($this->isValidUser()) {            
            $sql = "select concat(firstname, ' ', lastname) as nome from {$this->tablePrefix}user where id={$this->getUserId()}";
            $nome = mysql_fetch_array($this->database->sql($sql));

            return $nome['nome'];
        } else {
            throw new InvalidUserException("Usuário inválido. Impossível recuperar nome.");
        }
    }

    /**
     * Busca e retorna o id do usuário que tenha username e senha iguais aos especificados. Dispara InvalidUserException caso o conjunto {usuario,senha} não represente nenhum usuário.
     * @return int ID do usuário 
     */
    public function getUserId() {
        if ($this->isValidUser()) {
            $sql = "select id from {$this->tablePrefix}user where username='{$this->username}'";
            $id = mysql_fetch_array($this->database->sql($sql));
            return $id['id'];
        } else {
            throw new InvalidUserException("Usuário inválido");
        }
    }

    /**
     * Busca e retorna o id do contexto que identifica o curso nas tabelas do moodle. Este id é importante para sabermos se um determinado usuário está ou não em um curso (identificado pelo contexto).
     * @return int indicando o contexto do curso. 
     * 
     * 
     */
    private function getContextId() {
        $contexto = "select id from {$this->tablePrefix}context where contextlevel=50 and instanceid={$this->courseid}";

        if (@mysql_num_rows($this->database->sql($contexto)) == 0) {
            throw new UndefinedCourseException("Impossível definir o contexto do curso");
        } else {
            $contexto = mysql_fetch_array($this->database->sql($contexto));
            return $contexto['id'];
        }
    }
    
    /**
     * Busca e retorna o id do grupo que o usuario pertence. Dispara InvalidUserException caso o conjunto {usuario,senha} não represente nenhum usuário.
     * @return int ID do grupo do usuario
     */
    public function getGroupId() {
    	if ($this->isValidUser()) {
    		$sql = "select groupid from {$this->tablePrefix}groups_members where userid='{$this->getUserId()}'";
    		$id = mysql_fetch_array($this->database->sql($sql));
    		return $id['groupid'];
    	} else {
    		throw new InvalidUserException("Usuário inválido");
    	}
    }

    /**
     * Busca e retorna o nome do grupo que o usuario pertence. Dispara InvalidUserException caso o conjunto {usuario,senha} não represente nenhum usuário.
     * @return string nomeGrupo do grupo do usuario
     */
    public function getGroupName(){
        if ($this->isValidUser()) {
            $sql = "select name from {$this->tablePrefix}groups where id='{$this->getGroupId()}'";
            $nomeGrupo = mysql_fetch_array($this->database->sql($sql));

            $nomeGrupo = str_replace("\"", "'", $nomeGrupo);
            $nomeGrupo = str_replace(" ", "", $nomeGrupo);
            $nomeGrupo = str_replace("Grupo", "", $nomeGrupo);

            return $nomeGrupo['name'];
        } else {
            throw new InvalidUserException("Usuário inválido");
        }
    }
}

?>
