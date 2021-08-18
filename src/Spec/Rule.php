<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Specification\Spec;

use BrenoRoosevelt\Specification\Specification;

/**
 * converts anything to the spec.
 */
class Rule implements Specification
{
    /** @var string|callable|Specification */
    private $rule;

    /**
     * (new MyRule('p1', 'p2'))
     * (MyRule::class)
     * (MyRule::class, 'p1', 'p2')
     * ([MyRule::class, 'p1', 'p2'])
     * (true) // always true
     * ('array_key_exists', ['a', 'b'])  // callable where the first argument is the candidate
     * (function($candidate, $arg) { return (bool) ... }, 'my_arg')
     * (new class { public function __invoke($candidate, $arg) { return (bool) ...} }, 'my_arg')
     * @param bool|string|callable|Specification|array $rule
     */
    public function __construct($rule, ...$args)
    {
        $this->rule = empty($args) ? $rule : array_merge([$rule], $args);
    }

    public function isSatisfiedBy($candidate): bool
    {
        $rule = $this->rule;
        $args = [];

        if (is_bool($rule)) {
            return $rule;
        }

        if (is_array($rule)) {
            $args = $rule;
            $rule = array_shift($rule);
        }

        if (is_string($rule) && class_exists($rule)) {
            $rule = new $rule(...$args);
        }

        if ($rule instanceof Specification) {
            return $rule->isSatisfiedBy($candidate);
        }

        if (is_callable($rule)) {
            return (bool) call_user_func_array($rule, array_merge([$candidate], $args));
        }

        return false;
    }
}
