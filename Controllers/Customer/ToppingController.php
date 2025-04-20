<?php

namespace YourNamespace;

require_once './Models/Customer/ToppingModel.php';
require_once './Controllers/BaseController.php';


use YourNamespace\Models\ToppingModel;
// use YourNamespace\Controllers\BaseController;

class ToppingController extends BaseController
{
    private $model;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->model = new ToppingModel();
    }

    public function index()
    {
        $toppings = $this->model->getToppings();
        $this->views('admin/toppings/topping', ['toppings' => $toppings]); // Ensure this view exists
    }

    public function create()
    {
        $this->views('admin/toppings/create'); // Ensure this view exists
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $uploadDir = 'uploads/toppings/'; // Changed to toppings directory
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $imageName = basename($_FILES['image']['name']);
            $uploadFile = $uploadDir . $imageName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                $data = [
                    'name' => $_POST['name'], // Adjust fields to match your ToppingModel
                    'price' => $_POST['price'],
                    'image' => $uploadFile,
                ];

                $this->model->createTopping($data);
                $this->redirect('/admin/toppings'); // Redirect to toppings list
            } else {
                die("Failed to upload the image.");
            }
        }
    }

    public function edit($id)
    {
        $topping = $this->model->getTopping($id);
        if (!$topping) {
            $_SESSION['error'] = "Topping not found!";
            return $this->redirect('/admin/toppings');
        }
        $this->views('admin/toppings/edit', ['topping' => $topping]); // Ensure this view exists
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $topping = $this->model->getTopping($id);

            if (!$topping) {
                $_SESSION['error'] = "Topping not found!";
                return $this->redirect('/admin/toppings');
            }

            $data = [
                'name' => $_POST['name'],
                'price' => $_POST['price'],
            ];

            // Handle image update (optional)
            if (!empty($_FILES['image']['name'])) {
                $uploadDir = 'uploads/toppings/';
                $imageName = basename($_FILES['image']['name']);
                $uploadFile = $uploadDir . $imageName;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    $data['image'] = $uploadFile;
                }
            }

            $updated = $this->model->updateTopping($id, $data);

            if ($updated) {
                $_SESSION['success'] = "Topping updated successfully!";
            } else {
                $_SESSION['error'] = "Failed to update topping.";
            }

            $this->redirect('/admin/toppings');
        }
    }

    public function destroy($id)
    {
        if (!is_numeric($id)) {
            $_SESSION['error'] = 'Invalid topping ID!';
            return $this->redirect('/admin/toppings');
        }

        if ($this->model->deleteTopping($id)) {
            $_SESSION['success'] = 'Topping deleted successfully!';
        } else {
            $_SESSION['error'] = 'Failed to delete topping!';
        }

        $this->redirect('/admin/toppings');
    }
}