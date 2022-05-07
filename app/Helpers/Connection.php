<?php
/*
 * Represent the Connection
 */
class Connection
{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private $conn;
    private $stmt;
    private $error;

    public function __construct()
    {
        // Set DSN
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        // Create PDO instance
        try {
            $this->conn = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    public function Query($query, $param = null, $returnLastID = false)
    {
        $Q1 = $this->conn->prepare("SET NAMES utf8");
        $Q1->execute();

        $Q2 = $this->conn->prepare('SET CHARACTER SET utf8');
        $Q2->execute();
        $ID = null;

        if (is_null($param)) {
            $result = $this->conn->prepare($query);
            $result->execute();
            if ($returnLastID) {
                return $this->conn->lastInsertId();
            } else {
                return $result;
            }
        } else {
            $result = $this->conn->prepare($query);
            $result->execute($param);
            if ($returnLastID) {
                return $this->conn->lastInsertId();
            } else {
                return $result;
            }
        }
    }


    public function createTriggers()
    {
        $triggers = array(
            "person", "person_address", "person_bank_details", "person_attachment", "ashna_bank_account", "transaction"
        );
        $actions = array("UPDATE", "DELETE", "INSERT");
        foreach ($triggers as $triger) {
            $Delet_Triggers_Query = "";
            $Create_Triggers_Query = "";
            foreach ($actions as $action) {
                // check if trigger exists delete them all
                // $Delet_Triggers_Query = "DROP TRIGGER IF EXISTS ".$triger."_".$action;
                // $delete_trigger = $this->conn->prepare($Delet_Triggers_Query);
                // $res = $delete_trigger->execute();
                // echo $res;
                if ($action == "INSERT") {
                    $Create_Triggers_Query = "CREATE TRIGGER " . $triger . "_" . $action . " AFTER " . $action . " ON " . $triger . " FOR EACH ROW 
                    INSERT INTO suppliers_log_data 
                    SET user = NEW.createby,
                        tble = '$triger',
                        user_action = '$action',
                        details = CONCAT(NEW.ID,' has been added by ',NEW.createby),
                        action_date = NOW();";
                } else {
                    $Create_Triggers_Query = "CREATE TRIGGER " . $triger . "_" . $action . " AFTER " . $action . " ON " . $triger . " FOR EACH ROW 
                    INSERT INTO suppliers_log_data 
                    SET user = OLD.createby,
                        tble = '$triger',
                        user_action = '$action',
                        details = CONCAT(OLD.ID,' has been $action by', OLD.updatedby),
                        action_date = NOW();";
                }

                $Q2 = $this->conn->prepare($Create_Triggers_Query);
                $res = $Q2->execute();
                echo $res;
            }
        }
    }
}
