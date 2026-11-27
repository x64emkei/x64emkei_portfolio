<div style="margin-bottom: 28px;">
    <h1 style="color: var(--admin-cyan); margin: 0 0 6px 0; font-size: 1.4rem;">SYSTEM MANAGEMENT & DIAGNOSTICS</h1>
    <p style="color: #64748b; margin: 0; font-size: 0.85rem;">Hardware, runtime environment, database cluster status, and portfolio dataset synchronization.</p>
</div>

<!-- Database Status & Sync Card -->
<div class="admin-card" style="border-left: 3px solid <?= ($systemInfo['database']['status'] === 'CONNECTED') ? 'var(--admin-green)' : 'var(--admin-magenta)' ?>;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px;">
        <div>
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                <span style="display: inline-block; width: 10px; height: 10px; border-radius: 50%; background: <?= ($systemInfo['database']['status'] === 'CONNECTED') ? 'var(--admin-green)' : 'var(--admin-magenta)' ?>;"></span>
                <h3 style="color: #f8fafc; margin: 0; font-size: 1rem;">DATABASE CLUSTER: <?= e($systemInfo['database']['status']) ?></h3>
            </div>
            <p style="color: #94a3b8; margin: 0; font-size: 0.82rem;">
                Database: <span style="color: var(--admin-cyan);"><?= e($systemInfo['database']['database'] ?? 'N/A') ?></span> &bull;
                Tables Active: <span style="color: var(--admin-green);"><?= (int)($systemInfo['database']['table_count'] ?? 0) ?></span>
            </p>
        </div>
        <form method="POST" action="<?= e(url('admin/database/sync')) ?>" onsubmit="return confirm('Synchronize database schema and portfolio datasets now?');">
            <?= csrf_field() ?>
            <button type="submit" class="btn-admin btn-admin-cyan">
                &#x21bb; RUN DATABASE & DATASET SYNC
            </button>
        </form>
    </div>
</div>

<!-- Two-Column Diagnostics Grid -->
<div class="layout-form-grid" style="gap: 24px;">

    <!-- PHP Runtime Telemetry -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">&#9881; PHP Runtime Environment</h3>
        </div>
        <table class="admin-table">
            <tbody>
                <tr>
                    <td style="color: #94a3b8;">PHP Version</td>
                    <td style="font-weight: 600; color: var(--admin-cyan);"><?= e($systemInfo['php_version']) ?></td>
                </tr>
                <tr>
                    <td style="color: #94a3b8;">Server Software</td>
                    <td><?= e($systemInfo['server_software']) ?></td>
                </tr>
                <tr>
                    <td style="color: #94a3b8;">Memory Limit</td>
                    <td><?= e($systemInfo['memory_limit']) ?></td>
                </tr>
                <tr>
                    <td style="color: #94a3b8;">Max Execution Time</td>
                    <td><?= e($systemInfo['max_execution_time']) ?>s</td>
                </tr>
                <tr>
                    <td style="color: #94a3b8;">Max Upload Size</td>
                    <td><?= e($systemInfo['upload_max_filesize']) ?> (Post Max: <?= e($systemInfo['post_max_size']) ?>)</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Required Extensions -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">&#10003; Essential PHP Extensions</h3>
        </div>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>EXTENSION</th>
                    <th>STATUS</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($systemInfo['extensions'] as $ext => $loaded): ?>
                    <tr>
                        <td style="font-family: monospace;"><?= e($ext) ?></td>
                        <td>
                            <?php if ($loaded): ?>
                                <span class="status-pill status-active">&#10004; LOADED</span>
                            <?php else: ?>
                                <span class="status-pill status-draft">&#10008; MISSING</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<!-- Database Tables Overview -->
<?php if (!empty($systemInfo['database']['tables'])): ?>
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">&#128451; Active Database Tables (<?= count($systemInfo['database']['tables']) ?>)</h3>
        </div>
        <div class="layout-auto-grid" style="gap: 10px;">
            <?php foreach ($systemInfo['database']['tables'] as $tbl): ?>
                <div style="background: rgba(7, 9, 14, 0.6); border: 1px solid var(--admin-border); padding: 8px 12px; border-radius: 4px; font-family: monospace; font-size: 0.8rem; color: #94a3b8;">
                    <span style="color: var(--admin-cyan);">&#9656;</span> <?= e($tbl) ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
