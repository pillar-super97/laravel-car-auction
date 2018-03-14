<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@renderHome');

Route::get('/login', 'AuthenticationController@renderLogin');

Route::post('/login', 'AuthenticationController@login');
Route::get('/logout', 'AuthenticationController@logout');
Route::get('/register', 'AuthenticationController@renderRegister');
Route::post('/register', 'AuthenticationController@register');
Route::post('checkUsername', 'AuthenticationController@checkUsername');
Route::get('/rent', 'RentACarController@render');
Route::get('/contact', 'ContactController@render');

Route::group(['middleware' => 'checkAuth'], function (){
    Route::get('/postcar', 'UploadCarsController@render');
    Route::post('/getmodel', 'UploadCarsController@getModel');
    Route::post('/postcar', 'UploadCarsController@uploadCar');
    Route::get('/mycars', 'MyCarsController@render');
    Route::get('/rented', 'MyCarsController@getRented');
});

Route::group(['middleware' => 'admin'], function (){
    Route::get('/adminpanel', "AdminPanelController@render");
});

Route::group(['prefix' => '/ajax'], function (){
   Route::post('/addforrent', 'MyCarsController@addForRent');
   Route::post('/removerent', 'MyCarsController@removeRent');
   Route::post('/rentacar', 'RentACarController@rentACar');
   Route::post('/rentfinished', 'RentACarController@rentFinished');
   Route::post('/updateuser', 'AdminPanelController@updateUser');
   Route::post('/deleteuser', 'AdminPanelController@deleteUser');
   Route::post('/paginate', 'AdminPanelController@paginateCars');
   Route::post('/getbrands', 'AdminPanelController@getBrands');
   Route::post('/updateCar', 'AdminPanelController@updateCar');
   Route::post('/deleteCar', 'AdminPanelController@deleteCar');
   Route::post('/insertbrand', 'AdminPanelController@insertBrand');
   Route::post('/deleteBrands','AdminPanelController@deleteBrand');
   Route::post('/getmodels', 'AdminPanelController@getModels');
   Route::post('/insertmodel', 'AdminPanelController@insertModel');
   Route::post('/deleteModels','AdminPanelController@deleteModels');
   Route::post('/getanswers', 'ContactController@getAnswers');
   Route::post('/vote', 'ContactController@insertVote');
   Route::post('/insertpoll', 'ContactController@insertPoll');
   Route::post('/deletePolls','ContactController@deletePoll');
   Route::post('/getanswers', 'ContactController@getAnswers');
   Route::post('/insertanswer', 'ContactController@insertAnswer');
   Route::post('/deleteAnswers','ContactController@deleteAnswers');
   Route::post('/deleterent', 'MyCarsController@cancelRent');
});