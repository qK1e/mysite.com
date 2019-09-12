function init() {
    $("#send-comment-btn").click(sendComment);
    $("#comment-textarea").on("keypress", function (e) {
        if(e.ctrlKey && (e.which === 13 || e.which === 10 ))
        {
            sendComment();
        }
    });
    $("#reply").click(dontReply);
    refreshCommentSection();
    setInterval(refreshCommentSection, 1000*60);
}

function deleteComment(event) {
    event.stopPropagation();
    //get id
    let id = $(this).parents(".comment").find(".comment-id").html();
    //send request
    $.ajax({
        url: "article/delete-comment",
        type: "POST",
        data: {
            id: id
        },
        dataType: "json",
        success: function (json) {
            let id = json.id;
            $("#comment-" + id).remove();
        },
        error: function () {
            alert("couldn't delete comment!");
        }
    });


    //refresh comment section
}

function dontReply() {
    $("#reply").css('visibility', 'hidden');
    $(document).find("#answer-to").val(0);
}

function resetCommentForm(event) {
    $(document).find("#answer-to").val(0);
    $(document).find("#comment-textarea").val("");
}

function reply() {

    $("#reply").css('visibility', 'visible');
    $("HTML, BODY").animate({
        scrollTop: $("#comment-form").offset().top - 500
    },
    500);

    $("#comment-textarea").focus();

    let comment_id = $(this).parents(".comment").find(".comment-id").html();
    let login = $(this).parents(".comment").find(".login").html();
    $("#answer-to").val(comment_id);
    $("#comment-textarea").val(login + ", ");
}

function sendComment()
{
    let answer_to = $("#answer-to").val();
    let text = $("#comment-textarea").val();
    let blog = $("#blog-id").val();

    $.ajax(
        {
            url: "article/post-comment",
            data: {
                answer_to: answer_to,
                text: text,
                blog: blog
            },
            type: "POST",
            dataType: "json",
            success: function (json) {
                $("#comment-textarea").val("");
                $("#reply").css('visibility', 'hidden');
                refreshCommentSection();
            },
            error: function () {
                alert("Error occurred!");
            }
        }
    );
}

function refreshCommentSection()
{

    let blog_id = $("#blog-id").val();

    $.ajax(
        {
            url: "article/comment-section?id=" + blog_id,
            type: "GET",
            dataType: "html",
            success: function (html) {
                $("#comment-section").html(html);
                $(".comment__reply-button").click(reply);
                $(".delete-comment").click(deleteComment);
            }
        });
}

$(document).ready(init());