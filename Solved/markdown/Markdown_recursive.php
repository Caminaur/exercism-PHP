<?php

declare(strict_types=1);

function parseMarkdown(string $markdown, bool $enLista = false): string
{
    if ($markdown === '') {
        return $enLista ? '</ul>' : '';
    }

    $lineas = explode("\n", $markdown, 2);
    $lineaActual = $lineas[0];
    $resto = $lineas[1] ?? '';

    $html = '';

    // Encabezados
    if (preg_match('/^(#{1,6})\s*(.+)/', $lineaActual, $coincidencias)) {
        $nivel = strlen($coincidencias[1]);
        $contenido = formatearTexto($coincidencias[2]);
        $html .= "<h$nivel>$contenido</h$nivel>";
        return $html . parseMarkdown($resto, $enLista);
    }

    // Listas
    if (str_starts_with($lineaActual, '* ')) {
        if (!$enLista) {
            $html .= '<ul>';
            $enLista = true;
        }

        $contenido = formatearTexto(substr($lineaActual, 2));

        if (!str_contains($contenido, '<i>') && !str_contains($contenido, '<em>')) {
            $contenido = "<p>$contenido</p>";
        }

        $html .= "<li>$contenido</li>";

        return $html . parseMarkdown($resto, $enLista);
    }

    // Cierre de lista si estaba abierta
    if ($enLista) {
        $html .= '</ul>';
        $enLista = false;
    }

    $html .= '<p>' . formatearTexto($lineaActual) . '</p>';

    return $html . parseMarkdown($resto, $enLista);
}

function formatearTexto(string $texto): string
{
    $texto = preg_replace('/__(.*?)__/', '<em>$1</em>', $texto);
    $texto = preg_replace('/_(.*?)_/', '<i>$1</i>', $texto);
    return $texto;
}
