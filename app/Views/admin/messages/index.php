<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title">&#9993; Incoming Telemetry Messages (<?= count($messages) ?>)</h3>
        <span style="font-size: 0.8rem; color: var(--admin-magenta);">
            Unread: <b><?= (int)($unreadCount ?? 0) ?></b>
        </span>
    </div>

    <?php if (empty($messages)): ?>
        <p style="color: #64748b; font-size: 0.85rem; font-style: italic;">No contact inquiries or transmissions logged.</p>
    <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>STATUS</th>
                    <th>SENDER</th>
                    <th>SUBJECT & MESSAGE BODY</th>
                    <th>IP / TIMESTAMP</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($messages as $msg): ?>
                    <tr style="<?= !$msg['is_read'] ? 'background: rgba(0,229,255,0.03);' : '' ?>">
                        <td>
                            <?php if (!$msg['is_read']): ?>
                                <span class="status-pill" style="background: rgba(255,51,102,0.2); color: #ff3366; border: 1px solid #ff3366;">NEW</span>
                            <?php else: ?>
                                <span class="status-pill" style="color: #64748b; border: 1px solid #334155;">READ</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <b><?= e($msg['sender_name']) ?></b><br>
                            <a href="mailto:<?= e($msg['sender_email']) ?>" style="font-size: 0.75rem; color: var(--admin-cyan);"><?= e($msg['sender_email']) ?></a>
                        </td>
                        <td>
                            <div style="font-weight: 600; color: #f8fafc; font-size: 0.85rem;"><?= e($msg['subject']) ?></div>
                            <div style="color: #94a3b8; font-size: 0.8rem; margin-top: 4px; white-space: pre-wrap;"><?= e($msg['message_body']) ?></div>
                        </td>
                        <td style="font-size: 0.72rem; color: #64748b;">
                            <?= e($msg['sender_ip']) ?><br>
                            <?= e(date('M d, Y H:i:s', strtotime($msg['created_at']))) ?>
                        </td>
                        <td>
                            <div style="display: flex; gap: 6px;">
                                <form action="<?= e(url('admin/messages/' . $msg['id'] . '/read')) ?>" method="POST">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn-admin btn-admin-outline" style="padding: 3px 6px; font-size: 0.7rem;">
                                        <?= $msg['is_read'] ? 'MARK UNREAD' : 'MARK READ' ?>
                                    </button>
                                </form>
                                <form action="<?= e(url('admin/messages/' . $msg['id'] . '/delete')) ?>" method="POST" onsubmit="return confirm('Purge message?');">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn-admin btn-admin-danger" style="padding: 3px 6px; font-size: 0.7rem;">&times;</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
