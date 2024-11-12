<?php

require_once 'model/Admin.php';

class AdminController
{
    // Show list of admin
    public function show()
    {
        $adminModel = new Admin();
        $admins = $adminModel->allAdmins();
        require 'views/superadmin/show.view.php';
    }

    // View a specific admin details
    public function view()
    {
        if (!isset($_GET['id'])) {
            // Handle case when ID is missing, e.g., redirect to 404
            require 'views/pages/404.view.php';
            exit;
        }

        $id = $_GET['id'];
        $adminModel = new Admin();
        $admin = $adminModel->findAdminById($id);
        // $orderHistory = $adminModel->getOrderHistory($id);
        $savedAddresses = $adminModel->getSavedAddresses($id);

        require 'views/superadmin/view.view.php';
    }

    public function create()
    {
        require 'views/superadmin/create.view.php';
    }

    public function store()
    {
        $adminModel = new Admin();

        // Collect data from POST request
        $data = [
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'phone' => $_POST['phone'],
            'email' => $_POST['email'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT), // Hash the password
            'img' => $_POST['img'] ?? null, // Handle image upload if needed
            'role' => $_POST['role'], // Get role from the form
            'city' => $_POST['city'],
            'district' => $_POST['district'],
            'street' => $_POST['street'],
            'building_num' => $_POST['building_num'],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'is_active' => isset($_POST['is_active']) ? $_POST['is_active'] : 1 // Default to active
        ];

        $adminModel->create($data); // Use the Model's create method to save the data

        header('Location: /superadmin'); // Redirect after successful creation
        exit;
    }



    public function edit()
    {
        $adminModel = new Admin();
        $admin = $adminModel->find($_GET['id']); // Fetch the discount by ID

        require 'views/superadmin/edit.view.php'; // Load the edit view
    }

    public function update()
    {
        if (!isset($_POST['id'])) {
            // Handle the error, e.g., redirect or show an error message
            header('Location: /superadmin');
            exit;
        }

        $adminModel = new Admin();
        $id = $_POST['id'];

        // Collect data from POST request
        $data = [
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'phone' => $_POST['phone'],
            'email' => $_POST['email'],
            'city' => $_POST['city'],
            'district' => $_POST['district'],
            'street' => $_POST['street'],
            'building_num' => $_POST['building_num'],
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // // Optionally, update password if provided
        // if (!empty($_POST['password'])) {
        //     $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        // }

        $success = $adminModel->update($id, $data); // Use the Model's update method

        if ($success) {
            $_SESSION['alert'] = 'success';
            $_SESSION['alert_message'] = 'Admin updated successfully!';
        } else {
            $_SESSION['alert'] = 'danger';
            $_SESSION['alert_message'] = 'Failed to update admin.';
        }

        header('Location: /superadmin'); // Redirect after successful update
        exit;
    }


    // Update the status of a admin account (activate, deactivate, suspend)
    public function updateStatus()
    {
        $adminModel = new Admin();
        $adminId = $_POST['id'];
        $status = $_POST['status'];

        $success = $adminModel->updateStatus($adminId, $status);

        if ($success) {
            $_SESSION['alert'] = 'success';
            $_SESSION['alert_message'] = 'Admin status updated successfully!';
        } else {
            $_SESSION['alert'] = 'danger';
            $_SESSION['alert_message'] = 'Failed to update admin status.';
        }

        // Redirect to the referring page
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
    public function delete()
    {
        $adminModel = new Admin();
        $id = $_POST['id']; // Get the ID from POST data
        $adminModel->delete($id); // Delete the discount

        header('Location: /superadmin'); // Redirect after deletion
        exit; // Ensure no further code is executed
    }
}
