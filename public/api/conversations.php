<?php
require_once __DIR__ . '/../../classes/Auth.php';
require_once __DIR__ . '/../../classes/Conversation.php';


$auth = new Auth();
if (!$auth->isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Not logged in']);
    exit;
}

$conversations = new Conversation();
header('Content-Type: application/json');

switch($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $conversationsList = $conversations->getAllByUserId($auth->userId());
        echo json_encode(['success' => true,
                            'id' => $auth->userId(),
                            'conversations' => $conversationsList]);
        break;
    case 'POST':
        $decode_json = json_decode(file_get_contents('php://input'), true);
        $title = $decode_json['title'] ?? '';
        $chat_id = $conversations->create($auth->userId(), $title);
        echo json_encode(['success' => true, 'id' => $chat_id]);
        break;
    case 'DELETE':
        parse_str(file_get_contents("php://input"), $deleteVars);
        $chat_id = (int)($deleteVars['chat_id'] ?? 0);
        if ($chat_id <= 0) {
            echo json_encode(['success' => false, 'error' => 'Invalid ID']);
            exit;
        }
        $success = $conversations->deleteByIdAndUser($chat_id, $auth->userId());
        echo json_encode(['success' => $success]);
        break;
    default:
        http_response_code(405);
}

?>