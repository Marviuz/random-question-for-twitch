<?php
$api_url = [
    'https://opentdb.com/api.php?amount=1&category=31',
    'https://opentdb.com/api.php?amount=1&category=15'
];
$response = file_get_contents($api_url[array_rand($api_url)]);
$response = json_decode($response);
$choices = "";

// var_dump($response);

if ($response->results[0]->type == "boolean") {
    $choices .= "✅ or ❌?";
} else {
    $all = array($response->results[0]->correct_answer, ...$response->results[0]->incorrect_answers);
    shuffle($all);
    
    $choice_identifier = ["🔴","🟠","🟡","🟢"];
    for ($i = 0; $i < count($all); $i++) {
        $c = html_entity_decode($all[$i], ENT_QUOTES);
        $ci = $choice_identifier[$i];
        $all[$i] = "$ci $c";
    }
    
    $choices .= join(" ", $all);
    
}

echo html_entity_decode($response->results[0]->question) . " " . $choices;
?>