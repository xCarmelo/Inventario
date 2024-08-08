<?php $user = PersonData::getById($_GET["id"]);?>
<div class="row">
	<div class="col-md-12">
	<h1>Editar Proveedor</h1>
	<br>

  <div class="card">
  <div class="card-header">
    EDITAR PROVEEDOR
  </div>
    <div class="card-body">


		<form class="form-horizontal" method="post" id="addproduct" action="index.php?view=updateprovider" role="form">
  <div class="form-group">
    <label for="name" class="col-lg-2 control-label">Nombre*</label>
    <div class="col-md-6">
      <input type="text" name="name" value="<?php echo $user->name;?>" class="form-control" id="name" placeholder="Nombre" required
             title="Por favor ingresa tu nombre">
    </div>
  </div>
  <div class="form-group">
    <label for="lastname" class="col-lg-2 control-label">Apellido*</label>
    <div class="col-md-6">
      <input type="text" name="lastname" value="<?php echo $user->lastname;?>" required class="form-control" id="lastname" placeholder="Apellido" required
             title="Por favor ingresa tu apellido">
    </div>
  </div>
  <div class="form-group">
    <label for="address1" class="col-lg-2 control-label">Dirección*</label>
    <div class="col-md-6">
      <input type="text" name="address1" value="<?php echo $user->address1;?>" class="form-control" required id="username" placeholder="Dirección" required
             title="Por favor ingresa tu dirección">
    </div>
  </div>
  <div class="form-group">
    <label for="email1" class="col-lg-2 control-label">Email*</label>
    <div class="col-md-6">
      <input type="text" name="email1" value="<?php echo $user->email1;?>" class="form-control" id="email" placeholder="Email"
             pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}"
             title="Por favor ingresa un correo válido (formato: usuario@dominio.com)">
    </div>
  </div>
  <div class="form-group">
    <label for="phone1" class="col-lg-2 control-label">Teléfono</label>
    <div class="col-md-6">
      <input type="number" name="phone1" value="<?php echo $user->phone1;?>" class="form-control" id="inputEmail1" placeholder="Teléfono"
      pattern="[0-9]{8}" title="Ingresa un número de teléfono válido (8 dígitos)">
    </div>
  </div>
  <p class="alert alert-info">* Campos obligatorios</p>
  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
      <input type="hidden" name="user_id" value="<?php echo $user->id;?>">
      <button type="submit" class="btn btn-primary">Actualizar Proveedor</button>
    </div>
  </div>
</form>

	</div>
</div>    
</div>
</div>
