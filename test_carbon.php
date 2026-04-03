<?php
require __DIR__."/vendor/autoload.php";
$app = require_once __DIR__."/bootstrap/app.php";
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$now = "2026-04-03";
$deadline = "2026-04-05";

echo \Carbon\Carbon::parse($now)->startOfDay()->diffInDays(\Carbon\Carbon::parse($deadline)->startOfDay(), false);

