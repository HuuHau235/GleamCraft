document.getElementById('filterForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Ngăn form reload

    const formData = new FormData(this);
    const filters = {};
    formData.forEach((value, key) => {
        filters[key] = value;
    });

    fetch('/products/filter', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(filters),
    })
    .then((response) => response.json())
    .then((products) => {
        const productList = document.getElementById('productList');
        productList.innerHTML = products.length
            ? products
                    .map(
                        (product) => `
                <div class="product">
                    <img src="${product.image}" alt="${product.name}">
                    <h3>${product.name}</h3>
                    <p>Giá: ${product.price} VNĐ</p>
                </div>
            `
                    )
                    .join('')
            : '<p>No matching products found.</p>';
    });
});