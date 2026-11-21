<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px;">
    <!-- Add Certification Form -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">+ Add Certification</h3>
        </div>
        <form action="<?= e(url('admin/certifications')) ?>" method="POST">
            <?= csrf_field() ?>
            <div class="form-group">
                <label class="form-label" for="title">// CERTIFICATION TITLE</label>
                <input type="text" id="title" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="issuer">// ISSUING BODY</label>
                <input type="text" id="issuer" name="issuer" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="issue_date">// ISSUE DATE</label>
                <input type="text" id="issue_date" name="issue_date" class="form-control" placeholder="2024">
            </div>
            <div class="form-group">
                <label class="form-label" for="credential_id">// CREDENTIAL ID</label>
                <input type="text" id="credential_id" name="credential_id" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label" for="credential_url">// VERIFICATION URL</label>
                <input type="url" id="credential_url" name="credential_url" class="form-control">
            </div>
            <button type="submit" class="btn-admin btn-admin-cyan" style="width: 100%;">+ ADD CERTIFICATION</button>
        </form>
    </div>

    <!-- Certifications List -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">&#128391; Credential Archive</h3>
        </div>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>CERTIFICATION</th>
                    <th>ISSUER</th>
                    <th>DATE</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($certifications as $cert): ?>
                    <tr>
                        <td><b><?= e($cert['title']) ?></b></td>
                        <td style="font-size: 0.8rem; color: var(--admin-cyan);"><?= e($cert['issuer']) ?></td>
                        <td style="font-size: 0.75rem; color: #64748b;"><?= e($cert['issue_date']) ?></td>
                        <td>
                            <form action="<?= e(url('admin/certifications/' . $cert['id'] . '/delete')) ?>" method="POST" onsubmit="return confirm('Delete credential?');">
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
