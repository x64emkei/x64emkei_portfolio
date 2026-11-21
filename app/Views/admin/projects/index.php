<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title">&#128187; Project Portfolio Matrix</h3>
        <a href="<?= e(url('admin/projects/create')) ?>" class="btn-admin btn-admin-cyan">+ NEW PROJECT BUILD</a>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th>ID / CODE</th>
                <th>PROJECT TITLE</th>
                <th>CATEGORY</th>
                <th>METRIC / STATUS</th>
                <th>VISIBILITY</th>
                <th>ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($projects as $proj): ?>
                <tr>
                    <td><span style="font-size: 0.75rem; color: var(--admin-cyan);"><?= e($proj['code_id']) ?></span></td>
                    <td>
                        <b><?= e($proj['title']) ?></b><br>
                        <span style="font-size: 0.75rem; color: #64748b;"><?= e(substr($proj['tagline'], 0, 70)) ?>...</span>
                    </td>
                    <td><span class="status-pill" style="border: 1px solid rgba(0,229,255,0.3);"><?= e($proj['category']) ?></span></td>
                    <td style="font-size: 0.78rem;"><?= e($proj['performance_metric'] ?: $proj['operational_status']) ?></td>
                    <td>
                        <?php if ($proj['is_published']): ?>
                            <span class="status-pill status-active">PUBLISHED</span>
                        <?php else: ?>
                            <span class="status-pill status-draft">DRAFT</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div style="display: flex; gap: 8px;">
                            <a href="<?= e(url('admin/projects/' . $proj['id'] . '/edit')) ?>" class="btn-admin btn-admin-outline" style="padding: 4px 8px; font-size: 0.72rem;">EDIT</a>
                            <form action="<?= e(url('admin/projects/' . $proj['id'] . '/delete')) ?>" method="POST" onsubmit="return confirm('Purge project <?= e($proj['title']) ?> permanently?');">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn-admin btn-admin-danger" style="padding: 4px 8px; font-size: 0.72rem;">DELETE</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
