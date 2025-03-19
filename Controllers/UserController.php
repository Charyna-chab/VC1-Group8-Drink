<?php
require_once 'Models/UserModel.php';
require_once 'BaseController.php';
class UserController extends BaseController
{
    private $model;
    function __construct()
    {
        $this->model =  new UserModel();
    }
    function index()
    {
        $users = $this->model->getUsers();
        $this->views('user/list.php',['users' => $users]);
    }

    function create()
    {
        // require_once 'Views/user/create.php';
        $this->views('user/create.php');
    }

    function store()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $data = [
                'name' => $_POST['name'],
                'phone' => $_POST['phone'],
                'email' => $_POST['email'],
                'address' => $_POST['address'],
            ];
            $this->model->createUser($data);
            $this->redirect('/user');
           
        }
    }

    function edit($id)
    {
        $user = $this->model->getUser($id);
        $this-> views('user/edit.php',['user' => $user]);
    }
    function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'name' => $_POST['name'],
                'phone' => $_POST['phone'],
                'email' => $_POST['email'],
                'address' => $_POST['address']
            ];
            $this->model->updateUser($id, $data);
            // $this->model->createUser($data);
            $this->redirect('/user');
        }
    }

    function destroy($id)
    {
        $this->model->deleteUser($id);
        $this->redirect('/user');
    }
}
