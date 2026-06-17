<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

foreach (App\Models\Feedback::all() as $f) {
    echo "ID: " . $f->id . " | Peminjaman ID: " . $f->peminjaman_id . " | Rating: " . $f->rating . " | Komentar: '" . $f->komentar . "'\n";
}
