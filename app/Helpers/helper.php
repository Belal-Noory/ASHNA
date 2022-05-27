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

    public static function generateForm($table, $ignorFeilds, $dropDowns, $formType, $subTable)
    {
        $query = "SHOW COLUMNS FROM $table";
        $con = new Connection();
        $res = $con->Query($query);
        $form_fields = $res->fetchAll(PDO::FETCH_OBJ);

        $formStep = 1;
        if ($formType == "step") {
            echo "<section id='validation'>
                    <div class='row'>
                        <div class='col-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <a class='heading-elements-toggle'><i class='la la-ellipsis-h font-medium-3'></i></a>
                                    <div class='heading-elements'>
                                        <ul class='list-inline mb-0'>
                                            <li><a data-action='collapse'><i class='ft-minus'></i></a></li>
                                            <li><a data-action='reload'><i class='ft-rotate-cw'></i></a></li>
                                            <li><a data-action='expand'><i class='ft-maximize'></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class='card-content collapse show'>
                                    <div class='card-body'>
                                        <form action='#' class='steps-validation wizard-notification' id='steps-validation' enctype='multipart/form-data'>
                                            <input type='hidden' name='add" . $table . "' id='add" . $table . "' />
                                            <h6>Step $formStep</h6>
                                            <fieldset>
                                                <div class='row'>";
            foreach ($form_fields as $field) {
                if (!in_array($field->Field, $ignorFeilds)) {
                    $title = str_replace("_", " ", $field->Field);

                    $dropDownnAdded = false;

                    foreach ($dropDowns as $drop) {
                        if ($drop["feild"] == $field->Field) {
                            $dropDownnAdded = true;
                            echo "<div class='col-md-6'>
                                                                            <div class='form-group'>
                                                                                <label for='$field->Field' style='font-variant:small-caps'>
                                                                                    $title:
                                                                                    <span class='danger'>*</span>
                                                                                </label>
                                                                                <select id='" . $drop["feild"] . "' name='$field->Field' class='form-control'>";
                            foreach ($drop["childs"] as $child) {
                                echo "<option value='$child'>$child</option>";
                            }
                            echo "</select>
                                                                            </div>
                                                                        </div>";
                        }
                    }

                    if ($dropDownnAdded == false) {
                        if ($field->Type == "text") {
                            echo "<div class='col-md-6'>
                            <div class='form-group'>
                                <label for='$field->Field' style='font-variant:small-caps'>
                                $title:
                                    <span class='danger'>*</span>
                                </label>
                                <textarea class='form-control' id='$field->Field' name='$field->Field' placeholder='" . strtoupper($title) . "'></textarea>
                            </div>
                        </div>";
                        } else {
                            echo "<div class='col-md-6'>
                            <div class='form-group'>
                                <label for='$field->Field' style='font-variant:small-caps'>
                                $title:
                                    <span class='danger'>*</span>
                                </label>
                                <input type='text' class='form-control' id='$field->Field' name='$field->Field' placeholder='" . strtoupper($title) . "'>
                            </div>
                        </div>";
                        }
                    }
                }
            }
            echo "</div>
                                            </fieldset>";

            if (count($subTable) > 0) {
                foreach ($subTable as $stable) {
                    $formStep++;

                    $tableName = $stable["table_name"];

                    $query = "SHOW COLUMNS FROM $tableName";
                    $con = new Connection();
                    $res = $con->Query($query);
                    $form_fields_sub = $res->fetchAll(PDO::FETCH_OBJ);

                    echo "<h6>Step $formStep</h6>
                                                            <fieldset data='$tableName'>
                                                                <input type='hidden' value='0' name='" . $tableName . "count' class='counter' />
                                                                <div class='row'>";

                    $attachment = false;
                    $addMultiForm = false;

                    foreach ($form_fields_sub as $form_sub_child) {
                        if (!in_array($form_sub_child->Field, $stable["ignore"])) {
                            if ($stable["hasAttachmen"]) {
                                $attachment = true;
                            } else {
                                $attachment = false;
                            }
                            if ($stable["addMulti"]) {
                                $addMultiForm = true;
                            } else {
                                $addMultiForm = false;
                            }

                            $dropDownnAdded = false;
                            if (count($stable["drompdowns"]) > 0) {
                                foreach ($stable["drompdowns"] as $drop) {
                                    if ($drop["feild"] == $form_sub_child->Field) {
                                        $dropDownnAdded = true;
                                        echo "<div class='col-md-6'>
                                                                                        <div class='form-group'>
                                                                                            <label for='" . $drop["feild"] . "' style='font-variant:small-caps'>
                                                                                            " . $drop["feild"] . ":
                                                                                                <span class='danger'>*</span>
                                                                                            </label>
                                                                                            <select id='" . $drop["feild"] . "' name='" . $drop["feild"] . "' class='form-control'>";
                                        foreach ($drop["childs"] as $child) {
                                            echo "<option value='$child'>$child</option>";
                                        }
                                        echo "</select>
                                                                                        </div>
                                                                                    </div>";
                                    }
                                }
                            }

                            if ($dropDownnAdded == false) {
                                echo "<div class='col-md-6'>
                                                                        <div class='form-group'>
                                                                            <label for='$form_sub_child->Field' style='font-variant:small-caps'>
                                                                                $form_sub_child->Field:
                                                                                    <span class='danger'>*</span>
                                                                                </label>
                                                                                <input type='text' class='form-control' id='$form_sub_child->Field' name='$form_sub_child->Field' placeholder='" . strtoupper($form_sub_child->Field) . "' />
                                                                            </div>
                                                                        </div>";
                            }
                        }
                    }

                    if ($attachment) {
                        echo "<div class='col-md-6'>
                                                                        <div class='form-group'>
                                                                            <label for='attachment' style='font-variant:small-caps'>
                                                                            Attach Document:
                                                                                    <span class='danger'>*</span>
                                                                                </label>
                                                                                <input type='file' class='form-control' id='attachment' name='attachment' />
                                                                            </div>
                                                                        </div>";
                    }
                    echo "</div>";
                    if ($addMultiForm) {
                        echo "<div class='col-md-6'>
                                                                            <a href='#' class='btn btn-sm btn-info btnaddmulti'>
                                                                                <span class='la la-plus'></span>    
                                                                            </a>
                                                                        </div>";
                    }
                    echo "</fieldset>";
                }
            }

            echo "</form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>";
        }
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
