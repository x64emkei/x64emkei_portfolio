<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title">&#9776; Portfolio Section Architecture & Telemetry Ordering</h3>
        <span style="font-size: 0.8rem; color: #94a3b8;">Controls section visibility, headers, descriptions, and sequence on the public portfolio.</span>
    </div>

    <div style="display: flex; flex-direction: column; gap: 20px;">
        <?php foreach ($sections as $sec): ?>
            <div style="background: rgba(14, 18, 26, 0.7); border: 1px solid <?= $sec['is_enabled'] ? 'rgba(255, 42, 42, 0.35)' : 'rgba(255, 51, 102, 0.3)' ?>; border-radius: 6px; padding: 20px;">
                <form action="<?= e(url('admin/sections/' . $sec['id'] . '/update')) ?>" method="POST">
                    <?= csrf_field() ?>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; border-bottom: 1px solid rgba(255,255,255,0.06); padding-bottom: 10px;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <span style="background: rgba(255,42,42,0.1); color: var(--admin-primary); border: 1px solid var(--admin-primary); padding: 2px 8px; font-size: 0.75rem; border-radius: 3px; font-weight: bold;">
                                // <?= strtoupper(e($sec['section_key'])) ?>
                            </span>
                            <span style="font-size: 0.85rem; color: <?= $sec['is_enabled'] ? '#10b981' : '#ff3366' ?>; font-weight: 600;">
                                <?= $sec['is_enabled'] ? '&#9679; ACTIVE & BROADCASTING' : '&#9675; DISABLED / MUTED' ?>
                            </span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 16px;">
                            <label style="font-size: 0.8rem; display: flex; align-items: center; gap: 6px; cursor: pointer; color: #f8fafc;">
                                <input type="checkbox" name="is_enabled" value="1" <?= $sec['is_enabled'] ? 'checked' : '' ?>>
                                ENABLED
                            </label>
                            <label style="font-size: 0.8rem; display: flex; align-items: center; gap: 6px; cursor: pointer; color: #94a3b8;">
                                <input type="checkbox" name="hide_if_empty" value="1" <?= $sec['hide_if_empty'] ? 'checked' : '' ?>>
                                HIDE IF EMPTY
                            </label>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 2fr 2fr 1fr 1fr; gap: 14px; margin-bottom: 12px;">
                        <div>
                            <label class="form-label">SECTION HEADING</label>
                            <input type="text" name="title" class="form-control" value="<?= e($sec['title']) ?>" required>
                        </div>
                        <div>
                            <label class="form-label">SUBTITLE / TELEMETRY BADGE</label>
                            <input type="text" name="subtitle" class="form-control" value="<?= e($sec['subtitle'] ?? '') ?>" placeholder="e.g. CORE SYSTEMS // ARCHIVE">
                        </div>
                        <div>
                            <label class="form-label">LAYOUT VARIATION</label>
                            <select name="layout_variation" class="form-control">
                                <option value="default" <?= ($sec['layout_variation'] ?? '') === 'default' ? 'selected' : '' ?>>Default Matrix</option>
                                <option value="compact" <?= ($sec['layout_variation'] ?? '') === 'compact' ? 'selected' : '' ?>>Compact Grid</option>
                                <option value="timeline" <?= ($sec['layout_variation'] ?? '') === 'timeline' ? 'selected' : '' ?>>Chronological</option>
                                <option value="cards" <?= ($sec['layout_variation'] ?? '') === 'cards' ? 'selected' : '' ?>>Expanded Cards</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">ORDER INDEX</label>
                            <input type="number" name="display_order" class="form-control" value="<?= e((string)$sec['display_order']) ?>">
                        </div>
                    </div>

                    <div style="margin-bottom: 14px;">
                        <label class="form-label">INTRODUCTORY / HUD MISSION BRIEFING</label>
                        <textarea name="intro_text" class="form-control" rows="2" placeholder="Dynamic introductory text displayed underneath the section header..."><?= e($sec['intro_text'] ?? '') ?></textarea>
                    </div>

                    <div style="display: flex; justify-content: flex-end;">
                        <button type="submit" class="btn-admin btn-admin-cyan">&#128190; SAVE SECTION CONFIG</button>
                    </div>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</div>
