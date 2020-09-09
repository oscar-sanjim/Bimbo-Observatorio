/**
 * Created by oscarsanchez on 31/08/20.
 */

function graphComplianceLevelByOrganization() {
    var url = HOST + URI + getFiltersQueryString() + "&graph=compliance_level_by_organization";
    $.ajax({
        url: url,
        type: "get",
        success: function (response) {

            var data = JSON.parse(response);

            var linesData = [];
            var xLabels = [];

            Object.keys(data).forEach(function (index) {

                var values = [];
                data[index].forEach(function (row) {
                    values.push(parseInt(row.nivel_cumplimiento));

                    // Appending X axis labels.
                    if(xLabels.includes(row.year + "-" + TRIMESTERS[row.trimester]) === false){
                        xLabels.push(row.year + "-" + TRIMESTERS[row.trimester]);

                    }
                });


                linesData.push({
                    'name': index,
                    'data': values
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