function init() {
    $("#send-comment-btn").click(sendComment);

    refreshCommentSection();
    setInterval(refreshCommentSection, 1000*60);
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
                let text = $("#comment-textarea").val("");
                alert("Comment posted successfully!");
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
            }
        });
}

$(document).ready(init());