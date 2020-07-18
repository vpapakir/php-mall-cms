<?php
class Mail_RFC822
{
    var $address = '';
    var $default_domain = 'localhost';
    var $nestGroups = true;
    var $validate = true;
    var $addresses = array();
    var $structure = array();
    var $error = null;
    var $index = null;
    var $num_groups = 0;
    var $mailRFC822 = true;
    var $limit = null;
    function Mail_RFC822($address = null, $default_domain = null, $nest_groups = null, $validate = null, $limit = null)
    {
        if (isset($address))        $this->address        = $address;
        if (isset($default_domain)) $this->default_domain = $default_domain;
        if (isset($nest_groups))    $this->nestGroups     = $nest_groups;
        if (isset($validate))       $this->validate       = $validate;
        if (isset($limit))          $this->limit          = $limit;
    }
    function parseAddressList($address = null, $default_domain = null, $nest_groups = null, $validate = null, $limit = null)
    {

        if (!isset($this->mailRFC822)) {
            $obj = new Mail_RFC822($address, $default_domain, $nest_groups, $validate, $limit);
            return $obj->parseAddressList();
        }

        if (isset($address))        $this->address        = $address;
        if (isset($default_domain)) $this->default_domain = $default_domain;
        if (isset($nest_groups))    $this->nestGroups     = $nest_groups;
        if (isset($validate))       $this->validate       = $validate;
        if (isset($limit))          $this->limit          = $limit;

        $this->structure  = array();
        $this->addresses  = array();
        $this->error      = null;
        $this->index      = null;

        while ($this->address = $this->_splitAddresses($this->address)) {
            continue;
        }
        
        if ($this->address === false || isset($this->error)) {
            return false;
        }
        set_time_limit(30);
        for ($i = 0; $i < count($this->addresses); $i++){

            if (($return = $this->_validateAddress($this->addresses[$i])) === false
                || isset($this->error)) {
                return false;
            }
            
            if (!$this->nestGroups) {
                $this->structure = arrayMerge($this->structure, $return);
            } else {
                $this->structure[] = $return;
            }
        }

        return $this->structure;
    }
    function _splitAddresses($address)
    {

        if (!empty($this->limit) AND count($this->addresses) == $this->limit) {
            return '';
        }

        if ($this->_isGroup($address) && !isset($this->error)) {
            $split_char = ';';
            $is_group   = true;
        } elseif (!isset($this->error)) {
            $split_char = ',';
            $is_group   = false;
        } elseif (isset($this->error)) {
            return false;
        }
        $parts  = explode($split_char, $address);
        $string = $this->_splitCheck($parts, $split_char);
        if ($is_group) {
            if (strpos($string, ':') === false) {
                $this->error = 'Invalid address: ' . $string;
                return false;
            }
            if (!$this->_splitCheck(explode(':', $string), ':'))
                return false;
            $this->num_groups++;
        }
        $this->addresses[] = array(
                                   'address' => trim($string),
                                   'group'   => $is_group
                                   );
        $address = trim(substr($address, strlen($string) + 1));
        if ($is_group && substr($address, 0, 1) == ','){
            $address = trim(substr($address, 1));
            return $address;
        } elseif (strlen($address) > 0) {
            return $address;
        } else {
            return '';
        }
        return false;
    }
    function _isGroup($address)
    {
        $parts  = explode(',', $address);
        $string = $this->_splitCheck($parts, ',');
        if (count($parts = explode(':', $string)) > 1) {
            $string2 = $this->_splitCheck($parts, ':');
            return ($string2 !== $string);
        } else {
            return false;
        }
    }
    function _splitCheck($parts, $char)
    {
        $string = $parts[0];

        for ($i = 0; $i < count($parts); $i++) {
            if ($this->_hasUnclosedQuotes($string)
                || $this->_hasUnclosedBrackets($string, '<>')
                || $this->_hasUnclosedBrackets($string, '[]')
                || $this->_hasUnclosedBrackets($string, '()')
                || substr($string, -1) == '\\') {
                if (isset($parts[$i + 1])) {
                    $string = $string . $char . $parts[$i + 1];
                } else {
                    $this->error = 'Invalid address spec. Unclosed bracket or quotes';
                    return false;
                }
            } else {
                $this->index = $i;
                break;
            }
        }

        return $string;
    }
    function _hasUnclosedQuotes($string)
    {
        $string     = explode('"', $string);
        $string_cnt = count($string);

        for ($i = 0; $i < (count($string) - 1); $i++)
            if (substr($string[$i], -1) == '\\')
                $string_cnt--;

        return ($string_cnt % 2 === 0);
    }
    function _hasUnclosedBrackets($string, $chars)
    {
        $num_angle_start = substr_count($string, $chars[0]);
        $num_angle_end   = substr_count($string, $chars[1]);

        $this->_hasUnclosedBracketsSub($string, $num_angle_start, $chars[0]);
        $this->_hasUnclosedBracketsSub($string, $num_angle_end, $chars[1]);

        if ($num_angle_start < $num_angle_end) {
            $this->error = 'Invalid address spec. Unmatched quote or bracket (' . $chars . ')';
            return false;
        } else {
            return ($num_angle_start > $num_angle_end);
        }
    }
    function _hasUnclosedBracketsSub($string, &$num, $char)
    {
        $parts = explode($char, $string);
        for ($i = 0; $i < count($parts); $i++){
            if (substr($parts[$i], -1) == '\\' || $this->_hasUnclosedQuotes($parts[$i]))
                $num--;
            if (isset($parts[$i + 1]))
                $parts[$i + 1] = $parts[$i] . $char . $parts[$i + 1];
        }
        
        return $num;
    }
    function _validateAddress($address)
    {
        $is_group = false;

        if ($address['group']) {
            $is_group = true;
            $parts     = explode(':', $address['address']);
            $groupname = $this->_splitCheck($parts, ':');
            $structure = array();
            if (!$this->_validatePhrase($groupname)){
                $this->error = 'Group name did not validate.';
                return false;
            } else {
                if ($this->nestGroups) {
                    $structure = new stdClass;
                    $structure->groupname = $groupname;
                }
            }

            $address['address'] = ltrim(substr($address['address'], strlen($groupname . ':')));
        }
        if ($is_group) {
            while (strlen($address['address']) > 0) {
                $parts       = explode(',', $address['address']);
                $addresses[] = $this->_splitCheck($parts, ',');
                $address['address'] = trim(substr($address['address'], strlen(end($addresses) . ',')));
            }
        } else {
            $addresses[] = $address['address'];
        }

        // Check that $addresses is set, if address like this:
        // Groupname:;
        // Then errors were appearing.
        if (!isset($addresses)){
            $this->error = 'Empty group.';
            return false;
        }

        for ($i = 0; $i < count($addresses); $i++) {
            $addresses[$i] = trim($addresses[$i]);
        }

        // Validate each mailbox.
        // Format could be one of: name <geezer@domain.com>
        //                         geezer@domain.com
        //                         geezer
        // ... or any other format valid by RFC 822.
        array_walk($addresses, array($this, 'validateMailbox'));

        // Nested format
        if ($this->nestGroups) {
            if ($is_group) {
                $structure->addresses = $addresses;
            } else {
                $structure = $addresses[0];
            }

        // Flat format
        } else {
            if ($is_group) {
                $structure = arrayMerge($structure, $addresses);
            } else {
                $structure = $addresses;
            }
        }

        return $structure;
    }

    /**
     * Function to validate a phrase.
     *
     * @access private
     * @param string $phrase The phrase to check.
     * @return boolean Success or failure.
     */
    function _validatePhrase($phrase)
    {
        // Splits on one or more Tab or space.
        $parts = preg_split('/[ \\x09]+/', $phrase, -1, PREG_SPLIT_NO_EMPTY);

        $phrase_parts = array();
        while (count($parts) > 0){
            $phrase_parts[] = $this->_splitCheck($parts, ' ');
            for ($i = 0; $i < $this->index + 1; $i++)
                array_shift($parts);
        }

        for ($i = 0; $i < count($phrase_parts); $i++) {
            // If quoted string:
            if (substr($phrase_parts[$i], 0, 1) == '"') {
                if (!$this->_validateQuotedString($phrase_parts[$i]))
                    return false;
                continue;
            }

            // Otherwise it's an atom:
            if (!$this->_validateAtom($phrase_parts[$i])) return false;
        }

        return true;
    }

    /**
     * Function to validate an atom which from rfc822 is:
     * atom = 1*<any CHAR except specials, SPACE and CTLs>
     * 
     * If validation ($this->validate) has been turned off, then
     * validateAtom() doesn't actually check anything. This is so that you
     * can split a list of addresses up before encoding personal names
     * (umlauts, etc.), for example.
     * 
     * @access private
     * @param string $atom The string to check.
     * @return boolean Success or failure.
     */
    function _validateAtom($atom)
    {
        if (!$this->validate) {
            // Validation has been turned off; assume the atom is okay.
            return true;
        }

        // Check for any char from ASCII 0 - ASCII 127
        if (!preg_match('/^[\\x00-\\x7E]+$/i', $atom, $matches)) {
            return false;
        }

        // Check for specials:
        if (preg_match('/[][()<>@,;\\:". ]/', $atom)) {
            return false;
        }

        // Check for control characters (ASCII 0-31):
        if (preg_match('/[\\x00-\\x1F]+/', $atom)) {
            return false;
        }

        return true;
    }

    /**
     * Function to validate quoted string, which is:
     * quoted-string = <"> *(qtext/quoted-pair) <">
     * 
     * @access private
     * @param string $qstring The string to check
     * @return boolean Success or failure.
     */
    function _validateQuotedString($qstring)
    {
        // Leading and trailing "
        $qstring = substr($qstring, 1, -1);

        // Perform check.
        return !(preg_match('/(.)[\x0D\\\\"]/', $qstring, $matches) && $matches[1] != '\\');
    }

    /**
     * Function to validate a mailbox, which is:
     * mailbox =   addr-spec         ; simple address
     *           / phrase route-addr ; name and route-addr
     * 
     * @access public
     * @param string &$mailbox The string to check.
     * @return boolean Success or failure.
     */
    function validateMailbox(&$mailbox)
    {
        // A couple of defaults.
        $phrase  = '';
        $comment = '';

        // Catch any RFC822 comments and store them separately
        $_mailbox = $mailbox;
        while (strlen(trim($_mailbox)) > 0) {
            $parts = explode('(', $_mailbox);
            $before_comment = $this->_splitCheck($parts, '(');
            if ($before_comment != $_mailbox) {
                // First char should be a (
                $comment    = substr(str_replace($before_comment, '', $_mailbox), 1);
                $parts      = explode(')', $comment);
                $comment    = $this->_splitCheck($parts, ')');
                $comments[] = $comment;

                // +1 is for the trailing )
                $_mailbox   = substr($_mailbox, strpos($_mailbox, $comment)+strlen($comment)+1);
            } else {
                break;
            }
        }

        for($i=0; $i<count(@$comments); $i++){
            $mailbox = str_replace('('.$comments[$i].')', '', $mailbox);
        }
        $mailbox = trim($mailbox);

        // Check for name + route-addr
        if (substr($mailbox, -1) == '>' && substr($mailbox, 0, 1) != '<') {
            $parts  = explode('<', $mailbox);
            $name   = $this->_splitCheck($parts, '<');

            $phrase     = trim($name);
            $route_addr = trim(substr($mailbox, strlen($name.'<'), -1));

            if ($this->_validatePhrase($phrase) === false || ($route_addr = $this->_validateRouteAddr($route_addr)) === false)
                return false;

        // Only got addr-spec
        } else {
            // First snip angle brackets if present.
            if (substr($mailbox,0,1) == '<' && substr($mailbox,-1) == '>')
                $addr_spec = substr($mailbox,1,-1);
            else
                $addr_spec = $mailbox;

            if (($addr_spec = $this->_validateAddrSpec($addr_spec)) === false)
                return false;
        }

        // Construct the object that will be returned.
        $mbox = new stdClass();

        // Add the phrase (even if empty) and comments
        $mbox->personal = $phrase;
        $mbox->comment  = isset($comments) ? $comments : array();

        if (isset($route_addr)) {
            $mbox->mailbox = $route_addr['local_part'];
            $mbox->host    = $route_addr['domain'];
            $route_addr['adl'] !== '' ? $mbox->adl = $route_addr['adl'] : '';
        } else {
            $mbox->mailbox = $addr_spec['local_part'];
            $mbox->host    = $addr_spec['domain'];
        }

        $mailbox = $mbox;
        return true;
    }

    /**
     * This function validates a route-addr which is:
     * route-addr = "<" [route] addr-spec ">"
     *
     * Angle brackets have already been removed at the point of
     * getting to this function.
     * 
     * @access private
     * @param string $route_addr The string to check.
     * @return mixed False on failure, or an array containing validated address/route information on success.
     */
    function _validateRouteAddr($route_addr)
    {
        // Check for colon.
        if (strpos($route_addr, ':') !== false) {
            $parts = explode(':', $route_addr);
            $route = $this->_splitCheck($parts, ':');
        } else {
            $route = $route_addr;
        }

        // If $route is same as $route_addr then the colon was in
        // quotes or brackets or, of course, non existent.
        if ($route === $route_addr){
            unset($route);
            $addr_spec = $route_addr;
            if (($addr_spec = $this->_validateAddrSpec($addr_spec)) === false) {
                return false;
            }
        } else {
            // Validate route part.
            if (($route = $this->_validateRoute($route)) === false) {
                return false;
            }

            $addr_spec = substr($route_addr, strlen($route . ':'));

            // Validate addr-spec part.
            if (($addr_spec = $this->_validateAddrSpec($addr_spec)) === false) {
                return false;
            }
        }

        if (isset($route)) {
            $return['adl'] = $route;
        } else {
            $return['adl'] = '';
        }

        $return = arrayMerge($return, $addr_spec);
        return $return;
    }

    /**
     * Function to validate a route, which is:
     * route = 1#("@" domain) ":"
     * 
     * @access private
     * @param string $route The string to check.
     * @return mixed False on failure, or the validated $route on success.
     */
    function _validateRoute($route)
    {
        // Split on comma.
        $domains = explode(',', trim($route));

        for ($i = 0; $i < count($domains); $i++) {
            $domains[$i] = str_replace('@', '', trim($domains[$i]));
            if (!$this->_validateDomain($domains[$i])) return false;
        }

        return $route;
    }

    /**
     * Function to validate a domain, though this is not quite what
     * you expect of a strict internet domain.
     *
     * domain = sub-domain *("." sub-domain)
     * 
     * @access private
     * @param string $domain The string to check.
     * @return mixed False on failure, or the validated domain on success.
     */
    function _validateDomain($domain)
    {
        // Note the different use of $subdomains and $sub_domains                        
        $subdomains = explode('.', $domain);

        while (count($subdomains) > 0) {
            $sub_domains[] = $this->_splitCheck($subdomains, '.');
            for ($i = 0; $i < $this->index + 1; $i++)
                array_shift($subdomains);
        }

        for ($i = 0; $i < count($sub_domains); $i++) {
            if (!$this->_validateSubdomain(trim($sub_domains[$i])))
                return false;
        }

        // Managed to get here, so return input.
        return $domain;
    }

    /**
     * Function to validate a subdomain:
     *   subdomain = domain-ref / domain-literal
     * 
     * @access private
     * @param string $subdomain The string to check.
     * @return boolean Success or failure.
     */
    function _validateSubdomain($subdomain)
    {
        if (preg_match('|^\[(.*)]$|', $subdomain, $arr)){
            if (!$this->_validateDliteral($arr[1])) return false;
        } else {
            if (!$this->_validateAtom($subdomain)) return false;
        }

        // Got here, so return successful.
        return true;
    }

    /**
     * Function to validate a domain literal:
     *   domain-literal =  "[" *(dtext / quoted-pair) "]"
     * 
     * @access private
     * @param string $dliteral The string to check.
     * @return boolean Success or failure.
     */
    function _validateDliteral($dliteral)
    {
        return !preg_match('/(.)[][\x0D\\\\]/', $dliteral, $matches) && $matches[1] != '\\';
    }

    /**
     * Function to validate an addr-spec.
     *
     * addr-spec = local-part "@" domain
     * 
     * @access private
     * @param string $addr_spec The string to check.
     * @return mixed False on failure, or the validated addr-spec on success.
     */
    function _validateAddrSpec($addr_spec)
    {
        $addr_spec = trim($addr_spec);

        // Split on @ sign if there is one.
        if (strpos($addr_spec, '@') !== false) {
            $parts      = explode('@', $addr_spec);
            $local_part = $this->_splitCheck($parts, '@');
            $domain     = substr($addr_spec, strlen($local_part . '@'));

        // No @ sign so assume the default domain.
        } else {
            $local_part = $addr_spec;
            $domain     = $this->default_domain;
        }

        if (($local_part = $this->_validateLocalPart($local_part)) === false) return false;
        if (($domain     = $this->_validateDomain($domain)) === false) return false;
        
        // Got here so return successful.
        return array('local_part' => $local_part, 'domain' => $domain);
    }

    /**
     * Function to validate the local part of an address:
     *   local-part = word *("." word)
     * 
     * @access private
     * @param string $local_part
     * @return mixed False on failure, or the validated local part on success.
     */
    function _validateLocalPart($local_part)
    {
        $parts = explode('.', $local_part);

        // Split the local_part into words.
        while (count($parts) > 0){
            $words[] = $this->_splitCheck($parts, '.');
            for ($i = 0; $i < $this->index + 1; $i++) {
                array_shift($parts);
            }
        }

        // Validate each word.
        for ($i = 0; $i < count($words); $i++) {
            if ($this->_validatePhrase(trim($words[$i])) === false) return false;
        }

        // Managed to get here, so return the input.
        return $local_part;
    }

    /**
    * Returns an approximate count of how many addresses are
    * in the given string. This is APPROXIMATE as it only splits
    * based on a comma which has no preceding backslash. Could be
    * useful as large amounts of addresses will end up producing
    * *large* structures when used with parseAddressList().
    *
    * @param  string $data Addresses to count
    * @return int          Approximate count
    */
    function approximateCount($data)
    {
        return count(preg_split('/(?<!\\\\),/', $data));
    }
    
    /**
    * This is a email validating function seperate to the rest
    * of the class. It simply validates whether an email is of
    * the common internet form: <user>@<domain>. This can be
    * sufficient for most people. Optional stricter mode can
    * be utilised which restricts mailbox characters allowed
    * to alphanumeric, full stop, hyphen and underscore.
    *
    * @param  string  $data   Address to check
    * @param  boolean $strict Optional stricter mode
    * @return mixed           False if it fails, an indexed array
    *                         username/domain if it matches
    */
    function isValidInetAddress($data, $strict = false)
    {
        $regex = $strict ? '/^([.0-9a-z_-]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,4})$/i' : '/^([*+!.&#$|\'\\%\/0-9a-z^_`{}=?~:-]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,4})$/i';
        if (preg_match($regex, trim($data), $matches)) {
            return array($matches[1], $matches[2]);
        } else {
            return false;
        }
    }
}

?>
