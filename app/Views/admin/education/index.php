<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px;">
    <!-- Add Education Form -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">+ Add Education</h3>
        </div>
        <form action="<?= e(url('admin/education')) ?>" method="POST">
            <?= csrf_field() ?>
            <div class="form-group">
                <label class="form-label" for="institution">// INSTITUTION</label>
                <input type="text" id="institution" name="institution" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="degree">// DEGREE / CERTIFICATION</label>
                <input type="text" id="degree" name="degree" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="field_of_study">// FIELD OF STUDY</label>
                <input type="text" id="field_of_study" name="field_of_study" class="form-control">
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                <div class="form-group">
                    <label class="form-label" for="period_start">// START</label>
                    <input type="text" id="period_start" name="period_start" class="form-control" placeholder="2022" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="period_end">// END</label>
                    <input type="text" id="period_end" name="period_end" class="form-control" placeholder="Present">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label" for="achievements">// ACHIEVEMENTS / HONORS</label>
                <textarea id="achievements" name="achievements" class="form-control" rows="3"></textarea>
            </div>
            <button type="submit" class="btn-admin btn-admin-cyan" style="width: 100%;">+ ADD EDUCATION</button>
        </form>
    </div>

    <!-- Education List -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">&#127891; Academic Records</h3>
        </div>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>INSTITUTION & DEGREE</th>
                    <th>PERIOD</th>
                    <th>HONORS / NOTES</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($education as $edu): ?>
                    <tr>
                        <td>
                            <b><?= e($edu['institution']) ?></b><br>
                            <span style="font-size: 0.75rem; color: var(--admin-cyan);"><?= e($edu['degree']) ?></span>
                        </td>
                        <td style="font-size: 0.75rem; color: #64748b;"><?= e($edu['period_start']) ?> &ndash; <?= e($edu['period_end'] ?: 'Present') ?></td>
                        <td style="font-size: 0.8rem;"><?= e($edu['achievements'] ?? '') ?></td>
                        <td>
                            <form action="<?= e(url('admin/education/' . $edu['id'] . '/delete')) ?>" method="POST" onsubmit="return confirm('Delete academic record?');">
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
