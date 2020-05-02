$(document).ready(function(){
    $(".money").maskMoney({
        showSymbol:true,
        symbol:"R$",
        decimal: ",",
        thousands: "."
    });
});