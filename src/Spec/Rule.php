<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Specification\Spec;

use BrenoRoosevelt\Specification\Specification;
use Respect\Validation\Validatable;

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
     * (true) // always true
     * ('array_key_exists', ['a', 'b'])  // callable where the first argument is the candidate
     * (function($candidate, $arg) { return (bool) ... }, 'my_arg')
     * (new class { public function __invoke($candidate, $arg) { return (bool) ...} }, 'my_arg')
     * @param mixed ...$args
     */
    public function __construct(...$args)
    {
        $this->rule = $args;
    }

    public function isSatisfiedBy($candidate): bool
    {
        $args = $this->rule;
        $rule = array_shift($args);

        if (is_bool($rule)) {
            return $rule;
        }

        if (is_string($rule) && class_exists($rule)) {
            $rule = new $rule(...$args);
        }

        if ($rule instanceof Specification) {
            return $rule->isSatisfiedBy($candidate);
        }

        // Respect/Validation
        if ($rule instanceof Validatable) {
            return $rule->validate($candidate);
        }

        if (is_callable($rule)) {
            return (bool) call_user_func_array($rule, array_merge([$candidate], $args));
        }

        return false;
    }
}
