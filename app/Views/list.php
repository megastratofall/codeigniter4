<!DOCTYPE html>
<html lang="en">

<head>
    <title>CI4 CRUD</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

    <style type="text/css">
        * {
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            text-align: right;
        }

        h2 {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container"><br /><br />
        <div class="row">
            <div class="col-lg-10">
                <h2>LIBRERIA</h2>
            </div>
            <div class="col-lg-2">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                    Agregar nuevo libro
                </button>
            </div>
        </div>
        <!-- TABLA LIBROS-->

        <table class="table table-bordered table-striped" id="libroTable">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Nombre</th>
                    <th>Autor</th>
                    <th>Fecha de edicion</th>
                    <th width="280px">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($libros_detail as $row) {
                ?>
                    <tr id="<?php echo $row['id']; ?>">
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['nombre']; ?></td>
                        <td><?php echo $row['autor']; ?></td>
                        <td><?php echo $row['fecha_de_edicion']; ?></td>
                        <td>
                            <a data-id="<?php echo $row['id']; ?>" class="btn btn-primary btnEdit">Editar</a>
                            <a data-id="<?php echo $row['id']; ?>" class="btn btn-danger btnDelete">Eliminar</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>

        <!--MODAL AGREGAR NUEVO LIBRO -->

        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalLabel">INSERTAR NUEVO LIBRO</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="addLibro" name="addLibro" action="<?php echo site_url('libro/store'); ?>" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="txtNombre">Nombre</label>
                                <input type="text" class="form-control" id="txtNombre" placeholder="Ingrese nombre" name="txtNombre">
                            </div>
                            <div class="form-group">
                                <label for="txtAutor">Autor</label>
                                <input type="text" class="form-control" id="txtAutor" placeholder="Ingrese autor" name="txtAutor">
                            </div>
                            <div class="form-group">
                                <label for="txtFecha">Fecha de edicion</label>
                                <input type="date" class="form-control" id="txtFecha" name="txtFecha"></input>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Agregar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--MODAL EDITAR/BORRAR -->

        <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalLabel">EDITAR LIBRO</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="updateLibro" name="updateLibro" action="<?php echo site_url('libro/update'); ?>" method="post">
                        <div class="modal-body">
                            <input type="hidden" name="hdnLibroId" id="hdnLibroId" />
                            <div class="form-group">
                                <label for="txtNombre">Nombre</label>
                                <input type="text" class="form-control" id="txtNombre" placeholder="Inserte nombre" name="txtNombre">
                            </div>
                            <div class="form-group">
                                <label for="txtAutor">Autor</label>
                                <input type="text" class="form-control" id="txtAutor" placeholder="Inserte autor" name="txtAutor">
                            </div>
                            <div class="form-group">
                                <label for="txtFecha">Fecha de edicion</label>
                                <input type="date" class="form-control" id="txtFecha" name="txtFecha"></input>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Editar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $('#libroTable').DataTable();

                $("#addLibro").validate({
                    rules: {
                        txtNombre: "required",
                        txtAutor: "required",
                        txtFecha: "required"
                    },
                    messages: {},

                    submitHandler: function(form) {
                        var form_action = $("#addLibro").attr("action");
                        $.ajax({
                            data: $('#addLibro').serialize(),
                            url: form_action,
                            type: "POST",
                            dataType: 'json',
                            success: function(res) {
                                var libro = '<tr id="' + res.data.id + '">';
                                libro += '<td>' + res.data.id + '</td>';
                                libro += '<td>' + res.data.nombre + '</td>';
                                libro += '<td>' + res.data.autor + '</td>';
                                libro += '<td>' + res.data.fecha_de_edicion + '</td>';
                                libro += '<td><a data-id="' + res.data.id + '" class="btn btn-primary btnEdit">Editar</a>  <a data-id="' + res.data.id + '" class="btn btn-danger btnDelete">Eliminar</a></td>';
                                libro += '</tr>';
                                $('#libroTable tbody').append(libro);
                                $('#addLibro')[0].reset();
                                $('#addModal').modal('hide');
                            },
                            error: function(data) {}
                        });
                    }
                });

                $('body').on('click', '.btnEdit', function() {
                    var libro_id = $(this).attr('data-id');
                    $.ajax({
                        url: 'libro/edit/' + libro_id,
                        type: "GET",
                        dataType: 'json',
                        success: function(res) {
                            $('#updateModal').modal('show');
                            $('#updateLibro #hdnLibroId').val(res.data.id);
                            $('#updateLibro #txtNombre').val(res.data.nombre);
                            $('#updateLibro #txtLastName').val(res.data.autor);
                            $('#updateLibro #txtAddress').val(res.data.fecha_de_edicion);
                        },
                        error: function(data) {}
                    });
                });

                $("#updateLibro").validate({
                    rules: {
                        txtNombre: "required",
                        txtAutor: "required",
                        txtFecha: "required"
                    },
                    messages: {},
                    submitHandler: function(form) {
                        var form_action = $("#updateLibro").attr("action");
                        $.ajax({
                            data: $('#updateLibro').serialize(),
                            url: form_action,
                            type: "POST",
                            dataType: 'json',
                            success: function(res) {
                                var libro = '<td>' + res.data.id + '</td>';
                                libro += '<td>' + res.data.nombre + '</td>';
                                libro += '<td>' + res.data.autor + '</td>';
                                libro += '<td>' + res.data.fecha_de_edicion + '</td>';
                                libro += '<td><a data-id="' + res.data.id + '" class="btn btn-primary btnEdit">Editar</a>  <a data-id="' + res.data.id + '" class="btn btn-danger btnDelete">Eliminar</a></td>';
                                $('#libroTable tbody #' + res.data.id).html(libro);
                                $('#updateLibro')[0].reset();
                                $('#updateModal').modal('hide');
                            },
                            error: function(data) {}
                        });
                    }
                });

                $('body').on('click', '.btnDelete', function() {
                    var libro_id = $(this).attr('data-id');
                    $.get('libro/delete/' + libro_id, function(data) {
                        $('#libroTable tbody #' + libro_id).remove();
                    })
                });
            });
        </script>
</body>

</html>