<?php

namespace Manger\Controller;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\Exception\Exception;
use PHPMailer\PHPMailer\SMTP;

use Manger\Model\ResetPasswordModel;
use Manger\Model\User;
use Manger\Helpers\Session_helper;

class ResetPasswords
{
    private $resetModel;
    private $userModel;
    private $mail;

    public function __construct()
    {
        $this->resetModel = new ResetPasswordModel();
        $this->userModel = new User();

        //Setup PHPMailer
        $this->mail = new PHPMailer();
        $this->mail->isSMTP();
        $this->mail->Host = 'sandbox.smtp.mailtrap.io';
        $this->mail->SMTPAuth = true;
        $this->mail->Port = 2525;
        $this->mail->Username = '2c4e5bb80a4c29';
        $this->mail->Password = '8d600ff75fa3af';
    }

    public function sendEmail()
    {
        //Sanitize POST data
        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);

       

        if ($this->userModel->findUserByEmail($email)) {


            //Will be used to query the user from the database
            $selector = bin2hex(random_bytes(8));
            //Will be used for confirmation once the database entry has been matched
            $token = random_bytes(32);
        $url = 'http://localhost/calorie-tracker-php/calorie-tracker-php/create-new-password&selector=' . $selector . '&validator=' . bin2hex($token);


            //Expiration date will last for half an hour
            $expires = date("U") + 1800;

            if (!$this->resetModel->deleteEmail($email)) {
                echo json_encode(['success' => false, 'message' => 'There was an error 1']);
                exit;
            }

            $hashedToken = password_hash($token, PASSWORD_DEFAULT);
            if (!$this->resetModel->insertToken($email, $selector, $hashedToken, $expires)) {
                echo json_encode(['success' => false, 'message' => 'There was an error 2']);
                exit;
            }

            //Can send Email Now 
            $subject = "Reset your password";
            $message = "<p>We recieved a password reset request.</p>";
            $message .= "<p>Here is your password reset link : </p>";
            $message .= "<a href='" . $url . "'>" . $url . "</a>";

            $this->mail->setFrom('mr.smoke2015@gmail.com');
            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body = $message;
            $this->mail->addAddress($email);

            $this->mail->send();

            echo json_encode(['success' => true]);
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'No user found']);
            exit;
        }
    }

    public function resetPassword()
    {
        //Sanitize POST data
        // Sanitize each POST field individually
        $selector = filter_var(trim($_POST['selector'] ?? ''), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $validator = filter_var(trim($_POST['validator'] ?? ''), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = trim($_POST['password'] ?? ''); // Passwords should generally not be altered, just trimmed.

        // Initialize data
        $data = [
            'selector' => $selector,
            'validator' => $validator,
            'password' => $password
        ];


        
        $url = '../create-new-password.php?selector=' . $data['selector'] . '&validator='
            . $data['validator'];

        $currentDate = date("U");

        if (!$row = $this->resetModel->resetPassword($data['selector'], $currentDate)) {

            echo json_encode(['success' => false, 'message' => 'Sorry. The link is no longer valid']);
            exit;
        }

        $tokenBin = hex2bin($data['validator']);
        $tokenCheck = password_verify($tokenBin, $row->pwdResetToken);
        if (!$tokenCheck) {

            echo json_encode(['success' => false, 'message' => 'You need to re-Submit your reset request']);
            exit;
        }

        $tokenEmail = $row->pwdResetEmail;

        $newPwdHash = password_hash($data['password'], PASSWORD_DEFAULT);
        if (!$this->userModel->resetPassword($newPwdHash, $tokenEmail)) {

            echo json_encode(['success' => false, 'message' => 'There was an error ']);
            exit;
        }

        if (!$this->resetModel->deleteEmail($tokenEmail)) {

            echo json_encode(['success' => false, 'message' => 'There was an error deleting email']);
            exit;
        }

        echo json_encode(['success' => true]);
        exit;
    }
}
