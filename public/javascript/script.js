$(document).ready(function () {
    var baseURI = "http://localhost/cmsManagementSystem/public";

    $('.showSearch').click(function () {
        //show loading icon

        var showSearchButtonID = $(this).attr("id");
        var filterElement = $('div.' + showSearchButtonID);
        var form = filterElement.find('form');

        //finding all checked radio buttons
        var checkedButtons = form.find('input[type=radio]:checked');

        //each result have the condition name with the corresponding table name
        var results = [];
        var i = 0;
        checkedButtons.each(function () {
            i++;
            //fieldsetParent is the table name
            var fieldsetParent = $(this).parent('fieldset').attr('class');
            results[i] = [fieldsetParent, $(this).val()];
        });

        //send conditions to controller by ajax
        $.ajax({
            type: 'POST',
            url: baseURI + "/showSearch",
            dataType: "json",
            data: JSON.stringify(results),
            success: function (data) {
                // Show search boxes and fill them with results
                var search = null;

                if (showSearchButtonID == 'contributorsFilters') {
                    search = "<div class=\"contributorsSearchByUsername\">\n" +
                        "                <label for=\"searchUsername\">\n" +
                        "                    <input type=\"text\" name=\"searchUsername\" id=\"searchUsername\">\n" +
                        "                </label>\n" +
                        "                <button type=\"button\" id=\"contributorsFiltersPost\">search</button>\n" +
                        "            </div>";
                } else if (showSearchButtonID == 'usePublishedArticlesFilters') {
                    search = "<div class=\"usePublishedArticlesSearchByUsername\">\n" +
                        "                <label for=\"searchUsername\">\n" +
                        "                    <input type=\"text\" name=\"searchUsername\" id=\"searchUsername\">\n" +
                        "                </label>\n" +
                        "                <button type=\"button\" id=\"searchPublishedArticlesByUsername\">search</button>\n" +
                        "            </div>" +
                        "<div class=\"usePublishedArticlesSearchByTitle\">\n" +
                        "                <label for=\"searchTitle\">\n" +
                        "                    <input type=\"text\" name=\"searchTitle\" id=\"searchTitle\">\n" +
                        "                </label>\n" +
                        "                <button type=\"button\" id=\"searchPublishedArticlesByTitle\">search</button>\n" +
                        "            </div>";

                }

                $('button#' + showSearchButtonID).after(search);
            },
            error: function (error) {
                alert("<div class='singleLineError'>error</div>");
            }
        });

    });


//***************************************************** FUNCTIONS DEFINITIONS *********************************************


    function filter($conditions) {

        $.ajax({
            type: 'POST',
            url: "url.php",
            dataType: "json",
            data: JSON.stringify(postData),
            success: function (data) {
                // Do something with the response
            },
            error: function (error) {
                // Do something with the error
            }
        });
    }
});
