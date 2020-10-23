function graphTotalsProgramsPerPilar() {


    var url = HOST + URI + getFiltersQueryString() + "&graph=total_programs_per_pilar";
    $.ajax({
        url: url,
        type: "get",
        success: function (response) {
            var data = JSON.parse(response);

            var pilarsNames = [];
            var programsValues = [];

            data.forEach(function (record, index) {
                // key == to organization
                // Survey columns data by type.
                programsValues.push({
                    'name': record.pilar,
                    'y': parseInt(record.total_programas),
                    'color': COLORS[index % COLORS.length]
                });

                pilarsNames.push(record.pilar);
            });




            // Total Absents Data
            Highcharts.chart('graph-101', {
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
                    categories: pilarsNames,
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
                        data: programsValues
                    }

                ],
                legend: {
                    labelFormatter: function () {
                        return names[this.index - 1];
                    }
                }
            });



        },
        error: function () {


        }
    });


}

function graphTotalsProgramsPerOrganization() {


    var url = HOST + URI + getFiltersQueryString() + "&graph=total_programs_per_organization";
    $.ajax({
        url: url,
        type: "get",
        success: function (response) {
            var data = JSON.parse(response);

            var organizationsNames = [];
            var programsValues = [];

            data.forEach(function (record, index) {
                // key == to organization
                // Survey columns data by type.
                programsValues.push({
                    'name': record.organizacion,
                    'y': parseInt(record.total_programas),
                    'color': COLORS[index % COLORS.length]
                });

                organizationsNames.push(record.organizacion);
            });




            // Total Absents Data
            Highcharts.chart('graph-102', {
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
                    categories: organizationsNames,
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
                        data: programsValues
                    }

                ],
                legend: {
                    labelFormatter: function () {
                        return names[this.index - 1];
                    }
                }
            });



        },
        error: function () {


        }
    });


}

function graphTotalsProgramsPerCategory() {


    var url = HOST + URI + getFiltersQueryString() + "&graph=total_programs_per_category";
    $.ajax({
        url: url,
        type: "get",
        success: function (response) {
            var data = JSON.parse(response);

            var categoryNames = [];
            var programsValues = [];

            data.forEach(function (record, index) {
                // key == to organization
                // Survey columns data by type.
                programsValues.push({
                    'name': record.categoria,
                    'y': parseInt(record.total_programas),
                    'color': COLORS[index % COLORS.length]
                });

                categoryNames.push(record.categoria);
            });




            // Total Absents Data
            Highcharts.chart('graph-103', {
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
                    categories: categoryNames,
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
                        data: programsValues
                    }

                ],
                legend: {
                    labelFormatter: function () {
                        return names[this.index - 1];
                    }
                }
            });



        },
        error: function () {


        }
    });


}

function graphTotalsParticipationsPerPilar() {


    var url = HOST + URI + getFiltersQueryString() + "&graph=total_participations_per_pilar";
    console.log("Test: " + url);
    $.ajax({
        url: url,
        type: "get",
        success: function (response) {
            var data = JSON.parse(response);

            var pilarNames = [];
            var participationValues = [];

            data.forEach(function (record, index) {
                // key == to organization
                // Survey columns data by type.
                participationValues.push({
                    'name': record.pilar,
                    'y': parseInt(record.total_participaciones),
                    'color': COLORS[index % COLORS.length]
                });

                pilarNames.push(record.pilar);
            });




            // Total Absents Data
            Highcharts.chart('graph-104', {
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
                    categories: pilarNames,
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
                        data: participationValues
                    }

                ],
                legend: {
                    labelFormatter: function () {
                        return names[this.index - 1];
                    }
                }
            });



        },
        error: function () {


        }
    });


}

function graphTotalsParticipationsPerOrganization() {


    var url = HOST + URI + getFiltersQueryString() + "&graph=total_participations_per_organization";
    $.ajax({
        url: url,
        type: "get",
        success: function (response) {
            var data = JSON.parse(response);

            var organizationNames = [];
            var participationValues = [];

            data.forEach(function (record, index) {
                // key == to organization
                // Survey columns data by type.
                participationValues.push({
                    'name': record.organizacion,
                    'y': parseInt(record.total_participaciones),
                    'color': COLORS[index % COLORS.length]
                });

                organizationNames.push(record.organizacion);
            });




            // Total Absents Data
            Highcharts.chart('graph-105', {
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
                    categories: organizationNames,
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
                        data: participationValues
                    }

                ],
                legend: {
                    labelFormatter: function () {
                        return names[this.index - 1];
                    }
                }
            });



        },
        error: function () {


        }
    });


}

function graphTotalsParticipationsPerCategory() {


    var url = HOST + URI + getFiltersQueryString() + "&graph=total_participations_per_category";
    $.ajax({
        url: url,
        type: "get",
        success: function (response) {
            var data = JSON.parse(response);

            var categoryNames = [];
            var participationValues = [];

            data.forEach(function (record, index) {
                // key == to organization
                // Survey columns data by type.
                participationValues.push({
                    'name': record.categoria,
                    'y': parseInt(record.total_participaciones),
                    'color': COLORS[index % COLORS.length]
                });

                categoryNames.push(record.categoria);
            });




            // Total Absents Data
            Highcharts.chart('graph-106', {
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
                    categories: categoryNames,
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
                        data: participationValues
                    }

                ],
                legend: {
                    labelFormatter: function () {
                        return names[this.index - 1];
                    }
                }
            });



        },
        error: function () {


        }
    });


}

function getProgramsGeneralData() {


    var url = HOST + URI + getFiltersQueryString() + "&graph=programs_general_data";


    $.ajax({
        url: url,
        type: "get",
        success: function (response) {
            var data = JSON.parse(response);

            jQuery("#programs-general-one").find(".value").html((data.total_programas !== null) ? sepparateByComma(data.total_programas) : "-");
            jQuery("#programs-general-two").find(".value").html((data.total_participaciones !== null) ? sepparateByComma(data.total_participaciones) : "-");



        },
        error: function () {


        }
    });


}


