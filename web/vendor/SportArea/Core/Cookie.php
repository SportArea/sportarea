<?php

namespace SportArea\Core;

/**
 * Session handling class
 *
 */
class Cookie
{
    public function set($name, $value = null, $expire = 0, $path = '/', $domain = null, $secure = false, $httpOnly = true)
    {
        // from PHP source code
        if (preg_match("/[=,; \t\r\n\013\014]/", $name)) {
            throw new \InvalidArgumentException(sprintf('The cookie name "%s" contains invalid characters.', $name));
        }

        if (empty($name)) {
            throw new \InvalidArgumentException('The cookie name cannot be empty.');
        }

        // convert expiration time to a Unix timestamp
        if ($expire instanceof \DateTime) {
            $expire = $expire->format('U');
        } elseif (!is_numeric($expire)) {
            $expire = strtotime($expire);

            if (false === $expire || -1 === $expire) {
                throw new \InvalidArgumentException('The cookie expiration time is not valid.');
            }
        }

        setcookie($name, $value, $expire, $path, $domain, $secure, $httpOnly);
    }

    public function get($name)
    {
        if(isset($_COOKIE) && isset($_COOKIE[$name])) {
            return $_COOKIE[$name];
        }

        return false;
    }

    public function delete($name, $path = '/')
    {
        if(isset($_COOKIE[$name])) {
            unset($_COOKIE[$name]);
            setcookie($name, NULL, time()-3600, $path);
            return true;
        } else {
            return false;
        }
    }
}