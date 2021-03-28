<!-- f3cf897892df57307c368f33bcb17d82 -->

<?php

$searchQuery = '19.07047950,72.89820200';

$buildQuery = http_build_query([
  'access_key' => 'f3cf897892df57307c368f33bcb17d82',
  'query' => $searchQuery
]);
$ch = curl_init(sprintf('%s?%s', 'http://api.positionstack.com/v1/reverse', $buildQuery));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);

// print("<pre>".print_r($result,true)."</pre>");

// echo $result["data"]["0"]["label"];

?>




<?php

$searchTerm = 'sahyadri krida mandal, tilak nagar, chembur , mumbai - 400089';

$buildQuery = http_build_query([
  'access_key' => 'f3cf897892df57307c368f33bcb17d82',
  'query' => $searchTerm
]);

$ch = curl_init(sprintf('%s?%s', 'http://api.positionstack.com/v1/forward', $buildQuery));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$responseData = curl_exec($ch);
curl_close($ch);

$resultData = json_decode($responseData, true);

echo $resultData["data"]["0"]["latitude"];
echo $resultData["data"]["0"]["longitude"];


?>