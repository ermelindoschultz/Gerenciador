$(document).ready(function(){
    $(".money").maskMoney(
        showSymbol:true,
        symbol:"R$",
        decimal: ",",
        thousands: "."
    );
    $("input.dinheiro").maskMoney({showSymbol:true, symbol:"R$", decimal:",", thousands:"."});

});