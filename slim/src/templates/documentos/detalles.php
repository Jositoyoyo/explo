<h3>
    <u>
        <?php echo $explotacion->nombre; ?>
    </u>
</h3>
<div class="card">
    <div class="card-body">
        <div class="content">
            <div class="col-md-6">
                <h3 class="card-title">Datos principales</h3>
                <p class="card-text"><b>Paraje : </b><?php echo $explotacion->paraje; ?></p>
            </div>
            <div class="col-md-6">
                <p class="card-text"><b>Municipio : </b><?php echo $explotacion->municipio; ?></p>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="content">
            <div class="col-md-6">
                <h3 class="card-title">Datos principales</h3>
                <p class="card-text"><b>Paraje : </b><?php echo $explotacion->paraje; ?></p>
            </div>
            <div class="col-md-6">
                <p class="card-text"><b>Municipio : </b><?php echo $explotacion->municipio; ?></p>
            </div>
        </div>
    </div>
</div>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<?php var_dump($explotacion); ?>
<?php var_dump($consumo); ?>