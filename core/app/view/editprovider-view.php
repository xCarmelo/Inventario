<?php $user = PersonData::getById($_GET["id"]); ?>
<div class="row">
    <div class="col-md-12">
        <h1>Editar Proveedor</h1>
        <br>
        <div class="card">
            <div class="card-header">
                EDITAR PROVEEDOR
            </div>
            <div class="card-body"> 
                <form class="row g-3" method="post" id="updateprovider" action="index.php?view=updateprovider" role="form">
                    <div class="col-md-6">4z<a
                        <label for="name" class="form-label">Nombre*</label>
                        <input type="text" name="name" value="<?php echo $user->name; ?>" class="form-control" id="name" placeholder="Nombre" required title="Por favor ingresa tu nombre">
                    </div>

                    <div class="col-md-6">
                        <label for="lastname" class="form-label">Apellido*</label>
                        <input type="text" name="lastname" value="<?php echo $user->lastname; ?>" class="form-control" id="lastname" placeholder="Apellido" required title="Por favor ingresa tu apellido">
                    </div>

                    <div class="col-md-6">
                        <label for="address1" class="form-label">Dirección*</label>
                        <input type="text" name="address1" value="<?php echo $user->address1; ?>" class="form-control" id="address1" placeholder="Dirección" required title="Por favor ingresa tu dirección">
                    </div>

                    <div class="col-md-6">
                        <label for="email1" class="form-label">Email*</label>
                        <input type="email" name="email1" value="<?php echo $user->email1; ?>" class="form-control" id="email1" placeholder="Email" required pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" title="Por favor ingresa un correo válido (formato: usuario@dominio.com)">
                    </div>

                    <div class="col-md-6">
                        <label for="phone1" class="form-label">Teléfono</label>
                        <input type="number" name="phone1" value="<?php echo $user->phone1; ?>" class="form-control" id="phone1" placeholder="Teléfono" pattern="[0-9]{8}" title="Ingresa un número de teléfono válido (8 dígitos)">
                    </div>

                    <div class="col-12">
                        <p class="alert alert-info">* Campos obligatorios</p>
                    </div>

                    <div class="col-12">
                        <input type="hidden" name="user_id" value="<?php echo $user->id; ?>">
                        <button type="submit" class="btn btn-primary">Actualizar Proveedor</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
