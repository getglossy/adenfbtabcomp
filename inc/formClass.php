<?php

class formClass
{
    /* Member Variables */
    private $dayStamp;
    private $timeStamp;
    private $first_name;
    private $last_name;
    private $Email;
    private $DOB;
    private $address;
    private $suburb;
    private $state;
    private $postCode;
    private $question;
    private $termsClicked;
    private $signup;
    private $device;
    private $config;

    /* Constructor */
    public function __construct($data = array())
    {
        include_once("db.class.inc.php");

        /*** parse the ini file ***/
        $this->config = parse_ini_file("config.ini", 1);

        date_default_timezone_set('Australia/Victoria');

        $this->dayStamp = date('Y/m/d');
        $this->timeStamp = date('H:i');

        if (isset($data['first_name'])) {
            $this->first_name = stripslashes(strip_tags($data['first_name']));
        } else {
            $this->first_name = 'NO';
        }

        if (isset($data['last_name'])) {
            $this->last_name = stripslashes(strip_tags($data['last_name']));
        } else {
            $this->last_name = 'NO';
        }

        if (isset($data['email'])) {
            $this->Email = stripslashes(strip_tags($data['email']));
        } else {
            $this->Email = 'NO';
        }

        if (isset($data['address'])) {
            $this->address = stripslashes(strip_tags($data['address']));
        } else {
            $this->address = 'NO';
        }

        if (isset($data['suburb'])) {
            $this->suburb = stripslashes(strip_tags($data['suburb']));
        } else {
            $this->suburb = 'NO';
        }

        if (isset($data['state'])) {
            $this->state = stripslashes(strip_tags($data['state']));
        } else {
            $this->state = 'NO';
        }

        if (isset($data['postcode'])) {
            $this->postCode = stripslashes(strip_tags($data['postcode']));
        } else {
            $this->postCode = 0000;
        }

        if (isset($data['dob'])) {
            $this->DOB = stripslashes(strip_tags($data['dob']));
        } else {
            $this->DOB = 'NO';
        }

        if (isset($data['question'])) {
            $this->question = stripslashes(strip_tags($data['question']));
        } else {
            $this->question = 'NO';
        }

        if (isset($data['tandc'])) {
            $this->termsClicked = 'YES';
        } else {
            $this->termsClicked = 'NO';
        }

        if (isset($data['signup'])) {
            $this->signup = 'YES';
        } else {
            $this->signup = 'NO';
        }

        if (isset($data['device'])) {
            $this->device = stripslashes(strip_tags($data['device']));
        } else {
            $this->device = 'NO';
        }

    }

    /* Destructor */
    public function __destruct()
    {

    }

    /* Store Form Values */
    public function storeFormValues($params)
    {
        $this->__construct($params);
    }

    /* Store Form Values */
    public function submitForm()
    {
        try {
            $con = new GetGlossyDB('getglossylabs');
            $pdo1 = $con->getDBObj();
            $sql = "INSERT INTO " . $this->config['facebook']['table_name'] . " (dayStamp, timeStamp, first_name, last_name, email, address, suburb, state, postcode, tandc, DateOfBirth, question, signup, device) VALUES (:dayStamp, :timeStamp, :first_name, :last_name, :Email, :address, :suburb, :state, :postCode, :termsClicked, :DOB, :question, :signup, :device)";
            $stmt = $pdo1->prepare($sql);

            $stmt->bindParam(':dayStamp', $this->dayStamp, SUNFUNCS_RET_TIMESTAMP);
            $stmt->bindParam(':timeStamp', $this->timeStamp, SUNFUNCS_RET_TIMESTAMP);
            $stmt->bindParam(':first_name', $this->first_name, PDO::PARAM_STR, 55);
            $stmt->bindParam(':last_name', $this->last_name, PDO::PARAM_STR, 55);
            $stmt->bindParam(':Email', $this->Email, PDO::PARAM_STR, 100);
            $stmt->bindParam(':address', $this->address, PDO::PARAM_STR, 100);
            $stmt->bindParam(':suburb', $this->suburb, PDO::PARAM_STR, 100);
            $stmt->bindParam(':state', $this->state, PDO::PARAM_STR, 100);
            $stmt->bindParam(':postCode', $this->postCode, PDO::PARAM_INT);
            $stmt->bindParam(':termsClicked', $this->termsClicked, PDO::PARAM_STR, 55);
            $stmt->bindParam(':DOB', $this->DOB, PDO::PARAM_STR, 100);
            $stmt->bindParam(':question', $this->question, PDO::PARAM_STR, 500);
            $stmt->bindParam(':signup', $this->signup, PDO::PARAM_STR, 100);
            $stmt->bindParam(':device', $this->device, PDO::PARAM_STR, 55);

            $stmt->execute();

        } catch (PDOException $Exception) {
            echo 'Something Wrong: ' . $Exception->getMessage();
        }
    }

    public function redirect($location)
    {
        echo '<script>
                        window.location.href="' . $location . '"
                  </script>';
    }

    public function getTandC()
    {
        $row = null;
        try {
            $con = new GetGlossyDB('getglossylabs');
            $pdo1 = $con->getDBObj();
            $statement = $pdo1->prepare("SELECT tandc FROM Clients_Comp WHERE ClientCompetitionName = :ClientCompetitionName");
            $statement->execute(array(':ClientCompetitionName' => $this->config['facebook']['table_name']));
            $row = $statement->fetch();
        } catch (PDOException $Exception) {
            echo 'Something Wrong: ' . $Exception->getMessage();
        }

        return $row;
    }

    public function getEndDate()
    {
        $row = null;
        try {
            $con = new GetGlossyDB('getglossylabs');
            $pdo1 = $con->getDBObj();
            $statement = $pdo1->prepare("SELECT endDate FROM Clients_Comp WHERE ClientCompetitionName = :ClientCompetitionName");
            $statement->execute(array(':ClientCompetitionName' => $this->config['facebook']['table_name']));
            $row = $statement->fetch();
        } catch (PDOException $Exception) {
            echo 'Something Wrong: ' . $Exception->getMessage();
        }

        return $row;
    }

    public function getShareText()
    {
        $row = null;
        try {
            $con = new GetGlossyDB('getglossylabs');
            $pdo1 = $con->getDBObj();
            $statement = $pdo1->prepare("SELECT shareText FROM Clients_Comp WHERE ClientCompetitionName = :ClientCompetitionName");
            $statement->execute(array(':ClientCompetitionName' => $this->config['facebook']['table_name']));
            $row = $statement->fetch();
        } catch (PDOException $Exception) {
            echo 'Something Wrong: ' . $Exception->getMessage();
        }

        return $row;
    }

    public function getCreativeQuestion()
    {
        $row = null;
        try {
            $con = new GetGlossyDB('getglossylabs');
            $pdo1 = $con->getDBObj();
            $statement = $pdo1->prepare("SELECT creativeQuestion FROM Clients_Comp WHERE ClientCompetitionName = :ClientCompetitionName");
            $statement->execute(array(':ClientCompetitionName' => $this->config['facebook']['table_name']));
            $row = $statement->fetch();
        } catch (PDOException $Exception) {
            echo 'Something Wrong: ' . $Exception->getMessage();
        }

        return $row;
    }

    public function getLiveLink()
    {
        $row = null;
        try {
            $con = new GetGlossyDB('getglossylabs');
            $pdo1 = $con->getDBObj();
            $statement = $pdo1->prepare("SELECT FacebookAppLink, liveLink, status FROM Clients_Comp WHERE ClientCompetitionName = :ClientCompetitionName");
            $statement->execute(array(':ClientCompetitionName' => $this->config['facebook']['table_name']));
            $row = $statement->fetchAll();
        } catch (PDOException $Exception) {
            echo 'Something Wrong: ' . $Exception->getMessage();
        }

        if ($row[0]['status'] == 'ENABLED')
        {
            return $row[0]['liveLink'];
        }
        else
        {
            return $row[0]["FacebookAppLink"];
        }
    }

    public function getCount()
    {
        $row = null;
        try {
            $con = new GetGlossyDB('getglossylabs');
            $pdo1 = $con->getDBObj();
            $statement = $pdo1->prepare("SELECT COUNT(*) FROM " . $this->config['facebook']['table_name']);
            $statement->execute();
            $row = $statement->fetch();
        } catch (PDOException $Exception) {
            echo 'Something Wrong: ' . $Exception->getMessage();
        }

        if ($row["COUNT(*)"] >= 500)
        {
            $this->redirect('sorry.php');
        }

        return true;
    }
}

?>