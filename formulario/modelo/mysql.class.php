<?php
/*
* Classe de Conexao com MySQL
* =====================
* por Felipe Rezende
* =====================
* Descricao: Classe que
* que realiza conexao com o banco
* de dados. 
 */

class MySQL {
    // edite aqui
    private $host;
    private $user;
    private $pass;
    private $db;

    // nao edite as vars abaixo
    private $query;
    private $link;
    private $result;
    private $last_id;
    
    /**
    * @return MySQL
    * @desc Construtor da classe MySQL.
    */
    function MySQL($host, $user, $pass, $db){
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->db = $db;
	$this->connect();
    mysql_query("SET NAMES 'utf8'");
    mysql_query('SET character_set_connection=utf8');
    mysql_query('SET character_set_client=utf8');
    mysql_query('SET character_set_results=utf8');
    } 
    /**
    * @return void
    * @desc M�todo que Conecta ao Servidor e seleciona Banco de Dados.
    */
    function connect(){
               
        $this->link = @mysql_connect($this->host,$this->user,$this->pass) or die(mysql_error());
        
        if(!$this->link){
            die();           
        } elseif (!mysql_select_db($this->db)){
            die();
        }
                
    }
    
    
    /**
    * @return Resultado
    * @param String $query
    * @desc Recebe query SQL, executa e retorna resultado, se houver erro retorna 0.
    */
    function sql($query,$get_id=false){
       
        $this->query = utf8_decode($query);
        if($this->result=@mysql_query($this->query)){
			if($get_id){
				$this->last_id= mysql_insert_id();
				//$this->disconnect();
				return $this->last_id;
			} else {
				//$this->disconnect();
				return $this->result;
			}
        } else {
            
           // $this->disconnect();
        }
        
    }
    /**
    * @return mysql_close
    * @desc Desconecta do servidor
    */
    function disconnect(){
        return mysql_close($this->link);
    }
	
	function get_id(){
		return mysql_insert_id($this->link);
	}

    function startTransaction(){
        @mysql_query("set autocommit = 0");
        @mysql_query("start transaction");
       
    }

    function commit(){
        @mysql_query("commit");
    }

    function rollback(){
        @mysql_query("rollback");
    }
}
?>
