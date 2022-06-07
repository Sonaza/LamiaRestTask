<?php

declare(strict_types=1);

class AuthProvider
{
	
	public function __construct()
	{
		
	}
	
	public function post_login(): array
	{
		$body = Helpers::getPostBody();
		
		// Rudimentary authorization for illustrative purposes, not for production use!
		if (array_key_exists('username', $body) && array_key_exists('password', $body))
		{
			if ($body['username'] == 'testuser' && $body['password'] == 'password')
			{
				$token = JSONWebTokenManager::make_token(
				[
					'username' => $body['username'],
				], 'HS256');
				
				return [
					'success' => true,
					'token'   => $token,
				];
			}
		}
		
		return [
			'success' => false,
		];
	}
	
	public function verify_authorization(): bool
	{
		$bearer_token = Helpers::getAuthorizationBearerToken();
		if (is_null($bearer_token)) return false;
		
		return JSONWebTokenManager::verify_token($bearer_token);
	}
	
}
