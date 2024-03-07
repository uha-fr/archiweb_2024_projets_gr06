<?php

namespace Manger\Controller;

use PHPMailer\PHPMailer\PHPMailer;
use Manger\Model\ResetPasswordModel;
use Manger\Model\UserModel;

/**
 * Controller used to reset password
 *
 * Handles the logic for resetting passwords, including sending reset emails and processing password reset requests.
 */
class ResetPasswords
{
    /**
     * @var ResetPasswordModel $resetModel An instance of the ResetPasswordModel class for accessing reset password data.
     */
    private $resetModel;

    /**
     * @var UserModel $userModel An instance of the User class for accessing user data.
     */
    private $userModel;

    /**
     * @var PHPMailer $mail An instance of the PHPMailer class for sending emails.
     */
    private $mail;

    /**
     * ResetPasswords constructor.
     *
     * Initializes a new instance of the ResetPasswords class with associated ResetPasswordModel, User, and PHPMailer instances.
     */
    public function __construct()
    {
        $this->resetModel = new ResetPasswordModel();
        $this->userModel = new UserModel();

        // Setup PHPMailer
        // $this->mail = new PHPMailer();
        // $this->mail->isSMTP();
        // $this->mail->Host = 'sandbox.smtp.mailtrap.io';
        // $this->mail->SMTPAuth = true;
        // $this->mail->Port = 2525;
        // $this->mail->Username = '2c4e5bb80a4c29';
        // $this->mail->Password = '8d600ff75fa3af';

        $this->mail = new PHPMailer();
        $this->mail->isSMTP();
        $this->mail->Host = 'smtp.gmail.com';
        $this->mail->SMTPAuth = true;
        //    $this->mail->Port = 2525;
        $this->mail->Username = 'projetmangergr06@gmail.com';
        $this->mail->Password = ''; // Put the password here 
        $this->mail->SMTPSecure = 'ssl';
        $this->mail->Port = 465;
    }

    /**
     * Send password reset email.
     *
     * This method initiates the process of sending a password reset email to a user.
     * It sanitizes the provided email address via the corresponding Model, checks if the user exists,
     * generates a secure reset link, and sends an email with the reset instructions.  
     *
     * @return void
     */
    public function sendEmail()
    {
        // Sanitize POST data
        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);

        if ($this->userModel->findUserByEmail($email)) {
            // Generate reset link
            $selector = bin2hex(random_bytes(8));
            $token = random_bytes(32);
            $url = 'http://localhost/archiweb_2024_projets_gr06/create-new-password?selector='
                . $selector . '&validator=' . bin2hex($token);
            $expires = date("U") + 1800;

            // Delete any existing entry for this email
            if (!$this->resetModel->deleteEmail($email)) {
                echo json_encode(['success' => false, 'message' => 'There was an error 1']);
                exit;
            }

            $hashedToken = password_hash($token, PASSWORD_DEFAULT);
            if (!$this->resetModel->insertToken($email, $selector, $hashedToken, $expires)) {
                echo json_encode(['success' => false, 'message' => 'There was an error 2']);
                exit;
            }

            // Send Email
            $subject = "Reset your password";
            $message = "<p>We received a password reset request.</p>";
            $message .= "<p>Here is your password reset link:</p>";
            $message .= "<a href='" . $url . "'>" . $url . "</a>";

            $this->mail->setFrom('projetmangergr06@gmail.com');
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

    /**
     * Reset user password.
     *
     * Resets the user's password based on the provided *POST* request.
     * This function processes the password reset request by going through the corresponding Model,
     * validates the provided link, and updates the user's password if the link is valid.
     *
     * @return void
     */
    public function resetPassword()
    {
        // Sanitize POST data
        $selector = filter_var(trim($_POST['selector'] ?? ''), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $validator = filter_var(trim($_POST['validator'] ?? ''), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = trim($_POST['password'] ?? ''); // Passwords should generally not be altered, just trimmed.

        $data = [
            'selector' => $selector,
            'validator' => $validator,
            'password' => $password
        ];

        //Url jamais utilisée ?
        $url = '../create-new-password.php?selector=' . $data['selector'] . '&validator=' . $data['validator'];
        $currentDate = date("U");

        if (!$row = $this->resetModel->resetPassword($data['selector'], $currentDate)) {
            echo json_encode(['success' => false, 'message' => 'Sorry. The link is no longer valid']);
            exit;
        }

        $tokenBin = hex2bin($data['validator']);
        $tokenCheck = password_verify($tokenBin, $row->pwdResetToken);
        if (!$tokenCheck) {
            echo json_encode(['success' => false, 'message' => 'You need to re-submit your reset request']);
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
