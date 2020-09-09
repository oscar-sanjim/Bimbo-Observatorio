/**
 * Created by oscarsanchez on 31/08/20.
 */

// Constants.
var HOST = "";
var URI = "?option=com_observatorio&task=getGraphData";
var COLORS = ["#002269", "#A6E1F6", "#248CC0", "#7CCD53", "#6075A1", "#C7ECF9", "#76B7D8", "#ADE094"];
var TRIMESTERS = {
    "1" : "Ene-Mar",
    "2" : "Abr-Jun",
    "3" : "Jul-Sep",
    "4" : "Oct-Dic"
};

// Globals
var activeGroup = "one";


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

jQuery(document).ready(function(){

    // Open/Close the filter windows.
    jQuery(".filter-selected-info").click(function(e){
        e.stopPropagation();

        var newClass = "";
        if(jQuery(this).siblings(".floating-window").hasClass("active")){
            newClass = "";

        }else{
            newClass = "active";

        }

        jQuery(".floating-window").removeClass("active");
        jQuery(this).siblings(".floating-window").addClass(newClass);
        jQuery(".filter-selected-info").children().removeClass("active");
        jQuery(this).children().addClass(newClass);

    });

    // Activate the nice selects.
    jQuery('select').niceSelect();

    // Managing the clicks on the navigation items.
    jQuery(".menu-item-container").click(function(){
        jQuery(".menu-item-container").each(function(){
            jQuery(this).removeClass("active");

        });

        jQuery(this).addClass("active");


        // Showing the graphs group.
        var graphsGroup = jQuery(this).data("graph-group");
        jQuery(".graph-group").hide();
        jQuery(".group-number-"+graphsGroup).show();

        // Changing global variable
        activeGroup = graphsGroup;

        getGroupGraphs(activeGroup);
    });
});