<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Configuración</h1>

            <?php
            $configurations = ConfigurationData::getAll();
            ?>

            <?php if(count($configurations) > 0): ?>
            <br>
            <div class="card">
                <div class="card-header">AJUSTES</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Clave</th>
                                    <th>Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($configurations as $conf): ?>
                                <tr>
                                    <td><?php echo $conf->name; ?></td>
                                    <td>
                                        <?php if($conf->kind == 1): // es boolean ?>
                                            <input type="checkbox" name="<?php echo $conf->short; ?>" <?php if($conf->val == "1"){ echo "checked"; } ?>>
                                        <?php elseif($conf->kind == 2): ?>
                                            <input type="text" class="form-control" name="<?php echo $conf->short; ?>" value="<?php echo $conf->val; ?>">
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
