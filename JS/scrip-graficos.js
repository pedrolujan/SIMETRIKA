$(document).on("click", "#gbTotalProspectos", function () {
    $("#txtItemABuscar").val("totalProspectos");
    cargarDatos_ParaGraficaBar();
    cargarDatos_ParaGrafica();
})
$(document).on("click", "#gbProspectosSeguidos", function () {
    $("#txtItemABuscar").val("prospectosSeguidos");
    cargarDatos_ParaGraficaBar();
    cargarDatos_ParaGrafica();
})
$(document).on("click", "#gbTotalVentas", function () {
    $("#txtItemABuscar").val("totalVentas");
    cargarDatos_ParaGraficaBar();
    cargarDatos_ParaGrafica();
})
/* codigo para los graficos del dashboarda del administrador */

const actions = [{
        name: 'Position: bottom',
        handler(chart) {
            chart.options.plugins.legend.position = 'bottom';
            chart.update();
        }
    },];
Graficopie();
function Graficopie() {
    let vacio = 0;
    $.ajax({data: {
            vacio
        }, url: "controller/controlador-graficos.php", type: "post"}).done(function (resp) {
        console.log(resp);
        if (resp.length > 0) {
            let titulo = [];
            let cantidad = [];
            let colores = [];
            let datos = JSON.parse(resp);
            let item = "";
            datos.forEach((element) => {
                titulo.push(element["fecha"]);
                cantidad.push(element["cantidad"]);
                colores.push(colorRGB());
            });
            crear_graficos(titulo, cantidad, colores, "bar", "grafico por año", "GraficoFiltrado");
            crear_graficosCircular(titulo, cantidad, colores, "pie", "grafico de barras normal", "graficopie");
        }
    });
}

/* genero numero para colores */
function generarNumero(numero) {
    return(Math.random() * numero).toFixed(0);
}
/* genero colores aleatorias */
function colorRGB() {
    let coolor = "(" + generarNumero(255) + "," + generarNumero(255) + "," + generarNumero(255) + ")";
    return "rgb" + coolor;
}

/* jalo los graficos cuando inicia el programa co cuando damos click */
cargarDatos_ParaGraficaBar();
cargarDatos_ParaGrafica();

$(document).on("click", "#btnBuscarEstadistica", function () {
    cargarDatos_ParaGraficaBar();
    cargarDatos_ParaGrafica();
    // alertasDashboardAdmin();
});


/* filtro por las fechas */
function cargarDatos_ParaGraficaBar() {
    let itemDashboard = $("#txtItemABuscar").val();
    let fechaIni = $("#fecha_inicio").val();
    let fechaFin = $("#fecha_final").val();
    let cboIdCampania = $("#CboCampania").val();
    let cboIdCurso = ($("#CboCursos").val() == null) ? 0 : $("#CboCursos").val();

    $.ajax({
        url: "controller/controlador-graficosBar.php",
        type: "post",
        data: {
            fechaIni,
            fechaFin,
            itemDashboard,
            cboIdCampania,
            cboIdCurso
        }
    }).done(function (resp) {
        if (resp.length > 0) {

            let titulo = [];
            let cantidad = [];
            let colores = [];
            let tipoGrafica = "";
            let datos = JSON.parse(resp);

            datos.forEach((element) => {

                titulo.push(`${
                    element.fecha
                }`);
                cantidad.push(`${
                    element.cantidad
                }`);
                colores.push(colorRGB());
                tipoGrafica = `${
                    element.tipoGrafica
                }`;
            });

            myChart.destroy();

            crear_graficos(titulo, cantidad, colores, "bar", tipoGrafica, "GraficoFiltrado");
        }
    });
}
function cargarDatos_ParaGrafica() {
    let itemDashboard = $("#txtItemABuscar").val();
    let fechaIni = $("#fecha_inicio").val();
    let fechaFin = $("#fecha_final").val();
    let cboIdCampania = $("#CboCampania").val();
    let cboIdCurso = ($("#CboCursos").val() == null) ? 0 : $("#CboCursos").val();

    $.ajax({
        url: "controller/controlador-graficos.php",
        type: "post",
        data: {
            fechaIni,
            fechaFin,
            itemDashboard,
            cboIdCampania,
            cboIdCurso
        }
    }).done(function (resp) {
        if (resp.length > 0) {

            let titulo = [];
            let titulo1 = [];
            let cantidad = [];
            let colores = [];
            let tipoGrafica = "";
            let datos = JSON.parse(resp);

            datos.forEach((element) => {

                titulo.push(`${
                    element.nombreCruso
                }`);
                // titulo1.push(`${element.fecha}`);
                cantidad.push(`${
                    element.cantidad
                }`);
                colores.push(colorRGB());
                tipoGrafica = `${
                    element.tipoGrafica
                }`;
            });

            // myChart.destroy();
            myChartCircular.destroy();

            // crear_graficos(titulo1,cantidad,colores,"bar",tipoGrafica,"GraficoFiltrado");
            crear_graficosCircular(titulo, cantidad, colores, "bar", tipoGrafica, "graficopie");
        }
    });
}

// /////////////////////////Genero los graficos///////////////////////
var myChart;
var myChartCircular;

function crear_graficos(titulo, cantidad, colores, tipo, encabezado, id) {
    var idCanva = document.getElementById(id);
    myChart = new Chart(idCanva, {
        type: tipo,
        data: {
            labels: titulo,
            datasets: [
                {
                    label: encabezado,
                    data: cantidad,
                    backgroundColor: colores,
                    borderColor: colores,
                    borderWidth: 1
                },
            ]
        },
        options: {
            legend: {
                position: "top"
            },
            plugins: {
                title: {
                    display: true,
                    padding: {
                        top: 100,
                        bottom: 0
                    }
                }
            },
            scales: {
                yAxes: [
                    {
                        ticks: {
                            beginAtZero: true
                        }
                    },
                ]
            }
        }
    });
}
function crear_graficosCircular(titulo, cantidad, colores, tipo, encabezado, id) {
    var idCanva = document.getElementById(id);
    myChartCircular = new Chart(idCanva, {
        type: tipo,
        data: {
            labels: titulo,
            datasets: [
                {
                    label: encabezado,
                    data: cantidad,
                    backgroundColor: colores,
                    borderColor: colores,
                    borderWidth: 1
                },
            ]
        },
        options: {
            scales: {
                yAxes: [
                    {
                        ticks: {
                            beginAtZero: true
                        }
                    },
                ]
            }
        }
    });
}
