<?php 

class Connect{
    protected $connection; 

    public function __construct(){
        $host = 'localhost';
        $name = 'root';
        $password = '';
        $dbname = 'kinocinema';

        $this->connection = new mysqli($host, $name, $password, $dbname);
    }

    public function getConnection() {
        return $this->connection;
    }

    public function close(){
        $this->connection->close();
    }
}

?>