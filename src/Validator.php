<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Specification;

use BrenoRoosevelt\Specification\Spec\Key;
use DomainException;

class Validator implements Specification
{
    /** @var Validation[] */
    private $rules = [];
    private $notRequired = [];
    private $allowsEmpty = [];

    public function add($rule, $message = null): self
    {
        $this->rules[] = new Validation($rule, $message);
        return $this;
    }

    public function field(string $field, $rule, $message = null): self
    {
        $this->rules[] = new Validation(key($field, rule($rule)), $message);
        return $this;
    }

    public function notRequired(string ...$field): self
    {
        foreach ($field as $key) {
            $this->notRequired[$key] = true;
        }

        return $this;
    }

    public function allowsEmpty(string ...$field): self
    {
        foreach ($field as $key) {
            $this->allowsEmpty[$key] = true;
        }

        return $this;
    }

    public function getErrors($candidate): array
    {
        $errors = [];
        foreach ($this->rules as $rule) {
            $specification = $rule->specification();
            $key = $specification instanceof Key ? $specification->getKey() : null;
            $hasValue = is_string($key) && is_array($candidate) && array_key_exists($key, $candidate);
            $value = $hasValue ? $candidate[$key] : null;
            if (is_string($key) && array_key_exists($key, $this->notRequired) && !$hasValue) {
                continue;
            }

            if (is_string($key) && array_key_exists($key, $this->allowsEmpty) && empty($value)) {
                continue;
            }

            if (!$specification->isSatisfiedBy($candidate)) {
                $errors[$key ?? '_errors'][] = $rule->errorMessage();
            }
        }

        return $errors;
    }

    public function isSatisfiedBy($candidate): bool
    {
        return empty($this->getErrors($candidate));
    }

    public function validate($candidate): void
    {
        $errors = $this->getErrors($candidate);
        if (!empty($errors)) {
            throw new DomainException('Errors');
        }
    }
}
