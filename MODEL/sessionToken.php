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
        $query = "SELECT * FROM $this->table_name INNER JOIN user ON session_token.user = user.id WHERE session_token.token = $token";
        $stmt = $this->conn->query($query);
        return $stmt;
    }

    public function createToken($user, $token)
    {
        $query = "INSERT INTO $this->table_name (`token`, `expiry`, `user`) VALUES ($token, '2023-01-01 20:08:17', $user); "
        $stmt = $this->conn->query($query);
        return $stmt;
    }
}
?>