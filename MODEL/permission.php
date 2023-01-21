<?php
class Permission{
    protected $conn;
    protected $table_name = 'permission';
    protected $middle_table_name = 'user_permission';

    public $permission;
    
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getPermissionByUserID($id) // Ottiene la ricreazione che ha l'id passato alla funzione   
    {
        $query = "SELECT up.permission FROM $this->table_name p INNER JOIN $this->middle_table_name up ON p.id = up.permission WHERE up.user = $id";
        echo($query);
        $stmt = $this->conn->query($query);

        return $stmt;
    }
}
?>
