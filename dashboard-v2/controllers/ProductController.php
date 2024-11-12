<?php
require 'model/Product.php';
require 'model/Category.php';
require 'model/ProductImages.php';
require 'model/Type.php';

class ProductController
{
    public function show()
    {
        $productModel = new Products();
        $products = $productModel->getAll(); // Make sure `all()` method fetches data correctly

        require 'views/products/show.view.php';
    }
    public function view()
    {
        $productModel = new Products();
        $product = $productModel->findWithCategory($_GET['id']);

        require 'views/products/view.view.php';
    }

    public function create()
    {
        $categoryModel = new Category();
        $typeModel = new Type();
        $categories = $categoryModel->all();
        $types = $typeModel->all();
        require 'views/products/create.view.php';
    }


    public function store()
    {
        $productModel = new Products();
        $productImagesModel = new ProductImages();

        // Directory for product image uploads
        $uploadDir = "uploads/products/";

        // Ensure the upload directory exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Gather product data
        $data = [
            'name' => $_POST['name'] ?? '',
            'price' => $_POST['price'] ?? 0,
            'description' => $_POST['description'] ?? '',
            'category_id' => $_POST['category_id'] ?? null,
            'created_by' => $_POST['created_by'] ?? 1,
            'is_package' => isset($_POST['is_package']) ? 1 : 0,
            'stock' => $_POST['stock'] ?? 0,
            'total_rating' => $_POST['total_rating'] ?? 0,
            'width' => $_POST['width'] ?? 0,
            'height' => $_POST['height'] ?? 0,
            'weight' => $_POST['weight'] ?? 0,
            'quality_checking' => $_POST['quality_checking'] ?? 'N/A',
            'status' => $_POST['status'] ?? 'pending',
            'type_id' => $_POST['type_id'] ?? null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Insert product data to get product ID
        $productId = $productModel->create($data);

        // Upload additional images (front, side, back)
        $views = ['front_view', 'side_view', 'back_view'];
        $productImagesData = ['product_id' => $productId, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')];

        foreach ($views as $view) {
            if (isset($_FILES[$view]) && $_FILES[$view]['error'] === UPLOAD_ERR_OK) {
                $fileName = uniqid() . '-' . basename($_FILES[$view]["name"]);
                $imgPath = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES[$view]["tmp_name"], $imgPath)) {
                    $productImagesData[$view] = $imgPath;
                }
            }
        }

        // Insert product images data and get the new image ID
        $imageId = $productImagesModel->create($productImagesData);

        // Update product table with the image ID
        $productModel->update($productId, ['image_id' => $imageId]);

        // Redirect to the products page
        header('Location: /products');
        exit;
    }




    public function edit()
    {
        $productModel = new Products();
        $products = $productModel->find($_GET['id']);
        // $products = $productModel->findWithCategory($_GET['id']);

        $categoryModel = new Category();
        $categories = $categoryModel->all();

        $typeModel = new Type();
        $types = $typeModel->all();
        require 'views/products/edit.view.php';
    }

    public function update()
    {
        $productModel = new Products();
        $productImagesModel = new ProductImages();
        $id = $_POST['id'];

        // Prepare data array for updating with checks for each field
        $data = [
            'name' => $_POST['name'] ?? '',
            'price' => $_POST['price'] ?? 0,
            'description' => $_POST['description'] ?? '',
            'category_id' => $_POST['category_id'] ?? null,
            'created_by' => $_POST['created_by'] ?? null,
            'is_package' => isset($_POST['is_package']) ? 1 : 0,
            'stock' => $_POST['stock'] ?? 0,
            'total_rating' => $_POST['total_rating'] ?? 0,
            'width' => $_POST['width'] ?? 0,
            'height' => $_POST['height'] ?? 0,
            'weight' => $_POST['weight'] ?? 0,
            'quality_checking' => $_POST['quality_checking'] ?? '',
            'status' => $_POST['status'] ?? '',
            'type_id' => $_POST['type_id'] ?? null,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Update main product image if a new one is uploaded
        if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            $fileName = uniqid() . '-' . basename($_FILES['img']['name']);
            $imgPath = $uploadDir . $fileName;

            // Move the uploaded file to the specified directory
            if (move_uploaded_file($_FILES['img']['tmp_name'], $imgPath)) {
                // Delete previous image if exists
                $existingProduct = $productModel->find($id);
                if (!empty($existingProduct['img']) && file_exists($existingProduct['img'])) {
                    unlink($existingProduct['img']);
                }
                // If upload is successful, add image path to data
                $data['img'] = $imgPath;
            }
        }

        // Retrieve existing images for the product
        $existingProductImages = $productImagesModel->find($id);

        // Update additional images (front, side, back)
        $views = ['front_view', 'side_view', 'back_view'];
        $productImagesData = ['updated_at' => date('Y-m-d H:i:s')];

        foreach ($views as $view) {
            if (isset($_FILES[$view]) && $_FILES[$view]['error'] === UPLOAD_ERR_OK) {
                $fileName = uniqid() . '-' . basename($_FILES[$view]["name"]);
                $imgPath = 'uploads/products/' . $fileName;

                // Move the uploaded file to the specified directory
                if (move_uploaded_file($_FILES[$view]["tmp_name"], $imgPath)) {
                    // Delete previous image if exists for this view
                    if (!empty($existingProductImages[$view]) && file_exists($existingProductImages[$view])) {
                        unlink($existingProductImages[$view]);
                    }
                    // Update the image path for this view
                    $productImagesData[$view] = $imgPath;
                }
            } else {
                // Keep the existing image path if no new file is uploaded
                $productImagesData[$view] = $existingProductImages[$view] ?? null;
            }
        }

        // Update the product in the database
        $productModel->update($id, $data);

        // Update or insert product images data in the database
        if ($existingProductImages) {
            $productImagesModel->update($existingProductImages['id'], $productImagesData);
        } else {
            $productImagesData['product_id'] = $id;
            $productImagesModel->create($productImagesData);
        }

        // Redirect to the products page after update
        header('Location: /products');
        exit;
    }

    public function delete()
    {
        $productModel = new Products();
        $id = $_POST['id'];
        $productModel->delete($id);

        header('Location: /products');
        exit;
    }
}
