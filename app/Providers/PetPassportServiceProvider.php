<?php

namespace App\Providers;

use App\PetPassport\Models\Announcement\Announcement;
use App\PetPassport\Models\Comment;
use App\PetPassport\Models\Community\Community;
use App\PetPassport\Models\Media\Photo;
use App\PetPassport\Models\Media\Video;
use App\PetPassport\Models\Message;
use App\PetPassport\Models\Post;
use App\PetPassport\Models\Shop;
use App\PetPassport\Models\User\UserProfile;
use App\PetPassport\Observers\MessageObserver;
use App\PetPassport\PetPassport;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class PetPassportServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('petpassport', function () {
            return new PetPassport();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->morph();
        $this->loadHelper();
        $this->routes();
        $this->schedule();
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        PetPassport::routes()
            ->withAPIRoutes()
            ->withAuthenticationRoutes()
            ->withFilemanagerRoutes()
            ->withIndexRoutes();
    }

    protected function loadHelper()
    {
        require_once dirname(__FILE__, 2) . '/PetPassport/helpers.php';
    }

    protected function morph()
    {
        Relation::morphMap([
            'photo' => Photo::class,
            'video' => Video::class,
            'announcement' => Announcement::class,
            'profile' => UserProfile::class,
            'community' => Community::class,
            'shop' => Shop::class,
            'post' => Post::class,
            'comment' => Comment::class
        ]);
        Message::observe(MessageObserver::class);
    }

    protected function schedule() {
        $schedule = app(Schedule::class);
//        $schedule->call(function () {
//            //
//        })->daily();
    }
}
