<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;
use InvalidArgumentException;

class LaterDateRule implements RuleInterface
{
    public function validate(array $data, string $field, array $params): bool
    {   
        $endDate = $data[$field];
        $startDate = $data[$params[0]];
        
        return $endDate > $startDate;
    }
    public function getMessage(array $data, string $field, array $params): string
    {
        return "'Data Od' musi być późniejsza niż 'Data Do'.";
    }
}