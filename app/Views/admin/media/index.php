<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title">&#128444; Secure Media & Storage Manager</h3>
        <span style="font-size: 0.8rem; color: #64748b;">
            Total Managed Storage: <b><?= round(($totalStorage ?? 0) / 1048576, 2) ?> MB</b>
        </span>
    </div>

    <!-- Upload Box -->
    <form action="<?= e(url('admin/media/upload')) ?>" method="POST" enctype="multipart/form-data" style="margin-bottom: 24px; padding: 18px; border: 1px dashed var(--admin-border); border-radius: 4px; background: rgba(0,229,255,0.02);">
        <?= csrf_field() ?>
        <div style="display: grid; grid-template-columns: 2fr 1fr 1fr auto; gap: 14px; align-items: end;">
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label" for="file">// SELECT MEDIA FILE (JPEG, PNG, WEBP, GIF, SVG - MAX 8MB)</label>
                <input type="file" id="file" name="file" class="form-control" required accept="image/*">
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label" for="alt_text">// ACCESSIBILITY ALT TEXT</label>
                <input type="text" id="alt_text" name="alt_text" class="form-control" placeholder="Descriptive image label">
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label" for="caption">// CAPTION (OPTIONAL)</label>
                <input type="text" id="caption" name="caption" class="form-control" placeholder="Caption notes">
            </div>
            <button type="submit" class="btn-admin btn-admin-cyan">&#8679; UPLOAD</button>
        </div>
    </form>

    <!-- Media Grid -->
    <?php if (empty($mediaList)): ?>
        <p style="color: #64748b; font-size: 0.85rem; font-style: italic;">No media files uploaded yet.</p>
    <?php else: ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 18px;">
            <?php foreach ($mediaList as $item): ?>
                <div style="background: rgba(7,9,14,0.8); border: 1px solid var(--admin-border); border-radius: 4px; overflow: hidden; display: flex; flex-direction: column;">
                    <div style="height: 120px; background: #000; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                        <img src="<?= e(url($item['file_path'])) ?>" alt="<?= e($item['alt_text'] ?? '') ?>" style="max-height: 100%; max-width: 100%; object-fit: cover;">
                    </div>
                    <div style="padding: 10px; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                        <div>
                            <div style="font-size: 0.75rem; color: #fff; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="<?= e($item['original_name']) ?>">
                                <?= e($item['original_name']) ?>
                            </div>
                            <div style="font-size: 0.68rem; color: #64748b; margin-top: 2px;">
                                <?= e($item['mime_type']) ?> &bull; <?= round($item['file_size'] / 1024, 1) ?> KB
                            </div>
                            <input type="text" readonly value="<?= e(url($item['file_path'])) ?>" class="form-control" style="font-size: 0.65rem; padding: 4px; margin-top: 6px;" onclick="this.select();">
                        </div>
                        <form action="<?= e(url('admin/media/' . $item['id'] . '/delete')) ?>" method="POST" onsubmit="return confirm('Purge media file?');" style="margin-top: 8px;">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn-admin btn-admin-danger" style="width: 100%; padding: 4px; font-size: 0.7rem; justify-content: center;">DELETE</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
