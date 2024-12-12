// Hàm kiểm tra khi phần tử vào trong khung nhìn
function checkVisibility() {
    const sections = document.querySelectorAll('.content-section');
    sections.forEach(section => {
        const rect = section.getBoundingClientRect();
        if (rect.top >= 0 && rect.bottom <= window.innerHeight) {
            section.classList.add('visible');

            // Thêm hiệu ứng cho các thẻ h2, p và img riêng biệt
            const h2 = section.querySelector('h2');
            const p = section.querySelector('p');
            const img = section.querySelector('img');

            if (h2) h2.classList.add('visible');
            if (p) p.classList.add('visible');
            if (img) img.classList.add('visible');
        }
    });
}

// Lắng nghe sự kiện cuộn trang
window.addEventListener('scroll', checkVisibility);

// Chạy hàm khi tải trang
document.addEventListener('DOMContentLoaded', checkVisibility);
