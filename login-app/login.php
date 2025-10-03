<?php 
    include "partials/header.php";
    include "partials/navigation.php";

    if(isLoggedIn()) {
        header("Location: admin.php");
    }

    $error = "";   

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve user's input
        $username = mysqli_real_escape_string($conn, $_POST["username"]);
        $password = mysqli_real_escape_string($conn, $_POST["password"]);

        $sql = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
        $result = mysqli_query($conn, $sql);
        // If result returns a num row equal to 1, then the username already exists
        if(mysqli_num_rows($result) === 1){
            // If return a result, then a user is found
            $user = mysqli_fetch_assoc($result);
            // Verify if the un-hashed db password to the user's input password
            if(password_verify($password, $user['password'])) {
                // Set session values
                $_SESSION['logged_in'] = true;
                $_SESSION['username'] = $user['username'];
                // Redirect to admin.php
                redirect("admin.php");
                exit;
            } else {
                $error = "Invalid password";
            }
        } else {
            $error = "User not found";
        }   
    }

?>
<div class="container">
    <div class="form-container">
        <form method="POST" action="">
            <h2> Login </h2>
            <?php if($error): ?>
                <p style="color:red"> 
                    <?php echo $error ?>
                </p>
            <?php endif; ?>
            <label for="username">Username:</label>
            <input placeholder="Enter your username" type="text" name="username" required> <br><br>

            <label for="password">Password:</label>
            <input placeholder="Enter your password" type="password" name="password" required><br><br>

            <input type="submit" value="Login">
        </form>
    </div>
</div>
   

<?php 
    include "partials/footer.php" 
?>

<?php 
    mysqli_close($conn);
?>