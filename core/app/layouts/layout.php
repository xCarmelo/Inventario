<!DOCTYPE html>
<html lang="es">
<head>
  <title>Fiore di Carmelo</title>
    <base href="./">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simplebar/6.0.0/simplebar.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/themes/prism.css">
    <link rel="stylesheet" type="text/css" href="assets/bootstrap-icons/bootstrap-icons.css">
    <link href="assets/css/style.css" rel="stylesheet">  
    <link rel="stylesheet" href="assets/css/stylesj.css">
    <link rel="icon" type="image/jpg" href="assets/img/logo.jpg">
    <script type="text/javascript" src="assets/node_modules/jquery/dist/jquery.min.js"></script>
</head>
<body>
<!--Login -->
<?php if(!isset($_SESSION["user_id"])):?>
<div class="bg-light min-vh-100 d-flex flex-row align-items-center">
<div class="container">
<div class="row justify-content-center">
<div class="col-lg-6">
<div class="card-group d-block d-md-flex row">
<div class="card col-md-12 p-4 mb-0">
<div class="card-body">
<h1>Articulos Religiosos S. Agustin</h1>
<br>
<p class="text-medium-emphasis">Iniciar Sesion al Sistema</p>
<form method="post" action="./?action=processlogin">
<div class="input-group mb-3"><span class="input-group-text">
<svg class="icon">
</svg></span>
<input class="form-control" type="text" name="username" placeholder="Email">
</div>
<div class="input-group mb-4"><span class="input-group-text">
<svg class="icon">
</svg></span>
<input class="form-control" name="password" type="password" placeholder="Password">
</div>
<div class="row">
<div class="col-6">
<button class="btn btn-primary px-4" type="submit">Iniciar Sesion</button>
</div>
</div>
</form>
<br><br><br>
</div>
</div>
</div>
</div>
</div>
</div>

<!---------------------------------------------------------------------------------------------- -->

<?php else:?>
<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
<div class="sidebar-brand d-none d-md-flex">
<div class="sidebar-brand-full" width="118" height="46" alt="Logo">
<h4><a href="./" style="color: white; text-decoration: none;">Fiore di Carmelo</a> <button class="btn btn__menu" id="sidebarToggle"><i class="bi bi_menu bi__menu--active bi-list"></i></button></h4>
</div>
<div class="sidebar-brand-narrow" width="46" height="46" alt="Logo">
<h4><a href="./" style="color: white;">I<b>L</b></a></h4>
</div>
</div>

<h4 class="logo_menu"><a href="./" style="color: white; text-decoration: none;">Fiore di Carmelo</a> <button class="btn btn__menu" id="sidebarToggle"><i class="bi bi_menu bi__menu--active bi-list"></i></button></h4>
<ul class="sidebar-nav" data-simplebar>
    <li class="nav-item"><a class="nav-link" href="./">
        <i class="bi bi-house"></i> INICIO</a></li>
    <li class="nav-item"><a class="nav-link" href="./?view=sell">
        <i class="bi bi-cash"></i> VENDER</a>
    </li>
    <li class="nav-item"><a class="nav-link" href="./?view=sells">
        <i class="bi bi-cart"></i> VENTAS</a>
    </li>
    <li class="nav-item"><a class="nav-link" href="./?view=box">
        <i class="bi bi-box"></i> CAJA</a>
    </li>

    <li class="nav-item">
      <a class="nav-link nav-group-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#catalogos-submenu" aria-expanded="false" aria-controls="catalogos-submenu">
        <i class="bi bi-folder"></i> CATALOGOS
      </a>
      <ul class="nav-submenu collapse" id="catalogos-submenu">
        <li class="nav-subitem">
          <a class="nav-link" href="./?view=products">
            <i class="bi bi-box-seam"></i> PRODUCTOS
          </a>
        </li>
        <li class="nav-subitem">
          <a class="nav-link" href="./?view=categories">
            <i class="bi bi-tags"></i> CATEGORIAS
          </a>
        </li>
        <li class="nav-subitem">
          <a class="nav-link" href="./?view=clients">
            <i class="bi bi-people"></i> CLIENTES
          </a>
        </li>
        <li class="nav-subitem">
          <a class="nav-link" href="./?view=providers">
            <i class="bi bi-truck"></i> PROVEEDORES
          </a>
        </li>
      </ul>
    </li>
    
    <li class="nav-item">
      <a class="nav-link nav-group-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#inventario-submenu" aria-expanded="false" aria-controls="inventario-submenu">
        <i class="bi bi-boxes"></i> INVENTARIO
      </a>
      <ul class="nav-submenu collapse" id="inventario-submenu">
        <li class="nav-subitem">
          <a class="nav-link" href="./?view=inventary">
            <i class="bi bi-boxes"></i> INVENTARIO
          </a>
        </li>
        <li class="nav-subitem">
          <a class="nav-link" href="./?view=re">
            <i class="bi bi-bag"></i> HACER COMPRA
          </a>
        </li>
        <li class="nav-subitem">
          <a class="nav-link" href="./?view=res">
            <i class="bi bi-basket"></i> COMPRAS
          </a>
        </li>
      </ul>
    </li>

    <li class="nav-item">
      <a class="nav-link nav-group-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#reportes-submenu" aria-expanded="false" aria-controls="reportes-submenu">
        <i class="bi bi-clipboard-data"></i> REPORTES
      </a>
      <ul class="nav-submenu collapse" id="reportes-submenu">
        <li class="nav-subitem">
          <a class="nav-link" href="./?view=reports">
            <i class="bi bi-clipboard-data"></i> INVENTARIO
          </a>
        </li>
        <li class="nav-subitem">
          <a class="nav-link" href="./?view=sellreports">
            <i class="bi bi-graph-up"></i> VENTAS
          </a>
        </li>
      </ul>
    </li>

    <li class="nav-item">
      <a class="nav-link nav-group-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#administracion-submenu" aria-expanded="false" aria-controls="administracion-submenu">
        <i class="bi bi-gear"></i> ADMINISTRACION
      </a>
      <ul class="nav-submenu collapse" id="administracion-submenu">
        <li class="nav-subitem">
          <a class="nav-link" href="./?view=users&opt=all">
            <i class="bi bi-person"></i> USUARIOS
          </a>
        </li>
        <li class="nav-subitem">
          <a class="nav-link" href="./?view=settings&opt=all">
            <i class="bi bi-sliders"></i> AJUSTES
          </a>
        </li>
      </ul>
    </li>

  </ul>
  <div class="p-4" style="width: 100%; height: 30px; background: #303c54"></div>
</div>

<div class="wrapper d-flex flex-column min-vh-100 bg-light">
  <header class="header header-sticky mb-4">
    <div class="container-fluid">
        <button class="btn btn__menu" id="sidebarToggle"><i class="bi bi_menu bi-list"></i></button>
        <a class="header-brand d-md-none" href="#">
      </a>

        <div class="logaut">
        <a class="dropdown-item logaut__link" href="./logout.php">
          <i class="logaut__bi bi bi-box-arrow-right"></i> Logout
        </a>
        </div>
    </div>
  </header>
  <div class="body flex-grow-1 px-3">
    <div class="container-fluid">
      <?php View::load("index");?>
    </div>
  </div>
</div>

<?php endif; ?>

<!-- Necessary scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/simplebar/6.0.0/simplebar.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
<script>
$(document).ready(function() {
  $('.bi_menu').on('click', function(event) {
    $("#sidebar").toggleClass("sidebar__active");
    $(".content").toggleClass("content-full-width");
  });
});
</script>

</body>
</html>