<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Specification\Spec;

use BrenoRoosevelt\Specification\Specification;
use SplObjectStorage;

class Contains implements Specification
{
    /** @var mixed */
    protected $value;

    /** @var bool  */
    protected $strict;

    public function __construct($value, bool $strict = true)
    {
        $this->value = $value;
        $this->strict = $strict;
    }

    public function isSatisfiedBy($candidate): bool
    {
        return $this->contains($this->value, $candidate, $this->strict);
    }

    protected function contains($needle, $haystack, $strict = true): bool
    {
        if (is_string($haystack) && mb_strlen($haystack) > 0 && !is_null($needle)) {
            try {
                $value = (string) $needle;
            } catch (\Throwable $exception) {
                return false;
            }

            return $strict ?
                strpos($haystack, $value) !== false :
                stripos($haystack, $value) !== false;
        }

        if (is_array($haystack)) {
            return in_array($needle, $haystack, $strict);
        }

        if ($haystack instanceof SplObjectStorage) {
            return $haystack->contains($needle);
        }

        if (\BrenoRoosevelt\Specification\is_iterable($haystack)) {
            foreach ($haystack as $value) {
                if ($strict && $value === $needle){
                    return true;
                }

                if (!$strict && $value == $needle) {
                    return true;
                }
            }
        }

        return false;
    }
}
