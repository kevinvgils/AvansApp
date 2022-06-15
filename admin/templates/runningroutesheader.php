<header>
  <div class="wrap">
    <a href="index.php">
      <img src="../img/Logo.png" alt="Logo">
    </a>
    <h2>
        <?php echo (getRouteById($_GET["id"])[0]->routeName)?>
    </h2>
  </div>
</header>