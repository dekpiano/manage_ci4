<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Google extends BaseConfig
{
    /**
     * Google Client ID
     */
    public string $clientId = '';

    /**
     * Google Client Secret
     */
    public string $clientSecret = '';

    /**
     * Path to the downloaded JSON key file if using a service account
     */
    public string $serviceAccountKeyPath = '';

    /**
     * Default Redirect URI for OAuth
     */
    public string $redirectUri = '';

    public function __construct()
    {
        parent::__construct();

        $this->clientId = env('google.clientId', '29638025169-aeobhq04v0lvimcjd27osmhlpua380gl.apps.googleusercontent.com');
        $this->clientSecret = env('google.clientSecret', 'RSANANTRl84lnYm54Hi0icGa');
        $this->redirectUri = base_url('Auth/googleLogin');
    }
}
