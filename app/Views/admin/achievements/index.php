<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px;">
    <!-- Add Achievement Form -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">+ Log Achievement / Award</h3>
        </div>
        <form action="<?= e(url('admin/achievements')) ?>" method="POST">
            <?= csrf_field() ?>
            <div class="form-group">
                <label class="form-label" for="title">// RECOGNITION TITLE</label>
                <input type="text" id="title" name="title" class="form-control" placeholder="e.g. Dean's Lister, Hackathon Champion" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="issuer">// ISSUING ENTITY / ORGANIZATION</label>
                <input type="text" id="issuer" name="issuer" class="form-control" placeholder="e.g. Mapúa Malayan Colleges Laguna" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="category">// RECOGNITION CATEGORY</label>
                <select id="category" name="category" class="form-control">
                    <option value="Academic">Academic Distinction</option>
                    <option value="Competition">Hackathon / CTF / Contest</option>
                    <option value="Leadership">Organizational & Leadership</option>
                    <option value="Professional">Industry & Professional Honor</option>
                    <option value="Publication">Research & Publication</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label" for="award_date">// CONFERRED DATE / TERM</label>
                <input type="text" id="award_date" name="award_date" class="form-control" placeholder="e.g. 1st Term AY 2024-2025">
            </div>
            <div class="form-group">
                <label class="form-label" for="verification_url">// VERIFICATION / RECORD URL</label>
                <input type="url" id="verification_url" name="verification_url" class="form-control" placeholder="https://...">
            </div>
            <div class="form-group">
                <label class="form-label" for="image_url">// SUPPORTING IMAGE / BADGE URL</label>
                <input type="text" id="image_url" name="image_url" class="form-control" placeholder="images/award.png">
            </div>
            <div class="form-group">
                <label class="form-label" for="description">// CITATION / DESCRIPTION</label>
                <textarea id="description" name="description" class="form-control" rows="3" placeholder="Brief details about the recognition..."></textarea>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 16px;">
                <div>
                    <label class="form-label" for="display_order">// SEQUENCE</label>
                    <input type="number" id="display_order" name="display_order" class="form-control" value="0">
                </div>
                <div style="display: flex; flex-direction: column; justify-content: center; gap: 8px;">
                    <label style="font-size: 0.8rem; display: flex; align-items: center; gap: 6px; cursor: pointer;">
                        <input type="checkbox" name="is_featured" value="1"> FEATURED PIN
                    </label>
                    <label style="font-size: 0.8rem; display: flex; align-items: center; gap: 6px; cursor: pointer;">
                        <input type="checkbox" name="is_published" value="1" checked> PUBLISHED
                    </label>
                </div>
            </div>
            <button type="submit" class="btn-admin btn-admin-cyan" style="width: 100%;">+ COMMIT ACHIEVEMENT</button>
        </form>
    </div>

    <!-- Achievements Table -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">&#127942; Conferred Achievements & Recognitions</h3>
        </div>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>AWARD & RECOGNITION</th>
                    <th>CATEGORY & DATE</th>
                    <th>ISSUER</th>
                    <th>STATUS</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($achievements)): ?>
                    <tr>
                        <td colspan="5" style="text-align: center; color: #64748b; padding: 20px;">
                            No achievements registered yet. Add one from the left panel.
                        </td>
                    </tr>
                <?php endif; ?>
                <?php foreach ($achievements as $ach): ?>
                    <tr>
                        <td>
                            <b><?= e($ach['title']) ?></b>
                            <?php if (!empty($ach['is_featured'])): ?>
                                <span style="background: rgba(245, 158, 11, 0.2); color: #fbbf24; border: 1px solid #f59e0b; padding: 1px 6px; font-size: 0.65rem; border-radius: 2px; margin-left: 6px;">FEATURED</span>
                            <?php endif; ?>
                            <?php if (!empty($ach['verification_url'])): ?>
                                <br><a href="<?= e($ach['verification_url']) ?>" target="_blank" style="color: var(--admin-cyan); font-size: 0.75rem;">[VERIFY &nearr;]</a>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span style="font-size: 0.75rem; color: var(--admin-cyan); display: block;"><?= e($ach['category'] ?? 'Academic') ?></span>
                            <span style="font-size: 0.7rem; color: #94a3b8;"><?= e($ach['award_date'] ?? '') ?></span>
                        </td>
                        <td style="font-size: 0.8rem; color: #cbd5e1;"><?= e($ach['issuer'] ?? 'N/A') ?></td>
                        <td>
                            <span class="status-badge <?= $ach['is_published'] ? 'status-active' : 'status-draft' ?>">
                                <?= $ach['is_published'] ? 'PUBLISHED' : 'DRAFT' ?>
                            </span>
                        </td>
                        <td>
                            <form action="<?= e(url('admin/achievements/' . $ach['id'] . '/delete')) ?>" method="POST" onsubmit="return confirm('Delete this achievement record?');">
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
