<?php

declare(strict_types=1);

function parseMarkdown(string $markdown): string
{
    $lines = explode("\n", $markdown);
    $html = '';
    $inList = false;

    foreach ($lines as $line) {
        // Encabezados
        if (preg_match('/^(#{1,6})\s*(.+)/', $line, $m)) {
            $level = strlen($m[1]); // ###### → 6
            $content = formatText($m[2]); // → solve for italic or bold
            $html .= "<h$level>$content</h$level>"; // <h5> Here is some text! </h5>
            continue;
        }

        // If Undordered List <ul></ul>
        if (str_starts_with($line, '* ')) {
            if (!$inList) {
                $html .= '<ul>';
                $inList = true;
            }

            $content = formatText(substr($line, 2)); // <em>$line</em>

            // If there no bold nor em → p
            if (!str_contains($content, '<i>') && !str_contains($content, '<em>')) {
                $content = "<p>$content</p>";
            }

            $html .= "<li>$content</li>";
            continue;
        }
        $html .= '<p>' . formatText($line) . '</p>';
    }


    // Cierre de lista si termina al final
    if ($inList) {
        $html .= '</ul>';
    }

    return $html;
}

function formatText(string $text): string
{
    $text = preg_replace('/__(.*?)__/', '<em>$1</em>', $text); // BOld
    $text = preg_replace('/_(.*?)_/', '<i>$1</i>', $text); // Italic
    return $text;
}
