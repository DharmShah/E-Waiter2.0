<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\WaiterModel;
use App\Models\DishModel;
use App\Models\OrderModel;
use CodeIgniter\RESTful\ResourceController;

class Home extends BaseController
{
    public function index()
    {
        return view('index');
    }

    public function menu()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/')->with('error', 'Please login first.');
        }

        // Fetch all dishes and categories
        $dishModel = new DishModel();
        $data['dishes'] = $dishModel->findAll();
        $data['categories'] = $dishModel->select('itemcategory, imgurl')->distinct()->findAll();

        // Get the table number from the session
        $data['tableno'] = session()->get('tableno'); 

        return view('menu', $data);
    }

    public function tablebook()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/')->with('error', 'Please login first.');
        }
    
        $data['waiter_name'] = session()->get('waiter_name'); // Pass waiter name to the view
        return view('tablebook', $data);
    }

    public function addOrder()
    {
        $orderModel = new OrderModel();
        $json = $this->request->getJSON(); // Get JSON data from request

        if (!$json || !isset($json->orders)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid order data']);
        }

        foreach ($json->orders as $order) {
            $orderData = [
                'tableno'  => $order->tableno,
                'itemname' => $order->itemname,
                'quantity' => $order->quantity
            ];
            $orderModel->insert($orderData);
        }

        return $this->response->setJSON(['status' => 'success', 'message' => 'Order added successfully!']);
        
    }
    
    public function vieworder()
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/')->with('error', 'Please login first.');
        }
        return view('vieworder');
    }

    public function getOrders()
    {
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        $tableNo = $this->request->getGet('tableno'); // Get table number from request
        if (!$tableNo) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Table number is required']);
        }

        $orderModel = new OrderModel();
        $orders = $orderModel->where('tableno', $tableNo)->findAll();

        return $this->response->setJSON(['status' => 'success', 'orders' => $orders]);
    }

    public function updateOrder()
    {
        $orderModel = new OrderModel();
        $json = $this->request->getJSON(); // Get JSON data from request

        if (!$json || !isset($json->id) || !isset($json->quantity)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid order data']);
        }

        // Update the order quantity
        $orderModel->update($json->id, ['quantity' => $json->quantity]);

        return $this->response->setJSON(['status' => 'success', 'message' => 'Order updated successfully!']);
    }

    public function deleteOrder($id)
    {
        $orderModel = new OrderModel();
        
        if (!$id) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid order ID']);
        }

        $orderModel->delete($id);
        return $this->response->setJSON(['status' => 'success', 'message' => 'Order deleted successfully!']);
    }

    public function updateOrderServed($id)
    {
        $orderModel = new OrderModel();
        $json = $this->request->getJSON();
        
        if (!$json || !isset($json->served)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request data']);
        }

        // Update served status in database
        $orderModel->update($id, ['served' => $json->served]);

        return $this->response->setJSON(['status' => 'success', 'message' => 'Order served status updated!']);
    }

    public function billing()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to(base_url());
        }

        if (!$session->has('tableno')) {
            die('⚠ Table number session me set nahi hai!');
        }

        $tableno = $session->get('tableno');

        $orderModel = new \App\Models\OrderModel();
        $data['orders'] = $orderModel->getOrdersWithPrice($tableno);
        $data['tableno'] = $tableno;

        return view('billing', $data);
    }

    public function selectTable($tableno)
    {
        // Store table number in session
        $session = session();
        $session->set('tableno', $tableno); 

        // Redirect to the menu page
        return redirect()->to('/menu');
    }

    
    public function login()
    {
        $waiterModel = new WaiterModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Find waiter by username
        $waiter = $waiterModel->where('waitername', $username)->first();

        if ($waiter) {
            // Check password (plain text comparison)
            if ($waiter['password'] === $password) {
                // Store waiter info in session
                session()->set([
                    'waiter_id'   => $waiter['id'],
                    'waiter_name' => $waiter['waitername'], // Ensure this matches view
                    'isLoggedIn'  => true
                ]);

                return redirect()->to('/tablebook');
            } else {
                return redirect()->to('/')->with('error', 'Invalid password.');
            }
        } else {
            return redirect()->to('/')->with('error', 'Invalid waiter name.');
        }
    }
}
