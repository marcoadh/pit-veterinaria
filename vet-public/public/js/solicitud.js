var base_url = window.location.origin;
var d = new Date();
var month = d.getMonth() + 1;
var day = d.getDate();
var output = (day < 10 ? '0' : '') + day + '-' + (month < 10 ? '0' : '') + month + '-' + d.getFullYear();

$("#periodo").val(output);

    function Buscardocumento(cod_sol) {
    return $.ajax({
        type: "get",
        url: '../documento/buscar',
        data: {
            idsol: cod_sol,
        },
        beforeSend: function () {
            $('#idsoldis').prop({'value': cod_sol});
            $('#idsoldisaprob').prop({'value': cod_sol});
            $('#tipo_doc').prop({'value': 'RES_DIS'});
        },
        success: function (data) {
            var returnedData = data;
            if (returnedData.data.length == 0) {
                $('#RES_DIS_SI').hide();
                $('#RES_DIS').show();
                $('#idsoldis').prop({'value': cod_sol});
                $('#tipo_doc').prop({'value': 'RES_DIS'});
            } else {
                $.each(returnedData.data, function (i, v) {
                    if (v.tipdoc == "RES_DIS") {
                        $('#RES_DIS_SI').show();
                        $('#RES_DIS').hide();
                        $("#urlimagen").prop("href", "../" + "" + v.urldoc);
                        $("#codigodelete").prop("value", v.codigo);
                    } else {
                        $('#RES_DIS_SI').hide();
                        $('#RES_DIS').show();
                        $('#idsoldis').prop({'value': cod_sol});
                        $('#tipo_doc').prop({'value': 'RES_DIS'});
                    }
                });
            }
        },
        error: function () {
        }
    })};

    function ListarSolicitudes(cod_org) {
        var dt = $('#ListaSolicitudes').DataTable({
            destroy: true,
            "buttons": [
                'copy', 'csv', 'excel', 'pdf'
            ],

            "language": {
                "lengthMenu": "Ver _MENU_ registros por página",
                "zeroRecords": "No se encontraron resultados",
                "info": "Viendo página _PAGE_ de _PAGES_",
                "infoEmpty": "No se encontraron responsables",
                "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                "search": "Buscar:",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
            },

            "ajax": {
                "type": "get",
                "url": "../solicitud/listar",
                "data": {cod_org: cod_org,}
            },

            "columns": [
                {"data": "num_sol"},
                {
                    "data": "tipo_sol",
                    render: function (data) {
                        if (data == 1) {
                            return 'NUEVO'
                        } else {
                            return 'ACTUALIZAR'
                        }
                    },
                },
                {"data": "inicio"},
                {"data": "fin"},

                {
                    "data": "flag",
                    render: function (data) {
                        if (data == 1) {
                            return "<span class='label label-info'>EN PROCESO</span>"
                        } else if (data == 2) {
                            return "<span class='label label-warning'>EN EVALUACIÓN</span>"
                        } else if (data == 3) {
                            return "<span class='label label-success'>APROBADO</span>"
                        } else {
                            return "<span class='label label-danger'>ARCHIVADO</span>"
                        }
                    },
                },
                {
                    "data": "codigo",
                    "cod_org": "cod_org",
                    render: function (data) {
                        return "<a class=''" +
                            "style='cursor:pointer;overflow: visible;'" +
                            "data-target='#ModalDocumentos'" +
                            "data-toggle='modal'" +
                            "data-codigo='" + data + "'" +
                            "data-cod_org='" + cod_org + "'>" +
                            "<i class='fa fa-upload'></i></a>"
                    },
                },

                {
                    "data": "codigo",
                    "cod_org": "cod_org",
                    render: function (data) {
                        return "<a class=''" +
                            "style='cursor:pointer;overflow: visible;'" +
                            "data-target='#ModalArchivar'" +
                            "data-toggle='modal'" +
                            "data-codigo='" + data + "'" +
                            "data-cod_org='" + cod_org + "'>" +
                            "<i class='fa fa-folder'></i></a>"
                    },
                },

            ],

            columnDefs: [
                {
                    className: 'text-center',
                    targets: [0, 1, 2, 3, 4, 5, 6],
                }
            ]

        });

    }

    !function (a) {
        "use strict";

        a(function () {
            var b = a(window),
                c = a(document.body),
                mensaje = '',
                tipo = '',
                codigo = '';

            $('.subirresmun').click(function () {
                //CKEDITOR.instances[instance].updateElement();
                var b = a(this), dataString;
                var holder = '';
                var exito = true;
                $(".obligate2").each(function () {
                    if ($(this).val() == '') {
                        $(this).focus();
                        holder = $(this).attr("data-content");
                        exito = false;
                        $(".msgu2").html("").show();
                        $(".msgu2").html("<div class='alert alert-danger'><i class='fa fa-exclamation-triangle'></i> " + holder + "</div>");
                        setTimeout(function () {
                            $(".msgu2").fadeOut(1500);
                        }, 1500);
                        return false;
                    }
                });

                if (!exito)
                    return false;

                var formData = new FormData($("#resdis")[0]);

                $.ajax({
                    type: "POST",
                    url: "../documento/subirdocdis",
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    beforeSend: function () {
                        b.button("Subiendo");
                        $('.subirresmun').attr("disabled", true);
                        $('.barra2').html("<div class='progress progress-sm active'><div class='progress-bar progress-bar-success progress-bar-striped' role='progressbar' aria-valuenow='20' aria-valuemin='0' aria-valuemax='100' style='width: 100%'><span class='sr-only'>20% Complete</span></div></div>");
                    },
                    success: function (datos) {
                        if (datos.response == 'success') {
                            $('.barra2').html(datos.message);
                            setTimeout(function () {
                                $('.barra2').hide();
                                $('#ModalDocumentos').modal('hide')
                                var cod_org = datos.organizacion;
                                ListarSolicitudes(cod_org);
                            }, 2000);
                        } else {
                            $('.barra2').html(datos.message);
                        }
                    },
                    error: function () {
                        console.log("Error");
                    }
                })
            });

            $('.deletresmun').click(function () {

                var b = a(this), dataString;
                dataString = $('#delresdis').serialize();

                $.ajax({
                    type: "POST",
                    url: "../documento/deletedocdis",
                    data: dataString,
                    dataType: 'json',
                    beforeSend: function () {
                        $('.deletresmun').attr("disabled", true);
                        $('.barra2').html("<div class='progress progress-sm active'><div class='progress-bar progress-bar-success progress-bar-striped' role='progressbar' aria-valuenow='20' aria-valuemin='0' aria-valuemax='100' style='width: 100%'><span class='sr-only'>20% Complete</span></div></div>");
                    },
                    success: function (datos) {
                        if (datos.response == 'success') {
                            setTimeout(function () {
                                $('.barra2').hide();
                                $('#ModalDocumentos').modal('hide');
                                var cod_org = datos.organizacion;
                                ListarSolicitudes(cod_org);
                            }, 2000);
                        } else {
                            $('.barra2').html(datos.message);
                        }
                    },
                    error: function () {
                        console.log("Error");
                    }
                })
            });

            $('.enviarsolicitud').click(function () {

                var b = a(this), dataString;
                dataString = $('#enviar').serialize();

                $.ajax({
                    type: "POST",
                    url: "../solicitud/enviar",
                    data: dataString,
                    dataType: 'json',
                    beforeSend: function () {
                        $('.deletresmun').attr("disabled", true);
                        $('.barra2').html("<div class='progress progress-sm active'><div class='progress-bar progress-bar-success progress-bar-striped' role='progressbar' aria-valuenow='20' aria-valuemin='0' aria-valuemax='100' style='width: 100%'><span class='sr-only'>20% Complete</span></div></div>");
                    },
                    success: function (datos) {
                        if (datos.response == 'success') {

                            setTimeout(function () {
                                $('.barra2').hide();
                                $('#ModalDocumentos').modal('hide');
                                var cod_org = datos.org;
                                ListarSolicitudes(cod_org);
                            }, 2000);

                        } else {
                            $('.barra2').html(datos.message);
                        }
                    },
                    error: function () {
                        console.log("Error");
                    }
                })
            });

            $('.archivarolicitud').click(function () {

                var b = a(this), dataString;
                dataString = $('#enviar').serialize();

                $.ajax({
                    type: "POST",
                    url: "../solicitud/archivar",
                    data: dataString,
                    dataType: 'json',
                    beforeSend: function () {
                        $('.deletresmun').attr("disabled", true);
                        $('.barra2').html("<div class='progress progress-sm active'><div class='progress-bar progress-bar-success progress-bar-striped' role='progressbar' aria-valuenow='20' aria-valuemin='0' aria-valuemax='100' style='width: 100%'><span class='sr-only'>20% Complete</span></div></div>");
                    },
                    success: function (datos) {
                        if (datos.response == 'success') {

                            setTimeout(function () {
                                $('.barra2').hide();
                                $('#ModalArchivar').modal('hide');
                                var cod_org = datos.org;
                                ListarSolicitudes(cod_org);
                            }, 2000);

                        } else if (datos.response == 'aprobado') {

                            setTimeout(function () {
                                $('.barra2').hide();
                                $('#ModalArchivar').modal('hide');
                                alert("La solicitud no puede ser archivada porque ya se encuentra en evaluación.");
                                var cod_org = datos.org;
                                ListarSolicitudes(cod_org);
                            }, 2000);

                        } else {
                            $('.barra2').html(datos.message);
                        }
                    },
                    error: function () {
                        console.log("Error");
                    }
                })
            });

            a("#ModalSolNuevo").on("show.bs.modal", function (b) {
                var c = a(b.relatedTarget),
                    cod_org = c.data("codigo"),
                    nombre = c.data("nombre"),
                    mensaje = c.data("mensaje"),
                    tipo = c.data("tipo"),
                    e = a(this);
                document.getElementById("cod_org_sol").value = cod_org;
                document.getElementById("tipo_solicitud").value = tipo;
                e.find(".modal-title").text(nombre);
                e.find(".proceso").text(mensaje);
                if (tipo == 1) {
                    $('#actualizacion').hide();
                    $('#tipo_mod').last().removeClass("obligate4");
                } else {

                    $('#actualizacion').show();
                    $('#tipo_mod').last().addClass("obligate4");

                }


            });

            a("#EditarOrganizacion").on("show.bs.modal", function (b) {

                var c = a(b.relatedTarget),
                    codigo = c.data("codigo"),
                    e = a(this);

                e.find(".modal-title").text("HISTORIAL");

                return $.ajax({
                    type: "get",
                    url: '../organizacion/editar',
                    data: {
                        codigo: codigo
                    },
                    beforeSend: function () {
                        e.find(".modal-title").text("EDITAR ORGANIZACIÓN");
                        e.find(".timeline li").html("cargando contenido");
                    },
                    success: function (data) {
                        $.each(data, function (i, item) {
                            $('#codigoorganizacion').val(item.codigo),
                                $('#nom_org').val(item.nombre_org);
                            $('#domicilio_org').val(item.domicilio_org);
                            $('#fecha_cons').val(item.fecha_constitucion);
                            $('#num_miem').val(item.num_miem);
                            $('#fines').val(item.fines);
                            $('#obj_denomina').val(item.tipo_org);
                            $('#latitud_editar').val(item.latitud);
                            $('#longitud_editar').val(item.longitud);
                            coords = {
                                lng2: item.longitud,
                                lat2: item.latitud,
                            };
                            editMapa(coords);
                        });
                    },
                    error: function () {
                    }
                });

            });

            a("#JuntaDirectiva").on("show.bs.modal", function (b) {
                var c = a(b.relatedTarget),
                    cod_org = c.data("codigo"),
                    nombre = c.data("nombre"),
                    e = a(this);
                document.getElementById("cod_org").value = cod_org;

                e.find(".organizacion-name").text(nombre);
                e.find(".modal-title").text("ADMINISTRAR JUNTA DIRECTIVA");
                ListarMiebros(cod_org);
            });

            a("#ActualizarOrganizaccion").on("click", function () {
                $("#distrito_org").prop("disabled", false);
                var b = a(this), dataString;
                var holder = '';
                var exito = true;
                $(".obligate").each(function () {
                    if ($(this).val() == '') {
                        $("#distrito_org").prop("disabled", true);
                        $(this).focus();
                        holder = $(this).attr("data-content");
                        exito = false;
                        $(".msg").html("").show();
                        $(".msg").html("<div class='alert alert-danger'><i class='fa fa-exclamation-triangle'></i> " + holder + "</div>");
                        setTimeout(function () {
                            $(".msg").fadeOut(1500);
                        }, 1500);
                        return false;
                    }
                });
                if (!exito)
                    return false;


                dataString = $('#FormActualizarOrganizacion').serialize();
                $.ajax({
                    type: "POST",
                    url: "../organizacion/actualizar",
                    data: dataString,
                    dataType: 'json',
                    beforeSend: function () {
                        b.button("loading");
                    },
                    success: function (data) {
                        if (data.response == 'si') {
                            $(".msg").html("").show();
                            $(".msg").html(data.message);
                            $("#distrito_org").prop("disabled", true);
                            b.button("reset");
                            setTimeout(function () {
                                $(".msg").fadeOut(1500);
                            }, 1500);
                        } else {
                            var position = data.indexOf('?');
                            var number = data.substr(0, position).replace(/\s+/g, '');
                            //alert(data + "=>" + position + " =>" + number + " =>"+number.length);
                            if (number > 0) {
                                b.button("reset");
                                $('#EditarOrganizacion').modal('hide')
                                $('#myModalInformation').find(".modal-body").html("<center>" + data.substr(position + 1, data.length) + "</center>");
                                $('#myModalInformation').modal('show');
                                setTimeout(function () {
                                    window.location.href = window.location;
                                }, 1500);
                            } else {
                                $(".msg").html("").show();
                                $(".msg").html(data.message);
                                setTimeout(function () {
                                    $(".msg").fadeOut(1500);
                                }, 1000);
                                b.button("reset");
                            }
                        }


                    },
                    error: function () {
                        console.log("It failed");
                    }
                })
            });

            a("#RegistrarOrganizacion").on("click", function () {

                $("#distrito_orgv2").prop("disabled", false);

                var b = a(this), dataString;
                var holder = '';
                var exito = true;
                $(".obligatev2").each(function () {
                    if ($(this).val() == '') {
                        $("#distrito_orgv2").prop("disabled", true);
                        $(this).focus();
                        holder = $(this).attr("data-content");
                        exito = false;
                        $(".msg2").html("").show();
                        $(".msg2").html("<div class='alert alert-danger'><i class='fa fa-exclamation-triangle'></i> " + holder + "</div>");
                        setTimeout(function () {
                            $(".msg2").fadeOut(1500);
                        }, 1500);
                        return false;
                    }
                });
                if (!exito)
                    return false;


                dataString = $('#FormAgregarOrganizacion').serialize();
                $.ajax({
                    type: "POST",
                    url: "../organizacion/registrar",
                    data: dataString,
                    dataType: 'json',
                    beforeSend: function () {
                        b.button("loading");
                    },
                    success: function (data) {
                        if (data.response == 'si') {
                            $(".msg2").html("").show();
                            $(".msg2").html(data.message);
                            $("#distrito_orgv2").prop("disabled", true);
                            b.button("reset");
                            setTimeout(function () {
                                $(".msg2").fadeOut(1500);
                            }, 1500);
                        } else {
                            var position = data.indexOf('?');
                            var number = data.substr(0, position).replace(/\s+/g, '');
                            //alert(data + "=>" + position + " =>" + number + " =>"+number.length);
                            if (number > 0) {
                                b.button("reset");
                                $('#AgregarOrganizacion').modal('hide')
                                $('#myModalInformation').find(".modal-body").html("<center>" + data.substr(position + 1, data.length) + "</center>");
                                $('#myModalInformation').modal('show');
                                setTimeout(function () {
                                    window.location.href = window.location;
                                }, 1500);
                            } else {
                                $(".msg2").html("").show();
                                $(".msg2").html(data.message);
                                setTimeout(function () {
                                    $(".msg2").fadeOut(1500);
                                }, 1000);
                                b.button("reset");
                            }
                        }

                    },
                    error: function () {
                        console.log("It failed");
                    }
                })
            });

            a("#posteliminarsolicitud").on("click", function () {
                var b = a(this), dataString;
                var holder = '';
                var exito = true;
                $(".obligateeliminar").each(function () {
                    if ($(this).val() == '') {
                        $(this).focus();
                        holder = $(this).attr("data-content");
                        exito = false;
                        $(".msg").html("").show();
                        $(".msg").html("<div class='alert alert-danger'><i class='fa fa-exclamation-triangle'></i> " + holder + "</div>");
                        setTimeout(function () {
                            $(".msg").fadeOut(1500);
                        }, 1500);
                        return false;
                    }
                });
                if (!exito)
                    return false;
                dataString = $('#eliminar_form').serialize();
                $.ajax({
                    type: "POST",
                    url: "../eliminarsolicitud",
                    data: dataString,
                    beforeSend: function () {
                        b.button("loading");
                    },
                    success: function (data) {
                        var position = data.indexOf('?');
                        var number = data.substr(0, position).replace(/\s+/g, '');
                        // alert(data + "=>" + position + " =>" + number + " =>"+number.length);
                        if (number > 0) {
                            b.button("reset");
                            $('#EliminarSolicitud').modal('hide')
                            $('#myModalInformation').find(".modal-body").html("<center>" + data.substr(position + 1, data.length) + "</center>");
                            $('#myModalInformation').modal('show');
                            ;
                            setTimeout(function () {
                                window.location.href = window.location;
                            }, 2000);

                        } else {
                            $(".msg").html("").show();
                            // $(".msg").html(data);
                            $(".msg").html("<div class='alert alert-danger'><i class='fa fa-exclamation-triangle'></i> " + holder + "</div>");
                            setTimeout(function () {
                                $(".msg").fadeOut(1500);
                            }, 1500);
                            b.button("reset");
                        }

                    },
                    error: function () {
                        console.log("It failed");
                    }
                })
            });

            a("#RegistrarMiembro").on("click", function () {

                var b = a(this), dataString;
                var holder = '';
                var exito = true;
                $(".obligate3").each(function () {
                    if ($(this).val() == '') {
                        $(this).focus();
                        holder = $(this).attr("data-content");
                        exito = false;
                        $(".msg3").html("").show();
                        $(".msg3").html("<div class='alert alert-danger'><i class='fa fa-exclamation-triangle'></i> " + holder + "</div>");
                        setTimeout(function () {
                            $(".msg3").fadeOut(1500);
                        }, 1500);
                        return false;
                    }
                });
                if (!exito)
                    return false;
                dataString = $('#FormAgregarMiembro').serialize();
                $.ajax({
                    type: "POST",
                    url: "../juntadirectiva/registrar",
                    data: dataString,
                    dataType: 'json',
                    beforeSend: function () {
                        b.button("loading");
                    },
                    success: function (data) {
                        if (data.response == 'si') {
                            $(".msg3").html("").show();
                            $(".msg3").html(data.message);
                            b.button("reset");
                            setTimeout(function () {
                                $(".msg3").fadeOut(1500);
                            }, 1500);
                        } else {

                            ListarMiebros(data.org);
                            var position = data.message.indexOf('?');
                            var number = data.message.substr(0, position).replace(/\s+/g, '');
                            if (number > 0) {
                                b.button("reset");
                                $('.obligate3').val('');
                                $('#imgElem').attr('src', '../images/anonimo.png');
                                $("#provincia").val('');
                                $("#departamento").val('');
                                $("#distrito").val('');
                                $("#descripcion_cargo").val('');
                                $("#cod_puesto").val('');
                            } else {
                                $(".msg3").html("").show();
                                $(".msg3").html(data.message);
                                setTimeout(function () {
                                    $(".msg2").fadeOut(1500);
                                }, 1000);
                                b.button("reset");
                            }
                        }

                    },
                    error: function () {
                        console.log("It failed");
                    }
                })
            });

            a("#RegistrarSolicitud").on("click", function () {

                var b = a(this), dataString;
                var holder = '';
                var exito = true;
                $(".obligate4").each(function () {
                    if ($(this).val() == '') {
                        $(this).focus();
                        holder = $(this).attr("data-content");
                        exito = false;
                        $(".msg5").html("").show();
                        $(".msg5").html("<div class='alert alert-danger'><i class='fa fa-exclamation-triangle'></i> " + holder + "</div>");
                        setTimeout(function () {
                            $(".msg5").fadeOut(1500);
                        }, 1500);
                        return false;
                    }
                });
                if (!exito)
                    return false;
                dataString = $('#FormNuevaSolicitud').serialize();
                $.ajax({
                    type: "POST",
                    url: "../solicitud/registrar",
                    data: dataString,
                    dataType: 'json',
                    beforeSend: function () {
                    },
                    success: function (data) {

                        if (data.solicitud > 0) {
                            $(".msg5").html("").show();
                            $(".msg5").html(data.message);

                            setTimeout(function () {
                                $(".msg5").fadeOut(1500);
                            }, 1000);

                            setTimeout(function () {
                                $('#ModalSolNuevo').modal('hide')
                                ListarSolicitudes(data.organizacion);
                            }, 2000);

                        } else {
                            $(".msg5").html("").show();
                            $(".msg5").html(data.message);
                            b.button("reset");
                            setTimeout(function () {
                                $(".msg5").fadeOut(1500);
                            }, 1500);
                        }

                    },
                    error: function () {
                        console.log("Error");
                    }
                })
            });

            a("#ModalSolicitudes").on("show.bs.modal", function (b) {

                var c = a(b.relatedTarget),
                    cod_org = c.data("codigo"),
                    nombre = c.data("nombre"),
                    mensaje = c.data("mensaje"),
                    tipo = c.data("tipo"),
                    e = a(this);

                e.find(".modal-title").text(nombre);

                return $.ajax({
                    type: "get",
                    url: '../solicitud/buscar',
                    data: {codigo: cod_org},
                    dataType: 'json',
                    beforeSend: function () {
                        $("#validaexistencia").html("");
                        ListarSolicitudes(cod_org);
                    },

                    success: function (data) {

                        if (data.response == "si") {

                        } else {

                            $("#validaexistencia").html("<div class='well center-block' style='max-width: 400px;'>" +
                                "<a class='btn btn-primary btn-lg btn-block'" +
                                "data-target='#ModalSolNuevo'" +
                                "data-toggle='modal'" +
                                "data-codigo='" + cod_org + "'" +
                                "data-tipo='1'" +
                                "data-nombre='" + nombre + "'>" +
                                "REGISTRO NUEVO " +
                                "<i class=''></i>" +
                                "</a>" +
                                "<a class='btn btn-default btn-lg btn-block'" +
                                "data-target='#ModalSolNuevo'" +
                                "data-toggle='modal'" +
                                "data-codigo='" + cod_org + "'" +
                                "data-tipo='2'" +
                                "data-mensaje='Complete los datos para continuar con la solicitud'" +
                                "data-nombre='" + nombre + "'>" +
                                "ACTUALIZACIÓN " +
                                "<i class=''></i>" +
                                "</a></div>");

                        }

                    },

                    error: function () {
                    }

                });

            });

            a("#ModalDocumentos").on("show.bs.modal", function (b) {
                var c = a(b.relatedTarget),
                    cod_sol = c.data("codigo"),
                    cod_org = c.data("cod_org"),
                    e = a(this);
                $('#codigoorghelpn').prop({'value': cod_org});
                $('#codigoorghelp').prop({'value': cod_org});
                $('#codorghelapro').prop({'value': cod_org});
                e.find(".modal-title").text("GESTIONAR SOLICITUD");
                Buscardocumento(cod_sol);
            });

            a("#ModalArchivar").on("show.bs.modal", function (b) {
                var c = a(b.relatedTarget),
                    cod_sol = c.data("codigo"),
                    cod_org = c.data("cod_org"),
                    e = a(this);
                $('#codigoorghelpn').prop({'value': cod_org});
                $('#codigoorghelp').prop({'value': cod_org});
                $('#codorghelapro').prop({'value': cod_org});
                e.find(".modal-title").text("ARCHIVAR SOLICITUD");
                Buscardocumento(cod_sol);
            });

        })
    }

    (jQuery), function () {
        "use strict";
        $('#fono').keyup(function () {
            this.value = (this.value + '').replace(/[^0-9]/g, '');
        });

    }();

    $(document).ready(function () {
        $('#example').DataTable({
            pageLength: 10,

            "buttons": [
                'copy', 'csv', 'excel', 'pdf'
            ],

            "language": {
                "lengthMenu": "Ver _MENU_ registros por página",
                "zeroRecords": "No se encontraron resultados",
                "info": "Viendo página _PAGE_ de _PAGES_",
                "infoEmpty": "No se encontraron organizaciones",
                "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                "search": "Buscar:",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
            },

            "order": [[0, "desc"]],

            columnDefs: [{
                targets: [0, 1],
                orderData: [0, 1],
                orderSequence: ["desc"],
            },
                {
                    className: 'text-center',
                    targets: [4],
                }
            ]
        });

    });


    initMap();

    var marker;
    var coords = {};

    function initMap() {
        coords = {
            lng: -77.03146290121919,
            lat: -12.045291343726586,
            lng2: -77.03146290121919,
            lat2: -12.045291343726586,
        };
        setMapa(coords);
    }

    function setMapa(coords) {

        var map = new google.maps.Map(document.getElementById('map'),
            {
                zoom: 12,
                center: new google.maps.LatLng(coords.lat, coords.lng),
            });


        var src = "http://ruoslima.com/public/mapas/limites.kmz";

        var kmlLayer = new google.maps.KmlLayer(src, {
            suppressInfoWindows: true,
            preserveViewport: true,
            map: map
        });

        marker = new google.maps.Marker({
            map: map,
            draggable: true,
            animation: google.maps.Animation.DROP,
            position: new google.maps.LatLng(coords.lat, coords.lng),
        });

        //--------------------------------------------------------------
        var map2 = new google.maps.Map(document.getElementById('map2'),
            {
                zoom: 14,
                center: new google.maps.LatLng(coords.lat2, coords.lng2),
                styles: [{
                    elementType: 'labels.icon',
                    stylers: [{visibility: 'off'}]
                }]
            });

        var kmlLayer = new google.maps.KmlLayer(src, {
            suppressInfoWindows: true,
            preserveViewport: true,
            map: map2
        });

        marker2 = new google.maps.Marker({
            map: map2,
            draggable: true,
            animation: google.maps.Animation.DROP,
            position: new google.maps.LatLng(coords.lat2, coords.lng2),
        });
        //--------------------------------------------------------------

        marker.addListener('click', toggleBounce);
        marker2.addListener('click', toggleBounce);

        marker.addListener('dragend', function (event) {
            $('#longitud').val(this.getPosition().lng());
            $('#latitud').val(this.getPosition().lat());
            $('#longitud_editar').val(this.getPosition().lng());
            $('#latitud_editar').val(this.getPosition().lat());
        });

        marker2.addListener('dragend', function (event) {
            $('#longitud').val(this.getPosition().lng());
            $('#latitud').val(this.getPosition().lat());
            $('#longitud_editar').val(this.getPosition().lng());
            $('#latitud_editar').val(this.getPosition().lat());
        });


    }


function editMapa(coords) {

    var src = "http://ruoslima.com/public/mapas/limites.kmz";

    //--------------------------------------------------------------
    var map2 = new google.maps.Map(document.getElementById('map2'),
        {
            zoom: 14,
            center: new google.maps.LatLng(coords.lat2, coords.lng2),
            styles: [{
                elementType: 'labels.icon',
                stylers: [{visibility: 'off'}]
            }]
        });

    var kmlLayer = new google.maps.KmlLayer(src, {
        suppressInfoWindows: true,
        preserveViewport: true,
        map: map2
    });

    marker2 = new google.maps.Marker({
        map: map2,
        draggable: true,
        animation: google.maps.Animation.DROP,
        position: new google.maps.LatLng(coords.lat2, coords.lng2),
    });
    //--------------------------------------------------------------

    marker2.addListener('click', toggleBounce);

    marker2.addListener('dragend', function (event) {
        $('#longitud_editar').val(this.getPosition().lng());
        $('#latitud_editar').val(this.getPosition().lat());
    });

}

function toggleBounce() {
        if (marker.getAnimation() !== null) {
            marker.setAnimation(null);
        } else {
            marker.setAnimation(google.maps.Animation.BOUNCE);
        }


        if (marker2.getAnimation() !== null) {
            marker2.setAnimation(null);
        } else {
            marker2.setAnimation(google.maps.Animation.BOUNCE);
        }


    }


    function puestochange(sel) {
        if (sel.value == "43" || sel.value == "2") {
            $("#div-otros").show();
        } else {
            $("#div-otros").hide();

        }
    }

    function buscarDni() {
        var dni;
        var usuario;
        var pass;

        usuario = 'GPV01';
        pass = '$GPV.2019';
        dni = $("#dni").val();

        if (dni.length == 8) {
            BuscarPersonaDNI_WS_propietario('', dni, '', '', usuario, pass);
        } else {
            limpiar_propietario();
            bloquear_datosPropietario('0');
        }
    }

    function BuscarPersonaDNI_WS_propietario(key, dni, NROTAR, FECH, usuario, pass) {


        $.ajax({
            url: 'https://pide.munlima.gob.pe/CWS/BuscarDatosPersonalesPIDE',
            type: 'POST',
            data:
                {
                    nuDniConsulta: dni,
                    usuario: usuario,
                    pass: pass

                },
            beforeSend: function (e) {
                $('#load').addClass('load');
            },
            success: function (data) {
                var c = JSON.parse(data);

                if (c.valor.return.coResultado = '0000') {
                    if (c.valor.return.datosPersona) {
                        bloquear_datosPropietario('1');
                        var a = c.valor.return.datosPersona;
                        var ubi = a.ubigeo.split("/");
                        $('#nombre').val(a.prenombres);
                        $('#apellido_pat').val(a.apPrimer);
                        $('#apellido_mat').val(a.apSegundo);
                        $('#direccion').val(a.direccion);
                        $('#departamento').val(ubi[0]);
                        $('#provincia').val(ubi[1]);
                        $('#distrito').val(ubi[2]);
                        $('#foto').val(a.foto);
                        document.getElementById("fecha_nacimiento").style.outline = "rgb(0, 163, 156) solid 2px";
                        document.getElementById("sexo").style.outline = "rgb(0, 163, 156) solid 2px";
                        var baseStr64 = a.foto;
                        imgElem.setAttribute('src', "data:image/jpg;base64," + baseStr64);
                    } else {
                        limpiar_propietario();
                        bloquear_datosPropietario('0');
                    }
                } else {
                    limpiar_propietario();
                    bloquear_datosPropietario('0');
                }
                $('#load').removeClass('load');
            },
            error: function (xhr, err) {
                $('#load').removeClass('load');
            }
        });

    }

    function limpiar_propietario() {

        $('#nombre').val('');
        $('#apellido_pat').val('');
        $('#apellido_mat').val('');
        $('#direccion').val('');
        $('#departamento').val('');
        $('#provincia').val('');
        $('#distrito').val('');
        $('#restriccion').val('');
    }

    function bloquear_datosPropietario(con) {
        if (con == '1') {
            $('#nombres').attr('disabled');
            $('#apellidopaterno').attr('disabled');
            $('#apellidomaterno').attr('disabled');
            $('#departamento').attr('disabled');
            $('#provincia').attr('disabled');
            $('#distrito').attr('disabled');


        } else {
            $('#nombres').removeAttr('disabled');
            $('#apellidopaterno').removeAttr('disabled');
            $('#apellidomaterno').removeAttr('disabled');
            $('#departamento').removeAttr('disabled');
            $('#provincia').removeAttr('disabled');
            $('#distrito').removeAttr('disabled');

        }
    }

    (jQuery), function () {
        "use strict";
        $('#fono').keyup(function () {
            this.value = (this.value + '').replace(/[^0-9]/g, '');
        });

    }();


    function format(d) {
        return '<div class="col-md-4"><strong>NOMBRE: </strong> ' + d.nombre + '<br>' +
            '<strong>APELLIDO PATERNO: </strong> ' + d.apellido_pat + '<br>' +
            '<strong>APELLIDO MATERNO: </strong> ' + d.apellido_mat + '<br>' +
            '<strong>FECHA DE NACIMIENTO: </strong>' + d.fecha_nacimiento + '<br>' +
            '<strong>SEXO: </strong>' + d.sexo + '<br>' +
            '<strong>DESPARTAMENTO: </strong>' + d.departamento + '<br>' +
            '<strong>PROVINCIA: </strong>' + d.provincia + '<br>' +
            '<strong>DISTRITO: </strong>' + d.distrito + '</div>' +
            '<div class="col-md-4"><img style="width: auto;border: solid 2px #9E9E9E;border-radius: 10px;" src="data:image/jpg;base64,' + d.foto + '"></div>';
    }


    var childRows = null;
    var codigo_organizacion = null;

    var obtener_id_eliminar = function (tbody, table) {
        $(tbody).on("click", "button.eliminar", function () {
            var data = table.row($(this).parents("tr")).data();
            var idusuario = $("#frmEliminarUsuario #idusuario").val(data.idusuario);
        });
    }

    function ListarMiebros(cod_org) {

        responsive: true

        document.getElementById("cod_org").value = cod_org;
        $codigo_organizacion = cod_org;

        var dt = $('#MiembrosJuntaDirectiva').DataTable({

            destroy: true,

            "buttons": [
                'copy', 'csv', 'excel', 'pdf'
            ],

            "language": {
                "lengthMenu": "Ver _MENU_ registros por página",
                "zeroRecords": "No se encontraron resultados",
                "info": "Viendo página _PAGE_ de _PAGES_",
                "infoEmpty": "No se encontraron responsables",
                "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                "search": "Buscar:",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
            },

            "ajax": {
                "type": "get",
                "url": "../juntadirectiva/listaruntadirectiva",
                "data": {cod_org: cod_org,}
            },

            "columns": [
                {
                    "class": "details-control",
                    "orderable": false,
                    "data": null,
                    "defaultContent": ""
                },
                {"data": "dni"},
                {"data": "puesto"},
                {"data": "nombre"},
                {"data": "apellido_pat"},
                {"data": "apellido_mat"},
                {
                    "className": "center",
                    "mData": "foto",
                    "mRender": function (data, type, row) {
                        return "<img style='width: 30px;border: solid 2px #9E9E9E;border-radius: 10px;' src='data:image/jpg;base64," + data + "'>";
                    }
                },
                {
                    "className": "center",
                    "mData": "codigo",
                    "mRender": function (data, type, row) {
                        return "<a class='btn btn-default' onclick='EliminarMiembro(" + data + ")' class='editor_remove'><i class='fa fa-remove'></i></a>";
                    }
                },
            ],

            columnDefs: [
                {
                    className: 'text-center',
                    targets: [0, 1, 2, 3, 4, 5, 6],
                }
            ]
        });


        // Array to track the ids of the details displayed rows
        var detailRows = [];

        $('#MiembrosJuntaDirectiva tbody').off('click', 'tr td.details-control');
        $('#MiembrosJuntaDirectiva tbody').on('click', 'tr td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = dt.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                d = row.data();
                row.child(format(d)).show();
                tr.addClass('shown');
            }
        });


        // On each draw, loop over the `detailRows` array and show any child rows
        dt.on('draw', function () {

            // If reloading table then show previously shown rows
            if (childRows) {

                childRows.every(function (rowIdx, tableLoop, rowLoop) {
                    d = this.data();
                    this.child($(format(d))).show();
                    this.nodes().to$().addClass('shown');
                });

                // Reset childRows so loop is not executed each draw
                childRows = null;
            }
        });


    }


    function EliminarMiembro(codigo) {
        $.ajax({
            type: "get",
            url: "../juntadirectiva/eliminar",
            data: {codigo: codigo,},
            dataType: 'json',
            success: function (data) {
                if (data.response == 'si') {
                    ListarMiebros($codigo_organizacion);
                } else {
                    $(".msg3").html("").show();
                    $(".msg3").html("<div class='alert alert-warning'><i class='fa fa-warning'></i> Se ha producido un error, actualice la página por favor.</div>");
                    setTimeout(function () {
                        $(".msg3").fadeOut(1500);
                    }, 1500);
                    ListarMiebros($codigo_organizacion);
                }

            },
            error: function () {
                console.log("Error");
            }
        })
    };

    function ExportarExcelCasos(tipo, pag) {

        $.ajax({
            url: 'exportar-casos-excel',
            type: 'post',
            data: {
                tipo: tipo,
                pag: pag
            },
            beforeSend: function (e) {
                $('#load').addClass('load');
            },
            success: function (data) {
                $('#load').removeClass('load');

                if (data.success) {
                    window.open(DOMAINSITE + data.achivoxls, '_blank');
                }
            },
            error: function (e) {
                $('#load').removeClass('load');
            }
        });
    }

    $(document).on('show.bs.modal', '.modal', function (event) {
        var zIndex = 1040 + (10 * $('.modal:visible').length);
        $(this).css('z-index', zIndex);
        setTimeout(function () {
            $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
        }, 0);
    });
