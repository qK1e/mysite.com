function init() {
    $(".search__textarea").on("keypress", search);
}

function search(event)
{
    if(event.which === 13)
    {
        event.preventDefault();
        $("#search-form").submit();
    }
}

$(document).ready(init());