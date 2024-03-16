<?php

namespace Config;

/**
 * PDO Database Class
 * Connects to the database, creates prepared statements, binds values,
 * and returns rows and results.
 */
class Database
{
    /**
     * @var \PDO The PDO object.
     */
    private $dbh;

    /**
     * @var \PDOStatement The PDOStatement object.
     */
    private $stmt;

    /**
     * @var string|null Holds any error messages.
     */
    private $error;
    /**
     * Constructor
     * Sets up the PDO connection using the environment variables found in the _.env_ file.
     */
    public function __construct()
    {
        $host = $_ENV['DB_HOST'];
        $user = $_ENV['DB_USERNAME'];
        $pass = $_ENV['DB_PASSWORD'];
        $dbname = $_ENV['DB_DATABASE'];

        // Set DSN
        $dsn = 'mysql:host=' . $host . ';dbname=' . $dbname;
        $options = array(
            \PDO::ATTR_PERSISTENT => true,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        );

        // Create PDO instance
        try {
            $this->dbh = new \PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    /**
     * Prepare statement with query
     *
     * @param string $sql The SQL query to prepare.
     */
    public function query($sql)
    {
        $this->stmt = $this->dbh->prepare($sql);
    }

    /**
     * Bind values to prepared statement using named parameters
     *
     * @param string $param The parameter name.
     * @param mixed $value The value to bind.
     * @param int|null $type The data type of the parameter.
     */
    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = \PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = \PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = \PDO::PARAM_NULL;
                    break;
                default:
                    $type = \PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    /**
     * Bind multiples values to prepared statement using named parameters
     *
     * @param array $params The array of names.
     * @param array $value The array of values to bind.
     * @param array|null $type The array containing the data type of the parameter.
     */
    public function bindMultipleParams($params, $values, $types = null)
    {
        array_map(function ($param, $value) {
            $this->bind($param, $value);
        }, $params, $values);
    }

    /**
     * Execute the prepared statement
     *
     * @return bool True if the execution is successful, false otherwise.
     */
    public function execute()
    {
        return $this->stmt->execute();
    }

    /**
     * Get result set as an array of associative arrays
     *
     * @return array The result set.
     */
    public function resultSet()
    {
        $this->execute();
        return $this->stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * Get the result of COUNT(*) as an integer
     *
     * @return int The count result.
     */
    public function fetchCount()
    {
        return (int) $this->stmt->fetchColumn();
    }

    /**
     * Get a single record as an object
     *
     * @return object The single record.
     */
    public function single()
    {
        $this->execute();
        return $this->stmt->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * Get the row count
     *
     * @return int The row count.
     */
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }

    /**
     * Get the ID of the last inserted record in a database table
     * 
     * This function retrieves the ID of the last inserted record in the database
     * using the lastInsertId method provided by the PDO database connection,
     * which is a predefined method in PHP.
     * 
     * @return int The ID of the last inserted record
     */
    public function lastInsertId()
    {
        // retun the last inserted ID
        return $this->dbh->lastInsertId();
    }
}
