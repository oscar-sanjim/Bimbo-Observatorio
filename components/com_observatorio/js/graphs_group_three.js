function graphHealthSurvey() {


    var url = HOST + URI + getFiltersQueryString() + "&graph=surveys_by_organization_and_trimester";
    $.ajax({
        url: url,
        type: "get",
        success: function (response) {

            var data = JSON.parse(response);

            var healthColumnsData = [];
            var energyColumnsData = [];
            var wealthColumnsData = [];
            var programsColumnsData = [];
            var xLabels = [];
            var counter = 0;

            Object.keys(data).forEach(function (key) {
                // key == to organization

                var healthSurveyValues = [];
                var energySurveyValues = [];
                var wealthSurveyValues = [];
                var programsSurveyValues = [];

                data[key].forEach(function (row) {

                    healthSurveyValues.push(parseInt(row.healt_survey_totals));
                    energySurveyValues.push(parseInt(row.energy_survey_totals));
                    wealthSurveyValues.push(parseInt(row.wealth_survey_totals));
                    programsSurveyValues.push(parseInt(row.programs_survey_totals));

                    // Appending X axis labels.
                    if (xLabels.includes(row.year + "-" + TRIMESTERS[row.trimester]) === false) {
                        xLabels.push(row.year + "-" + TRIMESTERS[row.trimester]);

                    }
                });

                // Survey columns data by type.
                healthColumnsData.push({
                    'name': key + " - Líderes",
                    'display': key,
                    'data': healthSurveyValues
                });

                energyColumnsData.push({
                    'name': key + " - Líderes",
                    'display': key,
                    'data': energySurveyValues
                });
                wealthColumnsData.push({
                    'name': key + " - Líderes",
                    'display': key,
                    'data': wealthSurveyValues
                });
                programsColumnsData.push({
                    'name': key + " - Líderes",
                    'display': key,
                    'data': programsSurveyValues
                });
            });



            // Health Survey
            Highcharts.chart('graph-31', {

                chart: {
                    type: 'column'
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: xLabels,
                    min: 0,
                    max: (healthColumnsData[0].data.length > 2) ? 1 : healthColumnsData[0].data.length - 1,
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
                            this.series.name + ': ' + this.y + '<br/>' +
                            'Total: ' + this.point.stackTotal;
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
                series: healthColumnsData
            });

            // Energy Survey
            Highcharts.chart('graph-32', {

                chart: {
                    type: 'column'
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: xLabels,
                    min: 0,
                    max: (energyColumnsData[0].data.length > 2) ? 1 : energyColumnsData[0].data.length - 1,
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
                            this.series.name + ': ' + this.y + '<br/>' +
                            'Total: ' + this.point.stackTotal;
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
                series: energyColumnsData
            });

            // Wealth Survey
            Highcharts.chart('graph-33', {

                chart: {
                    type: 'column'
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: xLabels,
                    min: 0,
                    max: (wealthColumnsData[0].data.length > 2) ? 1 : wealthColumnsData[0].data.length - 1,
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
                            this.series.name + ': ' + this.y + '<br/>' +
                            'Total: ' + this.point.stackTotal;
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
                series: wealthColumnsData
            });

            // Programs Survey
            Highcharts.chart('graph-34', {

                chart: {
                    type: 'column'
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: xLabels,
                    min: 0,
                    max: (programsColumnsData[0].data.length > 2) ? 1 : programsColumnsData[0].data.length - 1,
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
                            this.series.name + ': ' + this.y + '<br/>' +
                            'Total: ' + this.point.stackTotal;
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
                series: programsColumnsData
            });


        },
        error: function () {


        }
    });


}