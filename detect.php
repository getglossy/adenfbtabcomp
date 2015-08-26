<?php
include 'inc/formClass.php';
$config = parse_ini_file("config.ini", 1);
$usr = new formClass; //create new instance of the class Users

$shareText = $usr->getShareText();
$live_link = $usr->getLiveLink();
?>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <!-- Open Graph meta tags -->
    <meta property="og:title" content="<?php echo $config['facebook']['client'] ?>" />
    <meta property="og:type" content="article" />
    <meta property="og:image" content="<?php echo $config['facebook']['app_link'] ?>images/share1.png" />
    <meta property="og:url" content="<?php echo $config['facebook']['app_link'] ?>share.php" />
    <meta property="og:description" content="<?php echo $shareText[0];?>"/>
    <title>Share Message</title>
</head>

    <script>

        /* Check if Desktop or Mobile */
        var isMobile = {
            Android: function() {
                return navigator.userAgent.match(/Android/i);
            },
            BlackBerry: function() {
                return navigator.userAgent.match(/BlackBerry/i);
            },
            iOS: function() {
                return navigator.userAgent.match(/iPhone|iPad|iPod/i);
            },
            Opera: function() {
                return navigator.userAgent.match(/Opera Mini/i);
            },
            Windows: function() {
                return navigator.userAgent.match(/IEMobile/i);
            },
            any: function() {
                return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
            }
        };

        if( isMobile.any() )
        {
                window.location.href = 'enter.php';
        }
        else
        {
                window.location.href = '<?php echo $live_link ?>';
        }
    </script>

