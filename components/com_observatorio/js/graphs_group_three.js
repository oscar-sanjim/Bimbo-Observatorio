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

                var zones = [{
                    value: 51,
                    color: '#FA0006'
                }, {
                    value: 61,
                    color: '#FDFF0D'
                }, {
                    value: 75,
                    color: '#E0E0DF'
                },{
                    color: '#80CC40'
                }];


                // Survey columns data by type.
                healthColumnsData.push({
                    'name': key + " - Líderes",
                    'display': key,
                    'data': healthSurveyValues,
                    'zones': zones
                });

                energyColumnsData.push({
                    'name': key + " - Líderes",
                    'display': key,
                    'data': energySurveyValues,
                    'zones': zones

                });
                wealthColumnsData.push({
                    'name': key + " - Líderes",
                    'display': key,
                    'data': wealthSurveyValues,
                    'zones': zones
                });
                programsColumnsData.push({
                    'name': key + " - Líderes",
                    'display': key,
                    'data': programsSurveyValues,
                    'zones': zones
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



function graphHealthSurveyByCountry() {


    var url = HOST + URI + getFiltersQueryString() + "&graph=surveys_by_country_and_trimester";
    console.log("URL: " + url);
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

                var zones = [{
                    value: 51,
                    color: '#FA0006'
                }, {
                    value: 61,
                    color: '#FDFF0D'
                }, {
                    value: 75,
                    color: '#E0E0DF'
                },{
                    color: '#80CC40'
                }];


                // Survey columns data by type.
                healthColumnsData.push({
                    'name': key + " - Líderes",
                    'display': key,
                    'data': healthSurveyValues,
                    'zones': zones
                });

                energyColumnsData.push({
                    'name': key + " - Líderes",
                    'display': key,
                    'data': energySurveyValues,
                    'zones': zones

                });
                wealthColumnsData.push({
                    'name': key + " - Líderes",
                    'display': key,
                    'data': wealthSurveyValues,
                    'zones': zones
                });
                programsColumnsData.push({
                    'name': key + " - Líderes",
                    'display': key,
                    'data': programsSurveyValues,
                    'zones': zones
                });
            });



            // Health Survey
            Highcharts.chart('graph-36', {

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
            Highcharts.chart('graph-37', {

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
            Highcharts.chart('graph-38', {

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
            Highcharts.chart('graph-39', {

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