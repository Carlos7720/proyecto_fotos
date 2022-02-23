<?php

class DBController
{

    private $host = "localhost";

    private $user = "root";

    private $password = "";

    private $database = "z_pizarra";

    private  $conn;

    function __construct()
    {
        $this->conn = mysqli_connect($this->host, $this->user, $this->password, $this->database);

        if (!$this->conn) {
    echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
    echo "errno de depuracion: " . mysqli_connect_errno() . PHP_EOL;
    echo "error de depuracion: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

//echo "Conexion" . PHP_EOL;
//echo "Información del host: " . mysqli_get_host_info($enlace) . PHP_EOL;

    }

    public static function getConnection()
    {
        if (empty($this->conn)) {
            new DBController();
        }
    }

    function getDBResult($query, $params = array())
    {
        $sql_statement = $this->conn->prepare($query);
        if (! empty($params)) {
            $this->bindParams($sql_statement, $params);
        }
        $sql_statement->execute();
        $result = $sql_statement->get_result();
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_array()) {
                $resultset[] = $row;
            }
        }
        
        if (! empty($resultset)) {
            return $resultset;
        }
    }

    function insertDB($query, $params = array())
    {
        $sql_statement = $this->conn->prepare($query);
        if (! empty($params)) {
            $this->bindParams($sql_statement, $params);
        }
        $sql_statement->execute();
        
        $id = mysqli_insert_id ( $this->conn );
        return $id;
    }
    
    function updateDB($query, $params = array())
    {
        $sql_statement = $this->conn->prepare($query);
        if (! empty($params)) {
            $this->bindParams($sql_statement, $params);
        }
        $sql_statement->execute();
    }

    function bindParams($sql_statement, $params)
    {
        $param_type = "";
        foreach ($params as $query_param) {
            $param_type .= $query_param["param_type"];
        }
        
        $bind_params[] = & $param_type;
        foreach ($params as $k => $query_param) {
            $bind_params[] = & $params[$k]["param_value"];
        }
        
        call_user_func_array(array(
            $sql_statement,
            'bind_param'
        ), $bind_params);
    }
}
