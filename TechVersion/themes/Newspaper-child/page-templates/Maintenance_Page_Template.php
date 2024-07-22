<?php
/* Template Name: Maintance Page   */
?>
<!doctype html>
<head>
<title>Site Under Maintenance</title>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,700' rel='stylesheet'>
<style>
  html, body { padding: 0 !important; margin: 0 !important; width: 100% !important; height: 100% !important; }
  * {box-sizing: border-box;}
  body { text-align: center !important; padding: 0 !important; background: #d6433b !important; color: #fff !important; font-family: Open Sans !important; }
  h1 { font-size: 50px !important; font-weight: 100 !important; text-align: center !important;}
  body { font-family: Open Sans !important; font-weight: 100 !important; font-size: 20px !important; color: #fff !important; text-align: center !important; display: -webkit-box; display: -ms-flexbox; display: flex; -webkit-box-pack: center; -ms-flex-pack: center; justify-content: center; -webkit-box-align: center; -ms-flex-align: center; align-items: center;}
  article { display: block !important; width: 700px !important; padding: 50px !important; margin: 0 auto !important; }
  a { color: #fff !important; font-weight: none !important;}
  a:hover { text-decoration: none !important; }
  svg { width: 75px !important; margin-top: 1em !important; }
  .disable-text-selection {
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    }
</style>
</head>
<body style='max-width:100%' onmousedown="return false" onselectstart="return false">
<article>
  <img src='https://theinsightstoday.com/wp-content/uploads/2023/07/warning.png' width='75px' title='Warning icon'>
<h1 style='color: #FFF;border-bottom:0px'>We'll be back soon!</h1>
<div>
<p style='font-weight:200'>Sorry for the inconvenience. </br>We&rsquo;re performing some maintenance at the moment.</p>
</br></br>
<p style='font-size:16px'><a href='https://anteriad.com/privacy-policy/' target="_blank">Privacy Policy</a></p> 
<p style='font-size:16px'>You can reach us out at <a href='mailto:digitalrevops-webservices@anteriad.com'>digitalrevops-webservices@anteriad.com</a></p>
</div>
</article>
</body>
<script>
    function DisableCopyPaste (e) 
{
 // Message to display
 var message = "Cntrl key/ Right Click Option disabled";
 // check mouse right click or Ctrl key press
var kCode = event.keyCode || e.charCode; 
//FF and Safari use e.charCode, while IE use e.keyCode
 if (kCode == 17 || kCode == 2)
 {
 alert(Sorry! you cant able to copy);
 return false;
 }
}
    </script>
</html>
<?php
?>