<?php
    //to connect to database
    // $host = 'localhost';
    // $dbName = 'contact_manager';
    // $port = '3307'; 
    // $user = 'root';
    // $userPassword = '';

    // $dsn = "mysql:host=$host;dbname=$dbName;port=$port";
    // $dbConnection = new PDO($dsn,$user,$userPassword);
    // $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    class dbConnection{
        private $host = 'localhost';
        private $dbName = 'contact_manager';
        private $port = '3307';
        private $user = 'root';
        private $userPassword = '';
        public $dbConnection;
        
        public function __construct() {
            $dsn = "mysql:host=$this->host;dbname=$this->dbName;port=$this->port";
            $this->dbConnection = new PDO($dsn, $this->user, $this->userPassword);
            $this->dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
        }

        public function getConnection() {
            return $this->dbConnection;
        }
    }

?>