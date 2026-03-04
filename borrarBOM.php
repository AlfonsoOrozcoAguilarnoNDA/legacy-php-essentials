<?php
/*
 * ============================================================================
 * PROYECTO: n/a
 * ============================================================================
 * AUTOR:         Alfonso Orozco Aguilar (vibecodingmexico.com)
 * PERFIL:        DevOps / Programador desde 1991 / Contaduría
 * FECHA:         04 de Marzo, 2026
 * REQUISITOS:    PHP 5.3 - 8.4+ 
 * LICENCIA:      MIT (Libre uso, mantener crédito del autor)
 * * OBJETIVO: Encontrar archivos con BOM en directorios
 *
 * NOTA TÉCNICA:
 * Este es un archivo no intrusivo con dos finalidades
 *   a ) Detectar BOM en archivos php
 *   b ) Encontrar archivos php que tengan la cadena de texto. 
 *
 * Nota: Estas funciones están diseñadas buscando la máxima legibilidad y 
 * compatibilidad entre versiones, evitando sintaxis modernas que rompan 
 * sistemas antiguos.
 */
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html; charset=UTF-8");
// Restricción de IP
$allowed_ips = ['127.0.0.1', '201.103.232.198']; // cambia tu cadena de ip
$client_ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';

if (!in_array($client_ip, $allowed_ips)) {
    die("La dirección IP actual, {$client_ip}, no está autorizada.");
}

// Variable configurable para la cadena a buscar
$searchString = 'predicpdf';   // <-- cámbiala aquí si quieres buscar otra cosa

// Función para detectar BOM
function hasBOM($filename) {
    $fh = fopen($filename, 'r');
    if (!$fh) return false;
    $bytes = fread($fh, 3);
    fclose($fh);
    return $bytes === "\xEF\xBB\xBF";
}

// Directorios a revisar
$dirs = ['.', './aoa'];
$results = [];
$bomFiles = [];
$totalMatches = 0;

// Nombre del archivo actual (para excluirlo)
$currentFile = realpath(__FILE__);

foreach ($dirs as $dir) {
    if (!is_dir($dir)) continue;
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($iterator as $file) {
        if ($file->isFile() && strtolower($file->getExtension()) === 'php') {
            // Excluir el archivo actual
            if (realpath($file->getPathname()) === $currentFile) {
                continue;
            }
            $lines = file($file->getPathname());
            foreach ($lines as $num => $line) {
                if (stripos($line, $searchString) !== false) {
                    $results[] = [
                        'file' => $file->getPathname(),
                        'line' => $num + 1,
                        'content' => htmlspecialchars(trim($line))
                    ];
                    $totalMatches++;
                }
            }
            if (hasBOM($file->getPathname())) {
                $bomFiles[] = $file->getPathname();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Verificación de referencias <?= htmlspecialchars($searchString) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h1 class="mb-4 text-primary">
        <i class="fas fa-search"></i> Resultados de búsqueda de <code><?= htmlspecialchars($searchString) ?></code>
    </h1>

    <?php if (!empty($results)): ?>
        <ol class="list-group list-group-numbered">
            <?php foreach ($results as $r): ?>
                <li class="list-group-item">
                    <strong><i class="fas fa-file-code"></i> Archivo:</strong> <?= $r['file'] ?><br>
                    <strong><i class="fas fa-hashtag"></i> Línea:</strong> <?= $r['line'] ?><br>
                    <strong><i class="fas fa-code"></i> Contenido:</strong> <code><?= $r['content'] ?></code>
                </li>
            <?php endforeach; ?>
        </ol>
        <div class="alert alert-info mt-3">
            <i class="fas fa-calculator"></i> Total de coincidencias encontradas: <strong><?= $totalMatches ?></strong>
        </div>
    <?php else: ?>
        <div class="alert alert-info"><i class="fas fa-info-circle"></i> No se encontraron referencias a <code><?= htmlspecialchars($searchString) ?></code>.</div>
    <?php endif; ?>

    <h2 class="mt-4 text-secondary"><i class="fas fa-file-alt"></i> Verificación BOM</h2>
    <?php if (!empty($bomFiles)): ?>
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i> Los siguientes archivos contienen BOM:<br>
            <ul>
                <?php foreach ($bomFiles as $bf): ?>
                    <li><?= $bf ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php else: ?>
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> No hay archivos con BOM.</div>
    <?php endif; ?>
</div>
</body>
</html>
