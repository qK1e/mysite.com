function init() {
    $("#send-comment-btn").click(sendComment);
    $("#comment-form").focusout(resetCommentForm);
    $(".delete-comment").click(deleteComment);

    refreshCommentSection();
    setInterval(refreshCommentSection, 1000*60);
}

function deleteComment(event) {
    event.stopPropagation();
    alert("DELETING COMMENT!");
}

function resetCommentForm() {
    $(this).find("#answer-to").val(0);
    $(this).find("#comment-textarea").val("");
}

function reply() {
    $("HTML, BODY").animate({
        scrollTop: $("#comment-form").offset().top - 500
    },
    500);

    $("#comment-textarea").focus();

    let comment_id = $(this).find(".comment-id").html();
    let login = $(this).find(".login").html();
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
                let text = $("#comment-textarea").val("");
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
                $(".comment").click(reply);
            }
        });
}

$(document).ready(init());