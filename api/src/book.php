<?php

class Book implements JsonSerializable {       
    
    private $id;
    private $title;
    private $author;
    private $description;
    
    public function __construct() {
        $this->id = -1;
        $this->title = '';
        $this->author = '';
        $this->description = '';
    }
    
    
    public function getId() {   
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setAuthor($author) {
        $this->author = $author;
    }

    public function setDescription($description) {
        $this->description = $description;
    }
    
    public function create(mysqli $conn) {
        
    }
    
    public function update(mysqli $conn, $id) {
        
    }
    
    public static function loadFromDB(mysqli $conn, $id = null) {      // loadFromDB i deleteFromDB nie sa scisle powiazane z pojedynczym obiektem Book, dlatego sa statyczne
        //sprawdzamy czy chcemy pojedyncza ksiazke czy wszystkie
        if (!is_null($id)) {
            //pojedyncza ksiazka
            $result = $conn->query('SELECT * FROM Book WHERE id=' . intval($id));       // intval do zamieniania na liczebe, zeby zapobiec sqlinjection
        } else {
            //wszystkie ksiazki
            $result = $conn->query('SELECT * FROM Book');
        }
        
        $booksList = [];
        
        
        if($result && $result->num_rows > 0) {
            foreach ($result as $row) {
                $dbBook = new Book();
                $dbBook->id = $row['id'];
                $dbBook->author = $row['author'];
                $dbBook->title = $row['title'];
                $dbBook->description = $row['description'];
                
                $booksList[] = json_encode($dbBook);    //json_encode nie obsługuje obiektow w format json, należy zaimplementować interfejs JsonSerializable
            }
        }
        
        return $booksList;  //zawsze zwracamy tablice; dla pojedynczego elementu zwracana jest tablica jednoelementowa
    }
    
    public static function deleteFromDB(mysqli $conn, $id) {
        if ($id != null) {
            $result = $conn->query('DELETE * from Book WHERE id=' .intval($id));
        }
        
        if  ($result) {
            return true;
        } else {
            return false;
        }
    }
    
    public function jsonSerialize() {       // definiujemy metodę interfejsu JsonSerializable (zamiana obiektu na tablice)
        return [
            'id' => $this->id,
            'title'=> $this->title,
            'author' => $this->author,
            'description' => $this->description
        
        ];
    }
    
    
}
