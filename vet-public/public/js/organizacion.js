
function puestochange(sel) {
    if (sel.value=="43" || sel.value=="2"){
        $("#div-otros").show();
    }else{
        $("#div-otros").hide();

    }
}


function buscarDni(){
    var dni;
    var usuario;
    var pass;

    usuario = 'GPV01';
    pass= '$GPV.2019';


    dni = $("#dni").val();



    if (dni.length == 8){


        BuscarPersonaDNI_WS_propietario('',dni,'','',usuario,pass);
    }else{
        limpiar_propietario();
        bloquear_datosPropietario('0');
    }
}


function BuscarPersonaDNI_WS_propietario(key,dni,NROTAR,FECH,usuario,pass){


    $.ajax({
        url:'https://pide.munlima.gob.pe/CWS/BuscarDatosPersonalesPIDE',
        type:'POST',
        data:
            {
                nuDniConsulta:dni,
                usuario: usuario,
                pass: pass

            },
        beforeSend: function(e){
            $('#load').addClass('load');
        },
        success: function(data){
            var c = JSON.parse(data);

            if( c.valor.return.coResultado = '0000' ){
                if (c.valor.return.datosPersona){
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
                    document.getElementById("fecha_nacimiento").style.outline = "#fca700 solid 2px";
                    document.getElementById("sexo").style.outline = "#fca700 solid 2px";
                    var baseStr64=a.foto;
                    imgElem.setAttribute('src', "data:image/jpg;base64," + baseStr64);


                }else{
                    limpiar_propietario();
                    bloquear_datosPropietario('0');
                }
            }else{
                limpiar_propietario();
                bloquear_datosPropietario('0');
            }
            $('#load').removeClass('load');
        },
        error: function(xhr, err){
            $('#load').removeClass('load');
        }
    });

}

function limpiar_propietario(){

    $('#nombre').val('');
    $('#apellido_pat').val('');
    $('#apellido_mat').val('');
    $('#direccion').val('');
    $('#departamento').val('');
    $('#provincia').val('');
    $('#distrito').val('');
    $('#restriccion').val('');
}


function bloquear_datosPropietario(con){
    if(con=='1'){
        $('#nombres').attr('disabled');
        $('#apellidopaterno').attr('disabled');
        $('#apellidomaterno').attr('disabled');
        $('#departamento').attr('disabled');
        $('#provincia').attr('disabled');
        $('#distrito').attr('disabled');


    }else{
        $('#nombres').removeAttr('disabled');
        $('#apellidopaterno').removeAttr('disabled');
        $('#apellidomaterno').removeAttr('disabled');
        $('#departamento').removeAttr('disabled');
        $('#provincia').removeAttr('disabled');
        $('#distrito').removeAttr('disabled');

    }
}

!function(a){
    "use strict";

    a(function(){
        var b=a(window),
            c=a(document.body),
            content='',
            mycod='',
            operation='',
            form='',
            f='',
            mycodigo='',
            flag='',
            comentario='',
            codigo='';

        a("#posteliminarsolicitud").on("click",function(){
            var b=a(this),dataString;
            var holder='';
            var exito=true;
            $(".obligateeliminar").each(function(){
                if($(this).val()==''){
                    $(this).focus();
                    holder=$(this).attr("data-content");
                    exito=false;
                    $(".msg").html("").show();
                    $(".msg").html("<div class='alert alert-danger'><i class='fa fa-exclamation-triangle'></i> "+holder+"</div>");
                    setTimeout(function() {
                        $(".msg").fadeOut(1500);
                    },1500);
                    return false;
                }
            });
            if(!exito)
                return false;
            dataString=$('#eliminar_form').serialize();
            $.ajax({
                type:"POST",
                url:"../eliminarsolicitud",
                data:dataString,
                beforeSend: function(){
                    b.button("loading");
                },
                success: function(data){
                    var position=data.indexOf('?');
                    var number=data.substr(0,position).replace(/\s+/g, '');
                    // alert(data + "=>" + position + " =>" + number + " =>"+number.length);
                    if(number>0){
                        b.button("reset");
                        $('#EliminarSolicitud').modal('hide')
                        $('#myModalInformation').find(".modal-body").html("<center>"+data.substr(position+1,data.length)+"</center>");
                        $('#myModalInformation').modal('show');
                        ;
                        setTimeout(function() {
                            window.location.href = window.location;
                        }, 2000);

                    }else{
                        $(".msg").html("").show();
                        // $(".msg").html(data);
                        $(".msg").html("<div class='alert alert-danger'><i class='fa fa-exclamation-triangle'></i> "+holder+"</div>");
                        setTimeout(function() {
                            $(".msg").fadeOut(1500);
                        },1500);
                        b.button("reset");
                    }

                },
                error: function(){
                    console.log("It failed");
                }
            })
        });


    })}




(jQuery),function(){"use strict";
    $('#fono').keyup(function (){
        this.value = (this.value + '').replace(/[^0-9]/g, '');
    });

}();

$(document).ready(function() {

    document.getElementById("obj_denomina").disabled = true;

    $('#example').DataTable( {

        "language": {
            "lengthMenu": "Ver _MENU_ registros por página",
            "zeroRecords": "No se encontraron resultados",
            "info": "Viendo página _PAGE_ de _PAGES_",
            "infoEmpty": "No se encontraron responsables",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "search":         "Buscar:",
            "paginate": {
                "first":      "Primero",
                "last":       "Último",
                "next":       "Siguiente",
                "previous":   "Anterior"
            },
        },

        "order": [[ 0, "desc" ]],

        columnDefs: [ {
            targets: [ 0,1,2,3,4 ],
            orderData: [ 0, 1 ],
            orderSequence: [ "desc" ],
        }, {
            className: 'text-center',
            targets: [0,1,2,3,4,5,6,7,8,9,10],
        }
        ]


    } );


} );


function Buscardenominacion(selectObject) {
    document.getElementById("obj_denomina").disabled = false;
    var idvalor = selectObject.value;
    return $.ajax({
        type:"get",
        url: '../organizacion/denominaciones',
        data: {
            idvalor : idvalor,
        },
        success: function(data){
            $('#obj_denomina option').remove();
            $.each(data,function(i,item){
                $("#obj_denomina").append(""+
                    "<option value='"+item.codigo+"'>"+
                    item.descripcion);
            });
        },
        error: function(){
        }
    });
};


var marker;
var coords = {};
function initMap(){
    coords = {
        lng: -77.03146290121919,
        lat: -12.045291343726586
    };
    setMapa(coords);
}

function setMapa (coords){

    var map = new google.maps.Map(document.getElementById('map'),
        {
            zoom: 14,
            center:new google.maps.LatLng(coords.lat,coords.lng),
            styles: [{
                elementType: 'labels.icon',
                stylers: [{visibility: 'off'}]
            }]
        });

    var src = "https://aplicativos.munlima.gob.pe/kml/GPV-CASAS-VECINALES.kml";

    var kmlLayer = new google.maps.KmlLayer(src, {
        suppressInfoWindows: true,
        preserveViewport: true,
        map: map
    });

    marker = new google.maps.Marker({
        map: map,
        draggable: true,
        animation: google.maps.Animation.DROP,
        position: new google.maps.LatLng(coords.lat,coords.lng),
    });

    //--------------------------------------------------------------

    marker.addListener('click', toggleBounce);

    marker.addListener( 'dragend', function (event){
        $('#longitud').val(this.getPosition().lng());
        $('#latitud').val(this.getPosition().lat());
    });

}
function toggleBounce() {
    if (marker.getAnimation() !== null) {
        marker.setAnimation(null);
    } else {
        marker.setAnimation(google.maps.Animation.BOUNCE);
    }
}


