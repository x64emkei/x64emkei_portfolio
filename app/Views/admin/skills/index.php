<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px;">
    <!-- Add Skill Form -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">+ Add Skill</h3>
        </div>
        <form action="<?= e(url('admin/skills')) ?>" method="POST">
            <?= csrf_field() ?>
            <div class="form-group">
                <label class="form-label" for="category">// CATEGORY</label>
                <select id="category" name="category" class="form-control">
                    <option value="Languages">Languages</option>
                    <option value="Frameworks & Platforms">Frameworks & Platforms</option>
                    <option value="Databases & Storage">Databases & Storage</option>
                    <option value="Infrastructure & Networking">Infrastructure & Networking</option>
                    <option value="Tools & Methodologies">Tools & Methodologies</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label" for="name">// SKILL NAME</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="e.g. C# 12 / .NET 9" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="proficiency_level">// PROFICIENCY LEVEL (1-100%)</label>
                <input type="number" id="proficiency_level" name="proficiency_level" class="form-control" value="85" min="1" max="100">
            </div>
            <div class="form-group">
                <label class="form-label" for="display_order">// DISPLAY ORDER</label>
                <input type="number" id="display_order" name="display_order" class="form-control" value="0">
            </div>
            <button type="submit" class="btn-admin btn-admin-cyan" style="width: 100%;">+ ADD SKILL</button>
        </form>
    </div>

    <!-- Skills List -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">&#128394; Registered Skills Registry</h3>
        </div>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>CATEGORY</th>
                    <th>SKILL NAME</th>
                    <th>PROFICIENCY</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($skills as $sk): ?>
                    <tr>
                        <td><span style="font-size: 0.75rem; color: #64748b;"><?= e($sk['category']) ?></span></td>
                        <td><b><?= e($sk['name']) ?></b></td>
                        <td>
                            <div style="background: rgba(255,255,255,0.08); width: 80px; height: 6px; border-radius: 3px; display: inline-block; vertical-align: middle; margin-right: 8px;">
                                <div style="background: var(--admin-cyan); height: 100%; width: <?= (int)$sk['proficiency_level'] ?>%; border-radius: 3px;"></div>
                            </div>
                            <span style="font-size: 0.75rem;"><?= (int)$sk['proficiency_level'] ?>%</span>
                        </td>
                        <td>
                            <form action="<?= e(url('admin/skills/' . $sk['id'] . '/delete')) ?>" method="POST" onsubmit="return confirm('Delete skill?');">
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
