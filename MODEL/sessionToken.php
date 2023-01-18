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
        $query = "INSERT INTO $this->table_name (user, token) VALUES (?, ?)"
        $stmt = $this->conn->prepare($query);

        $stmt->bind_param('is', $user, $token);
        $stmt->execute();
        return $stmt;
    }
}
?>