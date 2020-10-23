/**
 * Created by oscarsanchez on 31/08/20.
 */

// Constants.
var HOST = "";
var URI = "?option=com_observatorio&task=getGraphData";
//var COLORS = ["#002269", "#A6E1F6", "#248CC0", "#7CCD53", "#6075A1", "#C7ECF9", "#76B7D8", "#ADE094"];
var COLORS = ["#002269", "#A6E1F6", "#248CC0", "#7CCD53", "#b5a512", "#353a59", "#5d4080", "#066475", "#75123E", "#033942", "#8C3F62", "#7F4680", "#398075", "#8F8000"];
var COLORS_STACKED = ["#9FACC7","#002269","#DEF4FC","#A6E1F6","#ADD4E7","#248CC0","#CEECBF","#7CCD53","#E3DDA6","#b5a512","#B3B5C1","#353a59","#C2B7CF","#5d4080","#A2C5CB","#066475","#BA899F","#75123E","#819CA1","#033942","#D4B7C4","#8C3F62","#CFBACF","#7F4680","#B5CFCB","#398075","#D5CF9F","#8F8000"];
var TRIMESTERS = {
    "1": "Ene-Mar",
    "2": "Abr-Jun",
    "3": "Jul-Sep",
    "4": "Oct-Dic"
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
    var userCountries = jQuery("#user-countries").val();

    var organizationString = "&organization=";
    jQuery(".organization").each(function (index) {
        if (jQuery(this).prop("checked")) {

            organizationString += jQuery(this).val() + ",";

        }
    });

    //organizationString = encodeURIComponent(organizationString);

    result = "&intialTrimester=" + initialTrimester + "&finalTrimester=" + finalTrimester + "&intialYear=" + initialYear + "&finalYear=" + finalYear + organizationString + "&userCountries="+userCountries;

    console.log("REQUEST URL: " + result);

    return result;

}

jQuery(document).ready(function () {


    // Open/Close the filter windows.
    jQuery(".filter-selected-info").click(function (e) {
        e.stopPropagation();

        var newClass = "";
        if (jQuery(this).siblings(".floating-window").hasClass("active")) {
            newClass = "";

        } else {
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
    jQuery(".menu-item-container").click(function () {

        jQuery(".menu-item-container").each(function () {
            jQuery(this).removeClass("active");

        });

        jQuery(this).addClass("active");


        // Showing the graphs group.
        var graphsGroup = jQuery(this).data("graph-group");
        jQuery(".graph-group").hide();
        jQuery(".group-number-" + graphsGroup).show();

        // Changing global variable
        activeGroup = graphsGroup;

        getGroupGraphs(activeGroup);

        // Hide mobile menu if opened.
        jQuery(".menu-main-items-container").removeClass("open");
    });

    // Handling the click on the Hamburger menu
    jQuery(".hamburger-container").click(function(){
        jQuery(".menu-main-items-container").addClass("open");

    });

    jQuery(".close-image-button").click(function(){
        jQuery(".menu-main-items-container").removeClass("open");

    });

    jQuery(".organization").change(function(){
        jQuery(".update-button").removeClass("deactivated");

    });

    jQuery(".update-button").click(function(){
        jQuery("#final-trimester").trigger('change');
    });

    jQuery(".grap-switcher").change(function () {
        jQuery(this).siblings(".switch-title").addClass("hide-title");
        if(jQuery(this).prop("checked")){
            jQuery(this).siblings(".countries").removeClass("hide-title");

        }else{
            jQuery(this).siblings(".organizations").removeClass("hide-title");

        }

        var graphsContainer = jQuery(this).closest(".card-graph-container");
        graphsContainer.find(".graph").toggleClass("hidden-graph");
    });
});