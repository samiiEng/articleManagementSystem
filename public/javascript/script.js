$('button').click(function(){
    filter($conditions);
});
//**************************************************************************************************
function filter($conditions){

    $.ajax({
        type: 'POST',
        url: $form.attr('action'),
        data: $form.serialize(),
        success: function(data) {
            // Do something with the response
        },
        error: function(error) {
            // Do something with the error
        }
    });
}
