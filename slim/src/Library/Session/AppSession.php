<?php

namespace src\Library\Session;

class AppSession {

    public function mark_as_flash($key) {
        if (is_array($key)) {
            for ($i = 0, $c = count($key); $i < $c; $i++) {
                if (!isset($_SESSION[$key[$i]])) {
                    return FALSE;
                }
            }

            $new = array_fill_keys($key, 'new');

            $_SESSION['__ci_vars'] = isset($_SESSION['__ci_vars']) ? array_merge($_SESSION['__ci_vars'], $new) : $new;

            return TRUE;
        }

        if (!isset($_SESSION[$key])) {
            return FALSE;
        }

        $_SESSION['__ci_vars'][$key] = 'new';
        return TRUE;
    }

  
    public function get_flash_keys() {
        if (!isset($_SESSION['__ci_vars'])) {
            return array();
        }

        $keys = array();
        foreach (array_keys($_SESSION['__ci_vars']) as $key) {
            is_int($_SESSION['__ci_vars'][$key]) OR $keys[] = $key;
        }

        return $keys;
    }

    // ------------------------------------------------------------------------

    /**
     * Unmark flash
     *
     * @param	mixed	$key	Session data key(s)
     * @return	void
     */
    public function unmark_flash($key) {
        if (empty($_SESSION['__ci_vars'])) {
            return;
        }

        is_array($key) OR $key = array($key);

        foreach ($key as $k) {
            if (isset($_SESSION['__ci_vars'][$k]) && !is_int($_SESSION['__ci_vars'][$k])) {
                unset($_SESSION['__ci_vars'][$k]);
            }
        }

        if (empty($_SESSION['__ci_vars'])) {
            unset($_SESSION['__ci_vars']);
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Mark as temp
     *
     * @param	mixed	$key	Session data key(s)
     * @param	int	$ttl	Time-to-live in seconds
     * @return	bool
     */
    public function mark_as_temp($key, $ttl = 300) {
        $ttl += time();

        if (is_array($key)) {
            $temp = array();

            foreach ($key as $k => $v) {
                // Do we have a key => ttl pair, or just a key?
                if (is_int($k)) {
                    $k = $v;
                    $v = $ttl;
                } else {
                    $v += time();
                }

                if (!isset($_SESSION[$k])) {
                    return FALSE;
                }

                $temp[$k] = $v;
            }

            $_SESSION['__ci_vars'] = isset($_SESSION['__ci_vars']) ? array_merge($_SESSION['__ci_vars'], $temp) : $temp;

            return TRUE;
        }

        if (!isset($_SESSION[$key])) {
            return FALSE;
        }

        $_SESSION['__ci_vars'][$key] = $ttl;
        return TRUE;
    }

    // ------------------------------------------------------------------------

    /**
     * Get temp keys
     *
     * @return	array
     */
    public function get_temp_keys() {
        if (!isset($_SESSION['__ci_vars'])) {
            return array();
        }

        $keys = array();
        foreach (array_keys($_SESSION['__ci_vars']) as $key) {
            is_int($_SESSION['__ci_vars'][$key]) && $keys[] = $key;
        }

        return $keys;
    }

    // ------------------------------------------------------------------------

    /**
     * Unmark flash
     *
     * @param	mixed	$key	Session data key(s)
     * @return	void
     */
    public function unmark_temp($key) {
        if (empty($_SESSION['__ci_vars'])) {
            return;
        }

        is_array($key) OR $key = array($key);

        foreach ($key as $k) {
            if (isset($_SESSION['__ci_vars'][$k]) && is_int($_SESSION['__ci_vars'][$k])) {
                unset($_SESSION['__ci_vars'][$k]);
            }
        }

        if (empty($_SESSION['__ci_vars'])) {
            unset($_SESSION['__ci_vars']);
        }
    }

    // ------------------------------------------------------------------------

    /**
     * __get()
     *
     * @param	string	$key	'session_id' or a session data key
     * @return	mixed
     */
    public function __get($key) {
        // Note: Keep this order the same, just in case somebody wants to
        //       use 'session_id' as a session data key, for whatever reason
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } elseif ($key === 'session_id') {
            return session_id();
        }

        return NULL;
    }

    // ------------------------------------------------------------------------

    /**
     * __isset()
     *
     * @param	string	$key	'session_id' or a session data key
     * @return	bool
     */
    public function __isset($key) {
        if ($key === 'session_id') {
            return (session_status() === PHP_SESSION_ACTIVE);
        }

        return isset($_SESSION[$key]);
    }

    // ------------------------------------------------------------------------

    /**
     * __set()
     *
     * @param	string	$key	Session data key
     * @param	mixed	$value	Session data value
     * @return	void
     */
    public function __set($key, $value) {
        $_SESSION[$key] = $value;
    }

    // ------------------------------------------------------------------------

    /**
     * Session destroy
     *
     * Legacy CI_Session compatibility method
     *
     * @return	void
     */
    public function sess_destroy() {
        session_destroy();
    }

    // ------------------------------------------------------------------------

    /**
     * Session regenerate
     *
     * Legacy CI_Session compatibility method
     *
     * @param	bool	$destroy	Destroy old session data flag
     * @return	void
     */
    public function sess_regenerate($destroy = FALSE) {
        $_SESSION['__ci_last_regenerate'] = time();
        session_regenerate_id($destroy);
    }

    // ------------------------------------------------------------------------

    /**
     * Get userdata reference
     *
     * Legacy CI_Session compatibility method
     *
     * @returns	array
     */
    public function &get_userdata() {
        return $_SESSION;
    }

    // ------------------------------------------------------------------------

    /**
     * Userdata (fetch)
     *
     * Legacy CI_Session compatibility method
     *
     * @param	string	$key	Session data key
     * @return	mixed	Session data value or NULL if not found
     */
    public function userdata($key = NULL) {
        if (isset($key)) {
            return isset($_SESSION[$key]) ? $_SESSION[$key] : NULL;
        } elseif (empty($_SESSION)) {
            return array();
        }

        $userdata = array();
        $_exclude = array_merge(
                array('__ci_vars'), $this->get_flash_keys(), $this->get_temp_keys()
        );

        foreach (array_keys($_SESSION) as $key) {
            if (!in_array($key, $_exclude, TRUE)) {
                $userdata[$key] = $_SESSION[$key];
            }
        }

        return $userdata;
    }

    // ------------------------------------------------------------------------

    /**
     * Set userdata
     *
     * Legacy CI_Session compatibility method
     *
     * @param	mixed	$data	Session data key or an associative array
     * @param	mixed	$value	Value to store
     * @return	void
     */
    public function set_userdata($data, $value = NULL) {
        if (is_array($data)) {
            foreach ($data as $key => &$value) {
                $_SESSION[$key] = $value;
            }

            return;
        }

        $_SESSION[$data] = $value;
    }

    // ------------------------------------------------------------------------

    /**
     * Unset userdata
     *
     * Legacy CI_Session compatibility method
     *
     * @param	mixed	$data	Session data key(s)
     * @return	void
     */
    public function unset_userdata($key) {
        if (is_array($key)) {
            foreach ($key as $k) {
                unset($_SESSION[$k]);
            }

            return;
        }

        unset($_SESSION[$key]);
    }

    // ------------------------------------------------------------------------

    /**
     * All userdata (fetch)
     *
     * Legacy CI_Session compatibility method
     *
     * @return	array	$_SESSION, excluding flash data items
     */
    public function all_userdata() {
        return $this->userdata();
    }

    // ------------------------------------------------------------------------

    /**
     * Has userdata
     *
     * Legacy CI_Session compatibility method
     *
     * @param	string	$key	Session data key
     * @return	bool
     */
    public function has_userdata($key) {
        return isset($_SESSION[$key]);
    }

    // ------------------------------------------------------------------------

    /**
     * Flashdata (fetch)
     *
     * Legacy CI_Session compatibility method
     *
     * @param	string	$key	Session data key
     * @return	mixed	Session data value or NULL if not found
     */
    public function flashdata($key = NULL) {
        if (isset($key)) {
            return (isset($_SESSION['__ci_vars'], $_SESSION['__ci_vars'][$key], $_SESSION[$key]) && !is_int($_SESSION['__ci_vars'][$key])) ? $_SESSION[$key] : NULL;
        }

        $flashdata = array();

        if (!empty($_SESSION['__ci_vars'])) {
            foreach ($_SESSION['__ci_vars'] as $key => &$value) {
                is_int($value) OR $flashdata[$key] = $_SESSION[$key];
            }
        }

        return $flashdata;
    }

    // ------------------------------------------------------------------------

    /**
     * Set flashdata
     *
     * Legacy CI_Session compatibility method
     *
     * @param	mixed	$data	Session data key or an associative array
     * @param	mixed	$value	Value to store
     * @return	void
     */
    public function set_flashdata($data, $value = NULL) {
        $this->set_userdata($data, $value);
        $this->mark_as_flash(is_array($data) ? array_keys($data) : $data);
    }

    // ------------------------------------------------------------------------

    /**
     * Keep flashdata
     *
     * Legacy CI_Session compatibility method
     *
     * @param	mixed	$key	Session data key(s)
     * @return	void
     */
    public function keep_flashdata($key) {
        $this->mark_as_flash($key);
    }

    // ------------------------------------------------------------------------

    /**
     * Temp data (fetch)
     *
     * Legacy CI_Session compatibility method
     *
     * @param	string	$key	Session data key
     * @return	mixed	Session data value or NULL if not found
     */
    public function tempdata($key = NULL) {
        if (isset($key)) {
            return (isset($_SESSION['__ci_vars'], $_SESSION['__ci_vars'][$key], $_SESSION[$key]) && is_int($_SESSION['__ci_vars'][$key])) ? $_SESSION[$key] : NULL;
        }

        $tempdata = array();

        if (!empty($_SESSION['__ci_vars'])) {
            foreach ($_SESSION['__ci_vars'] as $key => &$value) {
                is_int($value) && $tempdata[$key] = $_SESSION[$key];
            }
        }

        return $tempdata;
    }

    // ------------------------------------------------------------------------

    /**
     * Set tempdata
     *
     * Legacy CI_Session compatibility method
     *
     * @param	mixed	$data	Session data key or an associative array of items
     * @param	mixed	$value	Value to store
     * @param	int	$ttl	Time-to-live in seconds
     * @return	void
     */
    public function set_tempdata($data, $value = NULL, $ttl = 300) {
        $this->set_userdata($data, $value);
        $this->mark_as_temp(is_array($data) ? array_keys($data) : $data, $ttl);
    }

    // ------------------------------------------------------------------------

    /**
     * Unset tempdata
     *
     * Legacy CI_Session compatibility method
     *
     * @param	mixed	$data	Session data key(s)
     * @return	void
     */
    public function unset_tempdata($key) {
        $this->unmark_temp($key);
    }

}
