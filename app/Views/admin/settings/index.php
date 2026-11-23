<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title">&#9881; System Telemetry & SEO Configuration</h3>
    </div>

    <form action="<?= e(url('admin/settings')) ?>" method="POST">
        <?= csrf_field() ?>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label class="form-label" for="site_title">// PORTFOLIO TITLE</label>
                <input type="text" id="site_title" name="site_title" class="form-control" value="<?= e($settings['site_title'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="primary_domain">// PRIMARY HOST DOMAIN</label>
                <input type="text" id="primary_domain" name="primary_domain" class="form-control" value="<?= e($settings['primary_domain'] ?? 'welcome.x64emkei.dpdns.org') ?>" required>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="site_tagline">// SYSTEM TAGLINE</label>
            <input type="text" id="site_tagline" name="site_tagline" class="form-control" value="<?= e($settings['site_tagline'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label class="form-label" for="meta_description">// SEO META DESCRIPTION</label>
            <textarea id="meta_description" name="meta_description" class="form-control" rows="3"><?= e($settings['meta_description'] ?? '') ?></textarea>
        </div>

        <div class="form-group">
            <label class="form-label" for="meta_keywords">// SEO KEYWORDS (COMMA SEPARATED)</label>
            <input type="text" id="meta_keywords" name="meta_keywords" class="form-control" value="<?= e($settings['meta_keywords'] ?? '') ?>">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label class="form-label" for="contact_email">// PRIMARY CONTACT INBOX</label>
                <input type="email" id="contact_email" name="contact_email" class="form-control" value="<?= e($settings['contact_email'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label class="form-label" for="theme_default">// DEFAULT THEME</label>
                <select id="theme_default" name="theme_default" class="form-control">
                    <option value="dark" <?= ($settings['theme_default'] ?? '') === 'dark' ? 'selected' : '' ?>>Dark Mode (Cyberpunk HUD)</option>
                    <option value="light" <?= ($settings['theme_default'] ?? '') === 'light' ? 'selected' : '' ?>>Light Mode (Terminal White)</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label" for="copyright_text">// FOOTER COPYRIGHT</label>
                <input type="text" id="copyright_text" name="copyright_text" class="form-control" value="<?= e($settings['copyright_text'] ?? '') ?>">
            </div>
        </div>

        <button type="submit" class="btn-admin btn-admin-cyan" style="margin-top: 10px;">
            &#128190; COMMIT CORE SYSTEM CONFIGURATION
        </button>
    </form>
</div>
