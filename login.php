<?php
include_once "./includes/header.php";

// Show Registered Box
$registered = isset($_GET["registered"]) ? true : false;

if (isset($_POST["login-form"])) {
    $u_in = $_POST["username"];
    $p_in = $_POST["password"];

    require "./includes/dbConnect.php";

    $stmt = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($stmt, "SELECT user_id, email, username, password, isAdmin FROM users WHERE email = ? OR username = ?;")) {
        mysqli_stmt_bind_param($stmt, "ss", $u_in, $u_in);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_bind_result($stmt, $user_id, $email, $username, $password, $isAdmin);

        mysqli_stmt_fetch($stmt);

        mysqli_stmt_close($stmt);
    }

    require "./includes/dbDisconnect.php";

    // Verify Hash And User / Email
    $p_match = password_verify($p_in, $password);
    if (($u_in === $email || $u_in === $username) && $p_match) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION["isAdmin"] = $isAdmin === 1 ? true : false;
        $_SESSION["userId"] = $user_id;
        $_SESSION["cart"] = array();
        header("Location: index.php");
    } else {
        $error = array("message" => "Wrong Username Or Password!", "wrongUsername" => $u_in, "wrongPassword" => $p_in);
    }
}
?>
<main class="main-container">
    <h2 class="page-header">Login</h2>
    <form action="<?php $_SERVER["PHP_SELF"] ?>" method="POST" class="form-container mx-auto mb-4">
        <div class="form-group">
            <label for="username">Username / Email</label>
            <input value="<?php echo isset($error) ? $error["wrongUsername"] : '' ?>" id="username" name="username" type="text" class="form-control" placeholder="johndoe" required />
        </div>
        <div class="form-group mb-4">
            <label for="password">Password</label>
            <input value="<?php echo isset($error) ? $error["wrongPassword"] : '' ?>" id="password" name="password" type="password" class="form-control" placeholder="*********" required />
        </div>
        <button class="btn btn-block btn-site-main" name="login-form" type="submit">Login</button>
    </form>
    <?php
    echo $registered ? "<div class='alert alert-dark notice' role='alert'>Sign in with registered values</div>" : "";

    if (isset($error)) {
        echo "<div class='alert alert-danger notice' role='alert'>{$error['message']}</div>";
    }
    ?>
</main>

<?php
include_once "./includes/footer.php";
?>