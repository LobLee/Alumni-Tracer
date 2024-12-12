<?php
// Include the PHPMailer library
require 'vendor/autoload.php'; // Make sure PHPMailer is installed using Composer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Database connection (customize with your database credentials)
include 'connection/conn.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = $_POST['email'];

    // Check if the email is already registered
    $sql = "SELECT * FROM l_gmail_confirmation WHERE gmail = '$email'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        // Email is registered, redirect to question.php
        header("Location: php_files/question.php");
        exit();
    } else {
        // Email not registered, set session variable
        $_SESSION['unregistered_email'] = $email;
    }

    if ($result) {
        $result->free();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = $_POST['email'];

    // Create PHPMailer instance
    $mail = new PHPMailer(true);
    try {
        // Set up Yahoo SMTP configuration
        $mail->isSMTP();
        $mail->Host       = 'smtp.mail.yahoo.com';  // Yahoo SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'lovelyguzmana@myyahoo.com';  // Your Yahoo email address
        $mail->Password   = 'your-app-password';  // Your Yahoo App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Use TLS encryption
        $mail->Port       = 587;  // Use port 587 for TLS

        // Sender and recipient
        $mail->setFrom('your-email@yahoo.com', 'Alumni Tracer');
        $mail->addAddress($email);  // Recipient's email

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Email Confirmation';
        $mail->Body    = 'Please confirm your email by clicking <a href="http://localhost/verify?token=xyz">here</a>.';

        // Send email
        if($mail->send()) {
            echo "A confirmation email has been sent to $email.";
        } else {
            echo "Error: Could not send the email.";
        }
    } catch (Exception $e) {
        echo "Mailer Error: {$mail->ErrorInfo}";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Landing Page</title>
    <link href="https://fonts.googleapis.com/css?family=Heebo:400,500,700|Fira+Sans:600" rel="stylesheet">
    <link rel="stylesheet" href="dist/css/style.css">
	<script src="https://unpkg.com/animejs@2.2.0/anime.min.js"></script>
    <script src="https://unpkg.com/scrollreveal@4.0.0/dist/scrollreveal.min.js"></script>
</head>
				<div id="preloader">
					  <div class="loader" id="loader-1"></div>
					</div>
					
					
					<script>
					 
					  setTimeout(function() {
					    document.getElementById("preloader").style.display = "none";
					  }, 2000);
					</script>


				<style>
						 #preloader {
							position: fixed;
							top: 0;
							left: 0;
							right: 0;
							bottom: 0;
							background-color: #fff;
							z-index: 9999999; }
							
							.loader {
							top: 50%;
							width: 50px;
							height: 50px;
							border-radius: 100%;
							position: relative;
							margin: 0 auto; }
							
							#loader-1:before, #loader-1:after {
							content: "";
							position: absolute;
							top: -10px;
							left: -10px;
							width: 100%;
							height: 100%;
							border-radius: 100%;
							border: 7px solid transparent;
							border-top-color: #3c9cfd; }
							
							#loader-1:before {
							z-index: 100;
							animation: spin 2s infinite; }
							
							#loader-1:after {
							border: 7px solid #fafafa; }
							
							@keyframes spin {
							0% {
								-webkit-transform: rotate(0deg);
								-ms-transform: rotate(0deg);
								-o-transform: rotate(0deg);
								transform: rotate(0deg); }
							100% {
								-webkit-transform: rotate(360deg);
								-ms-transform: rotate(360deg);
								-o-transform: rotate(360deg);
								transform: rotate(360deg); } }

				</style>

<body class="is-boxed has-animations">
    <div class="body-wrap boxed-container">
        <header class="site-header">
			<div class="header-shape header-shape-1">
				<svg width="337" height="222" viewBox="0 0 337 222" xmlns="http://www.w3.org/2000/svg">
				    <defs>
				        <linearGradient x1="50%" y1="55.434%" x2="50%" y2="0%" id="header-shape-1">
				            <stop stop-color="#E0E1FE" stop-opacity="0" offset="0%"/>
				            <stop stop-color="#E0E1FE" offset="100%"/>
				        </linearGradient>
				    </defs>
				    <path d="M1103.21 0H1440v400h-400c145.927-118.557 166.997-251.89 63.21-400z" transform="translate(-1103)" fill="url(#header-shape-1)" fill-rule="evenodd"/>
				</svg>
			</div>
			<div class="header-shape header-shape-2">
				<svg width="128" height="128" viewBox="0 0 128 128" xmlns="http://www.w3.org/2000/svg" style="overflow:visible">
				    <defs>
				        <linearGradient x1="93.05%" y1="19.767%" x2="15.034%" y2="85.765%" id="header-shape-2">
				            <stop stop-color="#FF3058" offset="0%"/>
				            <stop stop-color="#FF6381" offset="100%"/>
				        </linearGradient>
				    </defs>
				    <circle class="anime-element fadeup-animation" cx="64" cy="64" r="64" fill="url(#header-shape-2)" fill-rule="evenodd"/>
				</svg>
			</div>
            <div class="container">
                <div class="site-header-inner">
                    <div class="brand header-brand">
                        <h1 class="m-0">
                            <a href="#" style = "display: flex;">
							<svg width="45" height="45" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg" fill="none">
							<!-- Outer Circle representing the Alumni Network -->
							<circle cx="25" cy="25" r="24" stroke="#4CAF50" stroke-width="2" fill="url(#outer-gradient)"/>

							<!-- Inner Circle representing Connection Points -->
							<circle cx="25" cy="25" r="16" fill="url(#inner-gradient)" opacity="0.8"/>

							<!-- Inner Dot representing Centralization -->
							<circle cx="25" cy="25" r="4" fill="#FF9800" />

							<!-- Gradient Definitions -->
							<defs>
								<radialGradient id="outer-gradient" cx="50%" cy="50%" r="50%" fx="50%" fy="50%">
								<stop offset="0%" style="stop-color:#A5D6A7; stop-opacity:1" />
								<stop offset="100%" style="stop-color:#4CAF50; stop-opacity:1" />
								</radialGradient>
								<radialGradient id="inner-gradient" cx="50%" cy="50%" r="50%" fx="50%" fy="50%">
								<stop offset="0%" style="stop-color:#BBDEFB; stop-opacity:1" />
								<stop offset="100%" style="stop-color:#2196F3; stop-opacity:1" />
								</radialGradient>
							</defs>
							</svg>
							<span style = "font-size: 23px; margin-left: 10px; margin-top: -5px;">Alumni Tracer</span>
                            </a>
                        </h1>
                    </div>
                </div>
            </div>
        </header>

        <main>
            <section class="hero">
                <div class="container">
                    <div class="hero-inner">
						<div class="hero-copy">
	                        <h1 class="hero-title mt-0">Alumni <span style = "color: orange;">Tracer</span></h1>
	                        <p class="hero-paragraph">- an <span style = "color: orange; font-weight: bolder;">Alumni Tracer</span> website to locate and know the alumni of an Alma Mater.</p>
							<div class="hero-form field field-grouped">
								<div class="control control-expanded">
									<a class="button button-primary button-block" href="php_files/login.php">Log in</a>
								</div>
								<div class="control">
									<a class="button button-primary button-block" href="php_files/register.php">Admin Register</a>
								</div>
								<div class="control">
									<a class="button button-primary button-block" href="php_files/school_register.php">school Register</a>
								</div>
							</div>
	
							<div class="div" style="margin-top: 10px;">
    - Are you an alumni?
    <span>
        <a href="#" onclick="openEmailModal()" style="color: orange; font-weight: bolder;">Click Here!</a>
    </span>
</div>
						</div>

						

						<div class="hero-illustration">
							<div class="hero-shape hero-shape-1">
								<svg width="40" height="40" xmlns="http://www.w3.org/2000/svg" style="overflow:visible">
									<circle class="anime-element fadeup-animation" cx="20" cy="20" r="20" fill="#FFD8CD" fill-rule="evenodd"/>
								</svg>
							</div>
							<div class="hero-shape hero-shape-2">
								<svg width="88" height="88" xmlns="http://www.w3.org/2000/svg" style="overflow:visible">
								    <circle class="anime-element fadeup-animation" cx="44" cy="44" r="44" fill="#FFD2DA" fill-rule="evenodd"/>
								</svg>
							</div>
							<div class="hero-main-shape">
									<img src="L-images/land1.jpg" alt="">
							</div>
                        </div>
                    </div>
                </div>
            </section>


<!-- Email Input Modal -->
<div id="emailModal" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 300px; padding: 20px; background-color: white; box-shadow: 0 5px 15px rgba(0,0,0,0.3);">
        <h3>Enter Your Email</h3>
        <form action="index.php" method="POST" onsubmit="return validateEmail()">
            <input type="email" name="email" id="emailInput" placeholder="Enter your email address" required style="width: 100%; padding: 8px; margin: 10px 0;">
            <button type="submit" style="width: 100%; padding: 8px; background-color: orange; color: white; font-weight: bold;">Check Email</button>
        </form>
        <button onclick="closeModal('emailModal')" style="width: 100%; padding: 8px; margin-top: 10px;">Cancel</button>
    </div>

    <!-- Not Registered Modal -->
    <div id="notRegisteredModal" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 300px; padding: 20px; background-color: white; box-shadow: 0 5px 15px rgba(0,0,0,0.3);">
        <h3>Your email is not registered.</h3>
        <p>Please register by clicking the button below.</p>
        <form action="index.php" method="POST">
            <input type="hidden" name="email" id="unregisteredEmail" value="<?php echo isset($_SESSION['unregistered_email']) ? $_SESSION['unregistered_email'] : ''; ?>">
            <button type="submit" name="sendConfirmation" style="width: 100%; padding: 8px; background-color: orange; color: white; font-weight: bold;">Send Confirmation Email</button>
        </form>
        <button onclick="closeModal('notRegisteredModal')" style="width: 100%; padding: 8px; margin-top: 10px;">Cancel</button>
    </div>

    <script>
        function openEmailModal() {
            document.getElementById('emailModal').style.display = 'block';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        function validateEmail() {
            const email = document.getElementById('emailInput').value;
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!emailPattern.test(email)) {
                alert("Please enter a valid email address.");
                return false;
            }
            return true;
        }

        // Check if email is not registered and open modal
        <?php if (isset($_SESSION['unregistered_email'])): ?>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('notRegisteredModal').style.display = 'block';
            });
            <?php unset($_SESSION['unregistered_email']); ?>
        <?php endif; ?>
    </script>

            <section class="features section">
                <div class="container">
                    <div class="features-inner section-inner">
                        <div class="features-header text-center">
                            <div class="container-sm">
                                <h2 class="section-title mt-0">What is <span style = "font-weight: bolder; color: orange;">Alumni Tracer</span> ?</h2>
                                <p class="section-paragraph"> a tool or software used by educational institutions to monitor and keep records of their graduates' career progression, educational achievements, and professional development after leaving the institution. It provides insights into where alumni are working, the sectors they contribute to, their job titles, and their geographic location.</p>
                            </div>
                        </div>
						<div class="features-wrap">
							<div class="feature text-center is-revealing">
                                <div class="feature-inner">
                                    <div class="feature-icon" style="background:#FFD2DA;">
										<svg width="88" height="88" xmlns="http://www.w3.org/2000/svg">
										    <g fill="none" fill-rule="nonzero">
										        <path d="M43 47v7a13 13 0 0 0 13-13v-7c-7.18 0-13 5.82-13 13z" fill="#FF6381"/>
										        <path d="M32 41v4a9 9 0 0 0 9 9v-4a9 9 0 0 0-9-9z" fill="#FF97AA"/>
										    </g>
										</svg>
                                    </div>
                                    <h4 class="feature-title h3-mobile mb-8">User-Centric Design</h4>
                                    <p class="text-sm">is designed with user experience in mind, providing clear navigation and options (like login/register prompts) that guide users effortlessly.</p>
                                </div>
                            </div>
							<div class="feature text-center is-revealing">
                                <div class="feature-inner">
                                    <div class="feature-icon" style="background:#FFD8CD;">
										<svg width="88" height="88" xmlns="http://www.w3.org/2000/svg">
										    <g fill="none" fill-rule="nonzero">
										        <path d="M54 56h-9a2 2 0 0 1-2-2V43a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2zm-9-13v10h9V43h-9z" fill="#FCAC96"/>
										        <path d="M41 50h-7V34h14v5h2v-5a2 2 0 0 0-2-2H34a2 2 0 0 0-2 2v18a2 2 0 0 0 2 2h7v-4z" fill="#FC8464"/>
										    </g>
										</svg>
                                    </div>
                                    <h4 class="feature-title h3-mobile mb-8">Comprehensive Features</h4>
                                    <p class="text-sm">By including a variety of functional modules, the system can serve multiple purposes, enhancing its value and appeal to users.</p>
                                </div>
                            </div>
							<div class="feature text-center is-revealing">
                                <div class="feature-inner">
                                    <div class="feature-icon" style="background:#C6FDF3;">
										<svg width="88" height="88" xmlns="http://www.w3.org/2000/svg">
										    <g fill="none" fill-rule="nonzero">
										        <circle fill="#1ADAB7" cx="38" cy="50" r="5"/>
										        <path d="M53 42h2v-8a1 1 0 0 0-1-1h-8v2h5.586l-8.293 8.293a1 1 0 1 0 1.414 1.414L53 36.414V42z" fill="#1ADAB7"/>
										        <path fill="#83F0DD" d="M34 41.414l3-3 3 3L41.414 40l-3-3 3-3L40 32.586l-3 3-3-3L32.586 34l3 3-3 3zM55.414 48L54 46.586l-3 3-3-3L46.586 48l3 3-3 3L48 55.414l3-3 3 3L55.414 54l-3-3z"/>
										    </g>
										</svg>
                                    </div>
                                    <h4 class="feature-title h3-mobile mb-8">Enhanced Engagement and Tracking</h4>
                                    <p class="text-sm">by keeping users engaged and enabling activity tracking, the system creates an interactive experience that promotes user retention.</p>
                                </div>
                            </div>
							<div class="feature text-center is-revealing">
                                <div class="feature-inner">
                                    <div class="feature-icon" style="background:#E0E1FE;">
										<svg width="88" height="88" xmlns="http://www.w3.org/2000/svg">
										    <g fill="none" fill-rule="nonzero">
										        <path d="M41 42h-7a1 1 0 0 1-1-1v-7a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1zM41 55h-7a1 1 0 0 1-1-1v-7a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1z" fill="#4950F6"/>
										        <path fill="#8D92FA" d="M45 34h10v2H45zM45 39h10v2H45zM45 47h10v2H45zM45 52h10v2H45z"/>
										    </g>
										</svg>
                                    </div>
                                    <h4 class="feature-title h3-mobile mb-8">Responsive Design</h4>
                                    <p class="text-sm">fully responsive interface ensures accessibility across all device types, providing a seamless experience for mobile, tablet, and desktop users.</p>
                                </div>
                            </div>
						</div>
                    </div>
                </div>
            </section>

			<section class="testimonials section">
				<div class="testimonials-shape testimonials-shape-1">
					<svg width="280" height="280" viewBox="0 0 280 280" xmlns="http://www.w3.org/2000/svg">
					    <defs>
					        <linearGradient x1="100%" y1="0%" x2="0%" y2="100%" id="testimonials-shape-1">
					            <stop stop-color="#261FB6" offset="0%"/>
					            <stop stop-color="#4950F6" offset="100%"/>
					        </linearGradient>
					    </defs>
					    <circle cx="140" cy="685" r="140" transform="translate(0 -545)" fill="url(#testimonials-shape-1)" fill-rule="evenodd"/>
					</svg>
				</div>
				<div class="testimonials-shape testimonials-shape-2">
					<svg width="125" height="107" viewBox="0 0 125 107" xmlns="http://www.w3.org/2000/svg">
						<g fill="none" fill-rule="evenodd">
							<circle fill="#C6FDF3" cx="48" cy="59" r="48"/>
							<path d="M58.536 39.713c0-6.884 1.72-14.007 5.163-21.368 3.443-7.36 8.167-13.458 14.173-18.292l11.645 7.91c-3.589 4.98-6.262 10.016-8.02 15.106S78.86 33.598 78.86 39.384v13.623H58.536V39.713z" fill="#55EBD0"/>
							<path d="M93.252 39.713c0-6.884 1.722-14.007 5.164-21.368 3.442-7.36 8.166-13.458 14.172-18.292l11.646 7.91c-3.589 4.98-6.262 10.016-8.02 15.106s-2.637 10.529-2.637 16.315v13.623H93.252V39.713z" fill="#1ADAB7"/>
						</g>
					</svg>
				</div>
				<div class="testimonials-shape testimonials-shape-3">
					<svg width="48" height="48" viewBox="0 0 48 48" mlns="http://www.w3.org/2000/svg">
						<defs>
							<linearGradient x1="93.05%" y1="19.767%" x2="15.034%" y2="85.765%" id="testimonials-shape-3">
								<stop stop-color="#FF3058" offset="0%"/>
								<stop stop-color="#FF6381" offset="100%"/>
							</linearGradient>
						</defs>
						<circle cx="24" cy="434" r="24" transform="translate(0 -410)" fill="url(#testimonials-shape-3)" fill-rule="evenodd"/>
					</svg>
				</div>
				<div class="container">
					<div class="testimonials-inner section-inner">
						<h2 class="section-title mt-0 text-center"><span style = "font-weight: bolder;	">Dev<span style = "padding: 5px; color: orange;">/</span>Developers<span style = "font-size: 100px; color: orange;">.</span></span></h2>
						<div class="testimonials-wrap">
							<div class="testimonial text-xs is-revealing">
								<div class="testimonial-inner">
									<div class="testimonial-main">
										<div class="testimonial-header">
											<img class="mb-16" src="L-images/daniel.png" alt="Testimonial">
										</div>
										<div class="testimonial-body">
											<p class="mb-0">I am a 3rd-year college student at Southern Leyte State University, passionate about developing technical and practical skills in my chosen field. I'm dedicated to academic growth, actively engaging in projects and activities that deepen my understanding and contribute to my future career.</p>
										</div>
									</div>
									<div class="testimonial-footer">
										<div class="testimonial-link">
											<a href="#">Mr. Daniel Rojas</a>
										</div>
									</div>
								</div>
							</div>
							<div class="testimonial text-xs is-revealing">
								<div class="testimonial-inner">
									<div class="testimonial-main">
										<div class="testimonial-header">
											<img class="mb-16" src="L-images/ejie.jpg" alt="Testimonial">
										</div>
										<div class="testimonial-body">
											<p class="mb-0">I am a 3rd-year college student at Southern Leyte State University, passionate about developing technical and practical skills in my chosen field. I'm dedicated to academic growth, actively engaging in projects and activities that deepen my understanding and contribute to my future career.</p>
										</div>
									</div>
									<div class="testimonial-footer">
										<div class="testimonial-link">
											<a href="#">Mr. Ejie C. Florida</a>
										</div>
									</div>
								</div>
							</div>

							<div class="testimonial text-xs is-revealing">
								<div class="testimonial-inner">
									<div class="testimonial-main">
										<div class="testimonial-header">
											<img class="mb-16" src="L-images/loblee.jpg" alt="Testimonial" style = "width: 60px; height: 60px;">
										</div>
										<div class="testimonial-body">
											<p class="mb-0">I am a 3rd-year college student at Southern Leyte State University, passionate about developing technical and practical skills in my chosen field. I'm dedicated to academic growth, actively engaging in projects and activities that deepen my understanding and contribute to my future career.</p>
										</div>
									</div>
									<div class="testimonial-footer">
										<div class="testimonial-link">
											<a href="#">Mr. Lovely Guzmana</a>
										</div>
									</div>
								</div>
							</div>
							<div class="testimonial text-xs is-revealing">
								<div class="testimonial-inner">
									<div class="testimonial-main">
										<div class="testimonial-header">
											<img class="mb-16" src="L-images/ralph.jpg" alt="Testimonial">
										</div>
										<div class="testimonial-body">
											<p class="mb-0">I am a 3rd-year college student at Southern Leyte State University, passionate about developing technical and practical skills in my chosen field. I'm dedicated to academic growth, actively engaging in projects and activities that deepen my understanding and contribute to my future career.</p>
										</div>
									</div>
									<div class="testimonial-footer">
										<div class="testimonial-link">
											<a href="#">Mr. Ralph Miole</a>
										</div>
									</div>
								</div>
							</div>

							<div class="testimonial text-xs is-revealing">
								<div class="testimonial-inner">
									<div class="testimonial-main">
										<div class="testimonial-header">
											<img class="mb-16" src="L-images/athena.jpg" alt="Testimonial">
										</div>
										<div class="testimonial-body">
											<p class="mb-0">I am a 3rd-year college student at Southern Leyte State University, passionate about developing technical and practical skills in my chosen field. I'm dedicated to academic growth, actively engaging in projects and activities that deepen my understanding and contribute to my future career.</p>
										</div>
									</div>
									<div class="testimonial-footer">
										<div class="testimonial-link">
											<a href="#">Ms. Athena Joy Campania</a>
										</div>
									</div>
								</div>
							</div>
							
						</div>
					</div>
				</div>
			</section>

			<!-- <section class="newsletter section text-light">
                <div class="container-sm">
                    <div class="newsletter-inner section-inner">
                        <div class="newsletter-header text-center">
                            <h2 class="section-title mt-0">Stay in the know</h2>
                            <p class="section-paragraph">Lorem ipsum is common placeholder text used to demonstrate the graphic elements of a document or visual presentation.</p>
                        </div>
                        <div class="footer-form newsletter-form field field-grouped">
                            <div class="control control-expanded">
                                <input class="input" type="email" name="email" placeholder="Your best email&hellip;">
                            </div>
                            <div class="control">
                                <a class="button button-primary button-block button-shadow" href="#">Early access</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section> -->
        </main>

        <footer class="site-footer">
            <div class="container">
                <div class="site-footer-inner has-top-divider">
                    <div class="brand footer-brand">
                        <a href="#">
						<svg width="50" height="50" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg" fill="none">
							<!-- Outer Circle representing the Alumni Network -->
							<circle cx="25" cy="25" r="24" stroke="#4CAF50" stroke-width="2" fill="url(#outer-gradient)"/>

							<!-- Inner Circle representing Connection Points -->
							<circle cx="25" cy="25" r="16" fill="url(#inner-gradient)" opacity="0.8"/>

							<!-- Inner Dot representing Centralization -->
							<circle cx="25" cy="25" r="4" fill="#FF9800" />

							<!-- Gradient Definitions -->
							<defs>
								<radialGradient id="outer-gradient" cx="50%" cy="50%" r="50%" fx="50%" fy="50%">
								<stop offset="0%" style="stop-color:#A5D6A7; stop-opacity:1" />
								<stop offset="100%" style="stop-color:#4CAF50; stop-opacity:1" />
								</radialGradient>
								<radialGradient id="inner-gradient" cx="50%" cy="50%" r="50%" fx="50%" fy="50%">
								<stop offset="0%" style="stop-color:#BBDEFB; stop-opacity:1" />
								<stop offset="100%" style="stop-color:#2196F3; stop-opacity:1" />
								</radialGradient>
							</defs>
							</svg>

                        </a>
                    </div>
                    <ul class="footer-links list-reset">
                        <li>
                            <a href="#">Contact</a>
                        </li>
                        <li>
                            <a href="#">About us</a>
                        </li>
                        <li>
                            <a href="#">FAQ's</a>
                        </li>
                        <li>
                            <a href="#">Support</a>
                        </li>
                    </ul>
                    <ul class="footer-social-links list-reset">
                        <li>
                            <a href="#">
                                <span class="screen-reader-text">Facebook</span>
                                <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6.023 16L6 9H3V6h3V4c0-2.7 1.672-4 4.08-4 1.153 0 2.144.086 2.433.124v2.821h-1.67c-1.31 0-1.563.623-1.563 1.536V6H13l-1 3H9.28v7H6.023z" fill="#FFF"/>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="screen-reader-text">Twitter</span>
                                <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M16 3c-.6.3-1.2.4-1.9.5.7-.4 1.2-1 1.4-1.8-.6.4-1.3.6-2.1.8-.6-.6-1.5-1-2.4-1-1.7 0-3.2 1.5-3.2 3.3 0 .3 0 .5.1.7-2.7-.1-5.2-1.4-6.8-3.4-.3.5-.4 1-.4 1.7 0 1.1.6 2.1 1.5 2.7-.5 0-1-.2-1.5-.4C.7 7.7 1.8 9 3.3 9.3c-.3.1-.6.1-.9.1-.2 0-.4 0-.6-.1.4 1.3 1.6 2.3 3.1 2.3-1.1.9-2.5 1.4-4.1 1.4H0c1.5.9 3.2 1.5 5 1.5 6 0 9.3-5 9.3-9.3v-.4C15 4.3 15.6 3.7 16 3z" fill="#FFF"/>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="screen-reader-text">Google</span>
                                <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7.9 7v2.4H12c-.2 1-1.2 3-4 3-2.4 0-4.3-2-4.3-4.4 0-2.4 2-4.4 4.3-4.4 1.4 0 2.3.6 2.8 1.1l1.9-1.8C11.5 1.7 9.9 1 8 1 4.1 1 1 4.1 1 8s3.1 7 7 7c4 0 6.7-2.8 6.7-6.8 0-.5 0-.8-.1-1.2H7.9z" fill="#FFF"/>
                                </svg>
                            </a>
                        </li>
                    </ul>
                    <div class="footer-copyright">&copy; 2024 Alumni Tracer, all rights reserved</div>
                </div>
            </div>
        </footer>
    </div>

    <script src="dist/js/main.min.js"></script>
</body>
</html>