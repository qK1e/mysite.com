function init() {
    $(".edit-user-button").click(edit_role);
    $(".close-user-edit").click(closeEditUserModal);
    $("#save-user-info-button").click(saveUserInfo);
}

function saveUserInfo() {

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