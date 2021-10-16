<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

//Route::post('/auth/register', 'Api\AuthController@register');
//Route::post('/auth/login',    'Api\AuthController@login');

//Route::middleware('auth:api')->group(function() {

//    Route::post('/auth/logout',   'Api\AuthController@logout');

//    Route::apiResource('user/shops', 'Api\UserShopController');

//    Route::post('/user/pets/link',       'Api\UserPetController@link');
//    Route::post('/user/pets/{id}/login', 'Api\UserPetController@login');
//    Route::apiResource('user/pets',      'Api\UserPetController');

//    Route::get('/user/friends/requests', 'Api\UserFriendController@requests');
//    Route::apiResource('user/friends',   'Api\UserFriendController');

//    Route::post('/user/subscriptions', 'Api\UserSubscriptionController@store');
//    Route::delete('/user/subscriptions', 'Api\UserSubscriptionController@destroy');
//    Route::delete('/user/subscribers', 'Api\UserSubscriptionController@destroy_subscriber');

//    Route::get('/user/announcements/favorites',  'Api\UserAnnouncementController@favorites_index');
//    Route::post('/user/announcements/favorites', 'Api\UserAnnouncementController@favorites_store');
//    Route::delete('/user/announcements/favorites/{id}', 'Api\UserAnnouncementController@favorites_destroy');
//    Route::resource('user/announcements', 'Api\UserAnnouncementController');

//    Route::resource('user/transactions', 'Api\UserTransactionsController');

//    Route::post('/user/login_owner', 'Api\UserPetController@login_owner');

//    Route::get('/user',           'Api\UserController@show');
//    Route::put('/user',           'Api\UserController@update');
//    Route::delete('/user',        'Api\UserController@destroy');
//    Route::get('/user/profile',   'Api\UserProfileController@show');
//    Route::put('/user/profile',   'Api\UserProfileController@update');
//    Route::post('/user/profile',  'Api\UserProfileController@upload');

//    Route::post('/like',   'Api\LikesController@like');
//    Route::delete('/like', 'Api\LikesController@dislike');

//    Route::post('/communities/{id}/membership',   'Api\CommunitiesController@join');
//    Route::delete('/communities/{id}/membership', 'Api\CommunitiesController@leave');

//    Route::delete('/subscribers', 'Api\SubscriptionsController@subscribers_destroy');

//    Route::post('/cart/order', 'Api\CartItemsController@order');
//    Route::apiResource('cart', 'Api\CartItemsController');

//    Route::apiResource('conversations', 'Api\ConversationsController');
//    Route::apiResource('messages', 'Api\MessagesController');
//});
////TODO This is a mess, someone has to fix it.
//Route::apiResource('shops',    'Api\ShopsController');
//Route::get('/profiles/{id}/pedigree', 'Api\ProfilesController@pedigree');
//Route::get('/profiles/{id}/passport', 'Api\ProfilesController@passport');
//Route::get('/profiles/{id}/card', 'Api\ProfilesController@card');
//Route::apiResource('profiles', 'Api\ProfilesController');
//Route::apiResource('friends',  'Api\FriendsController');
//Route::get('/subscribers', 'Api\SubscriptionsController@subscribers');
//Route::apiResource('subscriptions', 'Api\SubscriptionsController');
//Route::apiResource('announcements', 'Api\AnnouncementsController');
//Route::apiResource('posts', 'Api\PostsController');
//Route::apiResource('comments', 'Api\CommentsController');
//Route::apiResource('photos', 'Api\PhotosController');
//Route::apiResource('photo_albums', 'Api\PhotoAlbumsController');
//Route::apiResource('videos', 'Api\VideosController');
//Route::apiResource('video_albums', 'Api\VideoAlbumsController');
//Route::apiResource('countries', 'Api\CountriesController');
//Route::apiResource('cities', 'Api\CitiesController');
//Route::apiResource('reviews', 'Api\ReviewsController');
//Route::apiResource('communities', 'Api\CommunitiesController');
////Route::apiResource('community_members', 'Api\CommunityMembersController');
//// CommunityMembers
//Route::get('/community_members', 'Api\CommunityMembersController@index');
//Route::post('/community_members', 'Api\CommunityMembersController@store');
//Route::delete('/community_members', 'Api\CommunityMembersController@destroy');
//// CommunityRoles
//Route::get('/community_roles', 'Api\CommunityRolesController@index');
//Route::post('/community_roles', 'Api\CommunityRolesController@store');
//Route::delete('/community_roles', 'Api\CommunityRolesController@destroy');
//// CommunityCommunities
//Route::get('/community_communities', 'Api\CommunityCommunitiesController@index');
//Route::post('/community_communities', 'Api\CommunityCommunitiesController@store');
//Route::delete('/community_communities', 'Api\CommunityCommunitiesController@destroy');
//// CommunityUsers
//Route::get('/community_users', 'Api\CommunityUsersController@index');
//Route::post('/community_users', 'Api\CommunityUsersController@store');
//Route::delete('/community_users', 'Api\CommunityUsersController@destroy');
//
//Route::apiResource('community_events', 'Api\CommunityEventsController');
//
//Route::get('/likes', 'Api\LikesController@index');
//
//Route::apiResource('user_communities', 'Api\UserCommunitiesController');
//Route::apiResource('market_categories', 'Api\MarketCategoriesController');
//
////TODO fix this
//Route::apiResource('test', 'TestController');


//Route::post('/fast-search', 'Api\GlobalSearchController@fastSearch');



