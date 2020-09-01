/**
 * Created by oscarsanchez on 31/08/20.
 */

var HOST = "";
var URI = "?option=com_observatorio&task=getGraphData";


function getFiltersQueryString(){
    result = "";
    var initialTrimester = jQuery("#initial-trimester").val();
    var finalTrimester = jQuery("#final-trimester").val();
    var initialYear = jQuery("#initial-year").val();
    var finalYear = jQuery("#final-year").val();

    result = "&intialTrimester="+initialTrimester+"&finalTrimester="+finalTrimester+"&intialYear="+initialYear+"&finalYear="+finalYear;
    return result;

}

function totalRiskPopulation(){
    var url = HOST + URI + getFiltersQueryString() + "&graph=total_colaborators_in_risk";

    $.ajax({
        url: url,
        type: "get",
        success: function (response) {
            var data = JSON.parse(response);
            jQuery("#general-one").find(".value").html(data.total);
            jQuery("#general-two").find(".value").html(data.total_risk);

        },
        error: function () {


        }
    });
}

function getMainMenuGraphs(){
    totalRiskPopulation();
}


jQuery(document).ready(function(){

    HOST = jQuery("#host").val();

    getMainMenuGraphs();
});