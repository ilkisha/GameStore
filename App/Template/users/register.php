<h2>Register Form</h2>

<?php /** @var array $errors  */ ?>

<?php
if(count($errors) > 0){
    /**
     * @var \App\Data\ErrorDTO $error
     */
    foreach ($errors as $error){
        echo "<p style='color: red'>".$error->getMessage(). '</p>';
    }
}
?>

<form method="post">
    <label>
        Email: <input type="text" name="email"/> <br />
    </label>
    <label>
        Password: <input type="password" name="password"/> <br />
    </label>
    <label>
        Confirm Password: <input type="password" name="confirm_password"/> <br />
    </label>
    <label>
        Full Name: <input type="text" name="full_name"/><br />
    </label>
    <label>
    <input type="submit" name="register" value="Register"/> <br />

</form>

<a href="index.php">back</a>