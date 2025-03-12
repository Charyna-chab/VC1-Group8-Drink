<?php
require_once 'Models/UserModel.php';
require_once 'BaseController.php';
class UserController extends BaseController
{
    private $model;
    function __construct()
    {
        $this->model =  new UserModel();
        // $this->db = Database::getInstance();
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
                'address' => $_POST['address'],
            ];
            $this->model->updateUser($id, $data);
            $this->model->createUser($data);
            $this->redirect('/user');
        }
    }

    function destroy($id)
    {
        $this->model->deleteUser($id);
        $this->redirect('/user');
    }

    private $db;
    
  
       
    
    
    public function profile() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            return;
        }
        
        // Get user data
        // $user = $this->db->getUserById($_SESSION['user_id']);
        
        // if (!$user) {
        //     // User not found
        //     session_destroy();
        //     header('Location: /login');
        //     return;
        // }
        
        // Get user orders
        // $orders = $this->db->getOrdersByUserId($_SESSION['user_id']);
        
        // Include the view
        include 'views/profile.php';
    }
    
    public function notifications() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'User not logged in']);
            return;
        }
        
        
    }
}
