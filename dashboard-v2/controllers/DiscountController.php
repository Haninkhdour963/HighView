<?php

require 'model/Discount.php';
require 'model/Product.php';

class DiscountController
{
    public function show()
    {
        $discountModel = new Discount();
        $discounts = $discountModel->getAllWithDetails(); // Fetching all discounts with details

        require 'views/discounts/show.view.php'; // Load the show view
    }

    public function create()
    {
        $productModel = new Products(); // Assume you have a Product model
        $products = $productModel->getAll(); // Method to fetch all products
        require 'views/discounts/create.view.php'; // Load the create view with products
    }

    public function store()
    {
        $discountModel = new Discount();
        $data = [
            'id_product' => $_POST['id_product'],
            'newprice' => $_POST['newprice'],
            'startdate' => $_POST['startdate'],
            'enddate' => $_POST['enddate'],
            'created_at' => date('Y-m-d H:i:s') // Add created timestamp
        ];

        $discountModel->create($data);
        header('Location: /discounts'); // Redirect after creation
        exit; // Ensure no further code is executed
    }

    public function edit()
    {
        $discountModel = new Discount();
        $discount = $discountModel->find($_GET['id']); // Fetch the discount by ID

        // Fetch all products
        $productModel = new Products(); // Assuming you have a Product model
        $products = $productModel->getAll(); // Implement this method to get all products

        require 'views/discounts/edit.view.php'; // Load the edit view
    }


    public function update()
    {
        $discountModel = new Discount();
        $id = $_POST['id']; // Get the ID from POST data
        $data = [
            'id_product' => $_POST['id_product'],
            'newprice' => $_POST['newprice'],
            'startdate' => $_POST['startdate'],
            'enddate' => $_POST['enddate'],
            'updated_at' => date('Y-m-d H:i:s') // Add updated timestamp
        ];

        $discountModel->update($id, $data); // Update the discount
        header('Location: /discounts'); // Redirect after update
        exit; // Ensure no further code is executed
    }

    public function delete()
    {
        $discountModel = new Discount();
        $id = $_POST['id']; // Get the ID from POST data
        $discountModel->delete($id); // Delete the discount

        header('Location: /discounts'); // Redirect after deletion
        exit; // Ensure no further code is executed
    }
}
