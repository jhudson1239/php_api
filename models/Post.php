<?php
    class POST {
        //DB stuff
        private $conn;
        private $table = "posts";

        //propertise
        public $id;
        public $category_id;
        public $category_name;
        public $title;
        public $body;
        public $author;
        public $created_at;

        //Constructor with DB
        public function __construct($db){
            $this->conn = $db;
        }

        //Get Posts
        public function read(){
            //Create query
            $query = 'SELECT 
                c.name as category_name,
                p.id,
                p.category_id,
                p.title,
                p.body,
                p.author,
                p.created_at
            FROM
                ' . $this->table . ' p
                LEFT JOIN
                categories c ON p.category_id = c.id
            ORDER BY
                p.created_at DESC';

            //Create Prepared Statement
            $stmt = $this->conn->prepare($query);

            //Exacute query
            $stmt->execute();

            return $stmt;
        }

        //Get Sinlge Post

        public function read_single(){
            $query = 'SELECT 
                c.name as category_name,
                p.id,
                p.category_id,
                p.title,
                p.body,
                p.author,
                p.created_at
            FROM
                ' . $this->table . ' p
            LEFT JOIN
                categories c ON p.category_id = c.id
            WHERE
                p.id = ? 
            LIMIT 
                0,1';

            // Prepare statment
            $stmt = $this->conn->prepare($query);

            //Bind Id
            $stmt->bindParam(1, $this->id);

            //Execute
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            //Set propertise
            $this->title = $row['title'];
            $this->body = $row['body'];
            $this->author = $row['author'];
            $this->category_id = $row['category_id'];
            $this->category_name = $row['category_name'];
        }
    }
