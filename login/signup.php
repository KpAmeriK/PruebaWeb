<?php

  require 'database.php';

  $message = '';

  if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $stmt->bindParam(':password', $password);

    if ($stmt->execute()) {
      //$message = 'Successfully created new user';
      $message = '<script>
      Push.create("AGENDANDO", {
        body: "Se a Registrado Correctamente ",
        icon: "log/logo192.png",
        timeout: 4000,
        onClick: function () {
            window.focus();
            this.close();
        }
    });
    </script>';

    } else {
      //$message = 'Sorry there must have been an issue creating your account';
      $message = '<script>
      Push.create("AGENDANDO", {
        body: "Error al Registrar",
        icon: "log/logo192.png",
        timeout: 4000,
        onClick: function () {
            window.focus();
            this.close();
        }
    });
    </script>';
    }
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Registrarse</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="push.min.js"></script>

  </head>
  <body>

    <?php require 'partials/header.php' ?>

    <?php if(!empty($message)): ?>
      <p> <?= $message ?></p>
    <?php endif; ?>

    <h1>Registrarse</h1>
    <span>o <a href="login.php">Inicio de sesión</a></span>

    <form action="signup.php" method="POST">
      <input name="email" type="text" placeholder="Enter your email">
      <input name="password" type="password" placeholder="Enter your Password">
      <input name="confirm_password" type="password" placeholder="Confirm Password">
      <input type="submit" value="Submit">
    </form>

  </body>
</html>
