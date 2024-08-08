<div class="row">
	<div class="col-md-12">
	<h1>Nuevo Cliente</h1>
	<br>
<div class="card">
  <div class="card-header">
    NUEVO CLIENTE
  </div>
    <div class="card-body">

		<form class="form-horizontal" method="post" id="addproduct" action="index.php?view=addclient" role="form">

    <div class="col-md-4">
        <label for="validationCustom01" class="form-label">Nombre*</label>
        <input type="text" name="name" class="form-control" id="validationCustom01" placeholder="Nombre" pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+" title="Ingresa un nombre válido (solo letras y espacios)" required>
        <div class="valid-feedback">
            ¡Se ve bien!
        </div>
    </div>
    <div class="col-md-4">
        <label for="validationCustom02" class="form-label">Apellido*</label>
        <input type="text" name="lastname" class="form-control" id="validationCustom02" placeholder="Apellido" pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+" title="Ingresa un apellido válido (solo letras y espacios)" required>
        <div class="valid-feedback">
            ¡Se ve bien!
        </div>
    </div>
    <div class="col-md-4">
        <label for="validationCustom03" class="form-label">Dirección*</label>
        <input type="text" name="address1" class="form-control" id="validationCustom03" placeholder="Dirección" required>
        <div class="valid-feedback">
            ¡Se ve bien!
        </div>
    </div>
    <div class="col-md-4">
        <label for="validationCustom04" class="form-label">Email*</label>
        <input type="email" name="email1" class="form-control" id="validationCustom04" placeholder="Email" required>
        <div class="valid-feedback">
            ¡Se ve bien!
        </div>
    </div>
    <div class="col-md-4">
        <label for="validationCustom05" class="form-label">Teléfono*</label>
        <input type="number" name="phone1" class="form-control" id="validationCustom05" placeholder="Teléfono" pattern="[0-9]{8}" title="Ingresa un número de teléfono válido (8 dígitos)">
        <div class="valid-feedback">
            ¡Se ve bien!
        </div>
    </div>


  <p class="alert alert-info">* Campos obligatorios</p>

  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
      <button type="submit" class="btn btn-primary">Agregar Cliente</button>
    </div>
  </div>
</form>
    </div>
</div>

	</div>
</div>