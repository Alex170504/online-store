<?php
class DBConnect {
    private $servername;
    private $username;
    private $password;
    private $dbname;

    public function __construct() {
        $this->servername = "localhost"; // 数据库主机
        $this->username = "root"; // 数据库用户名
        $this->password = ""; // 数据库密码
        $this->dbname = "online_store"; // 数据库名称
    }

    public function connectdb() {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }
}
?>
