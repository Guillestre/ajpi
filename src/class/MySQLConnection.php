<?php

class MySQLConnection
{

  static $instance = null;

  private $connection = null;

  const USER = 'root';
  const HOST = 'localhost';
  const PASSWORD = '';
  const DATABASE = 'ajpi_dev';

  private function __construct()
  {
      $this->connection = new PDO(
        'mysql:dbname='.self::DATABASE.';host='.self::HOST,
        self::USER ,
        self::PASSWORD
      );
  }

  public static function getInstance()
  {  
    if(is_null(self::$instance))
    {
      self::$instance = new MySQLConnection();
    }
    return self::$instance;
  }

  public function getConnection()
  {
    return $this->connection;
  }

}


?>