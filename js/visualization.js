function updateVendasPorProduto(id_produto, ano, id_produto_comparar = false){
    $.post({
        url: "src/ajax/getVendasPorProduto.php",
        type: 'get',
        data: { id_produto, ano, id_produto_comparar},
        success: function(response){
            console.log(response);
            configChart = $.parseJSON(response);
            var ctx = document.getElementById("vendasPorProduto");
            new Chart(ctx, {
                type: configChart.type,
                data: {
                    labels: ["Jan","Fev","Mar","Abr","Mai","Jun","Jul","Ago","Set","Out","Nov","Dez"],
                    datasets: configChart.datasets
                },
                options:{
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                suggestedMax: configChart.maxvalue
                            }
                        }]
                    }   
                }
            });
        },
        error: function(response){
            console.log(response);
        }
    });
}

function updateFaturamentoPorProduto(id_produto, ano, id_produto_comparar = false){
    $.post({
        url: "src/ajax/getFaturamentoPorProduto.php",
        type: 'get',
        data: { id_produto, ano, id_produto_comparar},
        success: function(response){
            //console.log(response);
            configChart = $.parseJSON(response);
            var ctx = document.getElementById("faturamentoPorProduto");
            new Chart(ctx, {
                type: configChart.type,
                data: {
                    labels: ["Jan","Fev","Mar","Abr","Mai","Jun","Jul","Ago","Set","Out","Nov","Dez"],
                    datasets: configChart.datasets
                },
                options:{
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                suggestedMax: configChart.maxvalue
                            }
                        }]
                    }   
                }
            });
        },
        error: function(response){
            console.log(response);
        }
    });
}

function updateFaturamentoPorMes(ano, ano_comparar = false){
    $.post({
        url: "src/ajax/getFaturamentoPorMes.php",
        type: 'get',
        data: { ano, ano_comparar},
        success: function(response){
            //console.log(response);
            configChart = $.parseJSON(response);
            var ctx = document.getElementById("faturamentoPorMes");
            new Chart(ctx, {
                type: configChart.type,
                data: {
                    labels: ["Jan","Fev","Mar","Abr","Mai","Jun","Jul","Ago","Set","Out","Nov","Dez"],
                    datasets: configChart.datasets
                },
                options:{
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                suggestedMax: configChart.maxvalue
                            }
                        }]
                    }   
                }
            });
        },
        error: function(response){
            console.log(response);
        }
    });
}

function updateVendasPorVendedor(id_vendedor, ano, id_vendedor_comparar = false){
    $.post({
        url: "src/ajax/getVendasPorVendedor.php",
        type: 'get',
        data: { id_vendedor, ano, id_vendedor_comparar},
        success: function(response){
            //console.log(response);
            configChart = $.parseJSON(response);
            var ctx = document.getElementById("vendasPorVendedor");
            new Chart(ctx, {
                type: configChart.type,
                data: {
                    labels: ["Jan","Fev","Mar","Abr","Mai","Jun","Jul","Ago","Set","Out","Nov","Dez"],
                    datasets: configChart.datasets
                },
                options:{
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                suggestedMax: configChart.maxvalue
                            }
                        }]
                    }   
                }
            });
        },
        error: function(response){
            console.log(response);
        }
    });
}

function updateFaturamentoPorVendedor(id_vendedor, ano, id_vendedor_comparar = false){
    $.post({
        url: "src/ajax/getFaturamentoPorVendedor.php",
        type: 'get',
        data: { id_vendedor, ano, id_vendedor_comparar},
        success: function(response){
            configChart = $.parseJSON(response);
            var ctx = document.getElementById("faturamentoPorVendedor");
            new Chart(ctx, {
                type: configChart.type,
                data: {
                    labels: ["Jan","Fev","Mar","Abr","Mai","Jun","Jul","Ago","Set","Out","Nov","Dez"],
                    datasets: configChart.datasets
                },
                options:{
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                suggestedMax: configChart.maxvalue
                            }
                        }]
                    }   
                }
            });
        },
        error: function(response){
            console.log(response);
        }
    });
}



$(document).ready(function(){

    $( "#formFaturamentoPorMes" ).change(function() {
        ano = $("#anoFaturaPorMes").val();
        anoComparar = $("#anoCompararFaturaPorMes").val();
        updateFaturamentoPorMes(ano,anoComparar);
    });

    updateFaturamentoPorMes($("#anoFaturaPorMes").val(),$("#anoCompararFaturaPorMes").val());

    $( "#formVendasPorProduto" ).change(function() {
        ano = $("#anoVendasPorProduto").val();
        id_produto = $("#idVendasPorProduto").val();
        id_produto_comparar = $("#idCompararVendasPorProduto").val();
        console.log(id_produto);
        updateVendasPorProduto(id_produto,ano,id_produto_comparar);
    });

    updateVendasPorProduto( $("#idVendasPorProduto").val() , $("#anoVendasPorProduto").val(), $("#idCompararVendasPorProduto").val() );

    $( "#formFaturamentoPorProduto" ).change(function() {
        ano = $("#anoFaturamentoPorProduto").val();
        id_produto = $("#idFaturamentoPorProduto").val();
        id_produto_comparar = $("#idCompararFaturamentoPorProduto").val();
        updateFaturamentoPorProduto(id_produto, ano, id_produto_comparar);
    });

    updateFaturamentoPorProduto( $("#idFaturamentoPorProduto").val() , $("#anoFaturamentoPorProduto").val(), $("#idCompararFaturamentoPorProduto").val() );

    $( "#formVendasPorVendedor" ).change(function() {
        ano = $("#anoVendasPorVendedor").val();
        id_vendedor = $("#idVendasPorVendedor").val();
        id_vendedor_comparar = $("#idCompararVendasPorVendedor").val();
        updateVendasPorVendedor(id_vendedor,ano,id_vendedor_comparar);
    });

    updateVendasPorVendedor( $("#idVendasPorVendedor").val() , $("#anoVendasPorVendedor").val(), $("#idCompararVendasPorVendedor").val() );

    $( "#formFaturamentoPorVendedor" ).change(function() {
        ano = $("#anoFaturamentoPorVendedor").val();
        id_vendedor = $("#idFaturamentoPorVendedor").val();
        id_vendedor_comparar = $("#idCompararFaturamentoPorVendedor").val();
        updateFaturamentoPorVendedor(id_vendedor,ano,id_vendedor_comparar);
    });

    updateFaturamentoPorVendedor( $("#idFaturamentoPorVendedor").val() , $("#anoFaturamentoPorVendedor").val(), $("#idCompararFaturamentoPorVendedor").val() );
});