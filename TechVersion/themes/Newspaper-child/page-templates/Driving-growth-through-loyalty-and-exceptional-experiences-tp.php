<?php
/*
 * Template Name: New Thank Automation
 */
get_header(); ?>

<?php
//if ($_SESSION['form_submitted'] === 'FALSE') {
//    header('Location: ./A-Compensation-Strategy-to-Attract-Top-Talent-lp.php');
//}

include ("./connection.php");
//echo '<pre>';
//print_r($_SESSION);
//echo '</pre>';
//echo '<pre>';
//print_r($_POST);
//echo '</pre>';
if (isset($_POST['submit'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];   
    $title = $_POST['title'];
    $companyname = $_POST['companyname'];
    $address = $_POST['address'];
    $city = $_POST['city'];
	$state = $_POST['state'];
	
	
	$checkbox_optin = $_POST['invalidCheck'];
	
    

    //hidden Fields
    //$order_id = $_POST['order_id'];
    //$microsite_id = $_POST['microsite_id'];
    //$assetname = $_POST['assetname'];

    //Backend Fields
    $submit_date = date('Y-m-d H:i:s');
    $ip_address = $_SERVER['REMOTE_ADDR'];

//$sql = "INSERT INTO `lp-req-custom-question-rm` (firstname, lastname, email, customquestion, customquestion2, submit_date, ip_address) VALUES ('$firstname', '$lastname', '$email', '$customquestion' , '$customquestion2' , '$submit_date', '$ip_address')";

$sql = "INSERT INTO `lp-req-cq-driving-growth-through`(`firstname`, `lastname`, `email`, `title`, `companyname`, `address`, `city`, `state`, `checkbox_optin`, `submit_date`, `ip_address`) VALUES ('$firstname', '$lastname', '$email', '$title' , '$companyname' ,'$address' , '$city' , '$state' , '$checkbox_optin' ,'$submit_date', '$ip_address')";


//$sql = "INSERT INTO `lp-req-custom-question` (firstname, lastname, email, companyname, jobtitle,customquestion) VALUES ('$firstname', '$lastname', '$email', '$companyname', '$jobtitle', '$customquestion')";
}


if ($conn->query($sql) === TRUE) {
	
	
	
	
	

//if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["invalidCheck"]) && $_POST["invalidCheck"] == "Yes") {
		
		echo "yes";
		
		



            // Send the message
            //$mail->send();

            //$successMessage = "<p style='color: green;'>Thank you for contacting us :)</p>";
        //} catch (Exception $e) {
      //$errorMessage = "<p style='color: red;'>Oops, something went wrong. Please try again later</p>";
    //}















		
	
    } 
 else{ ?>
		
		<table width="730" align="center" style="background-color: #FFFFFF;" class="content-table">
	<tr>
	<td>
		<table width="100%" class="content-table" style="border-bottom: 1px solid #f2bf11;">
		<tr>
			<td style="padding-top: 10px; padding-left: 10px; padding-bottom: 10px;">
			<img src="https://techversions.com/wp-content/uploads/2021/01/TV-Logo-243-x-22.png" style="padding-top: 20px; padding-bottom: 10px;" alt="Bond" width="150">
			</td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
	<td>
		<table cellpadding="10" width="100%" class="content-table" style="border-bottom: 1px solid #f2bf11; padding: 2%;">
		<tr>
			<td width="180" valign="top" style="padding-top: 15px;" class="img">
		
			<img src="https://techversions.com/wp-content/uploads/2024/01/3-Strategies-for-Reaping-the-ROI-of-RPA-Final-New.jpg" width="180" class="thumbnail" alt="Driving Growth through Loyalty and Exceptional Experiences.">
			</td>
			<td width="464" valign="top">
						<div style="margin-top: -2%;">
								<p>
									<span style="font-size:15px;color:#505050;">Thank You for downloading, <br> '<span style="color: #f2bf11;">3 Strategies for Reaping the ROI of RPA.</span>'</span>
								</p>
								
			

				  
			  </div>

							
		  </td>
		  </tr>
			
		</table>
		<tr>
		<td>
			<table align="center" class="content-table" width="100%">
			<tr>
				<td colspan="2" style="font-size:10.5px;color:#505050;text-align: center;">
				
					<p style="font-size: 12px; color:#505050;line-height:20px;">This email was sent by Bond.</p>
					
				</td>
				</tr>
			</table>
			</td>
		</tr>
		</td>
	</tr>
	</table>
		
		
	<?php //}
	
//    $_SESSION['form_submitted'] = 'FALSE';

    /*
     * When testing uncomment the below line. Keep them comented when LIVE, as we do not have to show the SUCCESS or ERROR msg to the end-user
     */
//    if ($err) {
//        echo "cURL Error #:" . $err;
//    } else {
//        echo $response;
//    }
//} else {
    //echo "Error: " . $sql . "<br>" . $conn->error;
    
//}

?>



<html>
<head>
<meta charset="utf-8">

	<style>
@import url('https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap');

body
{
font-family:'Noto Sans',sans-serif;
background-color:#e8ecee;
margin-left:0;
margin-top:20px;
margin-right:0;
margin-bottom:40px;
}
		 .subject-sec {
                        margin-left: -15px;margin-right: -15px;
                    }
		.download{
			padding-top: 30px;
		}
        
                     /*responsive*/
                    
                     @media(max-width: 700px){
                        body {
                            padding-left: 15px;
                            padding-right: 15px;
                        }

                        .content-table thead{
                            display: none;
                        }
                    
                        .content-table, .content-table tbody, .content-table tr, .content-table td{
                            display: block;
                            width: 100%;
                        }
                        .content-table tr{
                            margin-bottom:0px;
                        }
                        .content-table td{
                            text-align: left;
                            padding-left: 0%;
                            position: relative;
                        }
                        .content-table td.footer {
                            text-align: center;
                        }
                        .img{
                            max-width: 100% !important;
                            height: auto;
                            width:95%!important;
                            background: #E4E4E4;
                        }
                        .thumbnail{
                            text-align: center;
                            margin-left: 25%;
                        }
                        .content-table td::before{
                            content: attr(data-label);
                            position: absolute;
                            left:0;
                            width: 50%;
                            text-align: left;
                        }
                        .download {
                            padding-top: 10px;
                        }
                    


	</style>
	
</head>
<body bgcolor="#B3B3B3">


</body>
</html>



<?php get_footer(); ?>