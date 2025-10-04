<?php 
    $host = "";
    $username = "";
    $password = "";
    $database = "login_app";

    $conn = mysqli_connect($host, $username, $password, $database);
    // Check if able to connect to mySQL DB
    if ( !$conn ) {
        die("Connection failed". mysqli_connect_error());
    } else {
        // echo "Connected";
    };
    // Validates the SQL Query
    function checkQuery($result) {
        global $conn;
        if(!$result) {
            return "Error". mysqli_error($conn);
        }
        return true;
    }

    // Check if the username already exists by using the query
    function userExists($conn, $username) {
        $sql = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
        $result = mysqli_query($conn, $sql);
        // return result returns a num row greater than 0, then the username already exists
        return mysqli_num_rows($result) > 0;
    }

    // Create a User
    function createUser($conn, $username, $email, $password) {
        // Hash the password using an algorithm
        $passwordHash = password_hash($password, PASSWORD_DEFAULT); 
        $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$passwordHash', '$email')";
        return mysqli_query($conn, $sql);
    }

    // Update SQL query
    function updateUser($conn, $user_id, $new_username, $new_email) {
        $sql = "UPDATE users SET email = '$new_email', username ='$new_username' WHERE id = $user_id";
        return mysqli_query($conn, $sql);
    }
    // Delete SQL Query
    function deleteUser($conn, $user_id) {
        $sql = "DELETE FROM users WHERE id = $user_id";
        return mysqli_query($conn, $sql);
    }

?>
