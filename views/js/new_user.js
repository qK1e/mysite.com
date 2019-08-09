function roleSelectHandle(event)
{
    let value = event.target.value;

    if(value === "Developer" || value === "Admin")
    {
        if(!document.getElementById("first-name"))
        {
            addDeveloperForm();
        }
    }
    else if(value === "Reader")
    {
        let first_name_input = document.getElementById("first-name");
        let second_name_input = document.getElementById("second-name");

        if(first_name_input)
        {
            first_name_input.parentElement.remove();
        }
        if (second_name_input)
        {
            second_name_input.parentElement.remove();
        }
    }
}

function addDeveloperForm()
{
    let form = document.getElementById("user-info-form");
    form.insertAdjacentHTML("beforeend", "" +
        "<div class='form-group d-flex justify-content-center col-12'>" +
        "   <label for='first-name'>First name:</label> " +
        "   <input id='first-name' type='text' name='first-name'/>" +
        "</div>" +
        "<div class='form-group d-flex justify-content-center col-12'>" +
        "   <label for='second-name'>Second name:</label>" +
        "   <input id='second-name' type='text' name='second-name'/>" +
        "</div>");
}



let role_select = document.getElementById("role_select");
role_select.addEventListener("change", roleSelectHandle);