/**
 * Created by oscarsanchez on 31/08/20.
 */

function graphTrainingLeadersAndCollaborators() {


    var url = HOST + URI + getFiltersQueryString() + "&graph=leaders_vs_collaborators_training";
    $.ajax({
        url: url,
        type: "get",
        success: function (response) {

            var data = JSON.parse(response);

            var linesData = [];
            var xLabels = [];
            var counter = 0;

            Object.keys(data).forEach(function (key) {

                var valuesLeaders = [];
                var valuesCollaborators = [];
                data[key].forEach(function (row) {
                    valuesLeaders.push(parseInt(row.capacitacion_lideres_terminado));
                    valuesCollaborators.push(parseInt(row.capacitacion_colaboradores_terminado));

                    // Appending X axis labels.
                    if (xLabels.includes(row.year + "-" + TRIMESTERS[row.trimester]) === false) {
                        xLabels.push(row.year + "-" + TRIMESTERS[row.trimester]);

                    }
                });


                linesData.push({
                    'id': counter++,
                    'name': key + " - Líderes",
                    'display': key,
                    'data': valuesLeaders,
                    'stack': key
                });

                linesData.push({
                    'id': counter++,
                    'name': key + " - Colaboradores",
                    'display': key,
                    'data': valuesCollaborators,
                    'stack': key,
                    'linkedTo': counter - 1,
                });
            });


            var chart;
            chart = Highcharts.chart('graph-23', {

                chart: {
                    type: 'column'
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: xLabels
                },
                yAxis: {
                    allowDecimals: false,
                    min: 0,
                    title: {
                        text: 'Total'
                    }
                },
                colors: COLORS_STACKED,
                tooltip: {
                    formatter: function () {
                        return '<b>' + this.x + '</b><br/>' +
                            this.series.name + ': ' + this.y + '<br/>' +
                            'Total: ' + this.point.stackTotal;
                    }
                },
                plotOptions: {
                    column: {
                        stacking: 'normal'
                    },
                    series: {
                        events: {
                            legendItemClick: function () {
                                var id = this._i;
                                Highcharts.each(this.chart.series, function (p, i) {
                                    if ( (id + 1) === p._i) {
                                        (!p.visible) ? p.show() : p.hide()
                                    }
                                })
                            }
                        },
                        states: {
                            inactive: {
                                opacity: .3
                            }
                        }
                    }
                },
                legend: {
                    labelFormatter: function () {
                        return this.name.split("-")[0];
                    }
                },
                series: linesData
            },
                function (chart){

                    jQuery(chart.series).each(function(i, serie){
                        if(serie.hasOwnProperty("legendItem") ) {

                            jQuery(serie.legendItem.element).hover(function () {
                                highlight(chart.series, serie.stackKey, true);

                            }, function () {
                                highlight(chart.series, serie.stackKey, false);

                            });
                        }else{


                        }
                    });

                    function highlight(series, stackKey, hover) {
                        console.log(stackKey);
                        jQuery(series).each(function (i, serie) {
                            if(serie.stackKey !== stackKey && hover) {
                                jQuery.each(serie.data, function (k, data) {
                                    data.graphic.css({
                                        opacity: .3
                                    });
                                });

                            } else {

                                console.log(serie);
                                jQuery.each(serie.data, function (k, data) {
                                    data.graphic.css({
                                        opacity: 1
                                    });
                                });

                            }
                        });
                    }
                }
            );


        },
        error: function () {


        }
    });


}

function graphTrainingLeadersAndCollaboratorsByCountry() {


    var url = HOST + URI + getFiltersQueryString() + "&graph=leaders_vs_collaborators_training_by_country";
    console.log("URL: " + url);
    $.ajax({
        url: url,
        type: "get",
        success: function (response) {
            console.log(response);
            var data = JSON.parse(response);

            var linesData = [];
            var xLabels = [];
            var counter = 0;

            Object.keys(data).forEach(function (key) {

                var valuesLeaders = [];
                var valuesCollaborators = [];
                data[key].forEach(function (row) {
                    valuesLeaders.push(parseInt(row.capacitacion_lideres_terminado));
                    valuesCollaborators.push(parseInt(row.capacitacion_colaboradores_terminado));

                    // Appending X axis labels.
                    if (xLabels.includes(row.year + "-" + TRIMESTERS[row.trimester]) === false) {
                        xLabels.push(row.year + "-" + TRIMESTERS[row.trimester]);

                    }
                });


                linesData.push({
                    'id': counter++,
                    'name': key + " - Líderes",
                    'display': key,
                    'data': valuesLeaders,
                    'stack': key
                });

                linesData.push({
                    'id': counter++,
                    'name': key + " - Colaboradores",
                    'display': key,
                    'data': valuesCollaborators,
                    'stack': key,
                    'linkedTo': counter - 1,
                });
            });


            var chart;
            chart = Highcharts.chart('graph-25', {

                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: ''
                    },
                    xAxis: {
                        categories: xLabels
                    },
                    yAxis: {
                        allowDecimals: false,
                        min: 0,
                        title: {
                            text: 'Total'
                        }
                    },
                    colors: COLORS_STACKED,
                    tooltip: {
                        formatter: function () {
                            return '<b>' + this.x + '</b><br/>' +
                                this.series.name + ': ' + this.y + '<br/>' +
                                'Total: ' + this.point.stackTotal;
                        }
                    },
                    plotOptions: {
                        column: {
                            stacking: 'normal'
                        },
                        series: {
                            events: {
                                legendItemClick: function () {
                                    var id = this._i;
                                    Highcharts.each(this.chart.series, function (p, i) {
                                        if ( (id + 1) === p._i) {
                                            (!p.visible) ? p.show() : p.hide()
                                        }
                                    })
                                }
                            },
                            states: {
                                inactive: {
                                    opacity: .3
                                }
                            }
                        }
                    },
                    legend: {
                        labelFormatter: function () {
                            return this.name.split("-")[0];
                        }
                    },
                    series: linesData
                },
                function (chart){

                    jQuery(chart.series).each(function(i, serie){
                        if(serie.hasOwnProperty("legendItem") ) {

                            jQuery(serie.legendItem.element).hover(function () {
                                highlight(chart.series, serie.stackKey, true);

                            }, function () {
                                highlight(chart.series, serie.stackKey, false);

                            });
                        }else{


                        }
                    });

                    function highlight(series, stackKey, hover) {
                        console.log(stackKey);
                        jQuery(series).each(function (i, serie) {
                            if(serie.stackKey !== stackKey && hover) {
                                jQuery.each(serie.data, function (k, data) {
                                    data.graphic.css({
                                        opacity: .3
                                    });
                                });

                            } else {

                                console.log(serie);
                                jQuery.each(serie.data, function (k, data) {
                                    data.graphic.css({
                                        opacity: 1
                                    });
                                });

                            }
                        });
                    }
                }
            );


        },
        error: function () {


        }
    });


}

function graphTrainingLeadersPercentage() {


    var url = HOST + URI + getFiltersQueryString() + "&graph=leaders_training_percentage";
    $.ajax({
        url: url,
        type: "get",
        success: function (response) {
            var data = JSON.parse(response);


            var values =[];

            if(data.lideres_terminados > 0 && data.lideres_objetivo > 0) {
                values = [
                    {
                        name: 'Terminados',
                        y: data.lideres_terminados * 100 / (data.lideres_terminados + data.lideres_objetivo),
                        z: sepparateByComma(data.lideres_terminados)
                    },
                    {
                        name: 'Objetivo',
                        y: data.lideres_objetivo * 100 / (data.lideres_terminados + data.lideres_objetivo),
                        z: sepparateByComma(data.lideres_objetivo)
                    }
                ];
            }


            // Radialize the colors
            Highcharts.setOptions({
                colors: Highcharts.map(Highcharts.getOptions().colors, function (color) {
                    return {
                        radialGradient: {
                            cx: 0.5,
                            cy: 0.3,
                            r: 0.7
                        },
                        stops: [
                            [0, color],
                            [1, Highcharts.color(color).brighten(-0.3).get('rgb')] // darken
                        ]
                    };
                })
            });

            // Build the chart
            Highcharts.chart('graph-24', {
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
                    data: values
                }]
            });


        },
        error: function () {


        }
    });


}

function graphTrainingCollaboratorsPercentage() {


    var url = HOST + URI + getFiltersQueryString() + "&graph=collaborators_training_percentage";
    $.ajax({
        url: url,
        type: "get",
        success: function (response) {
            var data = JSON.parse(response);


            var values =[];

            if(data.colaboradores_terminados > 0 && data.colaboradores_objetivo > 0) {
                values = [
                    {
                        name: 'Terminados',
                        y: data.colaboradores_terminados * 100 / (data.colaboradores_terminados + data.colaboradores_objetivo),
                        z: sepparateByComma(data.colaboradores_terminados)
                    },
                    {
                        name: 'Objetivo',
                        y: data.colaboradores_objetivo * 100 / (data.colaboradores_terminados + data.colaboradores_objetivo),
                        z: sepparateByComma(data.colaboradores_objetivo)
                    }
                ];
            }

            // Radialize the colors
            Highcharts.setOptions({
                colors: Highcharts.map(Highcharts.getOptions().colors, function (color) {
                    return {
                        radialGradient: {
                            cx: 0.5,
                            cy: 0.3,
                            r: 0.7
                        },
                        stops: [
                            [0, color],
                            [1, Highcharts.color(color).brighten(-0.3).get('rgb')] // darken
                        ]
                    };
                })
            });

            // Build the chart
            Highcharts.chart('graph-22', {
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
                    name: 'Porcentaje',
                    colorByPoint: true,
                    data: values
                }]
            });


        },
        error: function () {


        }
    });


}