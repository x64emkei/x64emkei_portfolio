<div class="layout-split">
    <!-- Add Hardware Form -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">+ Add Hardware Node</h3>
        </div>
        <form action="<?= e(url('admin/hardware')) ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="form-group">
                <label class="form-label" for="node_id">// DEVICE ID</label>
                <input type="text" id="node_id" name="node_id" class="form-control" placeholder="DEVICE.01 // HARDWARE ARCHIVE" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="tag">// STATUS TAG</label>
                <input type="text" id="tag" name="tag" class="form-control" placeholder="e.g. PRESERVED">
            </div>
            <div class="form-group">
                <label class="form-label" for="title">// HARDWARE TITLE</label>
                <input type="text" id="title" name="title" class="form-control" placeholder="Sony Vaio W-series VPCW115XG" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="subtitle">// SUBTITLE / PLATFORM</label>
                <input type="text" id="subtitle" name="subtitle" class="form-control" placeholder="Intel Atom N280 Netbook Platform" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="oem">// OEM MANUFACTURER</label>
                <input type="text" id="oem" name="oem" class="form-control" placeholder="Sony VAIO Corp." required>
            </div>
            <div class="form-group">
                <label class="form-label" for="specs_raw">// SPECS MATRIX (KEY: VALUE PER LINE)</label>
                <textarea id="specs_raw" name="specs_raw" class="form-control" rows="4" placeholder="CPU: Intel Atom N280&#10;RAM: 2GB DDR2-667&#10;Storage: 64GB SSD"></textarea>
            </div>
            <div class="form-group">
                <label class="form-label" for="diagnostics_log">// RESTORATION & LAB LOG</label>
                <textarea id="diagnostics_log" name="diagnostics_log" class="form-control" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label class="form-label" for="image_url">// IMAGE PATH / URL</label>
                <input type="text" id="image_url" name="image_url" class="form-control" placeholder="e.g. images/carousel-retro.jpg">
            </div>
            <div class="form-group">
                <label class="form-label" for="image_file">// UPLOAD IMAGE (OPTIONAL)</label>
                <input type="file" id="image_file" name="image_file" class="form-control" accept="image/*">
            </div>
            <button type="submit" class="btn-admin btn-admin-cyan" style="width: 100%;">+ ADD DEVICE</button>
        </form>
    </div>

    <!-- Hardware List -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">&#128421; Lab Archive Hardware Systems</h3>
        </div>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>DEVICE & OEM</th>
                    <th>PLATFORM</th>
                    <th>TAG</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($nodes as $nd): ?>
                    <tr>
                        <td>
                            <span style="font-size: 0.75rem; color: var(--admin-cyan);"><?= e($nd['node_id']) ?></span><br>
                            <b><?= e($nd['title']) ?></b>
                        </td>
                        <td style="font-size: 0.8rem;"><?= e($nd['subtitle']) ?></td>
                        <td><span class="status-pill status-active"><?= e($nd['tag']) ?></span></td>
                        <td>
                            <form action="<?= e(url('admin/hardware/' . $nd['id'] . '/delete')) ?>" method="POST" onsubmit="return confirm('Purge hardware node?');">
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
