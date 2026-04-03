<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$b = \App\Models\Borrowing::where('status', 'dikembalikan')->latest('return_date')->first();
$d = \Carbon\Carbon::parse($b->deadline)->startOfDay();
$n = \Carbon\Carbon::today()->startOfDay(); // now()->startOfDay()

echo "Borrowing ID: " . $b->id . "\n";
echo "Deadline: " . $b->deadline . " -> $d\n";
echo "ReturnDate: " . $b->return_date . "\n";
echo "Now (startOfDay): " . $n . "\n";
echo "Is Now > Deadline? " . ($n->gt($d) ? 'YES' : 'NO') . "\n";
echo "Hari Terlambat (diffInDays): " . $n->diffInDays($d) . "\n";
echo "Done.";
