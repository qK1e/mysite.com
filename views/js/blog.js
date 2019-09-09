function init() {
    $(".delete-blog").click(deleteBlog);
    $(".search__textarea").on("keypress", search);

}

function deleteBlog()
{
    let id = $(this).parents(".blog-article").find(".article-id").html();

    $.ajax({
        url: "/blog/delete-article",
        type: "POST",
        dataType: "json",
        data: {
            id: id
        },
        success: function (json) {
            let id = json.id;
            $("#article-"+id).remove();
        },
        error: function () {
            alert("couldn't delete article!");
        }

    });
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