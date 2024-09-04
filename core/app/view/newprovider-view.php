<div class="row">
    <div class="col-md-12">
        <h1>Nuevo Proveedor</h1>
        <br>
        <div class="card">
            <div class="card-header">
                NUEVO PROVEEDOR
            </div>
            <div class="card-body">
                <form class="row g-3" method="post" id="addprovider" action="index.php?view=addprovider" role="form">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Nombre*</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Nombre" required title="Ingresa tu nombre">
                    </div>

                    <div class="col-md-6">
                        <label for="lastname" class="form-label">Apellido*</label>
                        <input type="text" name="lastname" class="form-control" id="lastname" placeholder="Apellido" required title="Ingresa tu apellido">
                    </div>

                    <div class="col-md-6">
                        <label for="address1" class="form-label">Dirección*</label>
                        <input type="text" name="address1" class="form-control" id="address1" placeholder="Dirección" required title="Ingresa tu dirección">
                    </div>

                    <div class="col-md-6">
                        <label for="email1" class="form-label">Email*</label>
                        <input type="email" name="email1" class="form-control" id="email1" placeholder="Email" required pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" title="Ingresa un correo válido (formato: usuario@dominio.com)">
                    </div>

                    <div class="col-md-6">
                        <label for="phone1" class="form-label">Teléfono*</label>
                        <input type="number" name="phone1" class="form-control" id="phone1" placeholder="Teléfono" required pattern="[0-9]{8}" title="Ingresa un número de teléfono válido (8 dígitos)">
                    </div>

                    <div class="col-12">
                        <p class="alert alert-info">* Campos obligatorios</p>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Agregar Proveedor</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
