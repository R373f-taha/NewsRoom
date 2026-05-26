<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class SanitizeContent implements ValidationRule
{
     /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */

    private ?string $cleanedValue=null;
    private int $minLength=10;

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $this->cleanedValue=$this->sanitize($value);

        if(strlen($this->cleanedValue)<$this->minLength){
            $fail("The $attribute must be at least $this->minLength characters after sanitization.");
        }
    }

    public function sanitize(string $value): string
    {
        // Remove HTML tags and trim whitespace
        $cleaned = strip_tags($value);

       $cleaned=trim($cleaned);

        // Optionally, you could also convert multiple spaces to a single space
        $cleaned = preg_replace('/\s+/', ' ', $cleaned);

       $cleaned = preg_replace('/(.)\1{4,}/', '$1$1', $cleaned);


       $cleaned=strtolower($cleaned);

      $sensitiveWords = ['admin', 'root', 'superuser', 'administrator', 'password', 'hack', 'hacker', 'system', 'security', 'backup', 'bank', 'account', 'transfer', 'withdraw', 'deposit', 'sql', 'injection', 'exploit', 'bypass'];

      $cleaned = str_replace($sensitiveWords, '***', $cleaned);

       $cleaned=str_replace(['&', '<', '>', '"', "'"], ['&amp;', '&lt;', '&gt;', '&quot;', '&#39;'], $cleaned);


        // Store the cleaned value for later retrieval
        $this->cleanedValue = $cleaned;

        return $cleaned;
    }

    public function getCleanedValue(): ?string
    {
        return $this->cleanedValue;
    }

    public static function clean(?string $value): ?string
    {
        if($value===null) return null;

        $instance = new self();

        return $instance->sanitize($value);

    }

}
