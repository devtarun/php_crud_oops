<?php

class Post
{
    // DB Stuff
    private $conn;
    private $table = 'posts';

    //Post properties
    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $author;
    public $body;
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
                c.name as category_name,
                p.id,
                p.category_id,
                p.title,
                p.body,
                p.author,
                p.created_at
            FROM 
                $this->table p
            INNER JOIN 
                categories c on p.category_id=c.id
            ORDER BY 
                p.created_at DESC
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
                c.name as category_name,
                p.id,
                p.category_id,
                p.title,
                p.body,
                p.author,
                p.created_at
            FROM 
                $this->table p
            INNER JOIN 
                categories c on p.category_id=c.id
            WHERE
                p.id=?
            LIMIT 0,1
        ";

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        // BIND ID
        $stmt->bindParam(1, $this->id);

        //Execute
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->title = $row['title'];
        $this->body = $row['body'];
        $this->author = $row['author'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];
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
                title = :title,
                body = :body,
                author = :author,
                category_id = :category_id
        ";

        // PREPARE STMT
        $stmt = $this->conn->prepare($query);

        // print_r($stmt);
        // exit;

        // CLEAN DATA
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        // BIND DATA
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);

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
                title = :title,
                body = :body,
                author = :author,
                category_id = :category_id
            WHERE
                id=:id
        ";

        // PREPARE STMT
        $stmt = $this->conn->prepare($query);

        // print_r($stmt);
        // exit;

        // CLEAN DATA
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // BIND DATA
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);
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
