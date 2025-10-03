<?php 
    include "partials/header.php";
    include "partials/navigation.php";
?>
    <div class="container">
        <div class="hero">
            <div class="hero-content">
                <h1> Welcome to the PHP Login App </h1>
                <p> Securely login and manage your account with us</p> 
                <div class="hero-buttons">
                    <?php if(!isLoggedIn()): ?>
                        <a class="btn" href="login.php">Login</a>
                        <a class="btn" href="register.php">Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php 
    include "partials/footer.php"; 
    mysqli_close($conn);
?>
