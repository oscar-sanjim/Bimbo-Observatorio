/**
 * Created by oscarsanchez on 31/08/20.
 */

var HOST = "";
var URI = "?option=com_observatorio&task=getGraphData";

function sepparateByComma(input) {
    input = String(input);
    var nums = input.replace(/,/g, '');
    if (!nums || nums.endsWith('.'))  return;
    return parseFloat(nums).toLocaleString();


}


function getFiltersQueryString() {
    result = "";
    var initialTrimester = jQuery("#initial-trimester").val();
    var finalTrimester = jQuery("#final-trimester").val();
    var initialYear = jQuery("#initial-year").val();
    var finalYear = jQuery("#final-year").val();

    result = "&intialTrimester=" + initialTrimester + "&finalTrimester=" + finalTrimester + "&intialYear=" + initialYear + "&finalYear=" + finalYear;
    return result;

}

function totalRiskPopulation() {
    var url = HOST + URI + getFiltersQueryString() + "&graph=total_colaborators_in_risk";

    $.ajax({
        url: url,
        type: "get",
        success: function (response) {
            var data = JSON.parse(response);
            var difference = parseInt(data.total) - parseInt(data.total_risk)

            jQuery("#general-one").find(".value").html(sepparateByComma(data.total));
            jQuery("#general-two").find(".value").html(sepparateByComma(difference));
            jQuery("#general-three").find(".value").html(sepparateByComma(data.total_risk));

            var chart = // Build the chart
                Highcharts.chart('graph-one', {
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'pie'
                    },
                    colors: ["#002269", "#7CCD53"],
                    title: {
                        text: 'Población en Riesgo'
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
                        data: [
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
                        ]
                    }]
                });


        },
        error: function () {


        }
    });
}

function getMainMenuGraphs() {
    totalRiskPopulation();
}


jQuery(document).ready(function () {

    HOST = jQuery("#host").val();

    getMainMenuGraphs();
});