<?php 

/*
* PDO database class
* Connects to database
* Create prepared statements
* Binds values
* Returns rows and results
*/

class Database {
    private $host = DATABASE_HOST;
    private $user = DATABASE_USER;
    private $password = DATABASE_PASSWORD;
    private $name = DATABASE_NAME;

    private $database_handler;
    private $stmt;
    private $error;

    public function __construct() {
        // Set DSN
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->name;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        // Create PDO instance
        try {
            $this->database_handler = new PDO($dsn, $this->user, $this->password, $options);
        } catch (PDOException $error) {
            $this->error = $error->getMessage();
            echo $this->error;
        }
    }

    // Prepare statement with query
    public function query($sql) {
        $this->stmt = $this->database_handler->prepare($sql);
    }

    // Bind values
    public function bind($parameter, $value, $type = null) {
        if(is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
                    break;
            }
        }

        // $this->stmt->bindValue($parameter, $value, $type);
    }

    // Execute the prepared statement
    public function execute() {
        return $this->stmt->execute();
    }

    // Get result set as array of objects
    public function resultSet() {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Get single record as an object
    public function single() {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    // Get the row count
    public function rowCount() {
        return $this->stmt->rowCount();
    }
}