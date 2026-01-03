<?php

namespace App\Helpers;

use ArPHP\I18N\Arabic;

class ArabicHelper
{
    /**
     * Fix Arabic text for PDF rendering
     * Converts disconnected Arabic letters to their connected form
     * and fixes RTL text direction issues
     */
    public static function fixArabicText($text)
    {
        if (empty($text) || !is_string($text)) {
            return $text;
        }

        // Check if text contains Arabic characters
        if (!preg_match('/[\x{0600}-\x{06FF}]/u', $text)) {
            return $text;
        }

        $arabic = new Arabic();
        
        // Use ArPHP to fix Arabic text rendering
        // This handles both text shaping and BiDi direction
        $fixedText = $arabic->utf8Glyphs($text);
        
        return $fixedText;
    }

    /**
     * Process all Arabic text in an array or object
     */
    public static function processArabicContent($data)
    {
        if (is_string($data)) {
            return self::fixArabicText($data);
        }

        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = self::processArabicContent($value);
            }
        }

        if (is_object($data)) {
            foreach (get_object_vars($data) as $key => $value) {
                $data->$key = self::processArabicContent($value);
            }
        }

        return $data;
    }
}
