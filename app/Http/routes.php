<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('pages.vote');
});

Route::get('vote/{name}', 'VoteController@getVote');
Route::get('voteForm', 'VoteController@getVoteForm');
Route::post('postVote', 'VoteController@postVote');
Route::get('verifyForm/{id}', 'VoteController@getVerifyForm');
Route::post('postEmail', 'VoteController@postEmail');
Route::post('postVerify', 'VoteController@postVerify');
Route::get('thankyouForm', 'VoteController@getThankyouForm');



Route::get('cpanel', 'AdminController@cpanel');
Route::get('report', 'AdminController@index');
Route::get('modalAddBooth', 'AdminController@getModalAddBooth');
Route::post('modalAddBooth', 'AdminController@postModalAddBooth');
Route::get('tableBooth', 'AdminController@getTableBooth');
Route::get('modalEditBooth/{id}', 'AdminController@getModalEditBooth');
Route::post('modalEditBooth', 'AdminController@postModalEditBooth');
Route::get('modalDeleteBooth/{id}', 'AdminController@getModalDeleteBooth');
Route::post('modalDeleteBooth', 'AdminController@postModalDeleteBooth');
