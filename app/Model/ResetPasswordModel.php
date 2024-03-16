<?php

namespace Manger\Model;

use Config\Database;

/**
 * ResetPasswordModel
 * 
 * Model to access the database to reset passwords
 */
class ResetPasswordModel
{

    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * delete recovery email from the database
     *
     * @param  mixed $email
     * @return bool
     */
    public function deleteEmail($email)
    {
        $this->db->query('DELETE FROM pwdreset WHERE pwdResetEmail=:email');
        $this->db->bind(':email', $email);

        return $this->db->execute();
    }

    /**
     * insert token in the database 
     * 
     * Put an email and its associated values such as expiring date in the database
     *
     * @param  mixed $email
     * @param  mixed $selector
     * @param  mixed $hashedToken
     * @param  mixed $expires
     * @return bool
     */
    public function insertToken($email, $selector, $hashedToken, $expires)
    {
        $this->db->query('INSERT INTO pwdreset (pwdResetEmail, pwdResetSelector, pwdResetToken,
        pwdResetExpires) VALUES (:email, :selector, :token, :expires)');
        $this->db->bind(':email', $email);
        $this->db->bind(':selector', $selector);
        $this->db->bind(':token', $hashedToken);
        $this->db->bind(':expires', $expires);

        //Execute
        return $this->db->execute();
    }

    /**
     * get the selector associated if not expired
     *
     * @param  mixed $selector
     * @param  mixed $currentDate
     * @return object|bool
     */
    public function resetPassword($selector, $currentDate)
    {
        $this->db->query('SELECT * FROM pwdReset WHERE pwdResetSelector=:selector AND
            pwdResetExpires >= :currentDate');
        $this->db->bind(':selector', $selector);
        $this->db->bind(':currentDate', $currentDate);

        //Execute
        $row = $this->db->single();

        //check row
        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }
}
