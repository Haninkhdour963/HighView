<?php

require_once 'model/Order.php';
require_once 'model/User.php';

class HomeController
{
    private $orderModel;
    private $userModel;

    public function __construct()
    {
        $this->orderModel = new Orders();
        $this->userModel = new User();
    }

    public function index()
    {
        // Fetch data from models
        $totalOrders = $this->orderModel->getTotalOrders();
        $totalSales = $this->orderModel->getTotalSales();
        $totalUsers = $this->userModel->getTotalUsers();
        $recentOrders = $this->orderModel->getRecentOrders();

        // Combine data into an array
        $data = [
            'totalOrders' => $totalOrders,
            'totalSales' => $totalSales,
            'totalUsers' => $totalUsers,
            'recentOrders' => $recentOrders,
        ];

        // Render view with data
        require 'views/pages/show.view.php';
    }
}
