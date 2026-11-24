<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <div>
        <h1 style="color: var(--admin-cyan); margin: 0 0 4px 0; font-size: 1.3rem;">JOURNAL // TRANSMISSION REGISTRY</h1>
        <p style="color: #64748b; margin: 0; font-size: 0.8rem;">Manage articles, technical writeups, publication statuses, and tags.</p>
    </div>
    <a href="<?= url('admin/articles/create') ?>" class="admin-btn admin-btn-primary">+ NEW TRANSMISSION</a>
</div>

<div class="admin-card">
    <table class="admin-table">
        <thead>
            <tr>
                <th style="width: 50px;">ID</th>
                <th>TITLE</th>
                <th>CATEGORY</th>
                <th>AUTHOR</th>
                <th>STATUS</th>
                <th>PUBLISHED AT</th>
                <th style="text-align: right;">ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($articles)): ?>
            <tr>
                <td colspan="7" style="text-align: center; color: #64748b; padding: 32px;">
                    No journal articles logged in repository. Click "+ NEW TRANSMISSION" to publish an article.
                </td>
            </tr>
            <?php else: ?>
                <?php foreach ($articles as $art): ?>
                <tr>
                    <td>#<?= e((string)$art['id']) ?></td>
                    <td>
                        <strong style="color: #f8fafc;"><?= e($art['title']) ?></strong>
                        <div style="font-size: 0.72rem; color: #64748b; margin-top: 2px;">/journal/<?= e($art['slug']) ?></div>
                    </td>
                    <td>
                        <span style="display: inline-block; padding: 2px 8px; border-radius: 4px; font-size: 0.75rem; background: rgba(255, 42, 42, 0.1); color: var(--admin-primary); border: 1px solid rgba(255, 42, 42, 0.25);">
                            <?= e($art['category_name'] ?? 'Uncategorized') ?>
                        </span>
                    </td>
                    <td style="color: #94a3b8; font-size: 0.8rem;"><?= e($art['author_name'] ?? 'System') ?></td>
                    <td>
                        <?php if ($art['status'] === 'published'): ?>
                            <span style="color: var(--admin-green); font-weight: 600; font-size: 0.8rem;">● PUBLISHED</span>
                        <?php elseif ($art['status'] === 'draft'): ?>
                            <span style="color: var(--admin-amber); font-weight: 600; font-size: 0.8rem;">○ DRAFT</span>
                        <?php else: ?>
                            <span style="color: #64748b; font-size: 0.8rem;">ARCHIVED</span>
                        <?php endif; ?>
                    </td>
                    <td style="color: #64748b; font-size: 0.75rem;">
                        <?= e($art['published_at'] ?? $art['created_at']) ?>
                    </td>
                    <td style="text-align: right; white-space: nowrap;">
                        <a href="<?= url('journal/' . $art['slug']) ?>" target="_blank" class="admin-btn admin-btn-secondary" style="padding: 4px 8px; font-size: 0.75rem; margin-right: 4px;">VIEW</a>
                        <a href="<?= url('admin/articles/' . $art['id'] . '/edit') ?>" class="admin-btn admin-btn-secondary" style="padding: 4px 8px; font-size: 0.75rem; margin-right: 4px;">EDIT</a>
                        <form method="POST" action="<?= url('admin/articles/' . $art['id'] . '/delete') ?>" style="display: inline;" onsubmit="return confirm('Purge transmission dossier #<?= e((string)$art['id']) ?>? This action is permanent.');">
                            <?= csrf_field() ?>
                            <button type="submit" class="admin-btn admin-btn-danger" style="padding: 4px 8px; font-size: 0.75rem;">PURGE</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
