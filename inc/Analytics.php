<?php
class Analytics
{
    private $appName;
    private $accountManager;
    private $clientID;
    private $config;

    public function __construct(){
        include_once("db.class.inc.php");
        /*** parse the ini file ***/
        $this->config = parse_ini_file("../config.ini", 1);

        $this->appName = $this->config['facebook']['table_name'];
        $this->accountManager = $this->config['facebook']['account_manager'];
        $this->clientID = $this->config['facebook']['client_name'];;
    }

    public function __destruct(){
        $this->appName = '';
        $this->accountManager = '';
        $this->clientID = '';
    }

    public function shareImageAnalytic()
    {
        $statisticsName = 'shareImage';

        if($this->checkIfStatExists($statisticsName) > 0)
        {
            $statisticData = $this->getVal($statisticsName);

            $total = $statisticData + 1;

            $this->updateAnalytic($total, $statisticsName);
        }
        else
        {
            $this->insertAnalytic($statisticsName);
        }
    }

    public function shareCompAnalytic()
    {
        $statisticsName = 'shareComp';

        if($this->checkIfStatExists($statisticsName) > 0)
        {
            $statisticData = $this->getVal($statisticsName);

            $total = $statisticData + 1;

            $this->updateAnalytic($total, $statisticsName);
        }
        else
        {
            $this->insertAnalytic($statisticsName);
        }
    }

    public function visitFacebookLinkAnalytic()
    {
        $statisticsName = 'visitFacebookLink';

        if($this->checkIfStatExists($statisticsName) > 0)
        {
            $statisticData = $this->getVal($statisticsName);

            $total = $statisticData + 1;

            $this->updateAnalytic($total, $statisticsName);
        }
        else
        {
            $this->insertAnalytic($statisticsName);
        }
    }

    public function visitOtherPageLinkAnalytic()
    {
        $statisticsName = 'visitOtherPageLink';

        if($this->checkIfStatExists($statisticsName) > 0)
        {
            $statisticData = $this->getVal($statisticsName);

            $total = $statisticData + 1;

            $this->updateAnalytic($total, $statisticsName);
        }
        else
        {
            $this->insertAnalytic($statisticsName);
        }
    }

    public function AppVisitAnalytic()
    {
        $statisticsName = 'appVisits';

        if($this->checkIfStatExists($statisticsName) > 0)
        {
            $statisticData = $this->getVal($statisticsName);

            $total = $statisticData + 1;

            $this->updateAnalytic($total, $statisticsName);
        }
        else
        {
            $this->insertAnalytic($statisticsName);
        }
    }

    private function checkIfStatExists($StatisticsName) {
        try {
            $con = new GetGlossyDB('getglossylabs');
            $pdo1 = $con->getDBObj();
            $sql = "SELECT COUNT(*) as COUNT_ROW FROM Clients_AppStatistics WHERE ClientID = :ClientID AND StatisticsName = :StatisticsName AND appName = :appName";
            $stmt = $pdo1->prepare($sql);
            $stmt->bindParam(':ClientID', $this->clientID, PDO::PARAM_STR, 100);
            $stmt->bindParam(':StatisticsName', $StatisticsName, PDO::PARAM_STR, 100);
            $stmt->bindParam(':appName', $this->appName, PDO::PARAM_STR, 100);
            $stmt->execute();

            $temp = $stmt->fetch(PDO::FETCH_OBJ);
            return $temp->COUNT_ROW;
        } catch (PDOException $Exception) {
            echo 'Something Wrong: ' . $Exception->getMessage();
        }
    }

    private function getVal($StatisticsName)
    {
        try {
            $con = new GetGlossyDB('getglossylabs');
            $pdo1 = $con->getDBObj();
            $sql = "SELECT * FROM Clients_AppStatistics WHERE ClientID = :ClientID AND StatisticsName = :StatisticsName AND appName = :appName";
            $stmt = $pdo1->prepare($sql);
            $stmt->bindParam(':ClientID', $this->clientID, PDO::PARAM_STR, 100);
            $stmt->bindParam(':StatisticsName', $StatisticsName, PDO::PARAM_STR, 100);
            $stmt->bindParam(':appName', $this->appName, PDO::PARAM_STR, 100);
            $stmt->execute();

            $temp = $stmt->fetch(PDO::FETCH_OBJ);
            return $temp->StatisticsArray;
        } catch (PDOException $Exception) {
            echo 'Something Wrong: ' . $Exception->getMessage();
        }
    }

    private function insertAnalytic($statisticsName){
        $statisticArray = 1;

        try {
            $con = new GetGlossyDB('getglossylabs');
            $pdo1 = $con->getDBObj();
            $sql = "INSERT INTO  Clients_AppStatistics (AMID, ClientID, StatisticsName, StatisticsArray, appName) VALUES (:AMID, :ClientID, :StatisticsName, :StatisticsArray, :appName)";
            $stmt = $pdo1->prepare($sql);

            $stmt->bindParam(':AMID', $this->accountManager, PDO::PARAM_STR, 100);
            $stmt->bindParam(':ClientID', $this->clientID, PDO::PARAM_STR, 100);
            $stmt->bindParam(':StatisticsName', $statisticsName, PDO::PARAM_STR, 100);
            $stmt->bindParam(':StatisticsArray', $statisticArray, PDO::PARAM_STR, 100);
            $stmt->bindParam(':appName', $this->appName, PDO::PARAM_STR, 100);
            $stmt->execute();

        } catch (PDOException $Exception) {
            echo 'Something Wrong: ' . $Exception->getMessage();
        }
    }

    private function updateAnalytic($total, $statisticsName)
    {
        try {
            $con = new GetGlossyDB('getglossylabs');
            $pdo1 = $con->getDBObj();
            $sql = "UPDATE Clients_AppStatistics SET StatisticsArray = :StatisticsArray WHERE ClientID = :ClientID AND StatisticsName = :StatisticsName AND appName = :appName";
            $stmt = $pdo1->prepare($sql);

            $stmt->bindParam(':StatisticsArray', $total, PDO::PARAM_STR, 100);
            $stmt->bindParam(':ClientID', $this->clientID, PDO::PARAM_STR, 100);
            $stmt->bindParam(':StatisticsName', $statisticsName, PDO::PARAM_STR, 100);
            $stmt->bindParam(':appName', $this->appName, PDO::PARAM_STR, 100);

            $stmt->execute();

        } catch (PDOException $Exception) {
            echo 'Something Wrong: ' . $Exception->getMessage();
        }
    }
}


$analytics = new Analytics;

switch ($_POST['id'])
{
    case 'appVisit':
        $analytics->AppVisitAnalytic();
        break;
    case 'shareComp':
        $analytics->shareCompAnalytic();
        break;
    case 'facebookLink':
        $analytics->visitFacebookLinkAnalytic();
        break;
    case 'otherLink':
        $analytics->visitOtherPageLinkAnalytic();
        break;
    case 'shareImage':
        $analytics->shareImageAnalytic();
        break;
}
