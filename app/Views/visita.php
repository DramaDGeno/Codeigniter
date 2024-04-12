<?= $this->extend("layout/master") ?>

<?= $this->section("content") ?>

<!-- Main content -->
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-10 mt-2">
              <h3 class="card-title">Visita</h3>
            </div>
            <div class="col-2">
              <button type="button" class="btn float-right btn-success" onclick="save()" title="<?= lang("Agregar nuevo") ?>"> <i class="fa fa-plus"></i>   <?= lang('Agregar nuevo') ?></button>
            </div>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="data_table" class="table table-bordered table-striped">
            <thead>
              <tr>
              <th>Id visita</th>
<th>Nombre de la mascota</th>
<th>Nombre del médico</th>
<th>Fecha de la visita</th>
<th>Tipo de servicio</th>
<th>Descripción del servicio</th>

			  <th></th>
              </tr>
            </thead>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

<!-- /Main content -->

<!-- ADD modal content -->
<div id="data-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md">
    <div class="modal-content">
      <div class="text-center bg-info p-3" id="model-header">
        <h4 class="modal-title text-white" id="info-header-modalLabel"></h4>
      </div>
      <div class="modal-body">
        <form id="data-form" class="pl-3 pr-3">
          <div class="row">
<input type="hidden" id="id_visita" name="id_visita" class="form-control" placeholder="Id visita" maxlength="20" required>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group mb-3">
									<label for="id_mascota" class="col-form-label"> Nombre de la mascota: <span class="text-danger">*</span> </label>		
                  <select id="id_mascota" name="id_mascota" class="form-control" required>
                 <?php foreach ($mascotas as $mascota): ?>
                     <option value="<?= $mascota->id_mascota ?>"><?= $mascota->nombre ?></option>
                 <?php endforeach; ?>
                 </select>
                </div>
							</div>
							<div class="col-md-12">
								<div class="form-group mb-3">
									<label for="id_medico" class="col-form-label"> Nombre del médico: <span class="text-danger">*</span> </label>
									<select id="id_medico" name="id_medico" class="form-control" required>
                  <?php foreach ($medicos as $medico): ?>
                     <option value="<?= $medico->id_medico ?>"><?= $medico->nombre_completo ?></option>
                 <?php endforeach; ?>
                 </select>
                </div>
							</div>
              <div class="col-md-12">
								<div class="form-group mb-3">
									<label for="fecha_visita" class="col-form-label"> Fecha de la visita: <span class="text-danger">*</span> </label>
									<input type="date" id="fecha_visita" name="fecha_visita" class="form-control" dateISO="true" required>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group mb-3">
									<label for="tipo_servicio" class="col-form-label"> Tipo de servicio: <span class="text-danger">*</span> </label>
									<input type="text" id="tipo_servicio" name="tipo_servicio" class="form-control" placeholder="Tipo de servicio" minlength="1"  maxlength="50" required>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group mb-3">
									<label for="descripcion_servicio" class="col-form-label"> Descripción del servicio: <span class="text-danger">*</span> </label>
									<input type="text" id="descripcion_servicio" name="descripcion_servicio" class="form-control" placeholder="Descripción del servicio" minlength="1"  maxlength="50" required>
								</div>
							</div>
						</div>

          <div class="form-group text-center">
            <div class="btn-group">
              <button type="submit" class="btn btn-success mr-2" id="form-btn"><?= lang("Guardar") ?></button>
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><?= lang("Cancelar") ?></button>
            </div>
          </div>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
<!-- /ADD modal content -->



<?= $this->endSection() ?>
<!-- /.content -->


<!-- page script -->
<?= $this->section("pageScript") ?>
<script>
  // dataTables
  $(function() {
    var table = $('#data_table').removeAttr('width').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "scrollY": '45vh',
      "scrollX": true,
      "scrollCollapse": false,
      "responsive": false,
      "ajax": {
        "url": '<?php echo base_url("/public/visita/getAll") ?>',
        "type": "POST",
        "dataType": "json",
        async: "true"
      }
    });
  });

  var urlController = '';
  var submitText = '';

  function getUrl() {
    return urlController;
  }

  function getSubmitText() {
    return submitText;
  }

  function save(id_visita) {
    // reset the form 
    $("#data-form")[0].reset();
    $(".form-control").removeClass('is-invalid').removeClass('is-valid');
    if (typeof id_visita === 'undefined' || id_visita < 1) { //add
      urlController = '<?= base_url("/public/visita/add") ?>';
      submitText = '<?= lang("Guardar") ?>';
      $('#model-header').removeClass('bg-info').addClass('bg-success');
      $("#info-header-modalLabel").text('<?= lang("Agregar nuevo") ?>');
      $("#form-btn").text(submitText);
      $('#data-modal').modal('show');
    } else { //edit
      urlController = '<?= base_url("/public/visita/edit") ?>';
      submitText = '<?= lang("Modificar") ?>';
      $.ajax({
        url: '<?php echo base_url("/public/visita/getOne") ?>',
        type: 'post',
        data: {
          id_visita: id_visita
        },
        dataType: 'json',
        success: function(response) {
          $('#model-header').removeClass('bg-success').addClass('bg-info');
          $("#info-header-modalLabel").text('<?= lang("Modificar") ?>');
          $("#form-btn").text(submitText);
          $('#data-modal').modal('show');
          //insert data to form
          			$("#data-form #id_visita").val(response.id_visita);
			$("#data-form #id_mascota").val(response.id_mascota);
			$("#data-form #id_medico").val(response.id_medico);
			$("#data-form #fecha_visita").val(response.fecha_visita);
			$("#data-form #tipo_servicio").val(response.tipo_servicio);
			$("#data-form #descripcion_servicio").val(response.descripcion_servicio);

        }
      });
    }
    $.validator.setDefaults({
      highlight: function(element) {
        $(element).addClass('is-invalid').removeClass('is-valid');
      },
      unhighlight: function(element) {
        $(element).removeClass('is-invalid').addClass('is-valid');
      },
      errorElement: 'div ',
      errorClass: 'invalid-feedback',
      errorPlacement: function(error, element) {
        if (element.parent('.input-group').length) {
          error.insertAfter(element.parent());
        } else if ($(element).is('.select')) {
          element.next().after(error);
        } else if (element.hasClass('select2')) {
          //error.insertAfter(element);
          error.insertAfter(element.next());
        } else if (element.hasClass('selectpicker')) {
          error.insertAfter(element.next());
        } else {
          error.insertAfter(element);
        }
      },
      submitHandler: function(form) {
        var form = $('#data-form');
        $(".text-danger").remove();
        $.ajax({
          // fixBug get url from global function only
          // get global variable is bug!
          url: getUrl(),
          type: 'post',
          data: form.serialize(),
          cache: false,
          dataType: 'json',
          beforeSend: function() {
            $('#form-btn').html('<i class="fa fa-spinner fa-spin"></i>');
          },
          success: function(response) {
            if (response.success === true) {
              Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: response.messages,
                showConfirmButton: false,
                timer: 1500
              }).then(function() {
                $('#data_table').DataTable().ajax.reload(null, false).draw(false);
                $('#data-modal').modal('hide');
              })
            } else {
              if (response.messages instanceof Object) {
                $.each(response.messages, function(index, value) {
                  var ele = $("#" + index);
                  ele.closest('.form-control')
                    .removeClass('is-invalid')
                    .removeClass('is-valid')
                    .addClass(value.length > 0 ? 'is-invalid' : 'is-valid');
                  ele.after('<div class="invalid-feedback">' + response.messages[index] + '</div>');
                });
              } else {
                Swal.fire({
                  toast: false,
                  position: 'bottom-end',
                  icon: 'error',
                  title: response.messages,
                  showConfirmButton: false,
                  timer: 3000
                })

              }
            }
            $('#form-btn').html(getSubmitText());
          }
        });
        return false;
      }
    });

    $('#data-form').validate({

      //insert data-form to database

    });
  }



  function remove(id_visita) {
    Swal.fire({
      title: "<?= lang("Estás a punto de eliminar una cita") ?>",
      text: "<?= lang("¿Continuar?") ?>",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '<?= lang("Confirmar") ?>',
      cancelButtonText: '<?= lang("Cancelar") ?>'
    }).then((result) => {

      if (result.value) {
        $.ajax({
          url: '<?php echo base_url("/public/visita/remove") ?>',
          type: 'post',
          data: {
            id_visita : id_visita
          },
          dataType: 'json',
          success: function(response) {

            if (response.success === true) {
              Swal.fire({
                toast:true,
                position: 'top-end',
                icon: 'success',
                title: response.messages,
                showConfirmButton: false,
                timer: 1500
              }).then(function() {
                $('#data_table').DataTable().ajax.reload(null, false).draw(false);
              })
            } else {
              Swal.fire({
                toast:false,
                position: 'bottom-end',
                icon: 'error',
                title: response.messages,
                showConfirmButton: false,
                timer: 3000
              })
            }
          }
        });
      }
    })
  }
</script>


<?= $this->endSection() ?>
