<?php
    // Check if the user is logged in
    function isLoggedIn() {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }
    // Redirect to location.php
    function redirect($location) {
        header("Location: login.php");
        exit;
    }

    // Set a class to have active for css
    function setActiveClass($pageName) {
        $current_page = basename($_SERVER['PHP_SELF']);
        return ($current_page === $pageName) ? "active" : '';
    }

    // Set a dynamic class for any pages
    function getPageClass(){
        return basename($_SERVER['PHP_SELF'], ".php");
    }


    // Make the date readable
    function fullMonthDate($date) {
        return date("F j", strtotime($date));
    }
?>