<?php

namespace App\Providers;

use App\Interfaces\Auth\AuthInterface;
use App\Interfaces\Configs\ConfigsInterface;
use App\Interfaces\Episodes\EpisodesInterface;
use App\Interfaces\Faqs\FaqsInterface;
use App\Interfaces\Invoices\InvoicesInterface;
use App\Interfaces\Life\LifeInterface;
use App\Interfaces\Profile\ProfileInterface;
use App\Interfaces\Users\UsersInterface;
use App\Repository\Auth\AuthRepository;
use App\Repository\Configs\ConfigsRepository;
use App\Repository\Episodes\EpisodesRepository;
use App\Repository\Faqs\FaqsRepository;
use App\Repository\Invoices\InvoicesRepository;
use App\Repository\Life\LifeRepository;
use App\Repository\Profile\ProfileRepository;
use App\Repository\Users\UsersRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryInterfaceServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthInterface::class,AuthRepository::class);
        $this->app->bind(ProfileInterface::class,ProfileRepository::class);
        $this->app->bind(UsersInterface::class,UsersRepository::class);
        $this->app->bind(FaqsInterface::class,FaqsRepository::class);
        $this->app->bind(EpisodesInterface::class,EpisodesRepository::class);
        $this->app->bind(InvoicesInterface::class,InvoicesRepository::class);
        $this->app->bind(ConfigsInterface::class,ConfigsRepository::class);
        $this->app->bind(LifeInterface::class,LifeRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
