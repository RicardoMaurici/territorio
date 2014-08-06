<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MoodleData
 *
 * @author murillo
 */
class MoodleData {
    
    private $id;
    private $database;
    private $tablePrefix;

    function __construct($id, $tablePrefix) {
        require 'config.php';
        $this->id = $id;
        $this->tablePrefix = $tablePrefix;
        $this->database = new MySQL($moodle_host, $moodle_user, $moodle_pass, $moodle_db);
    }

    public function getFullUserName(){
        $sql = "select concat(firstname, ' ', lastname) as nome from {$this->tablePrefix}user where id={$this->id}";
        $nome = $this->database->sql($sql);
        if(mysql_num_rows($nome) == 0){
            return 'nome não encontrado';
        } else {
            $nome = mysql_fetch_array($nome);
            return $nome['nome'];
        }
        
        
    }



}
?>
