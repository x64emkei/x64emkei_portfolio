<div class="layout-split">
    <!-- Add Social Link Form -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">+ Add Social Link</h3>
        </div>
        <form action="<?= e(url('admin/social')) ?>" method="POST">
            <?= csrf_field() ?>
            <div class="form-group">
                <label class="form-label" for="platform">// PLATFORM</label>
                <input type="text" id="platform" name="platform" class="form-control" placeholder="github, linkedin, facebook, email" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="label">// DISPLAY LABEL</label>
                <input type="text" id="label" name="label" class="form-control" placeholder="GitHub" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="url">// TARGET URL</label>
                <input type="url" id="url" name="url" class="form-control" placeholder="https://github.com/x64_emkei" required>
            </div>
            <button type="submit" class="btn-admin btn-admin-cyan" style="width: 100%;">+ ADD SOCIAL LINK</button>
        </form>
    </div>

    <!-- Social Links List -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">&#128279; External Telemetry Channels</h3>
        </div>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>PLATFORM</th>
                    <th>LABEL</th>
                    <th>DESTINATION</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($links as $lk): ?>
                    <tr>
                        <td><span style="font-size: 0.75rem; color: var(--admin-cyan);"><?= e($lk['platform']) ?></span></td>
                        <td><b><?= e($lk['label']) ?></b></td>
                        <td style="font-size: 0.8rem;"><a href="<?= e($lk['url']) ?>" target="_blank" style="color: #38bdf8;"><?= e($lk['url']) ?></a></td>
                        <td>
                            <form action="<?= e(url('admin/social/' . $lk['id'] . '/delete')) ?>" method="POST" onsubmit="return confirm('Delete social link?');">
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
