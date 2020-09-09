/**
 * Created by oscarsanchez on 31/08/20.
 */


/**
 * Retrieves the total of healthy/sick collaborators.
 */
function graphTotalRiskPopulation() {
    var url = HOST + URI + getFiltersQueryString() + "&graph=total_colaborators_in_risk";

    $.ajax({
        url: url,
        type: "get",
        success: function (response) {

            var data = JSON.parse(response);
            var difference = (data.total !== null && data.total_risk !== null) ? (parseInt(data.total) - parseInt(data.total_risk)) : null;

            jQuery("#general-one").find(".value").html((data.total !== null) ? sepparateByComma(data.total) : "-");
            jQuery("#general-two").find(".value").html((difference !== null) ? sepparateByComma(difference) : "-");
            jQuery("#general-three").find(".value").html((data.total_risk !== null) ? sepparateByComma(data.total_risk) : "-");


            var pieChartData = [];
            if(data.total !== null && data.total_risk !== null){
                pieChartData = [
                    {
                        name: 'Furea de riesgo',
                        y: 100 - data.percentage_risk,
                        sliced: true,
                        selected: true
                    },
                    {
                        name: 'En riesgo',
                        y: data.percentage_risk,
                        sliced: true,
                        selected: true
                    }
                ];
            }

            Highcharts.chart('graph-one', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                colors: COLORS,
                title: {
                    text: ''
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: false
                        },
                        showInLegend: true
                    }
                },
                series: [{
                    name: 'Población',
                    colorByPoint: true,
                    data: pieChartData
                }]
            });


        },
        error: function () {


        }
    });
}

/**
 * Retrieves the total by type of medical attention and renders 2 graphs: bars and percentage.
 */
function graphTotalByMorbidities() {
    var url = HOST + URI + getFiltersQueryString() + "&graph=total_by_morbidities";

    $.ajax({
        url: url,
        type: "get",
        success: function (response) {
            var data = JSON.parse(response);


            var morbiditiesAlias = [];
            var morbiditiesTotals = [];
            var morbiditiesPercetage = [];
            data.morbidities.forEach(function (morbidityData, index) {
                morbiditiesAlias.push(morbidityData.morbidity_alias);
                morbiditiesTotals.push({
                    "y": parseInt(morbidityData.morbidity_total),
                    "color": "#7CCD53"
                });

                morbiditiesPercetage.push({
                    name: morbidityData.morbidity_alias,
                    y: morbidityData.morbidity_total * 100 / data.total,
                    sliced: (index === 0),
                    selected: (index === 0)
                });

            });


            // Graph number two.
            var chart = // Build the chart
                Highcharts.chart('graph-two', {
                    chart: {
                        renderTo: 'container',
                        type: 'bar',
                        marginBottom: 0,
                        height: 470
                    },
                    colors: COLORS,
                    legend: {
                        enabled: false
                    },
                    xAxis: {
                        categories: morbiditiesAlias,
                        labels: {
                            padding: 5,
                            align: 'left',
                            x: 0,
                            y: (-1 * data.morbidities.length) - 15, /* to be adjusted according to number of bars*/
                            style: {
                                fontSize: "14px",
                                color: "#002269"
                            }
                        },
                        lineWidth: 0,
                        gridLineWidth: 0,
                        lineColor: '#002269',
                        minorTickLength: 0,
                        tickLength: 0,
                        title: {
                            enabled: false
                        }

                    },
                    yAxis: {
                        lineWidth: 0,
                        gridLineWidth: 0,
                        lineColor: '#333333',
                        labels: {
                            enabled: false
                        },
                        minorTickLength: 0,
                        tickLength: 0,
                        title: {
                            enabled: false
                        }
                    },
                    plotOptions: {
                        bar: {
                            stacking: "normal",
                            //groupPadding: 0, //add here
                            //pointPadding: 0, //add here,
                            dataLabels: {
                                enabled: true,
                                color: 'white',
                                align: 'left'
                            },
                            grouping: false
                        }
                    },
                    title: {
                        text: "",
                    },
                    series: [{
                        data: morbiditiesTotals,
                        name: "Total",

                    }]
                });


            // Chart number five.
            Highcharts.chart('graph-five', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: ''
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: false
                        },
                        showInLegend: true
                    }
                },
                colors: COLORS.reverse(),
                series: [{
                    name: 'Porcentaje',
                    colorByPoint: true,
                    data: morbiditiesPercetage
                }]
            });


        },
        error: function () {


        }
    });
}


/**
 * Retrieves the total by type of medical attention and renders 2 graphs: bars and percentage.
 */
function graphTotalByMedicalAttention() {
    var url = HOST + URI + getFiltersQueryString() + "&graph=get_totals_by_type_of_medical_attention";

    $.ajax({
        url: url,
        type: "get",
        success: function (response) {

            var data = JSON.parse(response);

            var pieChartData = [];
            var secondPieChartData = [];
            if(
                data.total_collaborators !== null &&
                data.total_risk !== null &&
                data.red_coaboradores !== null &&
                data.programas_generales_colaboradores !== null
            ){
                pieChartData = [
                    {y: parseInt(data.total_collaborators), name: 'Total de Colaboradores', color: COLORS[0]},
                    {y: parseInt(data.total_risk), name: 'Colaboradores en Riesgo', color: COLORS[1]},
                    {
                        y: parseInt(data.red_coaboradores),
                        name: 'Atención con nuestra red de médicos',
                        color: COLORS[2]
                    },
                    {
                        y: parseInt(data.programas_generales_colaboradores),
                        name: 'Atención en programas médicos gerales',
                        color: COLORS[3]
                    }
                ];


                secondPieChartData = [{
                    name: 'Atención con nuestra red de médicos',
                    y: data.red_coaboradores * 100 / (data.red_coaboradores + data.programas_generales_colaboradores ),
                    sliced: true,
                    selected: true
                }, {
                    name: 'Atención en programas generales',
                    y: data.programas_generales_colaboradores * 100 / (data.red_coaboradores + data.programas_generales_colaboradores )
                }];
            }

            // Chart number three.
            Highcharts.chart('graph-three', {
                chart: {
                    type: 'column'
                },
                colors: COLORS,
                title: {
                    text: ''
                },
                subtitle: {
                    text: ''
                },
                xAxis: {
                    categories: [
                        'Totales',
                        'Riesgo',
                        'Red',
                        'Generales'
                    ],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Número de colaboradores'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [
                    {
                        pointWidth: 20,
                        showInLegend: false,
                        data: pieChartData
                    }

                ],
                legend: {
                    labelFormatter: function () {
                        return names[this.index - 1];
                    }
                }
            });

            // Chart number four.
            Highcharts.chart('graph-four', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: ''
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: false
                        },
                        showInLegend: true
                    }
                },
                colors: COLORS.reverse(),
                series: [{
                    name: 'Porcentaje',
                    colorByPoint: true,
                    data: secondPieChartData
                }]
            });


        },
        error: function () {


        }
    });
}
