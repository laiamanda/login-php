<?php 
    include "partials/header.php";
    include "partials/navigation.php";

    // Check if the user is logged in
    if(!isLoggedIn()) {
        redirect("login.php");
    }

    // Load all of the data from the users
    $result = mysqli_query($conn, "SELECT id, username, email, reg_date FROM users");

    // If Request Method is Post
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        // Edit User Info Post Method
        if(isset($_POST['edit_user'])) {
            // Retrieve user's input
            $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
            $new_username = mysqli_real_escape_string($conn, $_POST['username']);
            $new_email = mysqli_real_escape_string($conn, $_POST['email']);
            
            // Check if Query is valid
            $query_status = checkQuery(updateUser($conn, $user_id, $new_username, $new_email));
            if($query_status === true) {
                $_SESSION['message'] = "User updated successfully to $new_username";
                $_SESSION['msg_type'] = "success";
                redirect("admin.php");
            }
        } elseif(isset($_POST['delete_user'])) { // Delete User Post Method
            $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
            // Check if Query is valid
            $query_status = checkQuery(deleteUser($conn, $user_id));
            if($query_status === true) {
                $_SESSION['message'] = "User deleted successfully record with Id: $user_id ";
                $_SESSION['msg_type'] = "success";
                redirect("admin.php");
            }
        }
    }

?>
<!-- <div class="container">
    <h2> Welcome to Admin <?php // echo $_SESSION['username']; ?> </h2>
</div> -->

<h1>Manage Users</h1>
<div class="container">
    <?php if(isset($_SESSION['message'])) : ?>
        <div class="notification <?php echo $_SESSION['msg_type']; ?>">
            <?php 
                echo $_SESSION['message'];
                unset($_SESSION['message']);
                unset($_SESSION['msg_type']);
            ?>
        </div>
    <?php endif; ?>
    <table class="user-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Registration Date</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>

        <?php 
            while($user = mysqli_fetch_assoc($result)):  ?>
                <tr>
                    <td> <?php echo $user['id'] ?> </td>
                    <td> <?php echo $user['username'] ?> </td>
                    <td> <?php echo $user['email'] ?> </td>
                    <td> <?php echo fullMonthDate($user['reg_date']); ?> </td>
                    <td>
                        <form method="POST" style="display:inline-block;">
                            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                            <input type="text" name="username" value="<?php echo $user['username']; ?>" required>
                            <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
                            <button class="edit" type="submit" name="edit_user">Edit</button>
                        </form>
                        <form method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this user?');">
                            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                            <button class="delete" type="submit" name="delete_user">Delete</button>
                        </form>
                    </td>
                </tr>
           <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php 
    include "partials/footer.php" 
?>