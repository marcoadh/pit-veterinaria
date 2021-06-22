// http://bestwebcreator.com/cryptocash/demo/index-dark-particle.html
// https://codepen.io/yukki/pen/rmmKjM



    
$(function () {
    /*===================================*
     01. MENU JS
     *===================================*/
    $(window).on("scroll", function () {
        var scroll = $(window).scrollTop();

        if (scroll >= 80) {
            $("#site-header").addClass("nav-fixed");
        } else {
            $("#site-header").removeClass("nav-fixed");
        }
    });

    //Main navigation Active Class Add Remove
    $(".navbar-toggler").on("click", function () {
        $("header").toggleClass("active");
    });
    $(document).on("ready", function () {
        if ($(window).width() > 991) {
            $("header").removeClass("active");
        }
        $(window).on("resize", function () {
            if ($(window).width() > 991) {
                $("header").removeClass("active");
            }
        });
    });

    /*===================================*
     02. BACKGROUND ANIMATION JS
     *===================================*/
    var $particles_js = $("#banner-bg-effect");
    if ($particles_js.length > 0) {
        particlesJS(
                "banner-bg-effect",
                // Update your personal code.
                        {
                            particles: {
                                number: {
                                    value: 80,
                                    density: {
                                        enable: true,
                                        value_area: 800
                                    }
                                },
                                color: {
                                    value: "#ffffff"
                                },
                                shape: {
                                    type: "circle",
                                    stroke: {
                                        width: 0,
                                        color: "#ffffff"
                                    },
                                    polygon: {
                                        nb_sides: 5
                                    },
                                    image: {
                                        src: "img/github.svg",
                                        width: 100,
                                        height: 100
                                    }
                                },
                                opacity: {
                                    value: 0.4,
                                    random: false,
                                    anim: {
                                        enable: false,
                                        speed: 1,
                                        opacity_min: 0.5,
                                        sync: false
                                    }
                                },
                                size: {
                                    value: 3,
                                    random: true,
                                    anim: {
                                        enable: false,
                                        speed: 20,
                                        size_min: 0.2,
                                        sync: false
                                    }
                                },
                                line_linked: {
                                    enable: true,
                                    distance: 150,
                                    color: "#ffffff",
                                    opacity: 0.2,
                                    width: 1
                                },
                                move: {
                                    enable: true,
                                    speed: 6,
                                    direction: "none",
                                    random: false,
                                    straight: false,
                                    out_mode: "out",
                                    bounce: false,
                                    attract: {
                                        enable: false,
                                        rotateX: 600,
                                        rotateY: 1200
                                    }
                                }
                            },
                            interactivity: {
                                detect_on: "canvas",
                                events: {
                                    onhover: {
                                        enable: false,
                                        mode: "repulse"
                                    },
                                    onclick: {
                                        enable: false,
                                        mode: "push"
                                    },
                                    resize: true
                                },
                                modes: {
                                    grab: {
                                        distance: 400,
                                        line_linked: {
                                            opacity: 1
                                        }
                                    },
                                    bubble: {
                                        distance: 400,
                                        size: 20,
                                        duration: 2,
                                        opacity: 1,
                                        speed: 3
                                    },
                                    repulse: {
                                        distance: 200,
                                        duration: 0.4
                                    },
                                    push: {
                                        particles_nb: 4
                                    },
                                    remove: {
                                        particles_nb: 2
                                    }
                                }
                            },
                            retina_detect: true
                        }
                );
            }
});

         var base_url = window.location.origin;
        
        var d = new Date();
        var month = d.getMonth() + 1;
        var day = d.getDate();
        var output = (day < 10 ? '0' : '') + day + '-' + (month < 10 ? '0' : '') + month + '-' + d.getFullYear();

        $("#periodo").val(output);

        !function (a) {
            "use strict";

            a(function () {
                var b = a(window),
                    c = a(document.body),
                    mensaje = '',
                    tipo = '',
                    codigo = '';

                $('.registrar').click(function(){
                    var b = a(this), dataString;
                    var holder = '';
                    var exito = true;
                    
                    $(".valdni").each(function () {
                        if ($(this).val().length < 8) {
                            $(this).focus();
                            exito = false;
                            $(".msg").html("").show();
                            $(".msg").html("<div class='alert alert-danger'><i class='fa fa-exclamation-triangle'></i> El DNI debe contener 8 dígitos</div>");
                            return false;
                        }
                    });
                    
                    $(".valcel").each(function () {
                        if ($(this).val().length < 7) {
                            $(this).focus();
                            exito = false;
                            $(".msg").html("").show();
                            $(".msg").html("<div class='alert alert-danger'><i class='fa fa-exclamation-triangle'></i> El teléfono debe contener más de 7 dígitos</div>");
                            return false;
                        }
                    });
                    
                    $(".valcorreo").each(function () {
                        if ( $(this).val().indexOf('@', 0) == -1 || $(this).val().indexOf('.', 0) == -1) {
                            $(this).focus();
                            exito = false;
                            $(".msg").html("").show();
                            $(".msg").html("<div class='alert alert-danger'><i class='fa fa-exclamation-triangle'></i> El formato del correo es incorrecto</div>");
                            return false;
                        }
                    });
                    
                    $(".obligate").each(function(){
                        if($(this).val()==''){
                            $(this).focus();
                            holder=$(this).attr("data-content");
                            exito=false;
                            $(".msg").html("").show();
                            $(".msg").html("<div class='alert alert-danger'><i class='fa fa-warning'></i> "+holder+"</div>");
                            return false;
                        }
                    });

                    if(!exito)
                        return false;


                    var formData = new FormData($("#FormRegistro")[0]);

                    $.ajax({
                        type: "POST",
                        url: base_url+"/gps/public/formulario/registrar",
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        beforeSend: function () {
                            $("#registrar").attr("disabled", true);
                        },
                        success: function (data) {
                            if (data.response == 'success') {
                                $('#Formulario').modal('hide');
                                $('#modalMensaje').find(".modal-body").html(data.message);
                                $('#modalMensaje').modal('show');
                                setTimeout(function () {
                                    $("#FormRegistro")[0].reset();
                                    $('.msg').html('<div class="alert alert-success"><i class="fa fa-check"></i> Su mensaje fue registrado con éxito</div>');
                                    $("#registrar").attr("disabled", false);
                                }, 1500);
                            } else {
                                $('.msg').html(data.message);
                                $("#registrar").attr("disabled", false);
                            }
                        },
                        error: function () {
                            console.log("It failed");
                        }
                    })
                });
                
                $('.suscripcion1').click(function(){
                    var b = a(this), dataString;
                    var holder = '';
                    var exito = true;
                    
                    $(".valcorreo").each(function () {
                        if ( $(this).val().indexOf('@', 0) == -1 || $(this).val().indexOf('.', 0) == -1) {
                            $(this).focus();
                            exito = false;
                            $(".msg").html("").show();
                            $(".msg").html("<div class='alert alert-danger'><i class='fa fa-exclamation-triangle'></i> El formato del correo es incorrecto</div>");
                            return false;
                        }
                    });
                    
                    $(".obligate").each(function(){
                        if($(this).val()==''){
                            $(this).focus();
                            holder=$(this).attr("data-content");
                            exito=false;
                            $(".msg").html("").show();
                            $(".msg").html("<div class='alert alert-danger'><i class='fa fa-warning'></i> "+holder+"</div>");
                            return false;
                        }
                    });

                    if(!exito)
                        return false;


                    var formData = new FormData($("#FormSuscripcion1")[0]);

                    $.ajax({
                        type: "POST",
                        url: base_url+"/gps/public/suscripcion/registrar",
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        beforeSend: function () {
                            $("#suscripcion1").attr("disabled", true);
                        },
                        success: function (data) {
                            if (data.response == 'success') {
                                setTimeout(function () {
                                    $("#FormSuscripcion1")[0].reset();
                                    $('.msg').html('<div class="alert alert-success"><i class="fa fa-check"></i> Su mensaje fue registrado con éxito</div>');
                                    $("#suscripcion1").attr("disabled", false);
                                }, 1500);
                            } else {
                                $('.msg').html(data.message);
                                $("#suscripcion1").attr("disabled", false);
                            }
                        },
                        error: function () {
                            console.log("It failed");
                        }
                    })
                });
                
                $('.suscripcion').click(function(){
                    var b = a(this), dataString;
                    var holder = '';
                    var exito = true;
                    
                    $(".valcorreo2").each(function () {
                        if ( $(this).val().indexOf('@', 0) == -1 || $(this).val().indexOf('.', 0) == -1) {
                            $(this).focus();
                            exito = false;
                            $(".msg2").html("").show();
                            $(".msg2").html("<div class='alert alert-danger'><i class='fa fa-exclamation-triangle'></i> El formato del correo es incorrecto</div>");
                            return false;
                        }
                    });
                    
                    $(".obligate2").each(function(){
                        if($(this).val()==''){
                            $(this).focus();
                            holder=$(this).attr("data-content");
                            exito=false;
                            $(".msg2").html("").show();
                            $(".msg2").html("<div class='alert alert-danger'><i class='fa fa-warning'></i> "+holder+"</div>");
                            return false;
                        }
                    });

                    if(!exito)
                        return false;


                    var formData = new FormData($("#FormSuscripcion")[0]);

                    $.ajax({
                        type: "POST",
                        url: base_url+"/gps/public/suscripcion/registrar",
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        beforeSend: function () {
                            $("#suscripcion").attr("disabled", true);
                        },
                        success: function (data) {
                            if (data.response == 'success') {
                                setTimeout(function () {
                                    $("#FormSuscripcion")[0].reset();
                                    $('.msg2').html('<div class="alert alert-success"><i class="fa fa-check"></i> Su mensaje fue registrado con éxito</div>');
                                    $("#suscripcion").attr("disabled", false);
                                }, 1500);
                            } else {
                                $('.msg2').html(data.message);
                                $("#suscripcion").attr("disabled", false);
                            }
                        },
                        error: function () {
                            console.log("It failed");
                        }
                    })
                });
                
                $('.responder').click(function(){
                    var b = a(this), dataString;
                    var holder = '';
                    var exito = true;
                    
                    $(".obligate").each(function(){
                        if($(this).val()==''){
                            $(this).focus();
                            holder=$(this).attr("data-content");
                            exito=false;
                            $(".msg").html("").show();
                            $(".msg").html("<div class='alert alert-danger'><i class='fa fa-warning'></i> "+holder+"</div>");
                            return false;
                        }
                    });

                    if(!exito)
                        return false;

                    var formData = new FormData($("#FormRespuesta")[0]);

                    $.ajax({
                        type: "POST",
                        url: base_url+"/gps/public/respuesta/registrar",
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        beforeSend: function () {
                        $("#responder").attr("disabled", true);
                        },
                        success: function (data) {
                            if (data.response == 'success') {
                                setTimeout(function () {
                                    $("#FormRespuesta")[0].reset();
                                    $('.msg').html('<div class="alert alert-success"><i class="fa fa-check"></i> ' + data.message + '</div>');
                                    $("#responder").attr("disabled", false);
                                }, 1500);
                            } else {
                                $('.msg').html('<div class="alert alert-danger"><i class="fa fa-warning"></i> ' + data.message + '</div>');
                                $("#responder").attr("disabled", false);
                            }
                        },
                        error: function () {
                            console.log("It failed");
                        }
                    })
                });
                

            })
            
            
            
        }
        

        (jQuery), function () {
            "use strict";
            $('#fono').keyup(function () {
                this.value = (this.value + '').replace(/[^0-9]/g, '');
            });

        }();


