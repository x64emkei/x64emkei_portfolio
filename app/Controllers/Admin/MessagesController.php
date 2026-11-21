<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Message;
use App\Models\ActivityLog;
use App\Services\AuthService;
use App\Services\ViewRenderer;

class MessagesController
{
    public function index(): void
    {
        $messages = Message::getInbox(100);
        $renderer = new ViewRenderer();
        echo $renderer->render('admin.messages.index', [
            'messages' => $messages,
            'unreadCount' => Message::countUnread(),
            'pageTitle' => 'Transmitted Telemetry Messages'
        ], 'admin.layout');
    }

    public function toggleRead(int|string $id): void
    {
        $id = (int)$id;
        $msg = Message::find($id);
        if ($msg) {
            $newStatus = !$msg['is_read'];
            Message::markRead($id, $newStatus);
            flash('success', $newStatus ? 'Message marked as read.' : 'Message marked as unread.');
        }
        redirect('admin/messages');
    }

    public function archive(int|string $id): void
    {
        $id = (int)$id;
        Message::archive($id, true);
        flash('success', 'Message archived.');
        redirect('admin/messages');
    }

    public function delete(int|string $id): void
    {
        $id = (int)$id;
        $msg = Message::find($id);
        if ($msg) {
            Message::delete($id);
            ActivityLog::record(AuthService::id(), 'MESSAGE_DELETE', "Deleted transmission from {$msg['sender_name']}");
            flash('success', 'Message deleted permanently.');
        }
        redirect('admin/messages');
    }
}
