/**
 * Created by oscarsanchez on 31/08/20.
 */
function getGroupGraphs(groupNumber) {

    if (groupNumber === "one") {
        graphTotalRiskPopulation();
        graphTotalByMorbidities();
        graphTotalByMedicalAttention();
        graphAbsentsTypes();
        graphTotalsAbsentsByCountry()
        graphTotalsAbsents();

    }else if(groupNumber === "two"){
        graphTrainingLeadersAndCollaborators();
        graphTrainingLeadersPercentage();
        graphTrainingCollaboratorsPercentage();
        graphTrainingLeadersAndCollaboratorsByCountry();

    }else if(groupNumber === "three"){
        graphHealthSurvey();
        graphHealthSurveyByCountry();


    }else if(groupNumber === "four"){

        graphComplianceLevelByOrganization();
        graphTotalsProgramsPerPilar();
        graphTotalsProgramsPerOrganization();
        graphTotalsProgramsPerCategory();
        graphTotalsParticipationsPerPilar();
        graphTotalsParticipationsPerOrganization();
        graphTotalsParticipationsPerCategory();
        getProgramsGeneralData();

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
                        'viewFullscreen',
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

    function updateFilterDisplays(){
        var initYear = jQuery("#initial-year").val();
        var finYear = jQuery("#final-year").val();
        var initTrim = jQuery("#initial-trimester").val();
        var finTrim = jQuery("#final-trimester").val();

        var filtersString = "";
        switch(parseInt(initTrim)){
            case 1:
                filtersString += "Ene";
                break;
            case 2:
                filtersString += "Abr";
                break;
            case 3:
                filtersString += "Jul";
                break;
            case 4:
                filtersString += "Oct";
                break;

        }

        filtersString += " " + initYear + " / ";

        switch(parseInt(finTrim)){
            case 1:
                filtersString += "Mar";
                break;
            case 2:
                filtersString += "Jun";
                break;
            case 3:
                filtersString += "Sep";
                break;
            case 4:
                filtersString += "Dic";
                break;

        }

        filtersString += " " + finYear;
        jQuery("#date-filter-value").html(filtersString);
    }


    jQuery("#initial-year, #final-year, #initial-trimester, #final-trimester").change(function () {
        updateFilterDisplays();
        getGroupGraphs(activeGroup);
        jQuery(".update-button").addClass("deactivated");

    });

    updateFilterDisplays();
});