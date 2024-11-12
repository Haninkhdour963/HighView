<?php
require 'model/Category.php';

class CategoryController
{
    public function show()
    {
        $categoryModel = new Category();
        $categories = $categoryModel->all(); // Make sure `all()` method fetches data correctly

        require 'views/category/show.view.php';
    }
    public function create()
    {
        require 'views/category/create.view.php';
    }

    public function store()
    {
        $categoryModel = new Category();

        // File upload handling
        $targetDir = "uploads/"; // Define upload directory
        $targetFile = isset($_FILES['img']) ? $targetDir . basename($_FILES['img']['name']) : null;

        // Check if the directory exists, if not, create it
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // Move the uploaded file to the target directory
        if (isset($_FILES['img']) && move_uploaded_file($_FILES['img']['tmp_name'], $targetFile)) {
            $imgPath = $targetFile;
        } else {
            $imgPath = null;
        }

        // Gather category data
        $data = [
            'name' => $_POST['name'] ?? null,
            'img' => $imgPath,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        // Save data in the database
        $categoryModel->create($data);

        // Redirect to category listing page
        header('Location: /category');
        exit;
    }


    public function edit()
    {
        $categoryModel = new Category();
        $category = $categoryModel->find($_GET['id']);

        require 'views/category/edit.view.php';
    }

    public function update()
    {
        $categoryModel = new Category();
        $id = $_POST['id'];

        // Prepare data array for updating
        $data = [
            'name' => $_POST['name'],
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Check if a new image is uploaded
        if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            $fileName = uniqid() . '-' . basename($_FILES['img']['name']);
            $imgPath = $uploadDir . $fileName;

            // Ensure the upload directory exists, if not, create it
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Move the uploaded file to the specified directory
            if (move_uploaded_file($_FILES['img']['tmp_name'], $imgPath)) {
                // If upload is successful, add the new image path to data
                $data['img'] = $imgPath;
            } else {
                // Optionally handle upload failure
                $existingCategory = $categoryModel->find($id);
                $data['img'] = $existingCategory['img'] ?? null;
            }
        } else {
            // Retain the existing image if no new one is uploaded
            $existingCategory = $categoryModel->find($id);
            $data['img'] = $existingCategory['img'] ?? null;
        }

        // Update the category in the database
        $categoryModel->update($id, $data);

        // Redirect to the category page after update
        header('Location: /category');
        exit;
    }

    public function delete()
    {
        $categoryModel = new Category();
        $id = $_POST['id'];
        $categoryModel->delete($id);

        header('Location: /category');
        exit;
    }
}
