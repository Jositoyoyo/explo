<h3>Busqueda de explotacion / Obra</h3>
<div class="card p-4" style="border: #192666 1px solid;background: #ccd9ff;">
    <form>
        <div class="form-row">
            <div class="form-group col-md-6">
                <select id="inputState" class="form-control">
                    <option selected>Tipo</option>
                    <option>...</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <input type="text" class="form-control" id="inputEmail4" placeholder="Nombre">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Buscar</button>
    </form>
</div>
<table class="table table-sm datanel">
    <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Empresa Explotadora</th>
            <th scope="col">Nombre de la Explotación</th>
            <th scope="col">Municipo</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($explotaciones): ?>
        <h3>Se han encontrado <?php echo count($explotaciones); ?> explotaciones</h3>
        <?php foreach ($explotaciones as $explotacion): ?>
            <tr>
                <th scope="row">
                    <?php echo $explotacion->id; ?>
                </th>
                <td>
                    <a href="<?php echo $app->urlFor('documetos-explotacion-detalles', array('id' => $explotacion->id)); ?>">
                        <?php echo $explotacion->nombre; ?>
                    </a>
                </td>
                <td>Otto</td>
                <td>
                    <?php echo $explotacion->nombre; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <th colspan="4">No hay resultados</th>
        </tr>
    <?php endif; ?>
</tbody>
</table>