# Laravel Boiler plate 
 - tall preset [https://github.com/laravel-frontend-presets/tall]

 - debug bar [https://github.com/barryvdh/laravel-debugbar] dev only
 - Laravel N+1 Query Detector [https://github.com/beyondcode/laravel-query-detector] dev only
 - telescope [https://github.com/laravel/telescope] dev only

 - log viewer [https://github.com/opcodesio/log-viewer]
 - wire ui [https://github.com/wireui/wireui]


## setup/fixed

login use email and/or username
limited log viewer to some user
set timezone bangkok
set locale thai


# Step
    - tall preset [https://github.com/laravel-frontend-presets/tall]
    ## install
    ```
    composer require livewire/livewire laravel-frontend-presets/tall
    ```
    ## setup
    option (--auth) if need auth
    ```
    php artisan ui tall
    ```
    ## post setup
    ```
    npm install
    npm run dev
    ```

composer install & pas