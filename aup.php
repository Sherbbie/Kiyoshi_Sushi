<?php
	$title = "Acceptable Use Policy";
	$date = "11/11/2016";
	$filename = "aup.php";
	$description = "This webpage displays the Acceptable Use Policy within our site.";
	include("./header_footer/header.php");
?>
<div style="text-align:center">
<?php
if(isset($_SESSION["RedirectedOutput"]))
{

	echo $_SESSION["RedirectedOutput"];
	unset($_SESSION["RedirectedOutput"]);

}
?>
<h1>Acceptable Use Policy</h1>
<h5>In order to register to Kiyoshi Sushi, you must agree to the following policies.</h5>
</div>

<h4>1.0 Overview</h4>
<p>
Consistent standards for network access and authentication are critical to the company's information security and are often required by regulations or third-party agreements.  Any user accessing the company's computer systems has the ability to affect the security of all users of the network.  An appropriate Network Access and Authentication Policy reduces risk of a security incident by requiring consistent application of authentication and access standards across the network.
</p>
<h4>2.0 Purpose</h4>
<p>
The purpose of this policy is to describe what steps must be taken to ensure that users connecting to the corporate network are authenticated in an appropriate manner, in compliance with company standards, and are given the least amount of access required to perform their job function.  This policy specifies what constitutes appropriate use of network accounts and authentication standards.
</p>
<h4>3.0 Scope</h4>
<p>
The scope of this policy includes all users who have access to company-owned or company-provided computers or require access to the corporate network and/or systems.  This policy applies not only to employees, but also to guests, contractors, and anyone requiring access to the corporate network.  Public access to the company's externally-reachable systems, such as its corporate website or public web applications, are specifically excluded from this policy.
</p>
<h4>4.0 Policy</h4>

<h5>4.1 Account Setup</h5>
<p>
During initial account setup, certain checks must be performed in order to ensure the integrity of the process.  The following policies apply to account setup:

	<li>Positive ID and coordination with Human Resources is required.</li>

	<li>Users will be granted least amount of network access required to perform his or her job function.</li>

	<li>Users will be granted access only if he or she accepts the Acceptable Use Policy.</li>

	<li>Access to the network will be granted in accordance with the Acceptable Use Policy.</li>
</p>
<h5>4.2 Account Use</h5>
<p>
Network accounts must be implemented in a standard fashion and utilized consistently across the organization.  The following policies apply to account use:

	<li>Accounts must be created using a standard format (i.e., firstname lastname, or firstinitial lastname, etc.)</li>

	<li>Accounts must be password protected (refer to the Password Policy for more detailed information).</li>

	<li>Accounts must be for individuals only.  Account sharing and group accounts are not permitted.</li>

	<li>User accounts must not be given administrator or 'root' access unless this is necessary to perform his or her job function.</li>

	<li>Occasionally guests will have a legitimate business need for access to the corporate network.  When a reasonable need is demonstrated, temporary guest access is allowed.</li>

	<li>Individuals requiring access to confidential data must have an individual, distinct account.  This account may be subject to additional monitoring or auditing at the discretion of the IT Manager or executive team, or as required by applicable regulations or third-party agreements.</li>
</p>
<h5>4.3 Account Termination</h5>
<p>
When managing network and user accounts, it is important to stay in communication with the Human Resources department so that when an employee no longer works at the company, that employee's account can be disabled.  Human Resources must create a process to notify the IT Manager in the event of a staffing change, which includes employment termination, employment suspension, or a change of job function (promotion, demotion, suspension, etc.).
</p>
<h5>4.4 Authentication</h5>
<p>
User machines must be configured to request authentication against the domain at startup.  If the domain is not available or authentication for some reason cannot occur, then the machine should not be permitted to access the network.
</p>
<h5>4.5 Use of Passwords</h5>
<p>
When accessing the network locally, username and password is an acceptable means of authentication.  Usernames must be consistent with the requirements set forth in this document, and passwords must conform to the company's Password Policy.
</p>
<h5>4.6 Remote Network Access</h5>
<p>
Remote access to the network can be provided for convenience to users but this comes at some risk to security.  For that reason, the company encourages additional scrutiny of users remotely accessing the network.  The company's standards dictate that username and password is an acceptable means of authentication as long as appropriate policies are followed.  Remote access must adhere to the Remote Access Policy.
</p>
<h5>4.7 Screensaver Passwords</h5>
<p>
Screensaver passwords offer an easy way to strengthen security by removing the opportunity for a malicious user, curious employee, or intruder to access network resources through an idle computer.  For this reason screensaver passwords are encouraged.
</p>
<h5>4.8 Minimum Configuration for Access</h5>
<p>
Any system connecting to the network can have a serious impact on the security of the entire network.  A vulnerability, virus, or other malware may be inadvertently introduced in this manner.  For this reason, users should update their antivirus software, as well as other critical software, to the latest versions before accessing the network.
</p>
<h5>4.9 Encryption</h5>
<p>
Industry best practices state that username and password combinations must never be sent as plain text.  If this information were intercepted, it could result in a serious security incident.  Therefore, authentication credentials must be encrypted during transmission across any network, whether the transmission occurs internal to the company network or across a public network such as the Internet.
</p>
<h5>4.10 Failed Logons</h5>
<p>
Repeated logon failures can indicate an attempt to 'crack' a password and surreptitiously access a network account.  In order to guard against password-guessing and brute-force attempts, the company must lock a user's account after 5 unsuccessful logins.  This can be implemented as a time-based lockout or require a manual reset, at the discretion of the IT Manager.

In order to protect against account guessing, when logon failures occur the error message transmitted to the user must not indicate specifically whether the account name or password were incorrect.  The error can be as simple as "the username and/or password you supplied were incorrect."
</p>
<h5>4.11 Non-Business Hours</h5>
<p>
While some security can be gained by removing account access capabilities during non-business hours, the company does not mandate time-of-day lockouts.  This may be either to encourage working remotely, or because the company's business requires all-hours access.
</p>
<h5>4.12 Applicability of Other Policies</h5>
<p>
This document is part of the company's cohesive set of security policies.  Other policies may apply to the topics covered in this document and as such the applicable policies should be reviewed as needed.
</p>
<h4>5.0 Enforcement</h4>
<p>
This policy will be enforced by the IT Manager and/or Executive Team. Violations may result in disciplinary action, which may include suspension, restriction of access, or more severe penalties up to and including termination of employment. Where illegal activities or theft of company property (physical or intellectual) are suspected, the company may report such activities to the applicable authorities.
</p>
<h4>6.0 Definitions</h4>
<p>
<li>Antivirus Software  An application used to protect a computer from viruses, typically through real time defenses and periodic scanning.  Antivirus software has evolved to cover other threats, including Trojans, spyware, and other malware.</li>

<li>Authentication  A security method used to verify the identity of a user and authorize access to a system or network.</li>

<li>Biometrics  The process of using a person's unique physical characteristics to prove that person's identity.  Commonly used are fingerprints, retinal patterns, and hand geometry.</li>

<li>Encryption  The process of encoding data with an algorithm so that it is unintelligible without the key.  Used to protect data during transmission or while stored.</li>

<li>Password  A sequence of characters that is used to authenticate a user to a file, computer, or network.  Also known as a passphrase or passcode.</li>

<li>Smart Card  A plastic card containing a computer chip capable of storing information, typically to prove the identity of the user.  A card-reader is required to access the information.</li>

<li>Token  A small hardware device used to access a computer or network.  Tokens are typically in the form of an electronic card or key fob with a regularly changing code on its display.</li>
</p>
<h4>7.0 Revision History</h4>
<p>
Revision 1.0, 12/2/2015
</p>





<?php
	include("./header_footer/footer.php");
?>
