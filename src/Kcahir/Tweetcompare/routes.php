<?php


Route::get('/','Kcahir\Tweetcompare\Controllers\TweetcompareController@index');

Route::get('account/add/{screen_name?}', array(
	'as'=>'add',
	'uses'=>'Kcahir\Tweetcompare\Controllers\TweetcompareController@addAccount',
	));



App::bind('\Kcahir\Tweetcompare\Repositories\ServiceRepositoryInterface', '\Kcahir\Tweetcompare\Repositories\TweetsRepository');

// Route::get('test', function(){
// 	var_dump(App::make('\Kcahir\Tweetcompare\Repositories\ServiceRepositoryInterface'));
// });