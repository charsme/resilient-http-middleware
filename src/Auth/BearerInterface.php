<?php

declare(strict_types=1);

namespace Resilient\MiddleWare\Auth;

interface BearerInterface extends \JsonSerializable
{
    /**
     * Stores a given value in the session
     *
     * @param string                                               $key
     * @param int|bool|string|float|array|object|\JsonSerializable $value allows any nested combination of the previous
     *                                                                    types as well
     *
     * @return void
     */
    public function set(string $key, $value);
    
    /**
     * Retrieves a value from the session - if the value doesn't exist, then it uses the given $default, but transformed
     * into a immutable and safely manipulated scalar or array
     *
     * @param string                                               $key
     * @param int|bool|string|float|array|object|\JsonSerializable $default
     *
     * @return int|bool|string|float|array
     */
    public function get(string $key, $default = null);
    
    /**
     * Removes an item from the session
     *
     * @param string $key
     *
     * @return void
     */
    public function remove(string $key);
    
    /**
     * Clears the contents of the session
     *
     * @return void
     */
    public function clear();
    
    /**
     * Checks whether a given key exists in the session
     *
     * @param string $key
     *
     * @return bool
     */
    public function has(string $key): bool;
    
    /**
     * Checks whether the session has changed its contents since its lifecycle start
     *
     * @return bool
     */
    public function hasChanged() : bool;
    
    /**
     * Checks whether the session contains any data
     *
     * @return bool
     */
    public function isEmpty() : bool;
}
