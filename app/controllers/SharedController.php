<?php
require_once(__DIR__ . '/../core/Controller.php');
class SharedController extends Controller
{
    public function index()
    {
        $this->startSession();
        $isLoggedIn = isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'];
        $this->view('shared/header', [
            'isLoggedIn' => $isLoggedIn
        ]);
        $this->view('shared/footer'); 
    }
    private function startSession()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
}
