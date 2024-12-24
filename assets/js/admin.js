
function showTab(tabId) {
    // Hide all tabs
    document.querySelectorAll('.tab-content').forEach(tab => tab.classList.add('d-none'));
    // Remove active class from all sidebar buttons
    document.querySelectorAll('.sidebar button').forEach(btn => btn.classList.remove('active'));
    // Show selected tab and activate the corresponding button
    document.getElementById(tabId).classList.remove('d-none');
    document.querySelector(`.sidebar button[onclick="showTab('${tabId}')"]`).classList.add('active');
}

//  Xử lí form User
function OpenEditUser() {
    document.getElementById('edit-form-user').style.display = 'block';
}
function closeEditFormUser() {
    document.getElementById('overlay').style.display = 'none';
    document.getElementById('edit-form-user').style.display = 'none';
}
