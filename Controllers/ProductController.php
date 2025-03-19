<?php
require_once 'Models/ProductModel.php';
require_once 'BaseController.php';

class ProductController extends BaseController
{
    
    private $model;

    function __construct()
    {
        $this->model = new ProductModel();
    }

    function index()
    {
        $products = $this->model->getProducts();
        $this->views('products/product-list.php', ['products' => $products]);
    }

    function create()
    {
        $this->views('products/product-create.php');
    }

    function store()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $imageData = null;
            if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
             
                $imageData = file_get_contents($_FILES['file']['tmp_name']);
            }
            $data = [
            'product_name' => $_POST['product_name'],
            'image' => $imageData,
            'product_detail' => $_POST['product_detail'],
            'price' => $_POST['price'],
            ];
            $this->model->createProduct($data);
            $this->redirect('/product');
        }
    }

    function edit($id)
    {
        $product = $this->model->getProduct($id);
        $this->views('products/product-edit.php', ['product' => $product]);
    }

    function update($id)
    {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $data = [
            'product_name' => $_POST['product_name'],
            'image' => $_POST['image'],
            'product_detail' => $_POST['product_detail'],
            'price' => $_POST['price'],
        ];
        $this->model->updateProduct($id, $data); // Only call updateProduct
        // Remove this line: $this->model->createProduct($data);
        $this->redirect('/product');
    }
    }


    function destroy($id)
    {
        $this->model->deleteProduct($id);
        $this->redirect('/product');

    }
}