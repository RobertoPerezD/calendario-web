<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
  
    <link rel="stylesheet" href="../public/css/login.css">
</head>
<body>
  <link rel="stylesheet" href="../public/css/style.css">
  <link rel="stylesheet" href="../public/css/login.css">
  <h1 class="title-calendar">Calendario Web</h1>
  <form method="post" id="frmLogin">
      <div class="row-calendar">
          <label for="username">Usuario</label>
          <input id="username" type="email" name="username" autocomplete="off" placeholder="email@example.com">
      </div>
      <div class="row-calendar">
          <label for="password">Password</label>
          <input id="password" type="password" name="password">
      </div>
      <button type="submit">Iniciar sesión</button>
  </form>
</body>

<?php 
  require '../includes/footer.php';
?>
<script src="../scripts/login.js"></script>