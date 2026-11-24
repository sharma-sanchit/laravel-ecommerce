<?php

namespace App\Providers;

use App\Contracts\PaymentGateway;
use App\Contracts\ProductRepositoryInterface;
use App\Repositories\EloquentProductRepository;
use App\Services\RazorpayPaymentService;
use App\Services\StripePaymentService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PaymentGateway::class, RazorpayPaymentService::class);
        $this->app->bind(ProductRepositoryInterface::class, EloquentProductRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
