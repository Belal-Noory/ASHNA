<?php
require_once('phpmailer/autoload.php');
class helper
{
    public static function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public static function sendMail($toMail, $subject, $mailBody)
    {
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->IsSMTP(); // enable SMTP 
        $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth = true; // authentication enabled
        $mail->Host = 'smtp.gmail.com';
        $mail->Port =     587; // or 587
        $mail->IsHTML(true);
        $mail->Username = 'belalnoory2@gmail.com';
        $mail->Password = '143kakaw';
        $mail->SetFrom('belalnoory2@gmail.com', 'ALS');
        $mail->Subject = 'ALS Account password';
        $mail->Body = $mailBody;
        $mail->AddAddress($toMail);
        if (!$mail->Send()) {
            return 'MailerError';
        } else {
            return 'sent';
        }
    }

    public static function generateRandomPass($length = null)
    {
        $pass = null;
        if (is_null($length)) {
            $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%&';
            $pass = substr(str_shuffle($chars), 0);
        } else {
            $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%&';
            $pass = substr(str_shuffle($chars), 0, $length);
        }
        return $pass;
    }

    public static function addLogin($email, $pass, $role)
    {
        $query = 'INSERT INTO login(email,password,user) VALUES(?,?,?)';
        $params = [$email, $pass, $role];
        $con = new Connection();
        $con->Query($query, $params);
    }


    public static function changeTimestape($timestamp)
    {
        $when = '';
        $duration = time() - $timestamp;
        if ($duration < 60) {
            if ($duration < 0) {
                $when = date('d/m/Y', $timestamp);
            } else {
                $when = $duration . ' s';
            }
        } else if ($duration < 3600) {
            $when = round($duration / 60, 0) . ' m';
        } else if ($duration < 86400) {
            $when = round($duration / 3600, 0) . ' h';
        } else if ($duration < 2073600) {
            $when = round($duration / 86400, 0) . ' d';
        } else {
            $when = date('d/m/Y', $timestamp);
        }

        return $when;
    }

    public static function csvToDB($query, $params)
    {
        $con = new Connection();
        $res = $con->Query($query, $params);
        return $res->rowCount();
    }

    public static function generateExcel($PDORow, $filename, $header)
    {
        header('Content-Encoding: UTF-8');
        header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
        header('Content-Disposition: attachment; filename= $filename.xls');
        // header('Cache-Control: max-age=0');
        // header('Cache-Control: max-age=1');
        header('Pragma: no-cache');
        header('expires: 0');
        header('Content-Transfer-Encoding: binary');
        echo '\xEF\xBB\xBF';

        $table = "<table style='width:100%;direction:rtl' lang='fa' border='1px'><tr>";
        foreach ($header as $h) {
            $table .= '<th>$h</th>';
        }
        $table .= '</tr>';

        foreach ($PDORow as $r) {
            $table .= '<tr>';
            foreach ($r as $row) {
                $table .= '<td>$row</td>';
            }
            $table .= '</tr>';
        }
        $table .= '</table>';
        return $table;
    }
}
