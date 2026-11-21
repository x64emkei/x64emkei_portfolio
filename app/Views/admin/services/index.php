<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px;">
    <!-- Add Service Form -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">+ Add Service</h3>
        </div>
        <form action="<?= e(url('admin/services')) ?>" method="POST">
            <?= csrf_field() ?>
            <div class="form-group">
                <label class="form-label" for="title">// SERVICE TITLE</label>
                <input type="text" id="title" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="category">// CATEGORY</label>
                <input type="text" id="category" name="category" class="form-control" placeholder="e.g. Systems Architecture" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="description">// DESCRIPTION</label>
                <textarea id="description" name="description" class="form-control" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label class="form-label" for="display_order">// DISPLAY ORDER</label>
                <input type="number" id="display_order" name="display_order" class="form-control" value="0">
            </div>
            <button type="submit" class="btn-admin btn-admin-cyan" style="width: 100%;">+ REGISTER SERVICE</button>
        </form>
    </div>

    <!-- Services List -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">&#9881; Services & Engineering Offerings</h3>
        </div>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>SERVICE</th>
                    <th>CATEGORY</th>
                    <th>DESCRIPTION</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($services as $srv): ?>
                    <tr>
                        <td><b><?= e($srv['title']) ?></b></td>
                        <td><span style="font-size: 0.75rem; color: var(--admin-cyan);"><?= e($srv['category']) ?></span></td>
                        <td style="font-size: 0.8rem;"><?= e(substr($srv['description'], 0, 90)) ?>...</td>
                        <td>
                            <form action="<?= e(url('admin/services/' . $srv['id'] . '/delete')) ?>" method="POST" onsubmit="return confirm('Delete service?');">
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
