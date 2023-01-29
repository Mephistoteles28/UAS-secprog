<?php
if($_SERVER['REQUEST_METHOD' == "POST"]){
    $mysqli = new mysqli("localhost","my_user","my_password","my_db");
    // Sanitize the input
    //Dengan memakai 'real_escape_string' dibanding memakai 'strip_tags()' akan lebih aman karena sanitasi nya akan lebih luas dan lebih spesifik ke SQL special chars.
    $filter_query = $mysqli -> real_escape_string($_POST['query']);
    $filter_column = $mysqli -> real_escape_string($_POST['column']);

    // Validate input
    //Pada no 1a saya menjelaskan bahwa kemungkinan hal yang bisa di exploit pada code diatas yaitu '$filter_column'. Maka disini saya mencoba untuk me-validasi lagi agar inputan lebih aman.
    $valid_columns = array("id", "name", "price", "category");
    if (!in_array($filter_column, $valid_columns)) {
        die("Invalid column name provided");
    }

    $query = "SELECT * FROM products WHERE $filter_column = ?;";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("s", $filter_query);
    $stmt->execute();

    $result = $stmt->get_result();

}

?>