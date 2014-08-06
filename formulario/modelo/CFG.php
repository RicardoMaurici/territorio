<?php

class CFG{
    
    private $moodleTablePrefix;
    private $moodleCursoID;
    private $tablePrefix;
    private $DB;
    
    public function getMoodleTablePrefix() {
        return $this->moodleTablePrefix;
    }

    public function setMoodleTablePrefix($moodleTablePrefix) {
        $this->moodleTablePrefix = $moodleTablePrefix;
    }

    public function getMoodleCursoID() {
        return $this->moodleCursoID;
    }

    public function setMoodleCursoID($moodleCursoID) {
        $this->moodleCursoID = $moodleCursoID;
    }

    public function getTablePrefix() {
        return $this->tablePrefix;
    }

    public function setTablePrefix($tablePrefix) {
        $this->tablePrefix = $tablePrefix;
    }

    public function getDB() {
        return $this->DB;
    }

    public function setDB($DB) {
        $this->DB = $DB;        
    }
    
}


?>
