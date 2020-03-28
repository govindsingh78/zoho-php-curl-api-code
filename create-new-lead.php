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
	
	/**
	* Bearer token will access_token.
	*/
	$headers = array(
		'Content-Type: application/json',
		'Authorization: Bearer '.$response->access_token
	);
	
	$curl = 'https://www.zohoapis.in/crm/v2/Leads';
	
	$ch = curl_init($curl);
	curl_setopt($ch, CURLOPT_VERBOSE, 1);//standard i/o streams 
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);// Turn off the server and peer verification 
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//Set to return data to string ($response) 
	curl_setopt($ch, CURLOPT_POST, 1);//Regular post 
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode( $lead_data ) );// Set the request as a POST FIELD for curl. 
	$response = curl_exec($ch);
	$response = json_decode( $response );
	
	echo '<pre>'; print_r( $response ); echo '</pre>';
	echo $response->data[0]->details->id; // return CRM lead record id
	echo $response->data[0]->status; // success or error
	
}	else {
	echo 'Refresh Token is not valid';
}
