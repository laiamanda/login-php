<?php 
    include "partials/header.php";
    include "partials/navigation.php";

    $error = "";

    if(isLoggedIn()) {
        header("Location: admin.php");
    }

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve user's input
        $username = mysqli_real_escape_string($conn, $_POST["username"]);
        $email = mysqli_real_escape_string($conn, $_POST["email"]);
        $password = mysqli_real_escape_string($conn, $_POST["password"]);
        $confirm_password = mysqli_real_escape_string($conn, $_POST["confirm_password"]);

        // Check if the password is the exact same as confirm password
        if ($password !== $confirm_password){
            $error = "Passwords do not match.";
        } else { 
            // Check if user exists
            if(userExists($conn, $username)){
                // Display error
                $error = "Username already exists. Please choose another";
            } else {
                // Insert the data into the database
                if( checkQuery(createUser($conn, $username, $email, $password))) {
                    // Set session values
                    $_SESSION['logged_in'] = true;
                    $_SESSION['username'] = $username;
                    // Redirect to admin.php
                    redirect("admin.php");
                    exit;
                } else {
                    // If unable to insert, then display error
                    echo "Unable to insert data. " . mysqli_error($conn);
                }
            }         
        }
    }    

?>
<div class="container">
    <div class="form-container">
        <form method="POST" action="">
            <h2> Create your account </h2>
            <?php if($error): ?>
                <p style="color:red"> 
                    <?php echo $error ?>
                </p>
            <?php endif; ?>
            <label for="username">Username:</label>
            <input value="<?php echo isset($username) ? $username : '' ?>" placeholder="Enter your username" type="text" name="username" required> 

            <label for="email">Email:</label>
            <input value="<?php echo isset($email) ? $email : '' ?>" placeholder="Enter your email" type="email" name="email" required>

            <label for="password">Password:</label>
            <input placeholder="Enter your password" type="password" name="password" required>

            <label for="confirm_password">Confirm Password:</label>
            <input placeholder="Confirm your password" type="password" name="confirm_password" required>

            <input type="submit" value="Register">
        </form>
    </div>
</div>
   
<?php 
    include "partials/footer.php" 
?>
<?php 
    mysqli_close($conn);
?>