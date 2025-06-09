<?php

namespace App\Validator;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute(Attribute::TARGET_PROPERTY)]
class FlexibleDateTimeConstraint extends Constraint
{
    public string $message = 'The value "{{ value }}" is not a valid datetime.';
}
