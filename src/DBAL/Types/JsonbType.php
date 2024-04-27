<?php

namespace App\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\JsonType;

class JsonbType extends JsonType
{
    public function getName(): string {
        return 'jsonb';
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string {
        return 'jsonb';
    }
}
