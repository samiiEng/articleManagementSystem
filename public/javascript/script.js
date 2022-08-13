$(document).ready(function () {

    $('.showSearch').click(function (){
       var filterElement = $(this).attr("id");
       var form = filterElement.find('form');

       //finding all checked radio buttons
       var checkedButtons = form.find('input[type=radio]:checked');
       var fieldsetParents = [];

       //each result have the condition name with the corresponding table name
       var results = [];
        checkedButtons.each(function (){
            fieldsetParents = $(this).parent('fieldset').attr('class');
        });
    });

    var forms = [];
    $('div.filters').find('form').each(function () {
        forms = $(this).attr('class');
    });

    formsFieldsets = [];
    var i = 0;
    forms.each(function () {
        i++;
        var fields = [];
        fields = $(this).find('fieldset');

        var fieldsets = [];
        fields.each(function () {
            fieldsets = $(this).attr('class');
        });
        formsFieldsets[i] = [$(this), fieldsets];
    });

    makeListenerForRadioButtons(formsFieldsets);


//***************************************************** FUNCTIONS DEFINITIONS *********************************************
    function makeListenerForRadioButtons(formsFieldSets) {


    }


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
