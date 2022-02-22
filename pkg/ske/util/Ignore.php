<?php namespace Ske\Util;

class Ignore implements \IteratorAggregate, \Countable, \ArrayAccess {
    public function __construct(array $includePatterns = [], array $excludePatterns = []) {
        $this->addIncludePatterns($includePatterns);
        $this->addExcludePatterns($excludePatterns);
    }

    protected $patterns = [];

    public function addIncludePatterns(array $patterns): self {
        foreach($patterns as $pattern) {
            $this->addIncludePattern($pattern);
        }
        return $this;
    }

    public function addIncludePattern($pattern): self {
        $this->addPattern('include', $pattern);
        return $this;
    }

    public function getIncludePatterns(): array {
        return $this->getPatterns('include');
    }

    public function addExcludePatterns(array $patterns): self {
        foreach($patterns as $pattern) {
            $this->addExcludePattern($pattern);
        }
        return $this;
    }

    public function addExcludePattern($pattern): self {
        $this->addPattern('exclude', $pattern);
        return $this;
    }

    public function getExcludePatterns(): array {
        return $this->getPatterns('exclude');
    }

    public function addPattern(string $type, string $pattern): self {
        $this->patterns[$type][] = $pattern;
        return $this;
    }

    public function getPatterns(?string $type = null): array {
        return isset($type) ? $this->patterns[$type] ?? [] : $this->patterns;
    }

    public function isIgnored(string $path): bool {
        return self::isIgnoredByPatterns($path, $this->getIncludePatterns(), $this->getExcludePatterns());
    }

    public static function isIgnoredByPatterns(string $path, array $includePatterns = [], array $excludePatterns = []): bool {
        $isIgnored = false;
        foreach ($includePatterns as $index => $pattern) {
            if (self::isNegation($pattern)) {
                $excludePatterns[] = self::getNegation($pattern);
                unset($includePatterns[$index]);
                continue;
            }
            if(!$isIgnored && self::isIgnoredByPattern($path, $pattern))
                $isIgnored = true;
        }
        if ($isIgnored) {
            foreach ($excludePatterns as $pattern) {
                if (self::isIgnoredByPattern($path, $pattern)) {
                    if (self::isNegation($pattern)) {
                        $pattern = self::getNegation($pattern);
                        $isIgnored = !self::isIgnoredByPattern($path, $pattern);
                    }
                    else $isIgnored = false;
                    break;
                }
            }
        }
        return $isIgnored;
    }

    public static function isIgnoredByIncludes(string $path, array $patterns = []): bool {
        return self::isIgnoredPatterns($path, $patterns, []);
    }

    public static function isIgnoredByExcludes(string $path, array $patterns = []): bool {
        return self::isIgnoredPatterns($path, [], $patterns);
    }

    public static function isIgnoredByPattern(string $path, string $pattern): bool {
        $path = self::normalizePath($path);
        if (self::isComment($pattern)) {
            return false;
        }
        return self::isRoot($pattern) ? self::match($pattern, $path) : self::match($pattern, basename($path));
    }

    public static function normalizePath(string $path): string {
        $path = str_replace('\\', '/', $path);
        $path = rtrim($path, '/');
        return $path;
    }

    public static function isComment(string $pattern): bool {
        return str_starts_with($pattern, '#');
    }

    public static function isNegation(string $pattern): bool {
        return str_starts_with($pattern, '!');
    }

    public static function isRoot(string $pattern): bool {
        return str_starts_with($pattern, '/');
    }

    public static function getNegation(string $pattern): string {
        return substr($pattern, 1);
    }

    public static function match(string $pattern, string $path): bool {
        if (str_ends_with($pattern, '/')) {
            return self::match(substr($pattern, 0, -1), $path) || self::match($pattern . '*', $path);
        }
        return fnmatch($pattern, $path);
    }

    public function getIterator(): \Traversable {
        return new \ArrayIterator($this->patterns);
    }

    public function count(): int {
        return \count($this->patterns);
    }

    public function offsetExists(mixed $offset): bool {
        return isset($this->patterns[$offset]);
    }

    public function offsetGet(mixed $offset): mixed {
        return $this->patterns[$offset];
    }

    public function offsetSet(mixed $offset, mixed $value): void {
        $this->patterns[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void {
        unset($this->patterns[$offset]);
    }

    public function __toString(): string {
        return implode(PHP_EOL, $this->patterns);
    }

    public function __debugInfo(): array {
        return $this->patterns;
    }
}