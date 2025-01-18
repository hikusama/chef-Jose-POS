<?php

class Connection {
  private $host = 'db';
  private $user = 'chefjose';
  private $pass = 'chefjose4545';
  private $dbname = 'chef_jose_db'; 
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

