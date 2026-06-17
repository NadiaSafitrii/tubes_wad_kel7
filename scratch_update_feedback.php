<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

App\Models\Feedback::where('id', 9)->update(['komentar' => 'kondisi kabel baru']);
echo "Updated feedback successfully\n";
