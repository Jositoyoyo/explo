<table class="datanel" width="100%">
    <?php if ($explotaciones): ?>
        <select name="plantilla">
            <?php while ($dit->valid()): ?>
                <?php if (!$dit->isDot()): ?>
                    <option value="<?php echo $dit->getFilename(); ?>"><?php echo $dit->getFilename(); ?><?php echo $dit->getExtension() ?></option>
                <?php endif; ?>
                <?php $dit->next(); ?>
            <?php endwhile; ?>
            <?php unset($dit); ?>
        </select>
        <thead id="tthead">
            <tr>
                <td>
                    <b>id</b>
                </td>
                <td>
                    <b>Empresa Explotadora</b>
                </td>
                <td>
                    <b>Nombre Explotación</b>
                </td>
                <td>
                    <b>Municipio</b>
                </td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($explotaciones as $explotacion): ?>
                <tr>
                    <td width="35%">
                        <a href="edit_explotaciones.php?pk=281" style="text-decoration: none;">
                            <?php echo $explotacion->id; ?>
                        </a>
                    </td>
                    <td width="35%">
                        <a href="edit_explotaciones.php?pk=281" style="text-decoration: none;">
                            <?php echo $explotacion->nombre; ?>
                        </a>
                    </td>
                    <td width="30%">
                        <a href="edit_explotaciones.php?pk=281" style="text-decoration: none;">
                            <?php echo $explotacion->paraje; ?>
                        </a>
                    </td>
                    <td width="35%"><a href="edit_explotaciones.php?pk=281">
                            <?php echo $explotacion->municipio; ?>
                        </a>
                    </td>
                    <td>
                        <a>Generar Documento</a>
                    </td>
                </tr>
            <?php endforeach; ?>

        </tbody>
    <?php else: ?>
        <tr>
            <td>No hay resultados</td>
        </tr>
    <?php endif; ?>
</table>

