<?php

error_reporting( 0 );
//tutaj łączy się AJAX

$dir = dirname(__FILE__); //sciezka bezwzględna do /var/www/html/books


include($dir . '/src/db.php');
include($dir . '/src/book.php');

$conn = DB::connect();
//plik MUSI zwracać json'a
header('Conent-Type: application/json');

//sprawdzamy, jaką metodą request wysłano

if($_SERVER['REQUEST_METHOD']=='GET') {
    $data = $_GET;
    if(isset($_GET['id']) && intval($_GET['id'])>0) {
        //pojedyncza ksiazka
        $book = Book::loadFromDB($conn, $_GET['id']);
    }   else {
        $books = Book::loadFromDB($conn);
    }
    //books jest zawsze tablicą
    
    echo json_encode($books);
    
    
} elseif ($_SERVER ['REQUEST_METHOD']=='POST') {
    $data = $_POST;
} elseif ($_SERVER ['REQUEST_METHOD']=='PUT') {
    parse_str(file_get_contents("php://input"), $data);
} elseif ($_SERVER ['REQUEST_METHOD']=='DELETE') {
   parse_str(file_get_contents("php://input"), $data);
   
   $id = $data['id'];
    
    Book::deleteFromDB($conn, $id);
   
}