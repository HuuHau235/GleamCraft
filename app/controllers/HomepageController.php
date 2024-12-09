<?php

namespace App\Controllers;

class HomepageController {
    public function index() {
        // Tải header
        require_once '../app/views/shared/header.php';

        // Tải body (nội dung chính)
        require_once '../app/views/homepage/index.php';

        // Tải footer
        require_once '../app/views/shared/footer.php';
    }
}
