function edit_role() {
    showUserEditingPopup();

}

function showUserEditingPopup() {
    document.getElementById("editUserModal").style.display = "block";
}

function closeEditUserModal() {
    document.getElementById("editUserModal").style.display = "none";
}

function change_visibility() {
    alert("changing visibility");
}

function delete_user() {
    alert("deleting user");
}

let modal = document.getElementById("editUserModal");

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}