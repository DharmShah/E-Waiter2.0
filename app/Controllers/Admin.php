<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\DishModel;
use App\Models\WaiterModel;
use App\Models\TableModel;
use App\Models\AdminControlModel;

class Admin extends BaseController
{
    public function adminindex()
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

        return view('adminindex', ['adminData' => $adminData]); // Load admin login view with logo
    }

    public function login()
    {
        $session = session();
        $adminModel = new AdminModel();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $admin = $adminModel->where('username', $username)->first();

        if ($admin && $password === $admin['password']) {
            $session->set([
                'admin_id' => $admin['id'],
                'admin_username' => $admin['username'],
                'logged_in' => true
            ]);
            return redirect()->to('/admindashboard');
        }

        $session->setFlashdata('error', 'Invalid username or password');
        return redirect()->to('/admin');
    }

    public function admindashboard()
    {
        if (!session()->has('admin_id')) {
            return redirect()->to('/admin');
        }
        return view('admindashboard');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/admin');
    }

    public function adminsignup()
    {
        return view('adminsignup');
    }

    public function signup()
    {
        $adminModel = new AdminModel();

        $username = $this->request->getPost('username');
        $phonenumber = $this->request->getPost('phonenumber');
        $password = $this->request->getPost('password');
        $copassword = $this->request->getPost('copassword');

        if ($password !== $copassword) {
            return redirect()->back()->with('error', 'Passwords do not match!');
        }

        $data = [
            'username' => $username,
            'phonenumber' => $phonenumber,
            'password' => $password // Storing password as plain text
        ];

        $adminModel->insert($data);
        return redirect()->to('/admin')->with('success', 'Signup successful! Please login.');
    }

    public function adminwaiter()
    {
        if (!session()->has('admin_id')) {
            return redirect()->to('/admin');
        }

        $WaiterModel = new WaiterModel();
        $data['waiters'] = $WaiterModel->findAll();
    
        return view('adminwaiter', $data);
    }
    
    public function addWaiter()
    {
        $WaiterModel = new WaiterModel();
        
        // Check if waiter already exists
        $existingWaiter = $WaiterModel->where('waitername', $this->request->getPost('waiterName'))
                                    ->first();

        if ($existingWaiter) {
            return redirect()->to('/adminwaiter')->with('error', 'Waiter already exists!');
        }

        // Get raw password from form
        $rawPassword = $this->request->getPost('password');

        // Hash the password using BCRYPT (recommended)
        $hashedPassword = password_hash($rawPassword, PASSWORD_DEFAULT);

        // Insert new waiter
        $data = [
            'waitername'   => $this->request->getPost('waiterName'),
            'phonenumber'  => $this->request->getPost('waiterMobile'),
            'tablealloted' => $this->request->getPost('rangeFrom') . '-' . $this->request->getPost('rangeTo'),
            'password'     => $hashedPassword
        ];

        $WaiterModel->insert($data);

        return redirect()->to('/adminwaiter#waiterList')->with('success', 'Waiter added successfully!');
    }

    
    public function updateWaiter()
    {
        $WaiterModel = new WaiterModel();
        $id = $this->request->getPost('id');
    
        $data = [
            'waitername'   => $this->request->getPost('waitername'),
            'phonenumber'  => $this->request->getPost('phonenumber'),
            'tablealloted' => $this->request->getPost('tablealloted'),
            'password'     => $this->request->getPost('password')
        ];
    
        $WaiterModel->update($id, $data);
    
        return redirect()->to('/adminwaiter');
    }
    
    public function deleteWaiter($id)
    {
        $WaiterModel = new WaiterModel();
        $WaiterModel->delete($id);
    
        return redirect()->to('/adminwaiter');
    }
    
    public function tablestructure()
    {
        if (!session()->has('admin_id')) {
            return redirect()->to('/admin');
        }

        $model = new TableModel();
        $data['tables'] = $model->findAll(); // Fetch all table data
        return view('admin/manage_tables', $data);
    }

    public function updateTables()
    {
        $model = new TableModel();
        $numTables = $this->request->getPost('numTables');

        // Clear existing tables and insert new ones
        $model->truncate();
        for ($i = 1; $i <= $numTables; $i++) {
            $model->insert(['table_number' => $i]);
        }

        return redirect()->to('/manageTables')->with('success', 'Tables updated successfully.');
    }
    public function adminmenu()
    {
        if (!session()->has('admin_id')) {
            return redirect()->to('/admin');
        }

        $dishModel = new DishModel();
        $data['menuItems'] = $dishModel->findAll();
        return view('adminmenu', $data);
    }

    public function addDish()
    {
        $dishModel = new DishModel();

        $dishName = $this->request->getPost('dishName');
        $dishPrice = $this->request->getPost('dishPrice');
        $dishCategory = $this->request->getPost('dishCategory');
        $img = $this->request->getFile('dishImage');

        if (!$dishName || !$dishPrice || !$dishCategory || !$img->isValid()) {
            return redirect()->to('/adminmenu')->with('error', 'Invalid input fields.');
        }

        // Create category folder inside "images" if it doesn't exist
        $categoryFolder = 'images/' . $dishCategory;
        if (!is_dir($categoryFolder)) {
            mkdir($categoryFolder, 0777, true);
        }

        // Generate unique image name and move to category folder
        $imgName = $img->getRandomName();
        $img->move($categoryFolder, $imgName);

        // Save path in database (relative path)
        $imgPath = $dishCategory . '/' . $imgName;

        $dishModel->insert([
            'itemname'     => $dishName,
            'itemprice'    => $dishPrice,
            'itemcategory' => $dishCategory,
            'imgurl'       => $imgPath
        ]);

        return redirect()->to('/adminmenu')->with('success', 'Dish added successfully.');
    }

    public function updateDish()
    {
        $dishModel = new DishModel();
        $id = $this->request->getPost('id');

        // Get existing dish details
        $dish = $dishModel->find($id);
        if (!$dish) {
            return redirect()->to('/adminmenu')->with('error', 'Dish not found.');
        }

        // Process uploaded image
        $img = $this->request->getFile('dishImage');
        $imgName = $this->request->getPost('oldImage'); // Default to old image

        if ($img && $img->isValid() && !$img->hasMoved()) {
            $imgName = $img->getRandomName();
            $img->move('images', $imgName);

            // Delete old image if a new one is uploaded
            if (!empty($dish['imgurl']) && file_exists('images/' . $dish['imgurl'])) {
                unlink('images/' . $dish['imgurl']);
            }
        }

        // Update dish details
        $dishData = [
            'itemname'     => $this->request->getPost('dishName'),
            'itemprice'    => $this->request->getPost('dishPrice'),
            'itemcategory' => $this->request->getPost('dishCategory'),
            'imgurl'       => $imgName,
        ];

        $dishModel->update($id, $dishData);
        return redirect()->to('/adminmenu')->with('success', 'Dish updated successfully.');
    }

    public function deleteDish($id)
    {
        $dishModel = new DishModel();
        $dish = $dishModel->find($id);

        if ($dish) {
            if (!empty($dish['imgurl']) && file_exists('images/' . $dish['imgurl'])) {
                unlink('images/' . $dish['imgurl']);
            }
            $dishModel->delete($id);
        }

        return redirect()->to('/adminmenu')->with('success', 'Dish deleted successfully.');
    }


    public function adminControl() 
    {
        if (!session()->has('admin_id')) {
            return redirect()->to('/admin');
        }

        $model = new AdminControlModel();
        $data['restaurant'] = $model->getRestaurant();
        return view('admincontrol', $data);
    }

    public function saveAdminControl()
    {
        $restaurantModel = new \App\Models\AdminControlModel();
        
        $id = $this->request->getPost('id'); // Check if it's an update

        $data = [
            'name' => $this->request->getPost('name'),
            'address' => $this->request->getPost('address'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'table_count' => $this->request->getPost('table_count'),
            'opening_hours' => $this->request->getPost('opening_hours'),
            'closing_hours' => $this->request->getPost('closing_hours'),
            'cuisine_type' => $this->request->getPost('cuisine_type'),
            'gst_number' => $this->request->getPost('gst_number'),
        ];

        // Handle File Upload
        $file = $this->request->getFile('logo');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName(); // Generate a unique name
            $file->move('public/uploads/', $newName);
            $data['logo'] = 'uploads/' . $newName;
        }

        if ($id) {
            // Update Restaurant
            $restaurantModel->update($id, $data);
            session()->setFlashdata('success', 'Restaurant updated successfully!');
        } else {
            // Insert New Restaurant
            $restaurantModel->insert($data);
            session()->setFlashdata('success', 'Restaurant added successfully!');
        }

        return redirect()->to(base_url('admincontrol'));
    }

    public function deleteAdminControl($id) {
        $db = \Config\Database::connect();
        $builder = $db->table('admin_control');
        
        // Check if record exists
        $query = $builder->getWhere(['id' => $id]);
        if ($query->getRow()) {
            $builder->where('id', $id)->delete();
            session()->setFlashdata('success', 'Restaurant deleted successfully.');
        } else {
            session()->setFlashdata('error', 'Restaurant not found.');
        }
        
        return redirect()->to(base_url('admincontrol'));
    }

    public function adminforgotpassword()
    {
        return view('adminforgotpassword');
    }

    public function checkPhoneNumber()
    {
        $phoneNumber = $this->request->getPost('phonenumber');

        // Validate 10-digit phone number
        if (!preg_match('/^\d{10}$/', $phoneNumber)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid phone number']);
        }

        $adminModel = new AdminModel();
        $user = $adminModel->where('phonenumber', $phoneNumber)->first();

        if ($user) {
            // Generate a 6-digit OTP
            $otp = rand(100000, 999999);
            session()->set('otp', $otp);
            session()->set('otp_phone', $phoneNumber);

            return $this->response->setJSON(['status' => 'success', 'otp' => $otp]);
        } else {
            return $this->response->setJSON(['status' => 'redirect', 'url' => base_url('admin')]);
        }
    }

    public function verifyOTP()
    {
        $enteredOtp = $this->request->getPost('otp');
        $sessionOtp = session()->get('otp');

        if ($enteredOtp == $sessionOtp) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid OTP']);
        }
    }

    public function resetPassword()
    {
        $phoneNumber = session()->get('otp_phone');
        $newPassword = $this->request->getPost('password');

        if (!$phoneNumber) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Session expired']);
        }

        $adminModel = new AdminModel();
        $adminModel->where('phonenumber', $phoneNumber)->set(['password' => $newPassword])->update();

        session()->remove(['otp', 'otp_phone']); // Clear OTP session

        return $this->response->setJSON(['status' => 'success', 'message' => 'Password updated successfully']);
    }

    public function admintablestructure(){
        if (!session()->has('admin_id')) {
            return redirect()->to('/admin');
        }
        return view("admintablestructure");
    }

}