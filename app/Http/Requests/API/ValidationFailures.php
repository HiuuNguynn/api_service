<?php

namespace App\Http\Requests\API;

class ValidationFailures
{
    public static function format($failures): array
    {
        $groupedErrors = [];
        foreach ($failures as $failure) {
            $row = $failure->row();
            $attribute = $failure->attribute();
            foreach ($failure->errors() as $message) {
                $groupedErrors[$row][] = "Column {$attribute}: {$message}";
            }
        }
        $formatted = [];
        ksort($groupedErrors);
        foreach ($groupedErrors as $row => $messages) {
            $formatted[] = "Row {$row}:";
            foreach ($messages as $msg) {
                $formatted[] = "  - {$msg}";
            }
        }
        return $formatted;
    }
}