<?php
require_once __DIR__.'/vendor/autoload.php';
require_once 'templates/base.php';

// Set up authentication.
$client = new Google_Client();
$client->setAccessType('offline');
$client->addScope('https://www.googleapis.com/auth/adsense.readonly');

// Client Info
$client->setClientId('CLIENT_ID');
$client->setClientSecret('CLIENT_SECRET');
$client->setRedirectUri('http://localhost/adsense/index.php');


$service = new Google_Service_AdSense($client);

if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();

  echo "refresh_token = ".$client->getRefreshToken();
  exit;
}

$client->setApprovalPrompt('force');
$authUrl = $client->createAuthUrl();
echo pageHeader('AdSense Management API / Get Refresh Token with Oauth2');

// OAuth Link
echo '<div><div class="request">';
if (isset($authUrl)) {
  echo '<a class="login" href="' . $authUrl . '">Get Refresh Token</a>';
}
echo '</div>';
