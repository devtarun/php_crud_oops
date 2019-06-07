<?php

class Category
{
    // DB STUFF
    private $conn;
    private $table = 'categories';

    // PROPERTIES
    public $id;
    public $name;
    public $created_at;

    //Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * read
     *
     * @return void
     */
    public function read()
    {
        //Query
        $query = "
            SELECT 
                id,
                name
            FROM 
                $this->table
            ORDER BY 
                created_at DESC
        ";

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Execute
        $stmt->execute();

        return $stmt;
    }

    /**
     * read_single
     *
     * @return void
     */
    public function read_single()
    {
        //Query
        $query = "
            SELECT 
                id,
                name
            FROM 
                $this->table
            WHERE
                id=?
            LIMIT 0,1
        ";

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        // BIND ID
        $stmt->bindParam(1, $this->id);

        //Execute
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->id = $row['id'];
        $this->name = $row['name'];
    }

    /**
     * create
     *
     * @return void
     */
    public function create()
    {
        // QUERY
        $query = "
            INSERT INTO $this->table
            SET
                name = :name
        ";

        // PREPARE STMT
        $stmt = $this->conn->prepare($query);

        // print_r($stmt);
        // exit;

        // CLEAN DATA
        $this->name = htmlspecialchars(strip_tags($this->name));

        // BIND DATA
        $stmt->bindParam(':name', $this->name);

        // EXECUTE
        if ($stmt->execute()) {
            return true;
        }

        // PRINT ERROR IF ANY
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    /**
     * update
     *
     * @return void
     */
    public function update()
    {
        // QUERY
        $query = "
            UPDATE $this->table
            SET
                name = :name
            WHERE
                id=:id
        ";

        // PREPARE STMT
        $stmt = $this->conn->prepare($query);

        // print_r($stmt);
        // exit;

        // CLEAN DATA
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // BIND DATA
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':id', $this->id);

        // EXECUTE
        if ($stmt->execute()) {
            return true;
        }

        // PRINT ERROR IF ANY
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    /**
     * delete
     *
     * @return void
     */
    public function delete()
    {
        // QUERY
        $query = "
            DELETE FROM $this->table
            WHERE
                id=:id
        ";

        // PREPARE STMT
        $stmt = $this->conn->prepare($query);

        // print_r($stmt);
        // exit;

        // CLEAN DATA
        $this->id = htmlspecialchars(strip_tags($this->id));

        // BIND DATA
        $stmt->bindParam(':id', $this->id);

        // EXECUTE
        if ($stmt->execute()) {
            return true;
        }

        // PRINT ERROR IF ANY
        printf("Error: %s.\n", $stmt->error);
        return false;
    }
}
