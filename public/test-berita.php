<?php
// simpan sebagai public/test-berita.php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// Test query
use Illuminate\Support\Facades\DB;

try {
    $jumlah = DB::table('berita')->count();
    $data = DB::table('berita')->get();
    
    echo "<h2>Jumlah Berita: " . $jumlah . "</h2>";
    echo "<pre>";
    print_r($data->toArray());
    echo "</pre>";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}