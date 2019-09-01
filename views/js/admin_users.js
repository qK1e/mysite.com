function init() {
    $(".edit-user-button").click(edit_role);
    $(".close-user-edit").click(closeEditUserModal);
    $("#save-user-info-button").click(saveUserInfo);
    $(".delete-user-button").click(deleteUser);
}

function deleteUser() {
    id = $(this).parents(".user-container").find(".id").html();
    $.ajax({
        url: "/admin/delete-user",
        data: {
            id: id
        },
        type: "POST",
        dataType: "json",
        success: function (json) {
            //get json with id of user
            let id = json.id;
            //delete user from page
            $("#user-"+id).remove();
        },
        error: function () {
            alert("Couldn't remove user");
        }
    });
}

function saveUserInfo() {
    //1.collect data
    var id = $("#edited-user-id").attr("value");
    var role = $("#edited-user-role option:selected").attr("value");
    $("#edited-user-role").css("display","none");
    //2.send ajax request
    $.ajax({
        url: "/admin/update-user",
        data: {
        //2.1.put data in ajax request
            id: id,
            role: role
        },
        type: "POST",
        dataType: "json",
        success: function () {
            let id = $("#edited-user-id").attr("value");
            let role = $("#edited-user-role option:selected").attr("value");
            $("#user-"+id).find(".role").html(role);
            $("#edited-user-role").css("display","block");
            $("#close-user-edit").click();
        },
        error: function () {
            $("#edited-user-role").css("display","block");
            show_user_edit_error();
        }
    });
}

function refresh_user_in_list(id, role) {
    //1.get element with user
    let element = $("#user-"+id);
    //2.put values
    element.find(".role").html(role);
}

function show_user_edit_error() {
    alert("couldn't change user data");
}

function edit_role() {

    id = $(this).parents(".user-container").find(".id").html();

    showUserEditingModal(id);
}

function showUserEditingModal(id) {

    $("#editUserModal").find("input[name='user-id']").attr('value', id);
    $("#editUserModal").css('display', 'block' );
}

function closeEditUserModal() {
    $("#editUserModal").css('display', 'none');
}

$(document).ready(init());