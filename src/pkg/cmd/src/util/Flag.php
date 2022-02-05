<?php namespace Ske\Cli;

use \InvalidArgumentException;

class Flag extends Arg {
    public function __construct (string $name, string $type, mixed $value, null|string|array $aliases = null) {
        parent::__construct($name, $aliases);
        $this->setType($type);
        $this->setValue($value);
    }

    const TYPES = [
        'number',
        'string',
        'boolean',
        'array',
        'null',
    ];

    public static function sanitizeType(string $type): string {
        $type = preg_replace('/\s*\|\s*/s', '|', $type);
        $type = trim($type);
        $type = strtolower($type);
        return $type;
    }

    public static function validateType(string $type): bool {
        return in_array($type, self::TYPES, true);
    }

    protected array $types = [];

    public function setType(string $type): void {
        $type = self::sanitizeType($type);
        if (empty($type))
            throw new InvalidArgumentException('Empty type given');
        $types = explode('|', $type);
        foreach ($types as $type) {
            if (!in_array($type, $this->types)) {
                if (!self::validateType($type))
                    throw new InvalidArgumentException("Unknown type $type");
                $this->types[] = $type;
            }
        }
    }

    public function getType(): string {
        return implode('|', $this->types);
    }

    public function checkValue(mixed $value): bool {
        switch($type = strtolower(gettype($value))) {
            case 'double':
            case 'integer':
                $type = 'number';
                break;
            default:
                break;
        }
        return self::validateType($type) && in_array($type, $this->types, true);
    }

    protected $value;

    public function setValue(mixed $value): void {
        if (!$this->checkValue($value))
            throw new InvalidArgumentException('Invalid value (' . gettype($value) . ') given');
        $this->value = $value;
    }
}
