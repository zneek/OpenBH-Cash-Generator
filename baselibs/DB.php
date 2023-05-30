<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class DBLayer {
    private $connection;
    private $user = '';
    private $pass = '';
    private $host = 'localhost';
    private $name = '';

    private $noerror;

    function  __construct() {
        $this->user = OpenBHConf::get('dbuser');
        $this->pass = OpenBHConf::get('dbpass');
        $this->name = OpenBHConf::get('dbname');
        
        $this->connection = new mysqli($this->host,$this->user,$this->pass,$this->name);
        if ($this->connection->connect_error) {
            die('Connect Error:' . $this->connection->connect_errno . ' : '.$this->connection->connect_error);
        }
    }

    function SelectDatabase($dbName) {
        $this->connection->select_db($dbName);
    }

    function StartSession() {
        $this->noerror = true;
    }

    function GrabMod() {

    }

    function Insert($query) {
        if($this->connection->query($query)!==false) {
            return $this->connection->insert_id;
        }
        return false;
    }

    function QueryAndReturn($query,$both=true) {
        $result = $this->connection->query($query);
        $resultArray = array();
        if($result->num_rows==0) {
            return false;
        }
        if($both) {
            while($row = $result->fetch_array(MYSQLI_BOTH)) {
                array_push($resultArray,$row);
            }
            return $resultArray;
        }
        
        while($row = $result->fetch_array(MYSQLI_ASSOC)) {
            array_push($resultArray,$row);
        }
        return $resultArray;
        // return $this->connection->query($query) ? null : $this->noerror = false;
    }

    function Exists($query) {
        /* select and check for rows */
        $this->connection->query($query);
        if($this->connection->affected_rows>=1) {
            return true;
        }
        return false;
    }

    function Query($query) {
        if($this->connection->query($query)!==false) {
            return true;
        }
        $this->noerror = false;
        return false;
    }

    function EndSession($accept) {
        $accept ? $this->connection->commit() : $this->connection->rollback();
    }

    function __destruct() {
        $this->connection->close();
    }
}

?>