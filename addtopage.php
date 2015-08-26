<?php
/*** parse the ini file ***/
$config = parse_ini_file("config.ini", 1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Add to Page Dialog Page</title>
</head>
<body>
<div id='fb-root'></div>
<script src='//connect.facebook.com/en_US/sdk.js'></script>
<script>
    FB.init({
        appId: '<?php echo $config['facebook']['facebook_id'] ?>',
        version: 'v2.0'
    });

    function addToPage() {

        // calling the API ...
        var obj = {
            method: 'pagetab',
            redirect_uri: '<?php echo $config['facebook']['app_link'] ?>addtopage.php'
        };

        FB.ui(obj);
    }
    addToPage();


</script>
<div class="alert alert-info" role="alert"><i class="glyphicon glyphicon-info-sign"></i> Add this tab to your Facebook page by clicking the button below.</div>
<div class="addButton">
    <a class="btn btn-default btn-lg" onclick='addToPage(); return false;' style="color:#ed8f47; cursor:pointer;"><i class="glyphicon glyphicon-plus"></i> Add to Page</a>
</div>
</body>
</html>
