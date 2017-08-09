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

Route::get('/', function () {
	if (Auth::user()){
		if (Auth::user()->access_id == '2')
			return View('todolist');
		else
			return Redirect::to('profile');
	}
	else
    	return View('index');
});

Route::post('/', 'CRUDController@login');

Route::get('/login', function(){
	if (Auth::user()){
		if (Auth::user()->access_id == '2'){
			return Redirect::to('todolist');
		}
		else{
			return Redirect::to('profile');
		}
	}
	else{
		return Redirect::to('index');
	}
});

Route::get('/register', function(){
	if (Auth::user()){
		if (Auth::user()->access_id == '2'){
			return View('todolist');
		}
		else{
			return Redirect::to('profile');
		}
	}
	else{
		return View('register');
	}
});

Route::post('/register', 'CRUDController@register');

Route::get('/todolist', function(){
	return view('todolist');
});

Route::post('/todolist', function(){
	return view('todolist');
});

Route::get('todolist', 'CRUDController@todolist');

Route::get('todolist/reset/{date}', 'CRUDController@resetall');

Route::post('todolist/finish/{date}', 'CRUDController@finish');

Route::get('todolist/rekom/{listid}/{dtlid}', 'CRUDController@addToDoListByRecom');

Route::post('todolist/activity/others', 'CRUDController@updateActivityOthers');

Route::post('todolist/activity', 'CRUDController@updateActivity');

Route::post('todolist/reminder', 'CRUDController@setReminder');

Route::post('/todolist/exercise', 'CRUDController@updateExercise');

Route::post('/todolist/weight', 'CRUDController@updateWeight');

Route::get('/todolist/suggest/{date}', 'CRUDController@addSuggest');

Route::get('manage-item-ajax', function(){
	return view('manage-item-ajax');
});
// Route::resource('date_picker', 'CRUDController');
Route::resource('item-ajax', 'CRUDController');

Route::get('/forgotpassword', function(){
	return view('forgot_password');
});

Route::post('/forgotpassword', 'CRUDController@forgotPassword');

Route::get('/testing', function(){
	return view('testing');
});

Route::get('/calories/{jenis}', 'CRUDController@viewCalories');

Route::post('/calories/{jenis}', 'CRUDController@addCalories');

Route::post('/calories/satuan/add', 'CRUDController@addSatuan');

Route::post('calories/addSatuan/{jenis}/{title}/{id}', [
	'uses'=>'CRUDController@addSatuanById',
	'as'=>'calories/addSatuan'
]);

Route::get('calories/{jenis}/{title}/{id}', [
	'uses' =>'CRUDController@viewSubCalories',
	'as' => 'calories'
]);

Route::post('/calories/category/add', 'CRUDController@addCategoryCalories');

Route::get('/scoreboard', 'CRUDController@viewScoreboard');

Route::get('/scoreboard/{category}', 'CRUDController@viewScoreboard');

// Route::get('/tambahlist', function(){
// 	if (Request::ajax()){
// 		return View('tambah_list');
// 	}
// });

Route::get('/menu', function(){
	if (Auth::user()){
		if (Auth::user()->access_id == '2'){
			return view('menu');
		}
		else{
			return View('index_admin');
		}
	}
	else{
		return Redirect::to('/');
	}
});

Route::get('/menu/delete/{jenis}/{menuId}', [
	'uses' =>'CRUDController@deleteMenu',
	'as' => 'menu/delete'
]);

Route::post('/menu/add/{jenis}/{menuName}', 'CRUDController@newMenu');

Route::post('/menu/edit/{menuId}/{menuName}', 'CRUDController@editMenu');

Route::post('/menu/add/list/{menuId}/{menuName}', 'CRUDController@addListMenu');

Route::post('/menu/add-plan', 'CRUDController@insertToDoList');

Route::get('/menu/food/{jenis}', 'CRUDController@viewMenu');

Route::get('/goals', 'CRUDController@viewGoals');

Route::get('/steps', 'CRUDController@viewSteps');

Route::post('/steps', 'CRUDController@readSteps');

Route::get('/steps/{date}', [
	'uses' => 'CRUDController@stepMore',
	'as' => 'steps'
]);

Route::get('/online', 'CRUDController@viewOnline');

Route::get('/notification', 'CRUDController@notification');

Route::get('/profile', 'CRUDController@viewProfile');

Route::post('/profile/{edit}', 'CRUDController@editProfile');

Route::get('/logout', 'CRUDController@logout');