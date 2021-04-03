<?php

  session_start();

  if (isset($_SESSION['user_id'])) {
    header('Location: /login');
  }
  require 'database.php';

  if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $records = $conn->prepare('SELECT id, email, password FROM users WHERE email = :email');
    $records->bindParam(':email', $_POST['email']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $message = '';

    if (count($results) > 0 && password_verify($_POST['password'], $results['password'])) {
      $_SESSION['user_id'] = $results['id'];
      header("Location: /login/SesionIniciada.php");
    } else {

      //$message = 'Sorry, those credentials do not match';
      $message = '<script>
      Push.create("AGENDANDO", {
        body: "La cuenta no existe o esta mal la contraseña",
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
    <title>Inicio de sesión</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="push.min.js"></script>

  </head>
  <body>
    <?php require 'partials/header.php' ?>

    <?php if(!empty($message)): ?>
      <p> <?= $message ?></p>
    <?php endif; ?>

    <h1>Inicio de sesión</h1>
    <span>o <a href="signup.php">Registro</a></span>

    <form action="login.php" method="POST">
      <input name="email" type="text" placeholder="Enter your email">
      <input name="password" type="password" placeholder="Enter your Password">
      <input type="submit" value="Submit">
    </form>
  </body>
</html>
