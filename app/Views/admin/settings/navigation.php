<div style="margin-bottom: 28px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px;">
    <div>
        <h1 style="color: var(--admin-cyan); margin: 0 0 6px 0; font-size: 1.4rem;">PRIMARY NAVIGATION</h1>
        <p style="color: #64748b; margin: 0; font-size: 0.85rem;">Enforce and customize the 6 mandatory primary categories and child route destinations.</p>
    </div>
    <form action="<?= e(url('admin/settings/navigation/reset')) ?>" method="POST" onsubmit="return confirm('Restore default 6-destination architecture?');">
        <?= csrf_field() ?>
        <button type="submit" class="btn-admin btn-admin-outline" style="border-color: var(--admin-magenta); color: var(--admin-magenta);">
            &#x21bb; RESTORE DEFAULT 6-CATEGORY HIERARCHY
        </button>
    </form>
</div>

<form action="<?= e(url('admin/settings/navigation')) ?>" method="POST">
    <?= csrf_field() ?>

    <div style="display: flex; flex-direction: column; gap: 24px;">
        <?php foreach ($navigation as $pIdx => $primary): ?>
            <div class="admin-card" style="border-left: 3px solid <?= ($primary['id'] === 'admin') ? 'var(--admin-magenta)' : 'var(--admin-cyan)' ?>;">
                <div class="admin-card-header" style="margin-bottom: 14px;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <span style="font-weight: 700; color: var(--admin-cyan); font-size: 1.1rem;"><?= sprintf('%02d', $primary['order'] ?? ($pIdx + 1)) ?></span>
                        <h3 class="admin-card-title" style="margin: 0;"><?= e($primary['label']) ?></h3>
                        <span style="font-size: 0.78rem; color: #64748b; font-family: monospace;"><?= e($primary['route']) ?></span>
                    </div>
                    <div>
                        <label style="display: inline-flex; align-items: center; gap: 6px; font-size: 0.8rem; color: #94a3b8; cursor: pointer;">
                            <input type="checkbox" name="nav[<?= e($primary['id']) ?>][is_enabled]" value="1" <?= (!empty($primary['is_enabled'])) ? 'checked' : '' ?>>
                            <span>ENABLED</span>
                        </label>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr 100px; gap: 16px; margin-bottom: 16px;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">LABEL</label>
                        <input type="text" name="nav[<?= e($primary['id']) ?>][label]" class="form-control" value="<?= e($primary['label']) ?>" required>
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">ROUTE</label>
                        <input type="text" name="nav[<?= e($primary['id']) ?>][route]" class="form-control" value="<?= e($primary['route']) ?>" required>
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">ORDER</label>
                        <input type="number" name="nav[<?= e($primary['id']) ?>][order]" class="form-control" value="<?= (int)($primary['order'] ?? ($pIdx + 1)) ?>" required>
                    </div>
                </div>

                <!-- Child destinations -->
                <?php if (!empty($primary['children'])): ?>
                    <div style="background: rgba(7, 9, 14, 0.4); border: 1px solid var(--admin-border); border-radius: 4px; padding: 14px;">
                        <div style="font-size: 0.75rem; color: var(--admin-cyan); font-weight: 700; margin-bottom: 10px; text-transform: uppercase;">
                            CHILD DESTINATIONS (<?= count($primary['children']) ?>)
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 10px;">
                            <?php foreach ($primary['children'] as $cIdx => $child): ?>
                                <div style="display: grid; grid-template-columns: 2fr 3fr 70px 90px; gap: 12px; align-items: center;">
                                    <input type="text" name="nav[<?= e($primary['id']) ?>][children][<?= e($child['id']) ?>][label]" class="form-control" value="<?= e($child['label']) ?>" style="padding: 6px 10px; font-size: 0.8rem;" required>
                                    <input type="text" name="nav[<?= e($primary['id']) ?>][children][<?= e($child['id']) ?>][route]" class="form-control" value="<?= e($child['route']) ?>" style="padding: 6px 10px; font-size: 0.8rem;" required>
                                    <input type="number" name="nav[<?= e($primary['id']) ?>][children][<?= e($child['id']) ?>][order]" class="form-control" value="<?= (int)($child['order'] ?? ($cIdx + 1)) ?>" style="padding: 6px 10px; font-size: 0.8rem;" required>
                                    <label style="display: inline-flex; align-items: center; gap: 4px; font-size: 0.75rem; color: #94a3b8; margin: 0; cursor: pointer;">
                                        <input type="checkbox" name="nav[<?= e($primary['id']) ?>][children][<?= e($child['id']) ?>][is_enabled]" value="1" <?= (!empty($child['is_enabled'])) ? 'checked' : '' ?>>
                                        <span>ACTIVE</span>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <div style="margin-top: 24px; text-align: right;">
        <button type="submit" class="btn-admin btn-admin-cyan" style="padding: 12px 28px; font-size: 0.88rem;">
            &#128190; SAVE NAVIGATION CONFIGURATION
        </button>
    </div>
</form>
