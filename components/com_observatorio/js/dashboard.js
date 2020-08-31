/**
 * Created by oscarsanchez on 31/08/20.
 */
jQuery(document).ready(function(){

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

    });

    // Activate the nice selects.
    jQuery('select').niceSelect();

    // Managing the clicks on the navigation items.
    jQuery(".menu-item-container").click(function(){
        jQuery(".menu-item-container").each(function(){
            jQuery(this).removeClass("active");

        });

        jQuery(this).addClass("active");
    });
});