
function confirmDelete() {
    return confirm("Are you sure you want to delete this item?");
}

// Function to show the relevant tab
function showTab(tabId) {
    // Ẩn tất cả các tab
    let tabs = document.querySelectorAll('.tab-content');
    tabs.forEach(function (tab) {
        tab.classList.add('d-none');
    });

    // Hiển thị tab đã chọn
    let activeTab = document.getElementById(tabId);
    activeTab.classList.remove('d-none');

    // Cập nhật trạng thái của các nút sidebar
    let buttons = document.querySelectorAll('.sidebar button');
    buttons.forEach(function (button) {
        button.classList.remove('active');
    });
    document.querySelector(`button[onclick="showTab('${tabId}')"]`).classList.add('active');
}


function openEditFormUser(user_id, name, email, password, phone, role) {
    document.getElementById('edit-user-id').value = user_id;
    document.getElementById('edit-name').value = name;
    document.getElementById('edit-email').value = email;
    document.getElementById('edit-password').value = password;
    document.getElementById('edit-phone').value = phone;
    document.getElementById('edit-role').value = role;
    document.getElementById('edit-user-form').action = "/Gleamcraft_MVC/public/Admin1/edit/"+user_id;
    document.getElementById('edit-form-user').style.display = 'block';
}

function closeEditFormUser() {
    document.getElementById('edit-form-user').style.display = 'none';
}

// Gửi yêu cầu AJAX khi nhấn nút Save Changes
// document.getElementById('edit-user-form').addEventListener('submit', function(event) {
//     event.preventDefault();

//     const formData = new FormData(this);
    
//     fetch('', {
//         method: 'POST',
//         body: formData
//     })
//     .then(response => response.text())
//     .then(data => {
//         alert("You have successfully updated your information!"); // Hiển thị thông báo kết quả

//         // Cập nhật bảng người dùng mà không cần tải lại trang
//         const userId = document.getElementById('edit-user-id').value;
//         const name = document.getElementById('edit-name').value;
//         const email = document.getElementById('edit-email').value;
//         const password = document.getElementById('edit-password').value;
//         const phone = document.getElementById('edit-phone').value;
//         const role = document.getElementById('edit-role').value;

//         // Tìm dòng người dùng trong bảng và cập nhật thông tin
//         const row = document.querySelector(`tr[data-user-id="${userId}"]`);
//         row.querySelector('td:nth-child(2)').textContent = name;
//         row.querySelector('td:nth-child(3)').textContent = email;
//         row.querySelector('td:nth-child(4)').textContent = str_repeat('•', password.length); // Ẩn mật khẩu
//         row.querySelector('td:nth-child(5)').textContent = phone;
//         row.querySelector('td:nth-child(6)').textContent = role;

//         closeEditFormUser(); // Đóng form sau khi cập nhật thành công
//     })
//     .catch(error => {
//         console.error('Error:', error);
//     });
// });

// Hàm để lặp dấu • cho mật khẩu
function str_repeat(character, length) {
    return new Array(length + 1).join(character);
}
// Xử lí form product
function openEditFormProduct(product_id, name, description, color, gender, type_name, price, image) {
    document.getElementById('edit-product-id').value = product_id;
    document.getElementById('editt-name').value = name;
    document.getElementById('edit-description').value = description;
    document.getElementById('edit-color').value = color;
    document.getElementById('edit-gender').value = gender;
    document.getElementById('edit-type-name').value = type_name;
    document.getElementById('edit-price').value = price;
    document.getElementById('edit-image').value = image;
    document.getElementById('edit-product-form').action = "/Gleamcraft_MVC/public/Admin1/edit/"+product_id;
    document.getElementById('editt-product-form').style.display = 'block';
}

function closeEditFormProduct() {
    document.getElementById('editt-product-form').style.display = 'none';
    document.getElementById('overlay').style.display = 'none';
}