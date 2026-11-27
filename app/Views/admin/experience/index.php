<div class="layout-split">
    <!-- Add Experience Form -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">+ Add Experience</h3>
        </div>
        <form action="<?= e(url('admin/experience')) ?>" method="POST">
            <?= csrf_field() ?>
            <div class="form-group">
                <label class="form-label" for="title">// ROLE / TITLE</label>
                <input type="text" id="title" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="organization">// ORGANIZATION</label>
                <input type="text" id="organization" name="organization" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="location">// LOCATION</label>
                <input type="text" id="location" name="location" class="form-control">
            </div>
            <div class="layout-form-grid" style="gap: 10px;">
                <div class="form-group">
                    <label class="form-label" for="period_start">// START</label>
                    <input type="text" id="period_start" name="period_start" class="form-control" placeholder="2023" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="period_end">// END</label>
                    <input type="text" id="period_end" name="period_end" class="form-control" placeholder="Present">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label" for="description">// DESCRIPTION</label>
                <textarea id="description" name="description" class="form-control" rows="3"></textarea>
            </div>
            <button type="submit" class="btn-admin btn-admin-cyan" style="width: 100%;">+ ADD EXPERIENCE</button>
        </form>
    </div>

    <!-- Experience List -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">&#128218; Experience Timeline</h3>
        </div>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ROLE & ORG</th>
                    <th>PERIOD</th>
                    <th>DESCRIPTION</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($experiences as $exp): ?>
                    <tr>
                        <td>
                            <b><?= e($exp['title']) ?></b><br>
                            <span style="font-size: 0.75rem; color: var(--admin-cyan);"><?= e($exp['organization']) ?></span>
                        </td>
                        <td style="font-size: 0.75rem; color: #64748b;"><?= e($exp['period_start']) ?> &ndash; <?= e($exp['period_end'] ?: 'Present') ?></td>
                        <td style="font-size: 0.8rem;"><?= e(substr($exp['description'] ?? '', 0, 90)) ?>...</td>
                        <td>
                            <form action="<?= e(url('admin/experience/' . $exp['id'] . '/delete')) ?>" method="POST" onsubmit="return confirm('Delete experience entry?');">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn-admin btn-admin-danger" style="padding: 2px 6px; font-size: 0.7rem;">&times;</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
