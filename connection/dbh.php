<?php

class Connection {
  private $host = 'localhost';
  private $user = 'root';
  private $pass = '';
  private $dbname = 'chef_jose_db2'; // Correct the database name

  protected function connect() {
      try {
          $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbname;
          $pdo = new PDO($dsn, $this->user, $this->pass);
          $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
          $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          return $pdo;
      } catch (PDOException $e) {
          throw new PDOException($e->getMessage());
      }
  }
}
