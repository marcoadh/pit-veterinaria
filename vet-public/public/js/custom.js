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
      mycodigo='';


    $('.subir1').click(function(){
      //CKEDITOR.instances[instance].updateElement();
      var b=a(this),dataString;
      var holder='';
      var exito=true;
      $(".obligate1").each(function(){
        if($(this).val()==''){
          $(this).focus();
          holder=$(this).attr("data-content");
          exito=false;
          $(".msgu").html("").show();
          $(".msgu").html("<div class='alert alert-danger'><i class='fa fa-exclamation-triangle'></i> "+holder+"</div>");
          setTimeout(function() {
            $(".msgu").fadeOut(1500);
          },1500);
          return false;
        }
      });

      if(!exito)
        return false;

      var formData = new FormData($("#doc1")[0]);

      $.ajax({
        type:"POST",
        url:"../subirdocumento",
        data:formData,
        contentType: false,
        processData: false,
        dataType:'json',
        beforeSend: function(){
          b.button("Subiendo");
          $('.subir1').attr("disabled", true);
          $('.barra1').html("<div class='progress progress-sm active'><div class='progress-bar progress-bar-success progress-bar-striped' role='progressbar' aria-valuenow='20' aria-valuemin='0' aria-valuemax='100' style='width: 100%'><span class='sr-only'>20% Complete</span></div></div>");
        },
        success: function(datos){
          if(datos.response=='success'){
            $('.barra1').html(datos.message);
            if(datos.postulacion=='full'){
              jQuery('.popup-overlay').fadeIn('fast',function(){
                jQuery('.popup-overlay').height(jQuery(window).height());
                jQuery('#felicitaciones').css('display','block');
              });
            }else{
              
            }
          }else{
            $('.barra1').html(datos.message);
          }
        },
        error: function(){
          console.log("Error");
        }
      })
    });
    $('.subir2').click(function(){
      //CKEDITOR.instances[instance].updateElement();
      var b=a(this),dataString;
      var holder='';
      var exito=true;
      $(".obligate2").each(function(){
        if($(this).val()==''){
          $(this).focus();
          holder=$(this).attr("data-content");
          exito=false;
          $(".msgu2").html("").show();
          $(".msgu2").html("<div class='alert alert-danger'><i class='fa fa-exclamation-triangle'></i> "+holder+"</div>");
          setTimeout(function() {
            $(".msgu2").fadeOut(1500);
          },1500);
          return false;
        }
      });

      if(!exito)
        return false;

      var formData = new FormData($("#doc2")[0]);

      $.ajax({
        type:"POST",
        url:"../subirdocumento",
        data:formData,
        contentType: false,
        processData: false,
        dataType:'json',
        beforeSend: function(){
          b.button("Subiendo");
          $('.subir2').attr("disabled", true);
          $('.barra2').html("<div class='progress progress-sm active'><div class='progress-bar progress-bar-success progress-bar-striped' role='progressbar' aria-valuenow='20' aria-valuemin='0' aria-valuemax='100' style='width: 100%'><span class='sr-only'>20% Complete</span></div></div>");
        },
        success: function(datos){
          if(datos.response=='success'){
            $('.barra2').html(datos.message);
            if(datos.postulacion=='full'){
              jQuery('.popup-overlay').fadeIn('fast',function(){
                jQuery('.popup-overlay').height(jQuery(window).height());
                jQuery('#felicitaciones').css('display','block');
              });
            }else{
              
            }
          }else{
            $('.barra2').html(datos.message);
          }
        },
        error: function(){
          console.log("Error");
        }
      })
    });
    $('.subir3').click(function(){
      //CKEDITOR.instances[instance].updateElement();
      var b=a(this),dataString;
      var holder='';
      var exito=true;
      $(".obligate3").each(function(){
        if($(this).val()==''){
          $(this).focus();
          holder=$(this).attr("data-content");
          exito=false;
          $(".msgu3").html("").show();
          $(".msgu3").html("<div class='alert alert-danger'><i class='fa fa-exclamation-triangle'></i> "+holder+"</div>");
          setTimeout(function() {
            $(".msgu3").fadeOut(1500);
          },1500);
          return false;
        }
      });

      if(!exito)
        return false;

      var formData = new FormData($("#doc3")[0]);

      $.ajax({
        type:"POST",
        url:"../subirdocumento",
        data:formData,
        contentType: false,
        processData: false,
        dataType:'json',
        beforeSend: function(){
          b.button("Subiendo");
          $('.subir3').attr("disabled", true);
          $('.barra3').html("<div class='progress progress-sm active'><div class='progress-bar progress-bar-success progress-bar-striped' role='progressbar' aria-valuenow='20' aria-valuemin='0' aria-valuemax='100' style='width: 100%'><span class='sr-only'>20% Complete</span></div></div>");
        },
        success: function(datos){
          if(datos.response=='success'){
            $('.barra3').html(datos.message);
            if(datos.postulacion=='full'){
              jQuery('.popup-overlay').fadeIn('fast',function(){
                jQuery('.popup-overlay').height(jQuery(window).height());
                jQuery('#felicitaciones').css('display','block');
              });
            }else{
              
            }
          }else{
            $('.barra3').html(datos.message);
          }
        },
        error: function(){
          console.log("Error");
        }
      })
    });
    $('.subir4').click(function(){
      //CKEDITOR.instances[instance].updateElement();
      var b=a(this),dataString;
      var holder='';
      var exito=true;
      $(".obligate4").each(function(){
        if($(this).val()==''){
          $(this).focus();
          holder=$(this).attr("data-content");
          exito=false;
          $(".msgu4").html("").show();
          $(".msgu4").html("<div class='alert alert-danger'><i class='fa fa-exclamation-triangle'></i> "+holder+"</div>");
          setTimeout(function() {
            $(".msgu4").fadeOut(1500);
          },1500);
          return false;
        }
      });

      if(!exito)
        return false;
      var formData = new FormData($("#doc4")[0]);
      $.ajax({
        type:"POST",
        url:"../subirdocumento",
        data:formData,
        contentType: false,
        processData: false,
        dataType:'json',
        beforeSend: function(){
          b.button("Subiendo");
          $('.subir4').attr("disabled", true);
          $('.barra4').html("<div class='progress progress-sm active'><div class='progress-bar progress-bar-success progress-bar-striped' role='progressbar' aria-valuenow='20' aria-valuemin='0' aria-valuemax='100' style='width: 100%'><span class='sr-only'>20% Complete</span></div></div>");
        },
        success: function(datos){
          if(datos.response=='success'){
            $('.barra4').html(datos.message);
            if(datos.postulacion=='full'){
              jQuery('.popup-overlay').fadeIn('fast',function(){
                jQuery('.popup-overlay').height(jQuery(window).height());
                jQuery('#felicitaciones').css('display','block');
              });
            }else{
              
            }
          }else{
            $('.barra4').html(datos.message);
          }
        },
        error: function(){
          console.log("Error");
        }
      })
    });
    $('.subir5').click(function(){
      //CKEDITOR.instances[instance].updateElement();
      var b=a(this),dataString;
      var holder='';
      var exito=true;
      $(".obligate5").each(function(){
        if($(this).val()==''){
          $(this).focus();
          holder=$(this).attr("data-content");
          exito=false;
          $(".msgu5").html("").show();
          $(".msgu5").html("<div class='alert alert-danger'><i class='fa fa-exclamation-triangle'></i> "+holder+"</div>");
          setTimeout(function() {
            $(".msgu5").fadeOut(1500);
          },1500);
          return false;
        }
      });

      if(!exito)
        return false;

      var formData = new FormData($("#doc5")[0]);

      $.ajax({
        type:"POST",
        url:"../subirdocumento",
        data:formData,
        contentType: false,
        processData: false,
        dataType:'json',
        beforeSend: function(){
          b.button("Subiendo");
          $('.subir5').attr("disabled", true);
          $('.barra5').html("<div class='progress progress-sm active'><div class='progress-bar progress-bar-success progress-bar-striped' role='progressbar' aria-valuenow='20' aria-valuemin='0' aria-valuemax='100' style='width: 100%'><span class='sr-only'>20% Complete</span></div></div>");
        },
        success: function(datos){
          if(datos.response=='success'){
            $('.barra5').html(datos.message);
            if(datos.postulacion=='full'){
              jQuery('.popup-overlay').fadeIn('fast',function(){
                jQuery('.popup-overlay').height(jQuery(window).height());
                jQuery('#felicitaciones').css('display','block');
              });
            }else{
              
            }
          }else{
            $('.barra5').html(datos.message);
          }
        },
        error: function(){
          console.log("Error");
        }
      })
    });
    $('.subir6').click(function(){
      //CKEDITOR.instances[instance].updateElement();
      var b=a(this),dataString;
      var holder='';
      var exito=true;
      $(".obligate6").each(function(){
        if($(this).val()==''){
          $(this).focus();
          holder=$(this).attr("data-content");
          exito=false;
          $(".msgu6").html("").show();
          $(".msgu6").html("<div class='alert alert-danger'><i class='fa fa-exclamation-triangle'></i> "+holder+"</div>");
          setTimeout(function() {
            $(".msgu6").fadeOut(1500);
          },1500);
          return false;
        }
      });

      if(!exito)
        return false;

      var formData = new FormData($("#doc6")[0]);

      $.ajax({
        type:"POST",
        url:"../subirdocumento",
        data:formData,
        contentType: false,
        processData: false,
        dataType:'json',
        beforeSend: function(){
          b.button("Subiendo");
          $('.subir6').attr("disabled", true);
          $('.barra6').html("<div class='progress progress-sm active'><div class='progress-bar progress-bar-success progress-bar-striped' role='progressbar' aria-valuenow='20' aria-valuemin='0' aria-valuemax='100' style='width: 100%'><span class='sr-only'>20% Complete</span></div></div>");
        },
        success: function(datos){
          if(datos.response=='success'){
            $('.barra6').html(datos.message);
            if(datos.postulacion=='full'){
              jQuery('.popup-overlay').fadeIn('fast',function(){
                jQuery('.popup-overlay').height(jQuery(window).height());
                jQuery('#felicitaciones').css('display','block');
              });
            }else{
              
            }
          }else{
            $('.barra6').html(datos.message);
          }
        },
        error: function(){
          console.log("Error");
        }
      })
    });
    $('.subir7').click(function(){
      //CKEDITOR.instances[instance].updateElement();
      var b=a(this),dataString;
      var holder='';
      var exito=true;
      $(".obligate7").each(function(){
        if($(this).val()==''){
          $(this).focus();
          holder=$(this).attr("data-content");
          exito=false;
          $(".msgu7").html("").show();
          $(".msgu7").html("<div class='alert alert-danger'><i class='fa fa-exclamation-triangle'></i> "+holder+"</div>");
          setTimeout(function() {
            $(".msgu7").fadeOut(1500);
          },1500);
          return false;
        }
      });

      if(!exito)
        return false;

      var formData = new FormData($("#doc7")[0]);

      $.ajax({
        type:"POST",
        url:"../subirdocumento",
        data:formData,
        contentType: false,
        processData: false,
        dataType:'json',
        beforeSend: function(){
          b.button("Subiendo");
          $('.subir7').attr("disabled", true);
          $('.barra7').html("<div class='progress progress-sm active'><div class='progress-bar progress-bar-success progress-bar-striped' role='progressbar' aria-valuenow='20' aria-valuemin='0' aria-valuemax='100' style='width: 100%'><span class='sr-only'>20% Complete</span></div></div>");
        },
        success: function(datos){
          if(datos.response=='success'){
            $('.barra7').html(datos.message);
            if(datos.postulacion=='full'){
              jQuery('.popup-overlay').fadeIn('fast',function(){
                jQuery('.popup-overlay').height(jQuery(window).height());
                jQuery('#felicitaciones').css('display','block');
              });
            }else{
              
            }
          }else{
            $('.barra7').html(datos.message);
          }
        },
        error: function(){
          console.log("Error");
        }
      })
    });
    $('.subir8').click(function(){
      //CKEDITOR.instances[instance].updateElement();
      var b=a(this),dataString;
      var holder='';
      var exito=true;
      $(".obligate8").each(function(){
        if($(this).val()==''){
          $(this).focus();
          holder=$(this).attr("data-content");
          exito=false;
          $(".msgu8").html("").show();
          $(".msgu8").html("<div class='alert alert-danger'><i class='fa fa-exclamation-triangle'></i> "+holder+"</div>");
          setTimeout(function() {
            $(".msgu8").fadeOut(1500);
          },1500);
          return false;
        }
      });

      if(!exito)
        return false;

      var formData = new FormData($("#doc8")[0]);

      $.ajax({
        type:"POST",
        url:"../subirdocumento",
        data:formData,
        contentType: false,
        processData: false,
        dataType:'json',
        beforeSend: function(){
          b.button("Subiendo");
          $('.subir8').attr("disabled", true);
          $('.barra8').html("<div class='progress progress-sm active'><div class='progress-bar progress-bar-success progress-bar-striped' role='progressbar' aria-valuenow='20' aria-valuemin='0' aria-valuemax='100' style='width: 100%'><span class='sr-only'>20% Complete</span></div></div>");
        },
        success: function(datos){
          if(datos.response=='success'){
            $('.barra8').html(datos.message);
            if(datos.postulacion=='full'){
              jQuery('.popup-overlay').fadeIn('fast',function(){
                jQuery('.popup-overlay').height(jQuery(window).height());
                jQuery('#felicitaciones').css('display','block');
              });
            }else{
              
            }
          }else{
            $('.barra8').html(datos.message);
          }
        },
        error: function(){
          console.log("Error");
        }
      })
    });
    $('.subir9').click(function(){
      //CKEDITOR.instances[instance].updateElement();
      var b=a(this),dataString;
      var holder='';
      var exito=true;
      $(".obligate9").each(function(){
        if($(this).val()==''){
          $(this).focus();
          holder=$(this).attr("data-content");
          exito=false;
          $(".msgu9").html("").show();
          $(".msgu9").html("<div class='alert alert-danger'><i class='fa fa-exclamation-triangle'></i> "+holder+"</div>");
          setTimeout(function() {
            $(".msgu9").fadeOut(1500);
          },1500);
          return false;
        }
      });

      if(!exito)
        return false;

      var formData = new FormData($("#doc9")[0]);

      $.ajax({
        type:"POST",
        url:"../subirdocumento",
        data:formData,
        contentType: false,
        processData: false,
        dataType:'json',
        beforeSend: function(){
          b.button("Subiendo");
          $('.subir9').attr("disabled", true);
          $('.barra9').html("<div class='progress progress-sm active'><div class='progress-bar progress-bar-success progress-bar-striped' role='progressbar' aria-valuenow='20' aria-valuemin='0' aria-valuemax='100' style='width: 100%'><span class='sr-only'>20% Complete</span></div></div>");
        },
        success: function(datos){
          if(datos.response=='success'){
            $('.barra9').html(datos.message);
            if(datos.postulacion=='full'){
              $('.popup-overlay').fadeIn('fast',function(){
                $('.popup-overlay').height($(window).height());
                $('#felicitaciones').css('display','block');
              });
            }else{
              
            }
          }else{
            $('.barra9').html(datos.message);
          }
        },
        error: function(){
          console.log("Error");
        }
      })
    });
    $('.subir10').click(function(){
      //CKEDITOR.instances[instance].updateElement();
      var b=a(this),dataString;
      var holder='';
      var exito=true;
      $(".obligate10").each(function(){
        if($(this).val()==''){
          $(this).focus();
          holder=$(this).attr("data-content");
          exito=false;
          $(".msgu10").html("").show();
          $(".msgu10").html("<div class='alert alert-danger'><i class='fa fa-exclamation-triangle'></i> "+holder+"</div>");
          setTimeout(function() {
            $(".msgu10").fadeOut(1500);
          },1500);
          return false;
        }
      });

      if(!exito)
        return false;

      var formData = new FormData($("#doc10")[0]);

      $.ajax({
        type:"POST",
        url:"../subirdocumento",
        data:formData,
        contentType: false,
        processData: false,
        dataType:'json',
        beforeSend: function(){
          b.button("Subiendo");
          $('.subir10').attr("disabled", true);
          $('.barra10').html("<div class='progress progress-sm active'><div class='progress-bar progress-bar-success progress-bar-striped' role='progressbar' aria-valuenow='20' aria-valuemin='0' aria-valuemax='100' style='width: 100%'><span class='sr-only'>20% Complete</span></div></div>");
        },
        success: function(datos){
          if(datos.response=='success'){
            $('.barra10').html(datos.message);
            if(datos.postulacion=='full'){
              $('.popup-overlay').fadeIn('fast',function(){
                $('.popup-overlay').height($(window).height());
                $('#felicitaciones').css('display','block');
              });
            }else{
              
            }
          }else{
            $('.barra10').html(datos.message);
          }
        },
        error: function(){
          console.log("Error");
        }
      })
    });
    $('.subir11').click(function(){
      //CKEDITOR.instances[instance].updateElement();
      var b=a(this),dataString;
      var holder='';
      var exito=true;
      $(".obligate11").each(function(){
        if($(this).val()==''){
          $(this).focus();
          holder=$(this).attr("data-content");
          exito=false;
          $(".msgu11").html("").show();
          $(".msgu11").html("<div class='alert alert-danger'><i class='fa fa-exclamation-triangle'></i> "+holder+"</div>");
          setTimeout(function() {
            $(".msgu11").fadeOut(1500);
          },1500);
          return false;
        }
      });

      if(!exito)
        return false;

      var formData = new FormData($("#doc11")[0]);

      $.ajax({
        type:"POST",
        url:"../subirdocumento",
        data:formData,
        contentType: false,
        processData: false,
        dataType:'json',
        beforeSend: function(){
          b.button("Subiendo");
          $('.subir11').attr("disabled", true);
          $('.barra11').html("<div class='progress progress-sm active'><div class='progress-bar progress-bar-success progress-bar-striped' role='progressbar' aria-valuenow='20' aria-valuemin='0' aria-valuemax='100' style='width: 100%'><span class='sr-only'>20% Complete</span></div></div>");
        },
        success: function(datos){
          if(datos.response=='success'){
            $('.barra11').html(datos.message);
            if(datos.postulacion=='full'){
              $('.popup-overlay').fadeIn('fast',function(){
                $('.popup-overlay').height($(window).height());
                $('#felicitaciones').css('display','block');
              });
            }else{
              
            }
          }else{
            $('.barra11').html(datos.message);
          }
        },
        error: function(){
          console.log("Error");
        }
      })
    });
    $('.subir12').click(function(){
      //CKEDITOR.instances[instance].updateElement();
      var b=a(this),dataString;
      var holder='';
      var exito=true;
      $(".obligate12").each(function(){
        if($(this).val()==''){
          $(this).focus();
          holder=$(this).attr("data-content");
          exito=false;
          $(".msgu12").html("").show();
          $(".msgu12").html("<div class='alert alert-danger'><i class='fa fa-exclamation-triangle'></i> "+holder+"</div>");
          setTimeout(function() {
            $(".msgu12").fadeOut(1500);
          },1500);
          return false;
        }
      });

      if(!exito)
        return false;

      var formData = new FormData($("#doc12")[0]);

      $.ajax({
        type:"POST",
        url:"../subirdocumento",
        data:formData,
        contentType: false,
        processData: false,
        dataType:'json',
        beforeSend: function(){
          b.button("Subiendo");
          $('.subir12').attr("disabled", true);
          $('.barra12').html("<div class='progress progress-sm active'><div class='progress-bar progress-bar-success progress-bar-striped' role='progressbar' aria-valuenow='20' aria-valuemin='0' aria-valuemax='100' style='width: 100%'><span class='sr-only'>20% Complete</span></div></div>");
        },
        success: function(datos){
          if(datos.response=='success'){
            $('.barra12').html(datos.message);
            if(datos.postulacion=='full'){
              $('.popup-overlay').fadeIn('fast',function(){
                $('.popup-overlay').height($(window).height());
                $('#felicitaciones').css('display','block');
              });
            }else{
              
            }
          }else{
            $('.barra12').html(datos.message);
          }
        },
        error: function(){
          console.log("Error");
        }
      })
    });
    $('.subir13').click(function(){
      //CKEDITOR.instances[instance].updateElement();
      var b=a(this),dataString;
      var holder='';
      var exito=true;
      $(".obligate13").each(function(){
        if($(this).val()==''){
          $(this).focus();
          holder=$(this).attr("data-content");
          exito=false;
          $(".msgu13").html("").show();
          $(".msgu13").html("<div class='alert alert-danger'><i class='fa fa-exclamation-triangle'></i> "+holder+"</div>");
          setTimeout(function() {
            $(".msgu13").fadeOut(1500);
          },1500);
          return false;
        }
      });

      if(!exito)
        return false;

      var formData = new FormData($("#doc13")[0]);

      $.ajax({
        type:"POST",
        url:"../subirdocumento",
        data:formData,
        contentType: false,
        processData: false,
        dataType:'json',
        beforeSend: function(){
          b.button("Subiendo");
          $('.subir13').attr("disabled", true);
          $('.barra13').html("<div class='progress progress-sm active'><div class='progress-bar progress-bar-success progress-bar-striped' role='progressbar' aria-valuenow='20' aria-valuemin='0' aria-valuemax='100' style='width: 100%'><span class='sr-only'>20% Complete</span></div></div>");
        },
        success: function(datos){
          if(datos.response=='success'){
            $('.barra13').html(datos.message);
            if(datos.postulacion=='full'){
              $('.popup-overlay').fadeIn('fast',function(){
                $('.popup-overlay').height($(window).height());
                $('#felicitaciones').css('display','block');
              });
            }else{
              
            }
          }else{
            $('.barra13').html(datos.message);
          }
        },
        error: function(){
          console.log("Error");
        }
      })
    });
    $('.subir14').click(function(){
      //CKEDITOR.instances[instance].updateElement();
      var b=a(this),dataString;
      var holder='';
      var exito=true;
      $(".obligate14").each(function(){
        if($(this).val()==''){
          $(this).focus();
          holder=$(this).attr("data-content");
          exito=false;
          $(".msgu14").html("").show();
          $(".msgu14").html("<div class='alert alert-danger'><i class='fa fa-exclamation-triangle'></i> "+holder+"</div>");
          setTimeout(function() {
            $(".msgu14").fadeOut(1500);
          },1500);
          return false;
        }
      });

      if(!exito)
        return false;

      var formData = new FormData($("#doc14")[0]);

      $.ajax({
        type:"POST",
        url:"../subirdocumento",
        data:formData,
        contentType: false,
        processData: false,
        dataType:'json',
        beforeSend: function(){
          b.button("Subiendo");
          $('.subir14').attr("disabled", true);
          $('.barra14').html("<div class='progress progress-sm active'><div class='progress-bar progress-bar-success progress-bar-striped' role='progressbar' aria-valuenow='20' aria-valuemin='0' aria-valuemax='100' style='width: 100%'><span class='sr-only'>20% Complete</span></div></div>");
        },
        success: function(datos){
          if(datos.response=='success'){
            $('.barra14').html(datos.message);
            if(datos.postulacion=='full'){
              $('.popup-overlay').fadeIn('fast',function(){
                $('.popup-overlay').height($(window).height());
                $('#felicitaciones').css('display','block');
              });
            }else{
              
            }
          }else{
            $('.barra14').html(datos.message);
          }
        },
        error: function(){
          console.log("Error");
        }
      })
    });

    $('#subirDocumento').click(function () {

      var holder='';
      var exito=true;
      $(".obligatedoc").each(function(){
        if($(this).val()==''){
          $(this).focus();
          holder=$(this).attr("data-content");
          exito=false;
          $(".msgu").html("").show();
          $(".msgu").html("<div class='alert alert-danger'><i class='fa fa-exclamation-triangle'></i> "+holder+"</div>");
          setTimeout(function() {
            $(".msgu").fadeOut(1500);
          },1500);
          return false;
        }
      });
      if(!exito)
        return false;

      var formData = new FormData($("#form_update")[0]);

      $.ajax({
        type:"POST",
        url: '../redocumento',
        data:formData,
        contentType: false,
        processData: false,
        dataType:'json',
        beforeSend: function () {
          $('.subirDocumento').attr("disabled", true);

          $('.barra1').html("<div class='progress progress-sm active'><div class='progress-bar progress-bar-success progress-bar-striped' role='progressbar' aria-valuenow='20' aria-valuemin='0' aria-valuemax='100' style='width: 100%'><span class='sr-only'>20% Complete</span></div></div>");
        },

        success: function (datos) {

          if (datos.response == 'success') {
            document.getElementById("subirDocumento").disabled = true;
            $('.barra1').html(datos.message);
            setTimeout("location.reload()", 2500);

          } else {
            $('.barra1').html(datos.message);

          }
        },

        error: function (response, status, e) {
          alert('Error al subir');
        }


      });
    })


  })}

(jQuery),function(){"use strict";
  $('#fono').keyup(function (){
    this.value = (this.value + '').replace(/[^0-9]/g, '');
  });

}();
