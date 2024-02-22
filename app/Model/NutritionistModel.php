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
        if ($userType == "Regular") { // les regular verront les nutritionnistes
            $targetType = "Nutritionist";
        } else if ($userType == "Nutritionist") { // les nutritionnistes verront les regular
            $targetType = "Regular";
        } else { // juste pour éviter les bugs si un admin cherche ( admin n'est pas censé chercher though)
            $targetType = "Admin";
        }
        $sql = "SELECT * FROM users WHERE fullname LIKE CONCAT('%', :namePart, '%') AND role=:targetType LIMIT 4;";
        $this->db->query($sql);
        $this->db->bind(':namePart', $namePart);
        $this->db->bind(':targetType', $targetType);


        $results = $this->db->resultSet();

        if ($this->db->rowCount() > 0) {
            return $results;
        } else {
            return false;
        }
    }

    /**
     * checkIfWaitingNotification
     * 
     * Check if a notification already exists with the given receiver and sender ids and type 1
     *
     * @param int $receiverID
     * @param int $senderID
     * @return bool
     */
    private function checkIfWaitingNotification($receiverID, $senderID)
    {
        $this->db->query("SELECT COUNT(*) FROM notifications WHERE receiver_id = :receiverID AND sender_id = :senderID AND type = 1");
        $this->db->bind(':receiverID', $receiverID);
        $this->db->bind(':senderID', $senderID);
        $this->db->execute();
        $count = $this->db->fetchCount(); // Récupérer le résultat COUNT(*)

        return $count > 0;
    }


    /**
     * checkNotifThenSend
     * 
     * Fetch the email of the user clicked on, then send them a notification through the database
     *
     * @param  mixed $receiverID Id clicked on
     * @param  mixed $senderID Own Id, stocked in the session
     * @return bool|mixed return the user clicked on on success, to send them an email
     */
    public function checkNotifThenSend($receiverID, $senderID)
    {
        $sql = "SELECT * FROM users WHERE id=:receiverID;";
        $this->db->query($sql);
        $this->db->bind(':receiverID', $receiverID);


        $result = $this->db->single();
        if (!empty($result) && !$this->checkIfWaitingNotification($receiverID, $senderID)) {

            //  si utilisateur existe, et si pas de notif déjà en attente d'accept/decline
            $addQuery = "INSERT INTO notifications (`receiver_id`,`sender_id`,`type`) VALUES (:receiverID,:senderID,1)";
            $this->db->query($addQuery);
            $this->db->bind(':receiverID', $receiverID);
            $this->db->bind(':senderID', $senderID);
            if ($this->db->execute()) { // si les 2 requêtes se sont bien passées on renvoit les données de l'user cliqué
                return $result->email;
            }
        }

        return false;
    }


    /**
     * Get All Client for a Nutritionist
     *
     * Retrieves all clients for a given nutritionist from the users table.
     *
     * @param int $nutritionistId The ID of the nutritionist
     * @return array|false An array of user data if users are found, or false if no users are present.
     */
    public function getUsersForNutritionist($nutritionistId)
    {
        $data = array();
        // Construct the SQL query with a join operation
        $sql = "SELECT u.* 
                    FROM users u
                    JOIN nutritionist_client nc ON u.id = nc.client_id
                    WHERE nc.nutritionist_id = :nutritionist_id";


        // Prepare the query
        $this->db->query($sql);
        // Bind the nutritionist ID parameter
        $this->db->bind(':nutritionist_id', $nutritionistId);
        // Execute the query
        $rows = $this->db->resultSet();

        // Check if any rows were returned
        if ($this->db->rowCount() > 0) {
            // If rows are found, iterate through them and add to the data array
            foreach ($rows as $row) {
                $data[] = $row;
            }
            // Return the data array

            return $data;
        } else {
            // If no rows are found, return false
            return false;
        }
    }
}
