    <div class="row">
        <div class="col-md-12">
            <h1>Agregar Usuario</h1>
            <br>
            <div class="card">
                <div class="card-header text-white">Usuarios</div>
                <div class="card-body">
                    <form class="row g-3" method="post" id="adduser" action="index.php?view=adduser" role="form">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Nombre*</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Nombre" required>
                        </div>
                        <div class="col-md-6"> 
                            <label for="lastname" class="form-label">Apellido*</label>
                            <input type="text" name="lastname" class="form-control" id="lastname" placeholder="Apellido" required>
                        </div>
                        <div class="col-md-6">
                            <label for="username" class="form-label">Nombre de usuario*</label>
                            <input type="text" name="username" class="form-control" id="username" placeholder="Nombre de usuario" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email*</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="Email" required>
                        </div>
                        <div class="col-md-6">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" name="password" class="form-control" id="password" placeholder="Contraseña">
                        </div>
                        <div class="col-md-6">
                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" name="is_admin" id="is_admin">
                                <label class="form-check-label" for="is_admin">
                                    Es administrador
                                </label>
                            </div>
                        </div>
                        <div class="col-12">
                            <p class="alert alert-info">* Campos obligatorios</p>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Agregar Usuario</button>
                        </div>
                        <div class="col-12">
                            <div id="message-container"></div> 
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div id="message-container"></div> </div>