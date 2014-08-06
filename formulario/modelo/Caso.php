<?php
/**
 * Esta provê os mecanismos necessários para a manipulação e persistência (em banco de dados) dos objetos Caso.
 *
 * @author Murillo
 */

class Caso {

    private $id;
    private $aluno_id;
    private $empresa;
    private $estado;
    private $municipio;
    private $fundacao;
    private $descricao;
    private $tipo;
    private $visualizacoes;
    private $database;
    private $tablePrefix;

    function __construct($database, $tablePrefix) {
        $this->id = -1;
        $this->aluno_id = 0;
        $this->visualizacoes = 0;
        $this->database = $database;
        $this->tablePrefix = $tablePrefix;
    }

    public function load($id){
        $sql = "select * from {$this->tablePrefix}casos where id={$id}";
        $resultado = $this->database->sql($sql);
        if(mysql_num_rows($resultado) == 1){
            $caso = mysql_fetch_array($resultado);
            $this->id = $id;
            $this->aluno_id = $caso['aluno_id'];
            $this->empresa = $caso['empresa'];
            $this->estado = $caso['estado'];
            $this->municipio = $caso['municipio'];
            $this->fundacao = $caso['fundacao'];
            $this->descricao = $caso['descricao'];
            $this->tipo = $caso['tipo'];
            $this->visualizacoes = $caso['visualizacoes'];
        }else{
            throw new CasoCreationException("Não foi possível encontrar um caso com o id especificado");
        }
    }

    public function save(){
        if($this->id != -1){
            $sql = "update {$this->tablePrefix}casos set aluno_id = {$this->aluno_id}, empresa = \"".mysql_escape_string($this->empresa)."\", estado = '{$this->estado}', municipio =  \"".mysql_escape_string($this->municipio)."\", fundacao = '{$this->fundacao}', descricao =  \"".mysql_escape_string($this->descricao)."\", tipo= '{$this->tipo}', visualizacoes = {$this->visualizacoes} where id = {$this->id} ";
            if(!$this->database->sql($sql)){
              throw new CasoCreationException("Não foi possível salvar ");}
        }else{
            $sql = "insert into {$this->tablePrefix}casos(aluno_id, empresa, estado, municipio, fundacao, descricao, tipo) values ({$this->aluno_id}, \"".mysql_escape_string($this->empresa)."\", '{$this->estado}' , \"".mysql_escape_string($this->municipio)."\", '{$this->fundacao}' , \"".mysql_escape_string($this->descricao)."\", '{$this->tipo}')";
            if(!$this->id = $this->database->sql($sql, true))
              throw new CasoCreationException("Não foi possível salvar ");
        }
    }

    public function setId($id) {
        if($id > 0)
            $this->id = $id;
        else
            throw new WrongParameterException("O ID deve ser um inteiro positivo");
    }

    public function setAluno_id($aluno_id) {
        if($aluno_id > 0)
            $this->aluno_id = $aluno_id;
        else
            throw new WrongParameterException("O ID deve ser um inteiro positivo");
    }

    public function setEmpresa($empresa) {
        if(strlen($empresa) > 0)
            $this->empresa = $empresa;
        else
            throw new WrongParameterException("O nome da empresa deve ser preenchido");
    }

    public function setEstado($estado) {
        if(strlen($estado) == 2)
            $this->estado = $estado;
        else
            throw new WrongParameterException("O estado deve ser uma sigla de 2 caracteres");
    }

    public function setMunicipio($municipio) {
        if(strlen($municipio) > 0)
            $this->municipio = $municipio;
        else
            throw new WrongParameterException("O municipio deve ser preenchido");
    }

    public function setFundacao($fundacao) {
        $datepieces = explode("/", $fundacao);
        if(strlen($fundacao) == 10 and checkdate($datepieces[1], $datepieces[0], $datepieces[2])){
            $this->fundacao = $datepieces[2]."/".$datepieces[1]."/".$datepieces[0];
        }else{
            throw new WrongParameterException("A data informada parece inválida");
        }
        
    }

    public function setDescricao($descricao) {
        if(strlen($descricao) > 0)
            $this->descricao = $descricao;
        else
            throw new WrongParameterException("A descrição deve ser preenchida");
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function setVisualizacoes($visualizacoes) {
        $this->visualizacoes = $visualizacoes;
    }

    public function getId() {
        return $this->id;
    }

    public function getAluno_id() {
        return $this->aluno_id;
    }

    public function getEmpresa() {
        return $this->empresa;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getMunicipio() {
        return $this->municipio;
    }

    public function getFundacao() {
        return $this->fundacao;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getVisualizacoes() {
        return $this->visualizacoes;
    }

}
?>
