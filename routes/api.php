<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
//api
Route::match(array('POST', 'GET'), '/province', 'API\DataController@province')->name('api.province');
Route::match(array('POST', 'GET'), '/city', 'API\DataController@city')->name('api.city');
Route::match(array('POST', 'GET'), '/districts', 'API\DataController@districts')->name('api.districts');
Route::match(array('POST', 'GET'), '/cost', 'API\DataController@cost')->name('api.cost');

//raja ongkir generate
Route::match(array('POST', 'GET'), '/province/all', 'API\DataController@provinceAll')->name('api.province.all');
Route::match(array('POST', 'GET'), '/city/all', 'API\DataController@cityAll')->name('api.city.all');
Route::match(array('POST', 'GET'), '/provinceCity/all', 'API\DataController@insertProvinceCity')->name('api.provincecity.all');


//chat api
//Route::match(array('GET', 'POST', 'PUT', 'PATCH'), '/chat/getProject', 'API\ChatController@getProject')->name('api.chat.project');
//Route::match(array('GET', 'POST', 'PUT', 'PATCH'), '/chat/getChatByProject', 'API\ChatController@getChatByProject')->name('api.chat.all');
Route::match(array('GET', 'POST', 'PUT', 'PATCH'), '/chat/sendChat', 'API\ChatController@sendChat')->name('api.chat.send');
Route::match(array('GET', 'POST', 'PUT', 'PATCH'), '/chat/chatboxList', 'API\ChatController@chatboxList')->name('api.chat.chatbox');
Route::match(array('GET', 'POST', 'PUT', 'PATCH'), '/chat/getChatByPenjahit', 'API\ChatController@getChatByPenjahit')->name('api.chat.penjahit');
Route::match(array('GET', 'POST', 'PUT', 'PATCH'), '/chat/getChatByIkm', 'API\ChatController@getChatByIkm')->name('api.chat.ikm');
//Route::match(array('GET', 'POST', 'PUT', 'PATCH'), '/chat/listChat', 'API\ChatController@listChat')->name('api.chat.list_chat');

//master api
Route::match(array('GET', 'POST'), '/data/ikm', 'API\MasterController@ikm')->name('api.ikm');
Route::match(array('GET', 'POST'), '/data/penjahit', 'API\MasterController@penjahit')->name('api.penjahit');

//other
Route::match(array('GET', 'POST'), '/other/penawaran_list', 'API\ApiController@penawaran_list')->name('api.penawaran_list');
Route::match(array('GET', 'POST'), '/other/penawaran_get_data', 'API\ApiController@penawaran_get_data')->name('api.penawaran_get_data');
Route::match(array('GET', 'POST'), '/other/penawaran_approve', 'API\ApiController@penawaran_approve')->name('api.penawaran_approve');
Route::match(array('GET', 'POST'), '/other/penawaran_cancel', 'API\ApiController@penawaran_cancel')->name('api.penawaran_cancel');

Route::match(array('GET', 'POST'), '/other/transaksi_list', 'API\ApiController@transaksi_list')->name('api.transaksi_list');
Route::match(array('GET', 'POST'), '/other/transaksi_get_data', 'API\ApiController@transaksi_get_data')->name('api.transaksi_get_data');
Route::match(array('GET', 'POST'), '/other/transaksi_approve', 'API\ApiController@transaksi_approve')->name('api.transaksi_approve');
Route::match(array('GET', 'POST'), '/other/transaksi_update_progress', 'API\ApiController@transaksi_update_progress')->name('api.transaksi_update_progress');
Route::match(array('GET', 'POST'), '/other/transaksi_bukti_transfer', 'API\ApiController@transaksi_bukti_transfer')->name('api.transaksi_bukti_transfer');
Route::match(array('GET', 'POST'), '/other/transaksi_confirm_transfer', 'API\ApiController@transaksi_confirm_transfer')->name('api.transaksi_confirm_transfer');
Route::match(array('GET', 'POST'), '/other/transaksi_lihat_bukti_transfer', 'API\ApiController@transaksi_lihat_bukti_transfer')->name('api.transaksi_lihat_bukti_transfer');
Route::match(array('GET', 'POST'), '/other/transaksi_session', 'API\ApiController@transaksi_session')->name('api.transaksi_session');

Route::match(array('GET', 'POST'), '/other/detail_checkout', 'API\ApiController@detail_checkout')->name('api.detail_checkout');
Route::match(array('GET', 'POST'), '/other/detail_revisi', 'API\ApiController@detail_revisi')->name('api.detail_revisi');

Route::match(array('GET', 'POST'), '/other/review_insert', 'API\ApiController@review_insert')->name('api.review_insert');

Route::match(array('GET', 'POST'), '/revisi/detail_data_transaksi', 'API\ApiController@detail_data_transaksi')->name('api.detail_data_transaksi');
Route::match(array('GET', 'POST'), '/revisi/insert', 'API\ApiController@revisi_insert')->name('api.revisi_insert');

Route::match(array('GET', 'POST'), '/pks/detail', 'API\ApiController@pks_detail')->name('api.pks_detail');
Route::match(array('GET', 'POST'), '/pks/download', 'API\ApiController@pks_download')->name('api.pks_download');