<?php

namespace Manger\Model;

use Config\Database;

/**
 * NutritionistModel Class
 *
 * Represents the model for managing nutritionist data.
 */
class NutritionistModel
{
    /**
     * @var Database The database instance.
     */
    private $db;

    /**
     * Admin constructor.
     */
    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Get All Users
     *
     * Retrieves all users for the admin dashboard.
     *
     * @return array|false An array of user data if users are found, or false if no users are present.
     */
    public function getUserByFullname($namePart, $userType)
    {
        $sql = "SELECT * FROM users WHERE fullname LIKE CONCAT('%', :namePart, '%') AND role=:userType;";
        $this->db->query($sql);
        $this->db->bind(':namePart', $namePart);
        $this->db->bind(':userType', $userType);


        $results = $this->db->resultSet();

        if ($this->db->rowCount() > 0) {
            return $results;
        } else {
            return false;
        }
    }

    /**
     * checkNotifThenSend
     * 
     * Fetch the email of the user clicked on, then send them a notification through the database
     *
     * @param  mixed $receiverID
     * @param  mixed $senderID
     * @return bool|mixed return the user clicked on on success, to send them an email
     */
    public function checkNotifThenSend($receiverID, $senderID)
    {
        $sql = "SELECT * FROM users WHERE id=:receiverID;";
        $this->db->query($sql);
        $this->db->bind(':receiverID', $receiverID);


        $result = $this->db->single();

        if (!empty($result)) {
            $addQuery = "INSERT INTO notifications (`receiver_id`,`sender_id`,`type`) VALUES (:receiverID,:senderID,1)";
            $this->db->query($addQuery);
            $this->db->bind(':receiverID', $receiverID);
            $this->db->bind(':senderID', $senderID);
            if ($this->db->execute()) { // si les 2 requêtes se sont bien passées on renvoit les données de l'user cliqué
                return $result;
            }
        }

        return false;
    }
}
