<?php
namespace App\Controllers;

use App\Models\ChefModel;
use App\Models\OrderModel;
use App\Models\AdminControlModel;
use App\Controllers\BaseController;

class Chef extends BaseController
{
    public function chef()
{
    $adminControlModel = new \App\Models\AdminControlModel();
    $adminData = $adminControlModel->first();

    if ($adminData && !empty($adminData['logo'])) {
        $logoFile = basename($adminData['logo']);
        $logoPath = FCPATH . 'public/uploads/' . $logoFile;

        if (file_exists($logoPath)) {
            $logoUrl = base_url('public/uploads/' . $logoFile);
        } else {
            log_message('error', "Logo file not found: " . $logoPath);
            $logoUrl = base_url('public/default-logo.png');
        }
    } else {
        $logoUrl = base_url('public/default-logo.png');
    }

    return view('chef', ['logoUrl' => $logoUrl]);
}


    public function checkchef()
    {
        $session = session();
        $request = \Config\Services::request();

        $name = $request->getPost('name');
        $password = $request->getPost('password');

        $chefModel = new ChefModel();
        $chef = $chefModel->where('name', $name)->first();

        if ($chef && $chef['password'] === $password) {
            $session->set([
                'chef_id' => $chef['id'],
                'chef_name' => $chef['name'],
                'is_logged_in' => true
            ]);
            return redirect()->to('/chefdashboard');
        }

        $session->setFlashdata('error', 'Invalid credentials');
        return redirect()->to('/chef');
    }

    public function chefdashboard()
    {
        if (!session()->get('is_logged_in')) {
            return redirect()->to('/chef')->with('error', 'Please log in first.');
        }

        $orderModel = new OrderModel();
        $orders = $orderModel->orderBy('id', 'DESC')->findAll();

        return view('chefdashboard', ['orders' => $orders]);
    }

    public function markPrepared($id)
    {
        $orderModel = new OrderModel();
        $order = $orderModel->find($id);

        if ($order && $order['served'] == 0) {
            $orderModel->update($id, ['served' => 1]);
        }

        return redirect()->to('/chefdashboard');
    }

    public function cheflogout()
    {
        session()->destroy();
        return redirect()->to('/chef')->with('error', 'You have been logged out.');
    }
}
