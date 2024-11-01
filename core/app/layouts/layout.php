<!DOCTYPE html>
<html lang="es">
<head>
  <title>M. C. San Agustín</title>
    <base href="./">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" type="text/css" href="assets/node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simplebar/6.0.0/simplebar.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/themes/prism.css">
    <link href="assets/css/style.css" rel="stylesheet">  
    <link rel="stylesheet" href="assets/css/stylesj.css">
    <link rel="icon" type="image/jpg" href="assets/img/logoMC.jpg">
    <script type="text/javascript" src="assets/node_modules/jquery/dist/jquery.min.js"></script>
</head>
<body>
<!--Login -->
<?php if(!isset($_SESSION["user_id"])):?>
<div class="min-vh-100 d-flex flex-row align-items-center backgrount-img justify-content-center">
<div class="container login-container-margin">
<div class="row justify-content-center">
<div class="col-lg-6">
<div class="card-group d-block d-md-flex row">

<div class="card col-md-12 p-4 mb-0 card_login-container"> 
  <div class="card card_login-container">
    <div class="card-body login-background text-center">
      <!-- Imagen redonda y centrada -->
      <img src="assets/img/logoMC.jpg" alt="Logo" class="img-fluid rounded-circle mb-3 login-img">
      <br>
      <!-- Texto Login -->
      <p class="text-login h4 mb-4">Login</p>
      
      <!-- Formulario --> 
      <form method="post" class="form-login" action="./?action=processlogin">
          <div class="input-group mb-3">
              <span class="input-group-text">
                  <i class="bi-person-fill"></i>
              </span>
              <input value="<?php echo isset($_SESSION['form_data']['username']) ? $_SESSION['form_data']['username'] : ''; ?>" 
                  class="form-control <?php echo isset($_SESSION['errors']['username']) ? 'is-invalid' : ''; ?>" 
                  type="text" 
                  name="username" 
                  placeholder="Usuario" 
                  pattern="^[A-Za-z0-9_]{2,50}$" 
                  title="Ingresa un nombre de usuario válido de al menos 2 caracteres, sin acento" 
                  min="2" 
                  required>
              <div class="invalid-feedback">
                  <?php echo isset($_SESSION['errors']['username']) ? $_SESSION['errors']['username'] : ''; ?>
              </div>
          </div> 
          
          <div class="input-group mb-4">
              <span class="input-group-text">
                  <i class="bi-lock-fill"></i>
              </span>
              <input value="<?php echo isset($_SESSION['form_data']['password']) ? $_SESSION['form_data']['password'] : ''; ?>" 
                    class="form-control <?php echo isset($_SESSION['errors']['password']) ? 'is-invalid' : ''; ?>" 
                    name="password" 
                    type="password" 
                    placeholder="Contraseña" 
                    pattern="^(?=.*\d)[A-Za-z\d]{5,}$" 
                    title="La contraseña debe tener al menos 8 caracteres y contener al menos un número." 
                    min="5" 
                    required>
              <div class="invalid-feedback">
                  <?php echo isset($_SESSION['errors']['password']) ? $_SESSION['errors']['password'] : ''; ?>
              </div>
          </div>
          
          <div class="input-group mb-3">
              <button class="btn btn-primary form-control rounded" type="submit">Iniciar Sesión</button>
          </div>
      </form>

    </div>
  </div>
</div>



</div>
</div>
</div>

<!---------------------------------------------------------------------------------------------- -->

<?php else:?>
<div class="sidebar sidebar-fixed" id="sidebar">
<div class="sidebar-brand d-none d-md-flex">
<div class="sidebar-brand-full" width="118" height="46" alt="Logo">
<div class="d-flex align-items-center justify-content-center p-1"> 
    <img src="assets/img/logoMC.jpg" alt="" class="img-fluid rounded-circle me-4 logo-border" style="max-height: 100px;"> 
</div>
<h4>
<div class="d-flex justify-content-center align-items-center"> 
    <a href="./" style="color: white; text-decoration: none;" class="ms-2">M. C. San Agustín</a>
    <button class="btn btn__menu" id="sidebarToggle"><i class="bi bi_menu bi__menu--active bi-list"></i></button>
</div>
</h4>
</div>
<div class="sidebar-brand-narrow" width="46" height="46" alt="Logo">
</div>
</div>

<h4 class=" d-flex align-items-center logo_menu"> 
    <div class="me-auto logo_menu">  
        <img src="assets/img/logoMC.jpg" alt="" class="img-fluid rounded-circle logo-border" style="max-height: 70px;"> 
    </div>
    <button class="btn btn__menu logo_menu" id="sidebarToggle"><i class="bi bi_menu bi__menu--active bi-list icon-list"></i></button>
</h4>
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

        <?php if($_SESSION['is_admin'] === 1): ?> 
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
        <?php endif; ?>
      </ul>
    </li>

    <?php if ($_SESSION['is_admin'] === 1) { ?>
    
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
            <i class="bi bi-basket"></i>LISTA DE COMPRAS
          </a>
        </li>

        <li class="nav-subitem">
          <a class="nav-link" href="./?view=discard">
            <i class="bi bi-trash"></i> REALIZAR DESCARTE
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
            <i class="bi bi-clipboard-data"></i> MOVIMIENTOS 
          </a>
        </li>
        <?php } ?>

        <!--
        <li class="nav-subitem">
          <a class="nav-link" href="./?view=sellreports">
            <i class="bi bi-graph-up"></i> VENTAS
          </a>
        </li>
        -->
        <?php if ($_SESSION['is_admin'] === 1) { ?>
        <li class="nav-subitem">
          <a class="nav-link" href="./?view=discardreports">
            <i class="bi bi-file-earmark-excel"></i> DESCARTES 
          </a>
        </li>
        <?php } ?>
      </ul>
    </li>
    <?php if($_SESSION['is_admin'] === 1): ?>
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
    <?php endif; ?>
      </ul>
    </li>

  </ul>
  <div class="p-4" style="width: 100%; height: 30px; background: #0C1C26"></div>
</div>

<div class="wrapper d-flex flex-column min-vh-100 bg-light">
  <header class="header header-sticky mb-4">
    <div class="container-fluid">
        <button class="btn btn__menu" id="sidebarToggle"><i class="bi bi_menu bi-list"></i></button>
        <a class="header-brand d-md-none" href="#">
      </a>

      <div class="logout d-flex align-items-center justify-content-center">
        <div class="dropdown-item logout__link d-flex align-items-center me-3">
          <span class="ms-2"><?php echo $_SESSION['username']; ?></span>
          <i class="logaut__bi bi bi-person"></i>
        </div>
        <a class="dropdown-item logout__link" href="./logout.php">
          <i class="logaut__bi bi bi-box-arrow-right"></i>
        </a>
      </div>  
  </header>
  <div class="body flex-grow-1 px-3">
    <div class="container-fluid">
      <?php View::load("index");?>
    </div>
  </div>
</div>

<?php endif; ?>

<!-- Modal de error -->
<?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])) : ?>
    <div class="modal fade show" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"> 
                <div class="modal-header"> 
                    <h5 class="modal-title" id="errorModalLabel">
                        <i class="bi bi-exclamation-circle text-danger"></i> Error
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>  
                <div class="modal-body">
                    El usuario o la contraseña son incorrectos. Por favor, inténtalo de nuevo.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Necessary scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/simplebar/6.0.0/simplebar.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
<script>
$(document).ready(function(){
  $('.nav-group-toggle').on('click', function(){
    // Cierra cualquier submenú abierto
    $('.nav-submenu').collapse('hide');
    // Abre el submenú relacionado con el enlace clicado si no está abierto
    if (!$(this).next('.nav-submenu').hasClass('show')) {
      $(this).next('.nav-submenu').collapse('show');
    }
  });

  $('.bi_menu').on('click', function(event) {
    $("#sidebar").toggleClass("sidebar__active");
    $(".content").toggleClass("content-full-width");
  });

   // Mostrar el modal de error si está presente
    $('#errorModal').modal('show');

         // Si existe un parámetro 'result' en la URL, eliminar solo ese parámetro
    const url = new URL(window.location.href);
        if (url.searchParams.get('result')) {
            url.searchParams.delete('result'); // Eliminar solo el parámetro 'result'

            // Actualizar la URL sin recargar la página, manteniendo otros parámetros como 'view'
            window.history.replaceState({}, document.title, url.pathname + "?" + url.searchParams.toString());
        }
});
</script>

<?php
// Limpiar los errores y los datos de sesión después de usarlos
unset($_SESSION['errors']);
unset($_SESSION['form_data']);
?>


</body>
</html>