<div style="margin-bottom: 28px;">
    <h1 style="color: var(--admin-cyan); margin: 0 0 6px 0; font-size: 1.4rem;">DASHBOARD</h1>
    <p style="color: #64748b; margin: 0; font-size: 0.85rem;">Overview of your content, messages, projects, and site activity.</p>
</div>

<!-- Site statistics -->
<div class="layout-auto-grid" style="gap: 18px; margin-bottom: 30px;">
    <div class="admin-card" style="margin-bottom: 0;">
        <div class="form-label">// PROJECTS</div>
        <div style="font-size: 2rem; font-weight: 700; color: var(--admin-cyan);"><?= e((string)$stats['total_projects']) ?></div>
        <div style="font-size: 0.75rem; color: #64748b; margin-top: 4px;">
            <?= e((string)$stats['published_projects']) ?> Published &bull; <?= e((string)$stats['draft_projects']) ?> Drafts
        </div>
    </div>
    <div class="admin-card" style="margin-bottom: 0;">
        <div class="form-label">// UNREAD MESSAGES</div>
        <div style="font-size: 2rem; font-weight: 700; color: var(--admin-magenta);"><?= e((string)$stats['unread_messages']) ?></div>
        <div style="font-size: 0.75rem; color: #64748b; margin-top: 4px;">
            <?= e((string)$stats['total_messages']) ?> Total Messages
        </div>
    </div>
    <div class="admin-card" style="margin-bottom: 0;">
        <div class="form-label">// SKILLS</div>
        <div style="font-size: 2rem; font-weight: 700; color: var(--admin-green);"><?= e((string)$stats['total_skills']) ?></div>
        <div style="font-size: 0.75rem; color: #64748b; margin-top: 4px;">
            Across Languages, Frameworks & Infrastructure
        </div>
    </div>
    <div class="admin-card" style="margin-bottom: 0;">
        <div class="form-label">// HARDWARE DEVICES</div>
        <div style="font-size: 2rem; font-weight: 700; color: var(--admin-amber);"><?= e((string)$stats['total_hardware']) ?></div>
        <div style="font-size: 0.75rem; color: #64748b; margin-top: 4px;">
            Devices in the hardware archive
        </div>
    </div>
    <div class="admin-card" style="margin-bottom: 0;">
        <div class="form-label">// RECOGNITIONS & AWARDS</div>
                    <div style="font-size: 2rem; font-weight: 700; color: #FF5252;"><?= e((string)($stats['total_achievements'] ?? 0)) ?></div>
        <div style="font-size: 0.75rem; color: #64748b; margin-top: 4px;">
            Academic & Industry Honors
        </div>
    </div>
    <div class="admin-card" style="margin-bottom: 0;">
        <div class="form-label">// SITE SECTIONS</div>
        <div style="font-size: 2rem; font-weight: 700; color: #a855f7;"><?= e((string)($stats['total_sections'] ?? 0)) ?></div>
        <div style="font-size: 0.75rem; color: #64748b; margin-top: 4px;">
            Configurable homepage sections
        </div>
    </div>
</div>

<!-- Database sync -->
<div class="admin-card" style="border-left: 3px solid var(--admin-cyan); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px;">
    <div>
        <h3 style="color: var(--admin-cyan); margin: 0 0 4px 0; font-size: 0.95rem;">// DATABASE SYNC</h3>
        <p style="color: #94a3b8; margin: 0; font-size: 0.8rem;">Update the database with the current projects, hardware, skills, education, and services in your portfolio.</p>
    </div>
    <form method="POST" action="<?= e(url('admin/database/sync')) ?>" onsubmit="return confirm('Synchronize database with portfolio archives?');">
        <?= csrf_field() ?>
        <button type="submit" class="btn-admin btn-admin-primary" style="font-size: 0.78rem; padding: 7px 16px;">
            &#x21bb; SYNC DATABASE
        </button>
    </form>
</div>

<!-- Two Column Info Grid -->
<div class="layout-form-grid" style="gap: 24px;">
    <!-- Recent messages -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">&#9993; Recent Messages</h3>
            <a href="<?= e(url('admin/messages')) ?>" class="btn-admin btn-admin-outline" style="font-size: 0.72rem; padding: 4px 10px;">VIEW ALL</a>
        </div>
        <?php if (empty($recentMessages)): ?>
            <p style="color: #64748b; font-size: 0.85rem; font-style: italic;">No messages recorded yet.</p>
        <?php else: ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>SENDER</th>
                        <th>SUBJECT</th>
                        <th>TIME</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentMessages as $msg): ?>
                        <tr>
                            <td>
                                <b><?= e($msg['sender_name']) ?></b><br>
                                <span style="font-size: 0.75rem; color: #64748b;"><?= e($msg['sender_email']) ?></span>
                            </td>
                            <td><?= e($msg['subject']) ?></td>
                            <td style="font-size: 0.75rem; color: #64748b;"><?= e(date('M d, H:i', strtotime($msg['created_at']))) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <!-- Activity log -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">&#9881; Activity Log</h3>
        </div>
        <?php if (empty($recentActivity)): ?>
            <p style="color: #64748b; font-size: 0.85rem; font-style: italic;">No administrative operations logged.</p>
        <?php else: ?>
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <?php foreach ($recentActivity as $log): ?>
                    <div style="border-left: 2px solid var(--admin-cyan); padding-left: 12px;">
                        <div style="font-size: 0.82rem; color: #f8fafc; font-weight: 600;">
                            <?= e($log['action']) ?> &bull; <span style="font-size: 0.75rem; color: #64748b;"><?= e(date('M d, H:i:s', strtotime($log['created_at']))) ?></span>
                        </div>
                        <div style="font-size: 0.78rem; color: #94a3b8; margin-top: 2px;"><?= e($log['description']) ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
