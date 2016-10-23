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

Route::get('/', 'VoteController@getVotePage');


//login and register routes
Route::get('register', 'Auth\AuthController@getRegister');
Route::post('register', 'Auth\AuthController@postRegister');
Route::get('login', 'Auth\AuthController@getLogin');
Route::post('login', 'Auth\AuthController@postLogin');
Route::get('logout', 'Auth\AuthController@getLogout');

//voting routes
Route::get('vote/{name}', 'VoteController@getVote');
Route::get('voteForm', 'VoteController@getVoteForm');
Route::post('postVote', 'VoteController@postVote');
Route::get('verifyForm/{id}', 'VoteController@getVerifyForm');
Route::post('postEmail', 'VoteController@postEmail');
Route::post('postSendVerifyAgain', 'VoteController@postSendVerifyAgain');
Route::post('postVerify', 'VoteController@postVerify');
Route::get('activeVote/{vote}', 'VoteController@getVerify');
Route::get('thankyouForm', 'VoteController@getThankyouForm');
Route::get('redirect/facebook', 'VoteController@redirectToFacebook');
Route::get('vote-facebook/callback', 'VoteController@handleFacebookCallback');
// Route::get('sorryVoteTwitter', 'VoteController@getSorryVoteTwitter');
// Route::get('redirect/twitter', 'VoteController@redirectToTwitter');
// Route::get('vote-twitter/callback', 'VoteController@handleTwitterCallback');

//admin routes
Route::get('cpanel', 'AdminController@cpanel');
Route::get('report', 'AdminController@index');
Route::get('modalAddBooth', 'AdminController@getModalAddBooth');
Route::post('modalAddBooth', 'AdminController@postModalAddBooth');
Route::get('tableBooth', 'AdminController@getTableBooth');
Route::get('modalEditBooth/{id}', 'AdminController@getModalEditBooth');
Route::post('modalEditBooth', 'AdminController@postModalEditBooth');
Route::get('modalDeleteBooth/{id}', 'AdminController@getModalDeleteBooth');
Route::post('modalDeleteBooth', 'AdminController@postModalDeleteBooth');
Route::get('tableVote', 'AdminController@getTableVote');
Route::get('modalDeleteVote/{id}', 'AdminController@getModalDeleteVote');
Route::post('modalDeleteVote', 'AdminController@postModalDeleteVote');
Route::get('modalDeleteAllVote', 'AdminController@getModalDeleteAllVote');
Route::post('modalDeleteAllVote', 'AdminController@postModalDeleteAllVote');
Route::get('tableForbidden', 'AdminController@getTableForbidden');
Route::get('modalAddForbidden', 'AdminController@getModalAddForbidden');
Route::post('modalAddForbidden', 'AdminController@postModalAddForbidden');
Route::get('modalEditForbiddenEmail/{id}', 'AdminController@getModalEditForbidden');
Route::post('modalEditForbiddenEmail', 'AdminController@postModalEditForbidden');
Route::get('modalDeleteForbiddenEmail/{id}', 'AdminController@getModalDeleteForbiddenEmail');
Route::post('modalDeleteForbiddenEmail', 'AdminController@postModalDeleteForbiddenEmail');
Route::get('chartVote', 'AdminController@getChartVote');
Route::post('postEvent', 'AdminController@postEvent');
