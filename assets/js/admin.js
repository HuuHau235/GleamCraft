
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
    document.getElementById('edit-user-form').action = "/Gleamcraft_MVC/public/Admin1/editUser/"+user_id;
    document.getElementById('edit-form-user').style.display = 'block';
}

function closeEditFormUser() {
    document.getElementById('edit-form-user').style.display = 'none';
}


// Hàm để lặp dấu • cho mật khẩu
function str_repeat(character, length) {
    return new Array(length + 1).join(character);
}
// Xử lí form product

// Hàm mở form chỉnh sửa sản phẩm
function openEditFormProduct(product_id, name, description, color, gender, type_name, price, image) {
    // Gán giá trị vào các trường trong form
    document.getElementById('edit-product-id').value = product_id;
    document.getElementById('editt-name').value = name;
    document.getElementById('edit-description').value = description;
    document.getElementById('edit-color').value = color;
    document.getElementById('edit-gender').value = gender;
    document.getElementById('edit-type-name').value = type_name;
    document.getElementById('edit-price').value = price;
    document.getElementById('edit-image').value = image;

    // Hiển thị overlay và form
    document.getElementById('edit-product-form').action = "/Gleamcraft_MVC/public/Admin1/editProducts/"+product_id;
    console.log(product_id, name, description, color, gender, type_name, price, image);

    // Gửi form ngay sau khi thay đổi action (nếu muốn tự động cập nhật)
    // document.getElementById('edit-product-form').submit();  // Uncomment nếu bạn muốn tự động submit

    document.getElementById('edit-form-product').style.display = 'block';
}
