<?php

$coreFiles = [
    'app/Console/Kernel.php',
    'app/Exceptions/Handler.php',
    'app/Http/Kernel.php',
    'app/Providers/AppServiceProvider.php',
    'app/Providers/AuthServiceProvider.php',
    'app/Providers/EventServiceProvider.php',
    'app/Providers/RouteServiceProvider.php',
    'bootstrap/app.php',
    'config/app.php',
    'config/auth.php',
    'config/broadcasting.php',
    'config/cache.php',
    'config/database.php',
    'config/filesystems.php',
    'config/hashing.php',
    'config/logging.php',
    'config/mail.php',
    'config/queue.php',
    'config/services.php',
    'config/session.php',
    'config/view.php',
    'database/migrations/2014_10_12_000000_create_users_table.php',
    'database/migrations/2014_10_12_100000_create_password_reset_tokens_table.php',
    'database/migrations/2019_08_19_000000_create_failed_jobs_table.php',
    'database/migrations/2019_12_14_000001_create_personal_access_tokens_table.php',
    'public/index.php',
    'routes/api.php',
    'routes/channels.php',
    'routes/console.php',
    'routes/web.php',
    'storage/app/.gitignore',
    'storage/framework/.gitignore',
    'storage/logs/.gitignore',
    'tests/CreatesApplication.php',
    'tests/TestCase.php',
    '.env.example',
    'artisan',
    'composer.json',
    'package.json',
    'phpunit.xml',
    'vite.config.js',
];

$missingFiles = [];

foreach ($coreFiles as $file) {
    if (!file_exists($file)) {
        $missingFiles[] = $file;
    }
}

if (empty($missingFiles)) {
    echo "All core Laravel files are present.\n";
} else {
    echo "The following core Laravel files are missing:\n";
    foreach ($missingFiles as $file) {
        echo "- $file\n";
    }
}