jQuery(function ($) {

    $("#adminForm").submit(function(e) {

        e.preventDefault();

        if(!$("#jform_file_upload").val()){
            alert("Seleccione un archivo para continuar");
            return false;
        }

        var host = $("#host").val();
        var year = $("#jform_year").val();
        var trimester = $("#jform_trimester").val();
        var uri = "?option=com_observatorio&task=checkIfTrimesterExists&year=" + year + "&trimester=" + trimester;

        $.ajax({
            url: host + uri,
            type: "get",
            async: false,
            success: function (response) {
                var json = JSON.parse(response);
                if (json.status) {
                    var confirmation = confirm("Ya esxite un registro para este trimestre. Continuar eliminará registro previos.");
                    if (confirmation) {
                        $("#adminForm").unbind().submit();

                    } else {
                        return false;

                    }
                } else {
                    $("#adminForm").unbind().submit();

                }
            },
            error: function () {
                console.log("Error");
                return false;

            }
        });
    });
});
