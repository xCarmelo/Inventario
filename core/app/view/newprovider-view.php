<div class="row">
	<div class="col-md-12">
	<h1>Nuevo Proveedor</h1>
	<br>
<div class="card">
  <div class="card-header">
    NUEVO PROVEEDOR
  </div>
    <div class="card-body">

    <form class="form-horizontal" method="post" id="addproduct" action="index.php?view=addprovider" role="form">
  <div class="form-group">
    <label for="name" class="col-lg-2 control-label">Nombre*</label>
    <div class="col-md-6">
      <input type="text" name="name" class="form-control" id="name" placeholder="Nombre" required
             title="Ingresa tu nombre">
    </div>
  </div>
  <div class="form-group">
    <label for="lastname" class="col-lg-2 control-label">Apellido*</label>
    <div class="col-md-6">
      <input type="text" name="lastname" class="form-control" id="lastname" placeholder="Apellido" required
             title="Ingresa tu apellido">
    </div>
  </div>
  <div class="form-group">
    <label for="address1" class="col-lg-2 control-label">Dirección*</label>
    <div class="col-md-6">
      <input type="text" name="address1" class="form-control" id="address1" placeholder="Dirección" required
             title="Ingresa tu dirección">
    </div>
  </div>
  <div class="form-group">
    <label for="email1" class="col-lg-2 control-label">Email*</label>
    <div class="col-md-6">
      <input type="email" name="email1" class="form-control" id="email1" placeholder="Email" required
             pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}"
             title="Ingresa un correo válido (formato: usuario@dominio.com)">
    </div>
  </div>
  <div class="form-group">
    <label for="phone1" class="col-lg-2 control-label">Teléfono*</label>
    <div class="col-md-6">
      <input type="number" name="phone1" class="form-control" id="phone1" placeholder="Teléfono" required
      pattern="[0-9]{8}" title="Ingresa un número de teléfono válido (8 dígitos)">
    </div>
  </div>
  <p class="alert alert-info">* Campos obligatorios</p>
  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
      <button type="submit" class="btn btn-primary">Agregar Proveedor</button>
    </div>
  </div>
</form>


	</div>
</div>    
</div>
</div>
