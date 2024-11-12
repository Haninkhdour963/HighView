<?php

require_once 'model/Customer.php';

class CustomerController
{
    // Show list of customers
    public function show()
    {
        $customerModel = new Customer();
        $customers = $customerModel->allCustomers();
        require 'views/customers/show.view.php';
    }

    // View a specific customer’s details
    public function view()
    {
        if (!isset($_GET['id'])) {
            // Handle case when ID is missing, e.g., redirect to 404
            require 'views/pages/404.view.php';
            exit;
        }

        $id = $_GET['id'];
        $customerModel = new Customer();
        $customer = $customerModel->findCustomerById($id);
        $orderHistory = $customerModel->getOrderHistory($id);
        $savedAddresses = $customerModel->getSavedAddresses($id);

        require 'views/customers/view.view.php';
    }


    // Update the status of a customer account (activate, deactivate, suspend)
    public function updateStatus()
    {
        $customerModel = new Customer();
        $customerId = $_POST['id'];
        $status = $_POST['status'];

        $success = $customerModel->updateStatus($customerId, $status);

        if ($success) {
            $_SESSION['alert'] = 'success';
            $_SESSION['alert_message'] = 'Customer status updated successfully!';
        } else {
            $_SESSION['alert'] = 'danger';
            $_SESSION['alert_message'] = 'Failed to update customer status.';
        }

        // Redirect to the referring page
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
    public function delete()
    {
        $customerModel = new Customer();
        $id = $_POST['id']; // Get the ID from POST data
        $customerModel->delete($id); // Delete the discount

        header('Location: /customers'); // Redirect after deletion
        exit; // Ensure no further code is executed
    }
}
