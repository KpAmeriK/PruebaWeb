<?php
  session_start();

  require 'database.php';

  if (isset($_SESSION['user_id'])) {
    $records = $conn->prepare('SELECT id, email, password FROM users WHERE id = :id');
    $records->bindParam(':id', $_SESSION['user_id']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $user = null;

    if (count($results) > 0) {
      $user = $results;
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="assets/css/style.css">
<script src="push.min.js"></script>


    <title>PRUEBA</title>
</head>
<body>
    
<?php if(!empty($user)): ?>
      <br> Welcome. <?= $user['email']; ?>
      <br>Ha iniciado sesión correctamente
      <a href="logout.php" onClick="CerrarSesion()">
      Cerrar sesión
</a>
<?php else: ?>
      <h1>Inicie sesión o regístrese</h1>

      <a href="login.php">Iniciar sesión</a> o
      <a href="signup.php">Registrarse</a>
    <?php endif; ?>


<div>

<script>
  Push.create("AGENDANDO", {
    body: "Ha iniciado sesión correctamente",
    icon: 'log/logo192.png',
    timeout: 4000,
    onClick: function () {
        window.focus();
        this.close();
    }
});


function CerrarSesion() {
  Push.create("AGENDANDO", {
    body: "Cerraste sesion exitosamente",
    icon: 'log/logo192.png',
    timeout: 4000,
    onClick: function () {
        window.focus();
        this.close();
    }
});
  
}
</script>

</div>


</body>
</html>