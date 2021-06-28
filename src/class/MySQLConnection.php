<?php

/**
 * SINGLETON CLASS THAT ALLOW CONNECTION TO MYSQL DATABASE
 * */

class MySQLConnection
{

  static $instance = null;

  private $connection = null;

  //Username
  const USER = 'root';

  //Host
  const HOST = 'localhost';

  //Password
  const PASSWORD = 'root';

  //Database
  const DATABASE = 'ajpi_dev';

  /**
   * Construct
   * */

  private function __construct()
  {
      $this->connection = new PDO(
        'mysql:dbname='.self::DATABASE.';host='.self::HOST,
        self::USER ,
        self::PASSWORD
      );
  }

  /**
   * Get database instance
   * 
   * @return instance
   * */

  public static function getInstance()
  {  
    if(is_null(self::$instance))
    {
      self::$instance = new MySQLConnection();
    }
    return self::$instance;
  }

  /**
   * Get database connection
   * 
   * @return connection
   * */

  public function getConnection()
  {
    return $this->connection;
  }

}


?>