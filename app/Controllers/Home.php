<?php
namespace App\Controllers;
use App\Models\WaiterModel;
use App\Models\DishModel;
use App\Models\OrderModel;
use App\Models\DailyTransactionModel;
use App\Models\AdminControlModel;

class Home extends BaseController
{
    // ✅ Reusable session check function
    private function checkLogin()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/')->with('error', 'Please login first.');
        }
        return null;
    }

    public function index()
    {
        $adminControlModel = new AdminControlModel();
        $adminData = $adminControlModel->first();

        // Handle login if form is submitted
        if ($this->request->getMethod() === 'post') {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            $admin = $adminControlModel->where('username', $username)->first();

            if ($admin && password_verify($password, $admin['password'])) {
                session()->set([
                    'isAdminLoggedIn' => true,
                    'admin_id' => $admin['id'],
                    'admin_name' => $admin['username']
                ]);
                return redirect()->to('/admin/dashboard');
            } else {
                return redirect()->to('/')->with('error', 'Invalid username or password.');
            }
        }

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

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }

    public function menu()
    {
        $check = $this->checkLogin();
        if ($check) return $check;

        $dishModel = new DishModel();
        $data['dishes'] = $dishModel->findAll();
        $data['categories'] = $dishModel->select('itemcategory, imgurl')->distinct()->findAll();
        $data['tableno'] = session()->get('tableno');

        return view('menu', $data);
    }

    public function tablebook()
    {
        $check = $this->checkLogin();
        if ($check) return $check;

        $adminControlModel = new AdminControlModel();
        $adminData = $adminControlModel->first();

        $orderModel = new OrderModel();
        $orderedTables = $orderModel->select('tableno')->findAll();
        $occupiedTables = array_column($orderedTables, 'tableno');
        $tableCount = isset($adminData['table_count']) ? (int) $adminData['table_count'] : 10;

        $data = [
            'waiter_name' => session()->get('waiter_name'),
            'tableCount' => $tableCount,
            'occupiedTables' => $occupiedTables
        ];

        return view('tablebook', $data);
    }

    public function addOrder()
    {
        $orderModel = new OrderModel();
        $json = $this->request->getJSON();

        if (!$json || !isset($json->orders)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid order data']);
        }

        foreach ($json->orders as $order) {
            $existingOrder = $orderModel->where('tableno', $order->tableno)
                                        ->where('itemname', $order->itemname)
                                        ->first();

            if ($existingOrder) {
                $newQuantity = $existingOrder['quantity'] + $order->quantity;
                $orderModel->update($existingOrder['id'], ['quantity' => $newQuantity]);
            } else {
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

    public function getOrders()
    {
        $check = $this->checkLogin();
        if ($check) return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);

        $tableNo = $this->request->getGet('tableno');
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
        $json = $this->request->getJSON();

        if (!$json || !isset($json->id) || !isset($json->field) || !isset($json->value)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid data']);
        }

        $id = (int) $json->id;
        $field = $json->field;
        $value = $json->value;

        if (!in_array($field, ['quantity', 'notes'])) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid field']);
        }

        if ($field === 'quantity') {
            $value = (int) $value;
        }

        $orderModel->update($id, [$field => $value]);

        return $this->response->setJSON(['status' => 'success', 'message' => 'Order updated']);
    }

    public function updateOrderServed($id)
    {
        $orderModel = new OrderModel();
        $json = $this->request->getJSON();

        if (!$json || !isset($json->served)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request data']);
        }

        $orderModel->update($id, ['served' => (int) $json->served]);

        return $this->response->setJSON(['status' => 'success', 'message' => 'Order served status updated!']);
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

    public function vieworder()
    {
        $check = $this->checkLogin();
        if ($check) return $check;

        return view('vieworder');
    }

    public function billing()
    {
        $check = $this->checkLogin();
        if ($check) return $check;

        if (!session()->has('tableno')) {
            die('⚠ Table number not set in session!');
        }

        $tableno = session()->get('tableno');
        $orderModel = new OrderModel();
        $data['orders'] = $orderModel->getOrdersWithPrice($tableno);
        $data['tableno'] = $tableno;

        $adminControlModel = new AdminControlModel();
        $adminData = $adminControlModel->first();

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

        $data['admincontrol'] = [$adminData];
        $data['billno'] = 'BILL-' . time();

        return view('billing', $data);
    }

    public function payNow()
    {
        $check = $this->checkLogin();
        if ($check) return $this->response->setJSON([
            'status' => 'error',
            'message' => 'User not logged in'
        ]);

        $tableno = session()->get('tableno');
        $paymentMode = $this->request->getPost('paymentmode');

        if (!$paymentMode) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Payment mode is required'
            ]);
        }

        $orderModel = new OrderModel();
        $orders = $orderModel->getOrdersWithPrice($tableno);

        if (empty($orders)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'No orders found for this table'
            ]);
        }

        $itemNames = [];
        $quantities = [];
        $totalAmount = 0;

        foreach ($orders as $order) {
            $itemNames[] = $order['itemname'];
            $quantities[] = $order['quantity'];
            $totalAmount += $order['quantity'] * $order['itemprice'];
        }

        $dailyModel = new DailyTransactionModel();
        $dailyData = [
            'itemname'      => json_encode($itemNames),
            'itemquantitie' => json_encode($quantities),
            'total'         => $totalAmount,
            'paymentmode'   => $paymentMode,
            'tablenumber'   => $tableno,
            'datetime'      => date('Y-m-d H:i:s')
        ];

        if ($dailyModel->insert($dailyData) === false) {
            log_message('error', 'Transaction insert failed: ' . json_encode($dailyModel->errors()));

            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Failed to save transaction',
                'errors'  => $dailyModel->errors()
            ]);
        }

        $orderModel->where('tableno', $tableno)->delete();

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Payment completed and order archived successfully!'
        ]);
    }

    public function selectTable($tableno)
    {
        session()->set('tableno', $tableno);
        return redirect()->to('/menu');
    }

    public function login()
    {
        $waiterModel = new WaiterModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $waiter = $waiterModel->where('waitername', $username)->first();

        if ($waiter) {
            if ($waiter['password'] === $password) {
                session()->set([
                    'waiter_id'   => $waiter['id'],
                    'waiter_name' => $waiter['waitername'],
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
