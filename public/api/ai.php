<?php
$config = require_once __DIR__ . '../../config/secrets.php';
$apiKey = $config['OPENROUTER_API_KEY'];
$apiUrl = 'https://openrouter.ai/api/v1/chat/completions';

$input = json_decode(file_get_contents('php://input'), true);
$userMessage = $input['message'] ?? '';

$data = [
    "model" => "openai/gpt-4o-mini",
    "messages" => [
        ["role" => "system", "content" => 
            "You are ProffAI, a helpful and encouraging university professor. 
             Your goal is to help students with their schoolwork.
             Do not just give answers; explain concepts.
             Always be professional, academic, kind.
             Respond in Albanian and prioritize Albanian language."],
        ["role" => "user", "content" => $userMessage]
    ]
];

$headers = [
    "Content-Type: application/json",
    "Authorization: Bearer $apiKey"
];

$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo json_encode(['error' => curl_error($ch)]);
    exit;
}

curl_close($ch);

header('Content-Type: application/json');
echo $response;
