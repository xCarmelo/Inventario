<?php $user = UserData::getById($_GET["id"]); ?>
<div class="row">
    <div class="col-md-12">
        <h1>Editar Usuario</h1>
        <br>
        <div class="card">
            <div class="card-header text-white">
                Editar Usuario
            </div>
            <div class="card-body">
                <form class="row g-3" method="post" id="updateuser" action="index.php?view=updateuser" role="form">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Nombre*</label>
                        <input type="text" name="name" value="<?php echo $user->name; ?>" class="form-control" id="name" placeholder="Nombre" required>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="lastname" class="form-label">Apellido*</label>
                        <input type="text" name="lastname" value="<?php echo $user->lastname; ?>" class="form-control" id="lastname" placeholder="Apellido" required>
                    </div>

                    <div class="col-md-6">
                        <label for="username" class="form-label">Nombre de usuario*</label>
                        <input type="text" name="username" value="<?php echo $user->username; ?>" class="form-control" id="username" placeholder="Nombre de usuario" required>
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label">Email*</label>
                        <input type="email" name="email" value="<?php echo $user->email; ?>" class="form-control" id="email" placeholder="Email" required>
                    </div>

                    <div class="col-md-6">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Contraseña">
                        <div class="form-text">La contraseña solo se modificará si escribes algo, en caso contrario no se modifica.</div>
                    </div>

                    <div class="col-md-6">
                      <div class="row ms-4">
                          <div class="col-md-6">
                              <label for="is_active" class="form-label">¿Está activo?</label>
                              <div class="form-check">
                                  <input class="form-check-input" type="checkbox" name="is_active" id="is_active" <?php if($user->is_active){ echo "checked"; } ?>>
                                  <label class="form-check-label" for="is_active">Sí</label>
                              </div>
                          </div>

                          <div class="col-md-6">
                              <label for="is_admin" class="form-label">¿Es administrador?</label>
                              <div class="form-check">
                                  <input class="form-check-input" type="checkbox" name="is_admin" id="is_admin" <?php if($user->is_admin){ echo "checked"; } ?>>
                                  <label class="form-check-label" for="is_admin">Sí</label>
                              </div>
                          </div>
                      </div>
                    </div>


                    <div class="col-12">
                        <p class="alert alert-info">* Campos obligatorios</p>
                    </div>

                    <div class="col-12">
                        <input type="hidden" name="user_id" value="<?php echo $user->id; ?>">
                        <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
