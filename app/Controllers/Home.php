<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\WaiterModel;
use App\Models\DishModel;
use App\Models\OrderModel;
use App\Models\AdminControlModel;
use CodeIgniter\RESTful\ResourceController;

class Home extends BaseController
{
    public function index()
    {
        $adminControlModel = new AdminControlModel();
        $adminData = $adminControlModel->first();

        // Handle logo path
        if ($adminData && !empty($adminData['logo'])) {
            $logoFile = str_replace('uploads/', '', $adminData['logo']);
            $logoPath = FCPATH . 'public/uploads/' . $logoFile;

            if (file_exists($logoPath)) {
                $adminData['logo_url'] = base_url('public/uploads/' . $logoFile);
            } else {
                log_message('error', "Logo file not found: " . $logoPath);
                $adminData['logo_url'] = base_url('public/default-logo.png');
            }
        } else {
            $adminData['logo_url'] = base_url('public/default-logo.png');
        }

        return view('index', ['adminData' => $adminData]);
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

        $adminControlModel = new AdminControlModel();
        $adminData = $adminControlModel->first();

        $orderModel = new OrderModel(); // Fetching occupied tables from OrderModel
        $orderedTables = $orderModel->select('tableno')->findAll(); // Fetch all occupied tables

        // Convert ordered tables into an array of table numbers
        $occupiedTables = array_column($orderedTables, 'tableno');

        // Fetch table count from AdminControlModel
        $tableCount = isset($adminData['table_count']) ? (int) $adminData['table_count'] : 10; // Default to 10

        $data = [
            'waiter_name' => session()->get('waiter_name'),
            'tableCount' => $tableCount,
            'occupiedTables' => $occupiedTables // Send occupied tables to the view
        ];

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
            // Check if the same item already exists for the same table
            $existingOrder = $orderModel->where('tableno', $order->tableno)
                                        ->where('itemname', $order->itemname)
                                        ->first();
    
            if ($existingOrder) {
                // If exists, update the quantity
                $newQuantity = $existingOrder['quantity'] + $order->quantity;
                $orderModel->update($existingOrder['id'], ['quantity' => $newQuantity]);
            } else {
                // If not exists, insert a new row
                $orderData = [
                    'tableno'  => $order->tableno,
                    'itemname' => $order->itemname,
                    'quantity' => $order->quantity
                ];
                $orderModel->insert($orderData);
            }
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
    
        // Fetch order data
        $orderModel = new OrderModel();
        $data['orders'] = $orderModel->getOrdersWithPrice($tableno);
        $data['tableno'] = $tableno;
    
        // Fetch admin control data - matches saveAdminControl() structure
        $adminControlModel = new AdminControlModel();
        $adminData = $adminControlModel->first();
        
        // Handle logo path consistently with saveAdminControl()
        if ($adminData && !empty($adminData['logo'])) {
            // Remove 'uploads/' prefix if it exists (as your save function adds it)
            $logoFile = str_replace('uploads/', '', $adminData['logo']);
            
            // Check file in public/uploads/ where files are saved
            $logoPath = FCPATH . 'public/uploads/' . $logoFile;
            
            if (file_exists($logoPath)) {
                // Construct URL matching your upload path
                $adminData['logo_url'] = base_url('public/uploads/' . $logoFile);
            } else {
                log_message('error', "Logo file not found: " . $logoPath);
                $adminData['logo_url'] = base_url('public/default-logo.png');
            }
        } else {
            $adminData['logo_url'] = base_url('public/default-logo.png');
        }
    
        $data['admincontrol'] = [$adminData];
        $data['billno'] = 'BILL-'.time();
    
        return view('billing', $data);
    }
    
    public function clearBill() {
        $session = session();  // Start session
        $db = \Config\Database::connect();
        
        $tableno = $session->get('tableno'); // Get Table Number from session
        
        if ($tableno) {
            $builder = $db->table('tableorder'); // Corrected table name
            $builder->where('tableno', $tableno);
            $deleted = $builder->delete(); // Remove the records
    
            if ($db->affectedRows() > 0) {
                return service('response')->setJSON(['status' => 'success', 'message' => 'Bill cleared successfully']);
            } else {
                return service('response')->setJSON(['status' => 'error', 'message' => 'No orders found for this table']);
            }
        } else {
            return service('response')->setJSON(['status' => 'error', 'message' => 'Table number not found in session']);
        }
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
