<?php

function render_view(string $viewName, array $data = []): string
{
    extract($data, EXTR_SKIP);

    ob_start();
    $viewFile = __DIR__ . '/../views/' . $viewName . '.php';

    if (!file_exists($viewFile)) {
        throw new RuntimeException("View not found: {$viewName}");
    }

    include $viewFile;

    return ob_get_clean();
}
