<?php
$views = [];
$iter = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('resources/views'));
foreach($iter as $file) {
    if(strpos($file->getFilename(), '.blade.php') !== false) {
        $path = str_replace(['C:\xampp\htdocs\LIBSCHOOL\resources\views\\', 'C:/xampp/htdocs/LIBSCHOOL/resources/views/'], '', $file->getPathname());
        $path = str_replace('\\', '/', $path);
        $views[] = $path;
    }
}

// read all php files in app/Http/Controllers and routes/web.php
$usedViews = [];
$codeFiles = [];
$iter2 = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('app/Http/Controllers'));
foreach($iter2 as $file) {
    if(pathinfo($file->getFilename(), PATHINFO_EXTENSION) == 'php') {
        $codeFiles[] = $file->getPathname();
    }
}
$codeFiles[] = 'routes/web.php';

foreach($codeFiles as $file) {
    $content = file_get_contents($file);
    preg_match_all("/view\s*\(\s*['\"]([^'\"]+)['\"]/", $content, $matches);
    if (!empty($matches[1])) {
        foreach($matches[1] as $v) {
            $usedViews[] = str_replace('.', '/', $v) . '.blade.php';
        }
    }
}

$unused = array_diff($views, $usedViews);
echo "UNUSED VIEWS:\n";
foreach($unused as $u) {
    if (!str_starts_with($u, 'layouts/') && !str_starts_with($u, 'components/') && !str_starts_with($u, 'vendor/') && !str_starts_with($u, 'auth/') && !str_starts_with($u, 'profile/')) {
        echo "- " . $u . "\n";
    }
}
