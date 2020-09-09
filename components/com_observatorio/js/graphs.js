/**
 * Created by oscarsanchez on 31/08/20.
 */
function getGroupGraphs(groupNumber) {

    if (groupNumber === "one") {
        graphTotalRiskPopulation();
        graphTotalByMorbidities();
        graphTotalByMedicalAttention();

    }else if(groupNumber === "two"){
        graphComplianceLevelByOrganization();

    }
}


jQuery(document).ready(function () {

    HOST = jQuery("#host").val();


    Highcharts.setOptions({
        lang: {
            noData: 'No se encontraron datos'
        },
        chart: {
            style: {
                fontFamily: 'Open Sans'

            }
        },
        exporting: {
            buttons: {
                contextButton: {
                    menuItems: [
                        'printChart',
                        'separator',
                        'downloadPNG',
                        'downloadJPEG',
                        'downloadPDF',
                        'downloadSVG',
                        'separator',
                        'downloadCSV',
                        'downloadXLS'
                    ]
                }
            }
        }
    });

    // Initially get the group one of graphs.
    getGroupGraphs("one");


    jQuery("#initial-year, #final-year, #initial-trimester, #final-trimester").change(function () {
        getGroupGraphs(activeGroup);

    });
});