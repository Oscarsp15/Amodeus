$('.FormularioAjax').submit(function (e) {
    e.preventDefault();
    var form = $(this);
    var accion = form.attr('action');
    var metodo = form.attr('method');
    var respuesta = form.children('.RespuestaAjax');
    var formdata = new FormData(this);
    $.ajax({
        type: metodo,
        url: accion,
        data: formdata ? formdata : form.serialize(),
        cache: false,
        contentType: false,
        processData: false,
        xhr: function () {
            var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function (evt) {
                if (evt.lengthComputable) {
                    var percentComplete = evt.loaded / evt.total;
                    percentComplete = parseInt(percentComplete * 100);
                    if (percentComplete < 100) {
                        respuesta.html('<p class="text-center">Procesado... (' + percentComplete + '%)</p><div class="progress progress-striped active"><div class="progress-bar progress-bar-info" style="width: ' + percentComplete + '%;"></div></div>');
                    } else {
                        respuesta.html('<p class="text-center"></p>');
                    }
                }
            }, false);
            return xhr;
        },
        success: function (data) {
            respuesta.html(data); 
        }
    });
    return false;
});
let showNotification = function(from, align , text, color){
    $.notify({
        icon: "<i class='fa fa-check text-white'></i>",
        message: text
    }, {
        type: color,
        timer: 3000,
        placement: {
            from: from,
            align: align
        }
    });
}
window.onload =  function(){
    $("#preloader").fadeOut(300);
}