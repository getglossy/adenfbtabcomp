<?php
include 'inc/formClass.php';

/*** parse the ini file ***/
$config = parse_ini_file("config.ini", 1);

$usr = new formClass; //create new instance of the class Users

$tandc = $usr->getTandC();
$endDate = $usr->getEndDate();
$shareText = $usr->getShareText();
$creativeQuestion = $usr->getCreativeQuestion();

if (!isset($_POST['submit'])) {
    ?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Enter File</title>
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/rendezvous.css">
	<link rel="stylesheet" href="css/remodal.css">
	<link rel="stylesheet" href="css/remodal-default-theme.css">
	<!-- <link rel="stylesheet" href="css/typeahead.css"> -->
</head>
<body>
	<!-- connect to fb sdk -->
	<div id='fb-root'></div>
    <script src='//connect.facebook.com/en_US/sdk.js'></script>
    <script>
        FB.init({
            appId: '<?php echo $config['facebook']['facebook_id'] ?>',
            version: 'v2.0'
        });

        FB.Canvas.scrollTo(0, 0); // scrolls to the top of the page. this property can also be used for navigation for one page competition

        FB.Canvas.setAutoGrow(); // this property is used to adapt to document height automatically
    </script>
	<!--  -->


	<div class="container">
		<div class="wrapper">
			<form id="form" method="post" enctype="multipart/form-data">
				<div class="form-row-1">
					<input type="text" name="first_name" placeholder="First Name"><!--
					--><input type="text" name="last_name" placeholder="Surname">
				</div>

				<div class="form-row-2">
					<input type="email" name="email" placeholder="Email *">
				</div>

				<div class="form-row-3">
					<h3>Date of Birth*</h3>
					<div id="dob"></div>
				</div>

				<div class="form-row-4">
					<input type="text" name="address" id="address" placeholder="Address" ><br>
					<input type="text" name="suburb" placeholder="Suburb">
					<input type="text" name="state" placeholder="State">
					<input type="text" name="postcode" placeholder="Postcode">
				</div>

				<div class="form-row-5">
					<textarea name="question" placeholder="<?php echo $creativeQuestion[0]; ?>"></textarea>
				</div>

				<div class="form-row-6">
					<input type="checkbox" name="tandc" required> I agree to the <a href="#modal">Terms &amp; Conditions. *</a> <br>
					<input type="checkbox" name="signup" checked> Signup to our newsletter
				</div>
				<input type="hidden" name="device" id="device" value="">

				<button type="submit" name="submit" value="submit">Submit</button>

			</form>
		</div>
	</div>


	<!-- terms and conditions modal -->
	<div class="remodal" data-remodal-id="modal">
	  <button data-remodal-action="close" class="remodal-close"></button>
	  <h1>Remodal</h1>
	  <p>
	    Responsive, lightweight, fast, synchronized with CSS animations, fully customizable modal window plugin with declarative configuration and hash tracking.
	  </p>
	  <br>
	  <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
	  <button data-remodal-action="confirm" class="remodal-confirm">OK</button>
	</div>
	<!--  -->

	<script src="http://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>
	<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="js/rendezvous.js"></script>
	<script src="https://twitter.github.io/typeahead.js/releases/latest/typeahead.bundle.js"></script>
	<script src="dist/bloodhound.js"></script>
	<script src="dist/typeahead.jquery.js"></script>
	<script src="dist/typeahead-addresspicker.js"></script>
	<script src="js/remodal.min.js"></script>
	<script src="js/script.js"></script>
<script>
        $('.rendezvous-input-date').attr('name', 'dob');
        $(document).ready(function (e) {
            $('img[usemap]').rwdImageMaps();

        });

        $('.terms').change(function () {
            if ($('select.state').val() == '') {
                alert('Please select your state');
                $(".terms").prop('checked', false);
            }
            else {
                if ($('select#day').val() == '' || $('select#month').val() == '' || $('select#year').val() == '') {
                    alert('Please select your date of birth');
                    $(".terms").prop('checked', false);
                }
            }
        });

        $('input, textarea').placeholder();
        $('.selectpicker').selectpicker();

        $('#theform').validate({
            rules: {
                first_name: { required: true },
                last_name: { required: true },
                email: { email: true, required: true },
                address: {required: true},
                suburb: {required: true},
                postcode: {digits: true, required: true, minlength: 4},
                question: {required: true},
                tandc: {required: true}
            },
            tooltip_options: {
                first_name: {placement: 'bottom', trigger: 'focus'},
                last_name: {placement: 'bottom', trigger: 'focus'},
                email: {placement: 'bottom', trigger: 'focus'},
                address: {placement: 'bottom', trigger: 'focus'},
                postcode: {placement: 'bottom', trigger: 'focus'},
                question: {placement: 'bottom', trigger: 'focus'},
                tandc: {placement: 'right'}
            }
        });

        var isMobile = {
            Android: function () {
                return navigator.userAgent.match(/Android/i);
            },
            BlackBerry: function () {
                return navigator.userAgent.match(/BlackBerry/i);
            },
            iOS: function () {
                return navigator.userAgent.match(/iPhone|iPad|iPod/i);
            },
            Opera: function () {
                return navigator.userAgent.match(/Opera Mini/i);
            },
            Windows: function () {
                return navigator.userAgent.match(/IEMobile/i);
            },
            any: function () {
                return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
            }
        };

        if (isMobile.any()) {
            $('#device').val('Mobile');
        }
        else {
            $('#device').val('Desktop');
        }

        AppVisitAnalytic();
    </script>
    </body>
    </html>
<?php
} else {
    $usr->storeFormValues($_POST); //store form values
    $usr->submitForm(); //submit form to database
    $usr->redirect('wall.php'); //submit form to database
}

?>