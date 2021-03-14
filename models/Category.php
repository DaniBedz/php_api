<?php
class Category
{
    // DB Stuff
    private $_connection;
    private $_table = 'categories';

    // Category Properties
    public $id;
    public $name;
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
     * Get All Categories
     *
     * @return object $statement
     * **/
    public function read()
    {
        // Create Query
        $query = "SELECT
            id,
            name,
            created_at
        FROM
            $this->_table
        ORDER BY
            created_at DESC";

        // Prepare Statement
        $statement = $this->_connection->prepare($query);

        // Execute/Return Query
        $statement->execute();

        return $statement;
    }

    /**
     * Get Single Category
     *
     * @return void
     * **/
    public function readSingle()
    {
        // Create Query
        $query = "SELECT
            id,
            name,
            created_at
        FROM
            $this->_table
        WHERE id = ?
        LIMIT 0,1";

        // Prepare Statement
        $statement = $this->_connection->prepare($query);

        // Bind ID
        $statement->bindParam(1, $this->id);

        // Execute/Return Query
        $statement->execute();

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        // Set Properties
        $this->id = $row['id'];
        $this->name = $row['name'];
    }

    /**
     * Create Category
     *
     * @return boolean
     * **/
    public function create()
    {
        // Create Query
        $query = "INSERT INTO $this->_table
                    SET
                        name = :name";

        // Prepare Statement
        $statement = $this->_connection->prepare($query);

        // Clean Data
        $this->name = htmlspecialchars(strip_tags($this->name));

        // Bind Data
        $statement->bindParam(':name', $this->name);

        // Execute Query
        if ($statement->execute()) {
            return true;
        }
        // Print error if something goes wrong
        printf("Error: %s. \n", $statement->error);
        return false;
    }

    /**
     * Update Category
     *
     * @return boolean
     * **/
    public function update()
    {
        // Create Query
        $query = "UPDATE $this->_table
                    SET
                        name = :name
                    WHERE id = :id";

        // Prepare Statement
        $statement = $this->_connection->prepare($query);

        // Clean Data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->name = htmlspecialchars(strip_tags($this->name));

        // Bind Data
        $statement->bindParam(':id', $this->id);
        $statement->bindParam(':name', $this->name);

        // Execute Query
        if ($statement->execute()) {
            return true;
        }
        // Print error if something goes wrong
        printf("Error: %s. \n", $statement->error);
        return false;
    }

    /**
     * Delete Category
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
