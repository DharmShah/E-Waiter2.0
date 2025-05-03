<?php
namespace App\Controllers;
use Razorpay\Api\Api;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
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
        // Check if the user is logged in
        $check = $this->checkLogin();
        if ($check) return $check;

        // Check if session has 'tableno'
        if (!session()->has('tableno')) {
            die('⚠ Table number not set in session!');
        }

        $tableno = session()->get('tableno');
        
        // Fetch order details for the current table
        $orderModel = new OrderModel();
        $data['orders'] = $orderModel->getOrdersWithPrice($tableno);
        $data['tableno'] = $tableno;

        // Fetch the company logo
        $adminControlModel = new AdminControlModel();
        $adminData = $adminControlModel->first();
        
        // Check if the logo exists and retrieve it
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

        // Load the billing view
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
    
        // Proceed with Razorpay payment if UPI/Card method is selected
        if ($paymentMode === 'UPI' || $paymentMode === 'Card') {
            $api = new Api('rzp_test_IyD0iDso1IzvXe', 'wHopR0ULyem61vHdzQKYsLwN');
    
            $orderData = [
                'receipt'         => $tableno,
                'amount'          => $totalAmount * 100, // in paise
                'currency'        => 'INR',
                'payment_capture' => 1, // auto capture payment
            ];
    
            try {
                // Create the Razorpay Order
                $razorpayOrder = $api->order->create($orderData);
                $razorpayOrderId = $razorpayOrder['id'];
    
                // Generate Payment Link for UPI
                $paymentLinkData = [
                    'amount'          => $totalAmount * 100, // in paise
                    'currency'        => 'INR',
                    'payment_capture' => 1, // auto capture payment
                    'receipt'         => $tableno,
                ];
    
                $paymentLink = $api->paymentLink->create($paymentLinkData);
                $paymentLinkUrl = $paymentLink['short_url']; // URL for the payment link
    
            } catch (Exception $e) {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'Razorpay order creation failed'
                ]);
            }
    
            // Generate QR Code URL (Razorpay generates a short link for the payment)
            $qrCodeUrl = $paymentLinkUrl;
    
            // Return Razorpay order details and QR code URL to the client-side
            return $this->response->setJSON([
                'status'         => 'success',
                'message'        => 'Payment processing...',
                'razorpay_order' => $razorpayOrderId,
                'total_amount'   => $totalAmount * 100, // in paise
                'currency'       => 'INR',
                'qr_code_url'    => $qrCodeUrl, // Include QR code URL
            ]);
        }
    
        $orderModel->where('tableno', $tableno)->delete();
    
        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Payment completed and order archived successfully!'
        ]);
    }
    
    public function generateQRCode($paymentLinkUrl)
    {
        $qrCode = new QrCode($paymentLinkUrl);
        $writer = new PngWriter();
        $qrCodeImage = $writer->writeString($qrCode);

        // Save or output the QR Code as an image (you can also return it to the frontend)
        file_put_contents('path_to_save/qr_code.png', $qrCodeImage);
        return 'path_to_save/qr_code.png'; // Or return the image as base64 encoded
    }

    // Verify Razorpay payment
    public function verifyPayment()
    {
        $paymentId = $this->request->getPost('payment_id');
        $orderId = $this->request->getPost('order_id');

        $api = new Api('rzp_test_IyD0iDso1IzvXe', 'wHopR0ULyem61vHdzQKYsLwN');

        try {
            // Fetch payment and order details from Razorpay
            $payment = $api->payment->fetch($paymentId);
            $order = $api->order->fetch($orderId);

            // Verify payment status
            if ($payment->status === 'captured') {
                // Payment successful, you can update your database accordingly
                // Redirect to the table booking page
                return redirect()->to('/tablebook'); // Adjust the route to your actual table booking page
            } else {
                // Payment failed
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'Payment verification failed'
                ]);
            }
        } catch (Exception $e) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Payment verification failed: ' . $e->getMessage()
            ]);
        }
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
