<?php
/**
 * Description of Session
 *
 * @author murillo
 */
class Session {

    private $nomeCompleto;
    private $userid;
    private $data;
    private $groupid;
    private $groupName;

    function __construct() {
        session_start();
        if(isset($_SESSION['logged'])){
            $this->nomeCompleto = $_SESSION['nomeCompleto'];
            $this->userid = $_SESSION['userid'];
            $this->data = $_SESSION['data'];
            $this->groupid = $_SESSION['groupid'];
            $this->groupName = $_SESSION['groupName'];
        } else if($this->existsCookie()){
            $this->nomeCompleto = $_COOKIE['UserData']['nomeCompleto'];
            $this->userid = $_COOKIE['UserData']['userid'];
            $this->groupid = $_COOKIE['UserData']['groupid'];
            $this->groupName = $_COOKIE['UserData']['groupName'];
            $this->saveAll();
        }else{
            $this->nomeCompleto = "";
            $this->userid = "";
            $this->groupid = "";
            $this->groupName = "";
            if(isset($_SESSION['data']))
                $this->data = $_SESSION['data'];
        }
    }
    
    public function getNomecompleto() {
        return $this->nomeCompleto;
    }
        
    public function getUserid() {
        return $this->userid;
    }
        
    public function getData() {
        return $this->data;
    }
    
    public  function  getGroupid(){
    	return  $this->groupid;	
    }  

    public  function  getGroupName(){
        return  $this->groupName; 
    }   
         
    public function setData($data) {
        $this->data = $data;
    }
    
    public function setNomecompleto($nomeCompleto) {
        $this->nomeCompleto = $nomeCompleto;
    }
        
    public function setUserid($userid) {
        $this->userid = $userid;
    }
    
    public  function setGroupid($groupid){
    	$this->groupid = $groupid;
    }

    public  function setGroupName($groupName){
        $this->groupName = $groupName;
    }
        
    public function saveData(){
        $_SESSION['data'] = $this->data;
    }
    
    public function saveAll(){
        $_SESSION['nomeCompleto'] = $this->nomeCompleto;
        $_SESSION['userid'] = $this->userid;
        $_SESSION['data'] = $this->data;
        $_SESSION['groupid'] = $this->groupid;
        $_SESSION['groupName'] = $this->groupName;
        $_SESSION['logged'] = true;
        $this->saveCookie();
    }

    public function existsCookie(){
        if(isset($_COOKIE['UserData']))
            return true;
        else
            return false;
    }
    
    public function saveCookie(){
        setcookie("UserData[nomeCompleto]", $this->nomeCompleto, time()+60*60*24);
        setcookie("UserData[userid]", $this->userid, time()+60*60*24);
        setcookie("UserData[groupid]", $this->groupid, time()+60*60*24);
        setcookie("UserData[groupName]", $this->groupName, time()+60*60*24);
    }

    public function is_logged_in(){
        return isset($_SESSION['logged']);
    }

    public function destroy_session(){
        session_unset();
        session_destroy();
        setcookie("UserData[nomeCompleto]", $this->nomeCompleto, time() -3600);
        setcookie("UserData[userid]", $this->userid, time() -3600);
        setcookie("UserData[groupid]", $this->groupid, time() -3600);
        setcookie("UserData[groupName]", $this->groupName, time() - 3600);
    }
}
?>
