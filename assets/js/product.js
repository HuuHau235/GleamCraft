document.getElementById('filterBtn').addEventListener('click', function (e) {
    e.preventDefault(); // Ngăn reload trang

    // Thu thập dữ liệu từ form
    const formData = new FormData(document.querySelector('.filter'));
    const filters = {};
    formData.forEach((value, key) => {
        if (!filters[key]) {
            filters[key] = [];
        }
        filters[key].push(value);
    });

    // Gửi dữ liệu đến server
    fetch('/api/products', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(filters),
    })
        .then((response) => response.json())
        .then((products) => {
            renderProducts(products);
        })
        .catch((error) => console.error('Error:', error));
});

// Hàm hiển thị danh sách sản phẩm
function renderProducts(products) {
    const productList = document.getElementById('productList');
    if (products.length === 0) {
        productList.innerHTML = '<p>Không có sản phẩm nào phù hợp.</p>';
        return;
    }
    productList.innerHTML = products
        .map(
            (product) => `
        <div class="product">
            <img src="${product.image}" alt="${product.name}" />
            <h3>${product.name}</h3>
            <p>${product.description}</p>
            <p>Giá: ${product.price} VNĐ</p>
        </div>
    `
        )
        .join('');
}
