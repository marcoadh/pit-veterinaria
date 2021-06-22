
!function (a) {
    "use strict";
    a(function () {
        var b = a(window),
                c = a(document.body),
                content = '',
                mycod = '',
                operation = '',
                form = '',
                f = '',
                codigo = '';






        a("#modalatencion").on("show.bs.modal", function (b) {
            var c = a(b.relatedTarget),
                    codigo = c.data("codigo"),
                    e = a(this);
            e.find(".modal-title").text("[ ATENDER ASESORIA ]");
            $.ajax({
                type: "POST",
                url: "../adm/presentacion/forms/atender_asesoria.php",
                data: "codigo=" + codigo,
                beforeSend: function () {
                    e.find(".modal-body").html("cargando contenido...espere un momento por favor");
                },
                success: function (data) {
                    e.find(".modal-body").html(data);
                },
                error: function () {
                }

            });

        });





    })
}







(jQuery), function () {
    "use strict";

    $('#fono').keyup(function () {

        this.value = (this.value + '').replace(/[^0-9]/g, '');

    });



}();
