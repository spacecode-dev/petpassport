<?php

namespace App\PetPassport;

use Illuminate\Support\Facades\Route;

class PendingRouteRegistration
{

    /**
     * @return PendingRouteRegistration
     */
    public function withIndexRoutes()
    {
        Route::namespace('App\PetPassport\Controllers')
            ->as('petpassport.')
            ->middleware('web')
            ->group(function () {
                Route::get('/', 'IndexController@index')->name('index');
                Route::prefix('settings')
                    ->group(function() {
                        Route::get('/', 'IndexController@index')->name('index');
                        Route::get('{any}', 'IndexController@index')->where(['any' => '.+']);
                    });
                Route::get('/{any}', 'IndexController@index')->where(['any' => '.+']);
            });

        return $this;
    }

    /**
     * @return PendingRouteRegistration
     */
    public function withAuthenticationRoutes()
    {
        Route::namespace('App\PetPassport\Controllers\Auth')
            ->as('petpassport.')
            ->prefix(PetPassport::apiPath() . '/auth')
            ->group(function () {
                Route::post('login', 'LoginController@login')->name('login');
                Route::post('register', 'RegisterController@register')->name('register');
            });

        Route::namespace('App\PetPassport\Controllers\Auth')
            ->as('petpassport.')
            ->middleware(['api', 'auth:api'])
            ->prefix(PetPassport::apiPath() . '/auth')
            ->group(function () {
                Route::post('logout', 'LoginController@logout')->name('logout');
            });

        return $this;
    }

    /**
     * @return PendingRouteRegistration
     */
    public function withFilemanagerRoutes()
    {
        Route::namespace('App\PetPassport\Controllers')
            ->as('petpassport.')
            ->middleware(['api', 'auth:api'])
            ->prefix(PetPassport::apiPath() . '/filemanager')
            ->group(function () {
                Route::get('data', 'FilemanagerController@getData');
                Route::prefix('actions')
                    ->group(function () {
                        Route::post('move', 'FilemanagerController@move');
                        Route::post('create-folder', 'FilemanagerController@createFolder');
                        Route::post('delete-folder', 'FilemanagerController@deleteFolder');
                        Route::post('get-info', 'FilemanagerController@getInfo');
                        Route::post('remove-file', 'FilemanagerController@removeFile');
                        Route::post('rename-file', 'FilemanagerController@renameFile');
                        Route::post('rename', 'FilemanagerController@rename');
                    });
                Route::prefix('uploads')
                    ->group(function () {
                        Route::post('add', 'FilemanagerController@upload');
                        Route::get('update', 'FilemanagerController@updateFile');
                    });
                Route::prefix('events')
                    ->group(function () {
                        Route::post('folder', 'FilemanagerController@folderUploadedEvent');
                    });
            });

        return $this;
    }

    /**
     * @return PendingRouteRegistration
     */
    public function withAPIRoutes()
    {
        Route::namespace('App\PetPassport\Controllers\Api')
            ->as('petpassport.')
            ->middleware('api')
            ->prefix(PetPassport::apiPath())
            ->group(function () {
                $this->withUsers();
                $this->withProfiles();
                $this->withSettings();
                $this->withPosts();
                $this->withLikes();
//                $this->withShops();
//                $this->withPets();
//                $this->withFriends();
//                $this->withSubscriptions();
//                $this->withAnnouncements();
//                $this->withTransactions();
            });

        return $this;
    }

    /**
     * @return void
     */
    public function withUsers()
    {
        Route::middleware('auth:api')
            ->prefix('user')
            ->group(function () {
                Route::get('/', 'UserController@show')->name('user.show');
                Route::put('/', 'UserController@update')->name('user.update');
                Route::delete('/', 'UserController@destroy')->name('user.destroy');
                $this->withProfile();
            });
    }

    /**
     * @return void
     */
    public function withPosts()
    {
        Route::middleware('auth:api')
            ->prefix('posts')
            ->group(function () {
                Route::get('/', 'PostsController@show')->name('posts.show');
                Route::post('/', 'PostsController@store')->name('posts.store');
                Route::put('/{id}', 'PostsController@update')->name('posts.update');
                Route::delete('/{id}', 'PostsController@destroy')->name('posts.destroy');
            });
    }

    /**
     * @return void
     */
    public function withLikes()
    {
        Route::middleware('auth:api')
            ->prefix('like')
            ->group(function () {
                Route::post('/',   'LikesController@like')->name('likes.post');
                Route::delete('/', 'LikesController@dislike')->name('likes.delete');
            });
    }

    public function withProfile()
    {
        Route::get('/profile', 'UserProfileController@show')->name('userProfile.show');
        Route::put('/profile', 'UserProfileController@update')->name('userProfile.update');
        Route::post('/profile', 'UserProfileController@upload')->name('userProfile.upload');
    }

    public function withProfiles()
    {
        Route::middleware('auth:api')
            ->prefix('profiles')
            ->group(function () {
                Route::get('/{id}/pedigree', 'ProfilesController@pedigree')->name('userProfiles.pedigree');
                Route::get('/{id}/passport', 'ProfilesController@passport')->name('userProfiles.passport');
                Route::get('/{id}/card', 'ProfilesController@card')->name('userProfiles.card');
            });
        Route::prefix('profiles')
            ->group(function () {
//                Route::apiResource('/', 'ProfilesController');
                Route::get('/{query}', 'ProfilesController@show')->name('userProfiles.show');
            });
    }

    public function withSettings()
    {
        Route::middleware('auth:api')
            ->prefix('settings')
            ->group(function () {
                Route::get('/', 'ProfileController@show')->name('userSettings.show');
                Route::put('/', 'ProfileController@update')->name('userSettings.update');
                Route::post('/', 'ProfileController@upload')->name('userSettings.upload');
            });
    }

//    /**
//     * Register the PetPassport shops routes.
//     */
//    public function withShops()
//    {
//        Route::apiResource('shops', 'Api\User\ShopController');
//    }

//    /**
//     * Register the PetPassport pets routes.
//     */
//    public function withPets()
//    {
//        Route::post('pets/link', 'Api\User\PetController@link');
//        Route::post('pets/{id}/login', 'Api\User\PetController@login');
//        Route::apiResource('pets', 'Api\User\PetController');
//    }

//    /**
//     * Register the PetPassport friends routes.
//     */
//    public function withFriends()
//    {
//        Route::get('friends/requests', 'Api\User\FriendController@requests');
//        Route::apiResource('friends', 'Api\User\FriendController');
//    }

//    /**
//     * Register the PetPassport subscriptions & subscribers routes.
//     */
//    public function withSubscriptions()
//    {
//        Route::post('subscriptions', 'Api\User\SubscriptionController@store');
//        Route::delete('subscriptions', 'Api\User\SubscriptionController@destroy');
//        Route::delete('subscribers', 'Api\User\SubscriptionController@destroy_subscriber');
//    }

//    /**
//     * Register the PetPassport announcements routes.
//     */
//    public function withAnnouncements()
//    {
//        Route::get('announcements/favorites', 'Api\User\AnnouncementController@favorites_index');
//        Route::post('announcements/favorites', 'Api\User\AnnouncementController@favorites_store');
//        Route::delete('announcements/favorites/{id}', 'Api\User\AnnouncementController@favorites_destroy');
//        Route::resource('announcements', 'Api\User\AnnouncementController');
//    }

//    /**
//     * Register the PetPassport transactions routes.
//     */
//    public function withTransactions()
//    {
//        Route::resource('transactions', 'Api\User\TransactionsController');
//    }

//    /**
//     * Register the PetPassport password reset routes.
//     * @param array $middleware
//     * @return void
//     */
//    public function withPasswordResetRoutes($middleware = ['web'])
//    {
//        //
//    }
}
