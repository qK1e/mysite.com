function init() {
    $(".delete-blog").click(deleteBlog);
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

$(document).ready(init());