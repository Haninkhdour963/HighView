<?php
require 'model/Articles.php';

class ArticleController
{
    public function show()
    {
        $articleModel = new Articles();
        $articles = $articleModel->all(); // Make sure `all()` method fetches data correctly

        require 'views/articles/show.view.php';
    }
    public function create()
    {
        require 'views/articles/create.view.php';
    }

    public function store()
    {
        $articleModel = new Articles();
        $data = [
            'body' => $_POST['body'],
            'featured_img' => $_POST['featured_img'],
            'created_by' => $_POST['created_by'],
            'title' => $_POST['title'],
            'created_at' => date('Y-m-d H:i:s')
        ];

        $articleModel->create($data);
        header('Location: /articles');
        exit;
    }

    public function edit()
    {
        $articleModel = new Articles();
        $article = $articleModel->find($_GET['id']);

        require 'views/articles/edit.view.php';
    }

    public function update()
    {
        $articleModel = new Articles();
        $id = $_POST['id'];
        $data = [
            'title' => $_POST['title'],
            'body' => $_POST['body'],
            'featured_img' => $_POST['featured_img'],
            'created_by' => $_POST['created_by'],
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $articleModel->update($id, $data);
        header('Location: /articles');
        exit;
    }

    public function delete()
    {
        $articleModel = new Articles();
        $id = $_POST['id'];
        $articleModel->delete($id);

        header('Location: /articles');
        exit;
    }
}
