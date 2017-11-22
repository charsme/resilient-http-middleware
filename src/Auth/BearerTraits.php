<?php
declare(strict_types=1);

namespace Resilient\MiddleWare\Auth;

trait BearerTraits
{
    /**
     * @var array
     */
    private $data;

    /**
     * {@inheritDoc}
     */
    public function set(string $key, $value)
    {
        $this->data[$key] = self::convertValueToScalar($value);
    }

    /**
     * {@inheritDoc}
     */
    public function get(string $key, $default = null)
    {
        if (! $this->has($key)) {
            return self::convertValueToScalar($default);
        }

        return $this->data[$key];
    }

    /**
     * {@inheritDoc}
     */
    public function remove(string $key)
    {
        unset($this->data[$key]);
    }

    /**
     * {@inheritDoc}
     */
    public function clear()
    {
        $this->data = [];
    }

    /**
     * {@inheritDoc}
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, $this->data);
    }

    /**
     * {@inheritDoc}
     */
    public function hasChanged() : bool
    {
        return $this->data !== $this->originalData;
    }

    /**
     * {@inheritDoc}
     */
    public function isEmpty() : bool
    {
        return empty($this->data);
    }

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize()
    {
        return $this->data;
    }

    /**
     * @param int|bool|string|float|array|object|\JsonSerializable $value
     *
     * @return int|bool|string|float|array
     */
    private static function convertValueToScalar($value)
    {
        return json_decode(json_encode($value, \JSON_PRESERVE_ZERO_FRACTION), true);
    }
}
