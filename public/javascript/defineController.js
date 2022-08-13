$(document).ready(function () {
    var baseURI = "http://localhost/cmsManagementSystem/public";

    //contributorFilter
    var fieldsetDepartment = $('fieldset.departments');
    fieldsetDepartment.on('change', function () {
        if (fieldsetDepartment.siblings('div.after')) {
            $(this).addClass('noneDisplay');
        }
        //sending ajax

        //create the div.next
        var after = "<div class=\"after usernames\">\n" +
            "                    <label for=\"username\">نام کاربری کاربر مدنظرتان را وارد کنید:\n" +
            "                        <input type=\"text\" name=\"username\" id=\"username\">\n" +
            "                    </label>\n" +
            "                </div>";
        fieldsetDepartment.after(after);
    });

    $("div.usernames").onkeydown(function () {
        //search by ajax

        //show the results in the following element
        var result = "<div class=\"after usernamesResults\">\n" +
            "                    <p>نتایج</p>\n" +
            "                    @foreach($usernames as $username)\n" +
            "                        <div>{{$username}}</div>\n" +
            "                    @endforeach\n" +
            "                </div>";
        $(this).after(result);
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
