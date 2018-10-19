<?php
    use PHPHtmlParser\Dom;

function get_indented_ml($string, $count = 0)
{
    $lastCount = 0;
    $indentedString = '';
    $selfClosingTags = ['area', 'base', 'br', 'col', 'embed', 'hr', 'img', 'input', 'link', 'menuitem', 'meta', 'param', 'source', 'track', 'wbr'];

    foreach (preg_split('/((\r?\n)|(\r\n?))/', $string) as $line) {
        $openingMatches = null;
        $closingMatches = null;

        preg_match('/<([a-z0-9]*)[>\s]/', $line, $openingMatches);
        preg_match('/<\/([a-z0-9]*)[>\s]/', $line, $closingMatches);

        if ($closingMatches && !$openingMatches) {
            if ($closingMatches[1] != 'code') {
                --$count;
            } else {
                $count = $lastCount;
            }
        }

        for ($i = 0; $i < $count; ++$i) {
            $indentedString .= '    ';
        }

        if ($openingMatches && !in_array($openingMatches[1], $selfClosingTags) && !$closingMatches) {
            if ($openingMatches[1] != 'code') {
                ++$count;
            } else {
                $lastCount = $count;
                $count = 0;
            }
        }

        $trimmedLine = trim($line);

        if (strlen($trimmedLine) != 0) {
            $indentedString .= $trimmedLine.PHP_EOL;
        }
    }

    return $indentedString;
}
