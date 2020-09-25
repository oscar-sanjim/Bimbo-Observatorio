function graphTotalsAbsents() {


    var url = HOST + URI + getFiltersQueryString() + "&graph=total_absents_by_organization_and_date";
    $.ajax({
        url: url,
        type: "get",
        success: function (response) {
            var data = JSON.parse(response);

            var absentsData = [];
            var xLabels = [];

            Object.keys(data).forEach(function (key) {
                // key == to organization

                var absentsValues = [];

                data[key].forEach(function (row) {

                    absentsValues.push(parseInt(row.total_absents));

                    // Appending X axis labels.
                    if (xLabels.includes(row.year + "-" + TRIMESTERS[row.trimester]) === false) {
                        xLabels.push(row.year + "-" + TRIMESTERS[row.trimester]);

                    }
                });

                // Survey columns data by type.
                absentsData.push({
                    'name': key,
                    'display': key,
                    'data': absentsValues
                });
            });



            // Total Absents Data
            Highcharts.chart('graph-41', {

                chart: {
                    type: 'column'
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: xLabels,
                    min: 0,
                    max: (absentsData[0].data.length > 2) ? 1 : absentsData[0].data.length - 1,
                    scrollbar: {
                        enabled: true
                    },
                    tickLength: 0
                },
                yAxis: {
                    allowDecimals: false,
                    min: 0,
                    title: {
                        text: 'Total'
                    }
                },
                colors: COLORS,
                tooltip: {
                    formatter: function () {
                        return '<b>' + this.x + '</b><br/>' +
                            this.series.name + ': ' + this.y + '<br/>'
                    }
                },

                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                legend: {
                    labelFormatter: function () {
                        return this.name.split("-")[0];
                    }
                },
                series: absentsData
            });



        },
        error: function () {


        }
    });


}


function graphTotalsAbsentsByCountry() {


    var url = HOST + URI + getFiltersQueryString() + "&graph=total_absents_by_country_and_date";
    $.ajax({
        url: url,
        type: "get",
        success: function (response) {
            var data = JSON.parse(response);

            var absentsData = [];
            var xLabels = [];

            Object.keys(data).forEach(function (key) {
                // key == to organization

                var absentsValues = [];

                data[key].forEach(function (row) {

                    absentsValues.push(parseInt(row.total_absents));

                    // Appending X axis labels.
                    if (xLabels.includes(row.year + "-" + TRIMESTERS[row.trimester]) === false) {
                        xLabels.push(row.year + "-" + TRIMESTERS[row.trimester]);

                    }
                });

                // Survey columns data by type.
                absentsData.push({
                    'name': key,
                    'display': key,
                    'data': absentsValues
                });
            });



            // Total Absents Data
            Highcharts.chart('graph-46', {

                chart: {
                    type: 'column'
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: xLabels,
                    min: 0,
                    max: (absentsData[0].data.length > 2) ? 1 : absentsData[0].data.length - 1,
                    scrollbar: {
                        enabled: true
                    },
                    tickLength: 0
                },
                yAxis: {
                    allowDecimals: false,
                    min: 0,
                    title: {
                        text: 'Total'
                    }
                },
                colors: COLORS,
                tooltip: {
                    formatter: function () {
                        return '<b>' + this.x + '</b><br/>' +
                            this.series.name + ': ' + this.y + '<br/>'
                    }
                },

                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                legend: {
                    labelFormatter: function () {
                        return this.name.split("-")[0];
                    }
                },
                series: absentsData
            });



        },
        error: function () {


        }
    });


}


function graphAbsentsTypes() {


    var url = HOST + URI + getFiltersQueryString() + "&graph=percentage_absents_by_type";
    $.ajax({
        url: url,
        type: "get",
        success: function (response) {

            var data = JSON.parse(response);


            var pieChartData = [];
            if(data.total !== null && data.total_risk !== null){
                pieChartData = [
                    {
                        name: 'Generales',
                        y: data.percentage_general,
                        sliced: true,
                        selected: true,
                        z: data.total_general
                    },
                    {
                        name: 'Prevenibles',
                        y: data.percentage_preventable,

                        z: data.total_preventable
                    },
                    {
                        name: 'Mentales',
                        y: data.percentage_mental,

                        z: data.total_mental

                    }
                ];
            }


            // Total Absents Data
            Highcharts.chart('graph-42', {
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
                    formatter: function () {
                        return '{series.name}: <b>'+Number.parseFloat(this.point.percentage).toFixed(2)+'%</b><br>Total: ' + this.point.z
                    }
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

function graphComplianceLevelByOrganization() {
    var url = HOST + URI + getFiltersQueryString() + "&graph=compliance_level_by_organization";
    $.ajax({
        url: url,
        type: "get",
        success: function (response) {

            var data = JSON.parse(response);

            var linesData = [];
            var xLabels = [];
            var counter = 0;

            Object.keys(data).forEach(function (key) {

                var values = [];
                data[key].forEach(function (row) {
                    values.push(parseInt(row.nivel_cumplimiento));

                    // Appending X axis labels.
                    if (xLabels.includes(row.year + "-" + TRIMESTERS[row.trimester]) === false) {
                        xLabels.push(row.year + "-" + TRIMESTERS[row.trimester]);

                    }
                });


                linesData.push({
                    'name': key,
                    'data': values,
                    'visible': (counter++ < 5)
                });
            });


            Highcharts.chart('graph-21', {
                title: {
                    text: ''
                },
                subtitle: {
                    text: ''
                },
                colors: COLORS,
                yAxis: {
                    title: {
                        text: 'Nivel de Cumplimiento'
                    }
                },
                xAxis: {
                    categories: xLabels
                },

                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle'
                },

                plotOptions: {
                    series: {
                        label: {
                            connectorAllowed: false
                        }
                    }
                },

                series: linesData,

                responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 500
                        },
                        chartOptions: {
                            legend: {
                                layout: 'horizontal',
                                align: 'center',
                                verticalAlign: 'bottom'
                            }
                        }
                    }]
                }

            });


        },
        error: function () {


        }
    });
}