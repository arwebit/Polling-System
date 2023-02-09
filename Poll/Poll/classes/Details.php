<?php

class Details {

    protected $dbCon;

    public function __construct() {
        $this->dbCon = connect_db();
    }

    

}
