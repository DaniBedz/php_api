<?php
class Post
{
    // DB Stuff
    private $_connection;
    private $_table = 'posts';

    // Post Properties
    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $body;
    public $author;
    public $created_at;

    /**
     * Constructor with DB
     *
     * @param object $database //
     * **/
    public function __construct($database)
    {
        $this->_connection = $database;
    }

    /**
     * Get All Posts
     *
     * @return object $statement
     * **/
    public function read()
    {
        // Create Query
        $query = "SELECT
            c.name as category_name,
            p.id,
            p.category_id,
            p.title,
            p.body,
            p.author,
            p.created_at
        FROM
            $this->_table p
        LEFT JOIN
            categories c ON p.category_id = c.id
        ORDER BY
            p.created_at DESC";

        // Prepare Statement
        $statement = $this->_connection->prepare($query);

        // Execute/Return Query
        $statement->execute();
        return $statement;
    }

    /**
     * Get Single Post
     *
     * @return void
     * **/
    public function readSingle()
    {
        // Create Query
        $query = "SELECT
            c.name as category_name,
            p.id,
            p.category_id,
            p.title,
            p.body,
            p.author,
            p.created_at
        FROM
            $this->_table p
        LEFT JOIN
            categories c ON p.category_id = c.id
        WHERE p.id = ?
        LIMIT 0,1";

        // Prepare Statement
        $statement = $this->_connection->prepare($query);

        // Bind ID
        $statement->bindParam(1, $this->id);

        // Execute/Return Query
        $statement->execute();

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        // Set Properties
        $this-> title = $row['title'];
        $this-> body = $row['body'];
        $this-> author = $row['author'];
        $this-> category_id = $row['category_id'];
        $this-> category_name = $row['category_name'];
    }

    /**
     * Create Post
     *
     * @return boolean
     * **/
    public function create()
    {
        // Create Query
        $query = "INSERT INTO $this->_table
                    SET
                        title = :title,
                        body = :body,
                        author = :author,
                        category_id = :category_id";
        // Prepare Statement
        $statement = $this->_connection->prepare($query);

        // Clean Data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        // Bind Data
        $statement->bindParam(':title', $this->title);
        $statement->bindParam(':body', $this->body);
        $statement->bindParam(':author', $this->author);
        $statement->bindParam(':category_id', $this->category_id);

        // Execute Query
        if ($statement->execute()) {
            return true;
        }
        // Print error if something goes wrong
        printf("Error: %s. \n", $statement->error);
        return false;
    }

    /**
     * Update Post
     *
     * @return boolean
     * **/
    public function update()
    {
        // Create Query
        $query = "UPDATE $this->_table
                    SET
                        title = :title,
                        body = :body,
                        author = :author,
                        category_id = :category_id
                    WHERE id = :id";

        // Prepare Statement
        $statement = $this->_connection->prepare($query);

        // Clean Data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind Data
        $statement->bindParam(':title', $this->title);
        $statement->bindParam(':body', $this->body);
        $statement->bindParam(':author', $this->author);
        $statement->bindParam(':category_id', $this->category_id);
        $statement->bindParam(':id', $this->id);

        // Execute Query
        if ($statement->execute()) {
            return true;
        }
        // Print error if something goes wrong
        printf("Error: %s. \n", $statement->error);
        return false;
    }

    /**
     * Delete Post
     *
     * @return boolean
     * **/
    public function delete()
    {
        // Create Query
        $query = "DELETE FROM $this->_table
                    WHERE id = :id";

        // Prepare Statement
        $statement = $this->_connection->prepare($query);

        // Clean Data
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind Data
        $statement->bindParam(':id', $this->id);

        // Execute Query
        if ($statement->execute()) {
            return true;
        }
        // Print error if something goes wrong
        printf("Error: %s. \n", $statement->error);
        return false;
    }
}