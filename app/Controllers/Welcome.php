<?php

namespace App\Controllers;

use Google\Client;

class Welcome extends BaseController
{
    public function __construct()
    {
        // No need to call parent::__construct() in CI4 BaseController
        // No need to load helpers or models here if not used globally in the controller
    }

    public function index()
    {
		session()->remove('access_token');
		session()->destroy();
	
  $data['title'] = "หน้าแรก";
  $data['description'] = "หน้าแรก";  
  $data['full_url'] = current_url();
  $data['banner'] = "";

  return view('user/PageWelcomeAcademic', $data);
    }

    public function LoginMenager(){
        // Ensure the Google Client library's autoloader is included.
        // This path is based on the user's manual setup.
        $path = dirname(dirname(dirname(dirname((dirname(__FILE__))))));
        require $path . '/librarie_skj/google_sheet/vendor/autoload.php';

        // Create a new Google Client instance
        $google_client = new Client(); // Using 'Client' due to 'use Google\Client;'

        // Set the OAuth 2.0 Client ID, Client Secret, and Redirect URI
        // IMPORTANT: The Redirect URI MUST exactly match one of the Authorized redirect URIs
        // configured in your Google Cloud Console for this OAuth 2.0 Client ID.
        // Mismatches will result in a "redirect_uri_mismatch" error (Error 500 from Google).
        $redirect_uri = base_url('LoginMenager_callback'); // This will resolve to http://localhost/manage_ci4/LoginMenager_callback if running locally

        $google_client->setClientId('29638025169-aeobhq04v0lvimcjd27osmhlpua380gl.apps.googleusercontent.com');
        $google_client->setClientSecret('RSANANTRl84lnYm54Hi0icGa');
        $google_client->setRedirectUri($redirect_uri);

        // Add the necessary scopes for email and profile information
        $google_client->addScope('email');
        $google_client->addScope('profile');
    
        // Redirect the user to Google's authentication URL to start the OAuth flow
        return redirect()->to($google_client->createAuthUrl());
    }

	

    public function LoginStudent()
    {
		echo view('login/loginMain.php');
    }

    public function ClosePage()
    {
		echo view('errors/ClosePage.php');
    }
}