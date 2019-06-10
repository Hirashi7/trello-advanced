<?php


class DbConnection implements DbConnectionInterface
{
    /**
     * @return PDO
     */
    private function _connect(): PDO
    {
      $mysql_host = 'localhost';
      $port = '3306';
      $username = 'root';
      $password = '';
      $database = '';
      
        try{
            $pdo = new PDO('mysql:host='.$mysql_host.';dbname='.$database.';port='.$port,
                $username,
                $password,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            echo "Połączenie nieudane: {$e->getMessage()}";
            die();
        }
        return $pdo;
    }

    /**
     * @param string $command
     * @param string $class_name
     * @return array|bool
     */
    function select(string $command, $class_name = 'stdClass')
    {
        $db = $this->_connect();

        $query = $db->prepare($command);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_CLASS, $class_name);

        if ($query === false) {
            return false;
        }

        return $result;
    }

    /**
     * @param string $command
     * @return bool
     */
    function insert(string $command)
    {
        $db = $this->_connect();
        $query = $db->prepare($command);
        $query->execute();
        return true;
    }

    /**
     * @param string $command
     * @return bool
     */
    function update(string $command)
    {
        $db = $this->_connect();
        $query = $db->prepare($command);
        $result = $query->execute();
        return $result;
    }

    /**
     * @param string $command
     * @return bool
     */
    function delete(string $command)
    {
        $db = $this->_connect();
        $query = $db->prepare($command);
        $result = $query->execute();
        return $result;
    }
}