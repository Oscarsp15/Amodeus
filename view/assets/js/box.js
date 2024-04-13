// x la cantidad de productos en venta
var x = 'p=1&,p=2&,p=3&,p=4&,p=5&,p=6&,p=7&,p=8&,p=9&,p=10&,p=11&,p=12&,p=13&,p=14&,p=15&,p=16&,p=17&,p=18&,p=19&,p=20&,p=21&,p=22&,p=23&,p=24&,p=25&,p=26&,p=27&,p=28&,p=29&,p=30&';
// funcion para transformar x en un array []
var p = x.split(',');

//Crear HTML del producto para la caja
function htmlpro(producto,exist,id,cantidad,idum,um,precio,equivalente,moneda){
    var dmp = $('#pro-n-'+id);

    // Active Remove
    $('#caja .item-primary').removeClass('p-active');

    if (dmp.length){
       
       dmp.addClass('p-active');
       var dmcp = $('#pro-n-'+id+' .pro-n').text();
       var dmcp1 = parseInt(dmcp);

       if (dmcp1 == exist){
         return;
       }
       sumaPro(precio);
       var smdcp = dmcp1 + 1;
       $('#pro-n-'+id+' .pro-n').text(smdcp);

    }else{
        var html = '<div id="pro-n-'+id+'" data-id="'+id+'" data-equi="'+equivalente+'" data-idum="'+idum+'"  data-exis="'+exist+'" data-price="'+precio+'" class="item item-primary p-active" role="alert">\
                        <div class="row">\
                            <div class="col-8">\
                                <span class="pro-d">'+um+' de '+producto+'</span>\
                            </div>\
                            <div class="col-4 text-center">\
                                <span class="pre-pro" style="padding: 10%;">'+moneda+precio+'</span>\
                                <span class="pro-n">'+cantidad+'</span>\
                            </div>\
                        </div>\
                    </div>';
        $('#caja').prepend(html);
        sumaPro(precio*cantidad);       
    }
}

// Suma de productos
function sumaPro(precio){
    var inptSum = $('#suma').val();
    if (inptSum.length == 0){
       var dt1 = 0;
       var dt2 = parseFloat(precio);
       var suma = dt1 + dt2;  
    }else{
       var dt1 = parseFloat(inptSum);
       var dt2 = parseFloat(precio);
       var suma = dt1 + dt2;        
    }
    $('#suma').val(suma.toFixed(2));
    $('.final-price').text(suma.toFixed(2));
}

//Funcion para aumentar la cantidad de productos en caja con la tecla +
function maximusp(){
    var maid = $('.p-active').attr('data-id');
    var map = $('.p-active').attr('data-price'); 
    var matc = $('#pro-n-'+maid+' .pro-n').text();
    var exist1 = $('.p-active').attr('data-exis');
    var exist2 = parseInt(exist1);
    var matc1 = parseInt(matc);
    var opc1 = matc1 + 1;

    if (opc1 > exist2){
        showNotification('bottom','center','La cantidad que solicitas sobrepasa el stock','warning');
        return;
    }    

    var sum = $('#suma').val();
    var dt1 = parseFloat(map);
    var dt2 = parseFloat(sum);
    var ope = dt1 + dt2;

    $('#pro-n-'+maid+' .pro-n').text(opc1);
    $('#suma').val(ope.toFixed(2));
    $('.final-price').text(ope.toFixed(2));

}

//Funcion para disminuir la cantidad de productos en caja con la tecla -
function minumusp(){

    var maid = $('.p-active').attr('data-id');
    var map = $('.p-active').attr('data-price'); 
    var matc = $('#pro-n-'+maid+' .pro-n').text();
    var suminpt = $('#suma').val();

    if (suminpt == 0){
        return;
    }
    
    var matc1 = parseInt(matc);
    var opc1 = matc1 - 1;
    if (opc1 < 1){
        showNotification('bottom','center','El producto se elimino de la lista','info');
        $('#pro-n-'+maid).remove();
        $('#caja>div:nth-child(1)').addClass('p-active');
    }else{
        $('#pro-n-'+maid+' .pro-n').text(opc1);
    }

    var sum = $('#suma').val();

    var dt1 = parseFloat(map);
    var dt2 = parseFloat(sum);

    var ope = dt2 - dt1;

    $('#suma').val(ope.toFixed(2));
    $('.final-price').text(ope.toFixed(2));

}

// Limpiar Input Code
function ClearInput(){
    $('#compra').val('');
}

// Suma a la caja por tecla +
$(document).ready(function() {
    $(window).keypress(function(e) {
        if(e.which == 43) {
            maximusp();
            ClearInput();
        }
    }); 
});        
// Resta a la caja por tecla -
$(document).ready(function() {
    $(window).keypress(function(e) {
        if(e.which == 45) {
            minumusp();
            ClearInput();
        }
    }); 
});

//buscar cliente mediante el boton
$("#b-cliente").click(function(){
    let id = $("#identificacion").val();
    buscarcliente(id);
});
//buscar cliente mediante la tecla
$('#identificacion').on('change', function(){
    let id = $("#identificacion").val();
    buscarcliente(id);
});

//inputs cliente
let nit = document.getElementById('identificacion');
let nombre  = document.getElementById('nombre');
let direccion = document.getElementById('direccion');
//Modal Venta
function FinalizarVenta(){
    let total = $("#suma").val();
    if(total == ""){
        total = 0.00;
    }
    $("#paga_contado").html(total);
    $("#paga_credito").html(total);
    $('#pagoconModal').modal('show');
    setTimeout(function(){$('#pagocon').focus();},500);

}

//Activar modal venta por tecla espacio
// $(document).ready(function() {
//     $(window).keypress(function(e) {
//           if(e.which == 32) {
//               FinalizarVenta();
//           }
//     }); 
// });

$(document).ready(function() {
    $(window).keypress(function(e) {
          if(e.which == 13) {
              if ($('#pagoconModal').is(':visible')){
                SendDataCaja();
              }else{
                return;
              }
          }
    }); 
});
//Calcular precio credito
function pmt(tasa, meses, precio_actual, valor_futuro, type){
    valor_futuro = typeof valor_futuro !== 'undefined' ? valor_futuro : 0;
    type = typeof type !== 'undefined' ? type : 0;
    if(tasa != 0.0){
        var q = Math.pow(1 + tasa, meses);
        return (tasa * (valor_futuro + (q * precio_actual))) / ((-1 + q) * (1 + tasa * (type)));

    } else if(meses != 0.0){
        return (valor_futuro + precio_actual) / meses;
    }

    return 0;
}

$(document).on('click','.item',function(){
    $(".item").removeClass("p-active");
    $(this).addClass("p-active");
});