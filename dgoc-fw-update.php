<?php
// dgoc-fw-update.php
// update Digital Ocean firewall with your IP 
error_reporting(0);
$api_token 				= "YOUR_API_TOKEN";
$firewall_id			= "YOUR_FIREWALL_ID";
$firewall_name			= "allow-ssh";
$firewall_protocol		= "tcp";
$firewall_port			= "22";
// where you will get your IP? Static or Dynamic?
$firewall_source		= trim(file_get_contents("http://whatismyip.akamai.com/"));
$droplets_ids			= "201312280,214232601,230024322,257204439";
$payload	 			= '{"name":"'.$firewall_name.'","inbound_rules":[{"protocol":"'.$firewall_protocol.'","ports":"'.$firewall_port.'","sources":{"addresses":["'.$firewall_source.'"]}}],"droplet_ids":['.$droplets_ids.'],"tags":[]}';
$ch 					= curl_init('https://api.digitalocean.com/v2/firewalls/'.$firewall_id);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_VERBOSE, 0);   
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer '.$api_token,
    'Content-Type: application/json',
    'Content-Length: ' . strlen($payload))
);
$result = curl_exec($ch);
if($result === false){
    echo 'ERROR: ' . curl_error($ch);
}else{
    echo 'OK';
}
curl_close($ch);
?>