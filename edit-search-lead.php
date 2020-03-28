<?php
$client_id = 'ZohoApiClientId';
$client_secret = 'ZohoApiClientSecret';
$access_token  = 'ZohoApiAccessToken';
$refresh_token = 'ZohoApiRefreshToken';

$curl = 'https://accounts.zoho.in/oauth/v2/token?refresh_token='.$refresh_token.'&client_id='.$client_id.'&client_secret='.$client_secret.'&grant_type=refresh_token';

echo '<pre>'; print_r( $response ); echo '</pre>';
echo isset( $response->access_token ) ? $response->access_token : '';


if( isset( $response->access_token ) && $response->access_token != '' ){

	/**
	* Lead data array.
	*/
	$lead_data['data'][0] = array(
		'First_Name' => 'Lead First Name',
		'Last_Name' => 'Lead Last Name',
		'Email' => 'leaduser@email.com',
	);
	
	// check data is existing
	
	$email = $lead_data['data'][0]['Email'];
	$curl = 'https://www.zohoapis.in/crm/v2/Leads/search?email='.$email;
	
	$ch = curl_init($curl);
	curl_setopt($ch, CURLOPT_VERBOSE, 1);//standard i/o streams 
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);// Turn off the server and peer verification 
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//Set to return data to string ($response) 
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	$response = curl_exec($ch);
	
	$response = json_decode( $response );
	echo '<pre>'; print_r( $response ); echo '</pre>';
	
	$zoho_api_user_id = isset( $response->data[0]->id ) ? $response->data[0]->id : '';
	
	// check valid user id from zoho.
	
	if( isset( $zoho_api_user_id ) && $zoho_api_user_id != '' ) {
	
		// existing user
		$record_id = $zoho_api_user_id;
		$curl = 'https://www.zohoapis.in/crm/v2/Leads/'.$record_id;
		
		$ch = curl_init($curl);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);//standard i/o streams 
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);// Turn off the server and peer verification 
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//Set to return data to string ($response) 
		//curl_setopt($ch, CURLOPT_POST, 1);//Regular post 
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode( $lead_data ) );// Set the request as a POST FIELD for curl. 
		$response = curl_exec($ch);
		
		$response = json_decode( $response );
		echo '<pre>'; print_r( $response ); echo '</pre>';
		echo $response->data[0]->details->id;
		echo $response->data[0]->status; // success or error */
		
	} else {
		echo 'No lead found. Try insert new lead code';
		// insert new lead
	}
	
} else {
	echo 'Refresh Token is not valid';
}	
?>
