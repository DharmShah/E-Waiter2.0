<?php

use CodeIgniter\Router\RouteCollection;
// Waiter model routes
$routes->get('/', 'Home::index');
$routes->post('/login', 'Home::login');  // Handle login form submission
$routes->get('/logout', 'Home::logout'); // or 'Auth::logout' if in Auth controller
$routes->get('/tablebook', 'Home::tablebook');
$routes->get('/menu', 'Home::menu');
$routes->get('/header', 'Home::header');
$routes->get('/vieworder', 'Home::vieworder');
$routes->get('/billing', 'Home::billing');
$routes->get('/home/selectTable/(:num)', 'Home::selectTable/$1');
$routes->post('/order/update', 'Home::updateOrder'); // Update order
$routes->delete('/order/delete/(:num)', 'Home::deleteOrder/$1'); // Delete order
$routes->post('/order/add', 'Home::addOrder'); // Route to add orders
$routes->post('/order/served/(:num)', 'Home::updateOrderServed/$1');
$routes->get('/getOrders', 'Home::getOrders'); // Fetch orders dynamically
$routes->delete('/order/delete/(:num)', 'Home::deleteOrder/$1'); // Delete order
$routes->post('/home/payNow', 'Home::payNow');





$routes->get('/admin', 'Admin::adminindex');  // Admin login page
$routes->post('/adminlogin', 'Admin::login'); // Admin login action
$routes->get('/admindashboard', 'Admin::admindashboard'); // Admin dashboard
$routes->get('/adminlogout', 'Admin::logout'); // Logout admin
$routes->get('/adminsignup', 'Admin::adminsignup'); // Signup page
$routes->post('/logindata', 'Admin::signup'); // Handle signup
$routes->post('admin/save-control', 'Admin::saveAdminControl');
$routes->get('/adminmenu', 'Admin::adminmenu'); // View menu
$routes->get('/admintablestructure', 'Admin::admintablestructure'); // View menu
$routes->post('/admin/addDish', 'Admin::addDish'); // Add new dish
$routes->post('/admin/updateDish', 'Admin::updateDish'); // Update dish
$routes->get('/admin/deleteDish/(:num)', 'Admin::deleteDish/$1');// Delete dish
$routes->get('/adminwaiter', 'Admin::adminwaiter'); // View waiters
$routes->post('/admin/addWaiter', 'Admin::addWaiter'); // Add waiter
$routes->post('/admin/updateWaiter', 'Admin::updateWaiter'); // Update waiter
$routes->get('/admin/deleteWaiter/(:num)', 'Admin::deleteWaiter/$1'); // Delete waiter
$routes->get('/manageTables', 'TableStructure::tablestructure');
$routes->post('/updateTables', 'TableStructure::updateTables');
$routes->get('/admincontrol', 'Admin::adminControl');
$routes->post('/saveAdminControl', 'Admin::saveAdminControl');
$routes->get('/deleteAdminControl/(:num)', 'Admin::deleteAdminControl/$1');
$routes->get('/adminforgotpassword', 'Admin::adminforgotpassword');
$routes->post('/checkPhoneNumber', 'Admin::checkPhoneNumber');
$routes->post('/verifyOTP', 'Admin::verifyOTP');
$routes->post('/resetPassword', 'Admin::resetPassword');


$routes->get('/admin/manageAdmins', 'Admin::manageAdmins'); // View Admins
$routes->post('/admin/addAdmin', 'Admin::addAdmin'); // Add Admin
$routes->post('/admin/updateAdmin', 'Admin::updateAdmin'); // Update Admin
$routes->get('/admin/deleteAdmin/(:num)', 'Admin::deleteAdmin/$1'); // Delete Admin
$routes->get('/admin/editAdmin/(:num)', 'Admin::editAdmin/$1'); // Load Edit Admin Form