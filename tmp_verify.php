<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Borrowing;
use App\Models\Fine;

$user = User::where('username', 'siswa9')->first();
$borrowing = Borrowing::find(72);
$fines = Fine::where('borrowing_id', 72)->get();

echo "Borrowing 72 - Deadline: {$borrowing->deadline} | Status: {$borrowing->status}\n";
echo "Total fines pada borrowing 72: " . $fines->count() . "\n";
foreach($fines as $f) {
    echo "  Fine ID: {$f->id} | Amount: Rp " . number_format($f->amount) . " | Status: {$f->payment_status}\n";
}
