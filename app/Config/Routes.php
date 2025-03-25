<?php

use CodeIgniter\Router\RouteCollection;
// Waiter model routes
$routes->get('/', 'Home::index');
$routes->post('/login', 'Home::login');  // Handle login form submission
$routes->get('/logout', 'Home::logout'); // Logout route
$routes->get('/tablebook', 'Home::tablebook');
$routes->get('/menu', 'Home::menu');
$routes->get('/header', 'Home::header');
$routes->get('/vieworder', 'Home::vieworder');
$routes->get('/billing', 'Home::billing');
$routes->get('/home/selectTable/(:num)', 'Home::selectTable/$1');

$routes->post('/order/update', 'Home::updateOrder'); // Update order
$routes->delete('/order/delete/(:num)', 'Home::deleteOrder/$1'); // Delete order


// Order API route
$routes->post('/order/add', 'Home::addOrder'); // Route to add orders
$routes->post('/order/served/(:num)', 'Home::updateOrderServed/$1');

$routes->get('/getOrders', 'Home::getOrders'); // Fetch orders dynamically
$routes->delete('/order/delete/(:num)', 'Home::deleteOrder/$1'); // Delete order

/** Admin Routes */
$routes->get('/admin', 'Admin::adminindex');  // Admin login page
$routes->post('/adminlogin', 'Admin::login'); // Admin login action
$routes->get('/admindashboard', 'Admin::admindashboard'); // Admin dashboard
$routes->get('/adminlogout', 'Admin::logout'); // Logout admin
$routes->get('/adminsignup', 'Admin::adminsignup'); // Signup page
$routes->post('/logindata', 'Admin::signup'); // Handle signup
$routes->post('admin/save-control', 'Admin::saveAdminControl');



/** Admin Menu Management */
$routes->get('/adminmenu', 'Admin::adminmenu'); // View menu
$routes->post('/admin/addDish', 'Admin::addDish'); // Add new dish
$routes->post('/admin/updateDish', 'Admin::updateDish'); // Update dish
$routes->get('/admin/deleteDish/(:num)', 'Admin::deleteDish/$1');// Delete dish

/** Waiter Management */
$routes->get('/adminwaiter', 'Admin::adminwaiter'); // View waiters
$routes->post('/admin/addWaiter', 'Admin::addWaiter'); // Add waiter
$routes->post('/admin/updateWaiter', 'Admin::updateWaiter'); // Update waiter
$routes->get('/admin/deleteWaiter/(:num)', 'Admin::deleteWaiter/$1'); // Delete waiter


/** Table Structure Management */
$routes->get('/manageTables', 'TableStructure::tablestructure');
$routes->post('/updateTables', 'TableStructure::updateTables');


$routes->get('/admincontrol', 'Admin::adminControl');
$routes->post('/saveAdminControl', 'Admin::saveAdminControl');
$routes->get('/deleteAdminControl/(:num)', 'Admin::deleteAdminControl/$1');