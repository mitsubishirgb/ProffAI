<?php
require_once __DIR__ . '/../../classes/Auth.php';
require_once __DIR__ . '/../../classes/Message.php'; 

$auth = new Auth();
if (!$auth->isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Not logged in']);
    exit;
}

$message = new Message();
header('Content-Type: application/json');

$chat_id = isset($_GET['chat_id']) ? (int)$_GET['chat_id'] : null;

switch($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if ($chat_id === null) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Missing chat_id']);
            exit;
        }

        $list = $message->get($chat_id);
        echo json_encode(['success' => true, 'messages' => $list]);
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $chat_id = (int)($data['chat_id'] ?? 0);
        $content = $data['content'] ?? '';

        if ($chat_id <= 0 || empty($content)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Invalid data']);
            exit;
        }

        $msg_id = $message->create($chat_id, $data['role'], $content);
        echo json_encode(['success' => (bool)$msg_id, 'message_id' => $msg_id]);
        break;

    default:
        http_response_code(405);
}