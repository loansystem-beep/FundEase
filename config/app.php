<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    */
    'name' => env('APP_NAME', 'Laravel'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    */
    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    */
    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    */
    'url' => env('APP_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Set to Nairobi timezone (UTC+3) for accurate local time in Kenya.
    */
    'timezone' => 'Africa/Nairobi',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    */
    'locale' => env('APP_LOCALE', 'en'),

    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

    'faker_locale' => env('APP_FAKER_LOCALE', 'en_US'),

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    */
    'cipher' => 'AES-256-CBC',

    'key' => env('APP_KEY'),

    'previous_keys' => [
        ...array_filter(
            explode(',', env('APP_PREVIOUS_KEYS', ''))
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode Driver
    |--------------------------------------------------------------------------
    */
    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store' => env('APP_MAINTENANCE_STORE', 'database'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    */
    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,

        // 👉 Custom Service Provider for Loan Calculator
        App\Providers\LoanCalculatorServiceProvider::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Loan Calculator Default Configuration
    |--------------------------------------------------------------------------
    */
    'loan_calculator' => [
        // Core inputs
        'principal' => 100000, // Example principal amount
        'rate' => 10, // Annual interest rate in percentage
        'term' => 12, // Term in months
        'method' => 'flat', // Loan method, e.g., flat, reducing_installment
        'period' => 'monthly', // Repayment period, e.g., monthly, weekly
        'type' => 'percentage', // Type of rate, e.g., percentage or fixed

        // Optional schedule overrides
        'decimal_places' => 2,
        'round_up_off_interest' => false,
        'interest_start_date' => '2025-06-01',
        'first_repayment_date' => '2025-07-01',
        'pro_rata_first_repayment' => true,
        'adjust_fees_first_repayment' => true,
        'do_not_adjust_remaining_repayments' => false,
        'first_repayment_amount' => null,
        'last_repayment_amount' => null,
        'override_maturity_date' => null,
        'override_each_repayment_amount' => null,
        'calculate_interest_pro_rata' => false,
        'interest_charge_method' => 'normal',
        'skip_interest_first_n_repayments' => 0,
        'principal_charge_method' => 'normal',
        'skip_principal_first_n_repayments' => 0,
        'skip_principal_until_date' => null,
        'balloon_repayment_amount' => null,
        'move_first_repayment_days' => 0,
    ],

];
