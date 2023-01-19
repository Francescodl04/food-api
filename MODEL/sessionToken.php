<?php
class SessionToken
{
    protected $conn;
    protected $table_name = "session_token";

    public function __construct($connection)
    {
        $this->conn = $connection;
    }

    public function getUserByToken($token)
    {
        $query = "SELECT  FROM $this->table_name st 
        INNER JOIN `user` u 
        ON st.`user` = u.id
        WHERE st.token = '$token'";
        $stmt = $this->conn->query($query);
        return $stmt;
    }

    public function createToken($user, $token, $expiry)
    {
        $query = "INSERT INTO $this->table_name (token, `user`, expiry) VALUES (\"token\", $user, \"$expiry\");";
        $stmt = $this->conn->query($query);
        return $stmt;
    }
}
?>