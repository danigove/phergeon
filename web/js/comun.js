$(document).ready(function(){
    $('#formBusqueda').on('submit', function(e){
        var aux = $(this).find('#inputBusqueda').val();
        if(aux.length > 3){
            $('#formBusqueda').submit();
        }else{
            e.preventDefault();
            alert('Para buscar necesita al menos 3 caracteres');
        }
    });
});
