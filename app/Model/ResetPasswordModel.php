<?php

namespace Manger\Model;

use Config\Database;

class ResetPasswordModel
{

    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }

    public function deleteEmail($email)
    {
        $this->db->query('DELETE FROM pwdreset WHERE pwdResetEmail=:email');
        $this->db->bind(':email', $email);

        //Execute
        return $this->db->execute();
    }

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
