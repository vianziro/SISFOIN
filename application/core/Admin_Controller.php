<?php
class Admin_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $username = $this->session->userdata('username');
        $level    = $this->session->userdata('level');
        $is_login = $this->session->userdata('is_login');

        if (!$is_login) {
            redirect('login');
            return;
        }

        if ($level !== 'Admin') {
            redirect('login');
            return;
        }
    }
}