<div style="margin-bottom: 24px;">
    <a href="<?= url('admin/articles') ?>" style="color: #64748b; text-decoration: none; font-size: 0.8rem;">&larr; BACK TO JOURNAL REGISTRY</a>
    <h1 style="color: var(--admin-cyan); margin: 8px 0 4px 0; font-size: 1.3rem;">EDIT TRANSMISSION // <?= e($article['title']) ?></h1>
    <p style="color: #64748b; margin: 0; font-size: 0.8rem;">Modify telemetry article parameters, content, or publication schedule.</p>
</div>

<form method="POST" action="<?= url('admin/articles/' . $article['id'] . '/edit') ?>" class="admin-card" style="max-width: 900px;">
    <?= csrf_field() ?>

    <div class="form-group">
        <label class="form-label" for="title">ARTICLE TITLE *</label>
        <input type="text" id="title" name="title" class="form-control" required value="<?= e($article['title']) ?>">
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
        <div class="form-group">
            <label class="form-label" for="slug">URL SLUG</label>
            <input type="text" id="slug" name="slug" class="form-control" value="<?= e($article['slug']) ?>">
        </div>
        <div class="form-group">
            <label class="form-label" for="category_id">CATEGORY</label>
            <select id="category_id" name="category_id" class="form-control">
                <option value="">-- Select Category --</option>
                <?php foreach ($categories as $cat): ?>
                <option value="<?= e((string)$cat['id']) ?>" <?= ((int)($article['category_id'] ?? 0) === (int)$cat['id']) ? 'selected' : '' ?>>
                    <?= e($cat['name']) ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="form-label" for="excerpt">EXCERPT (SHORT SUMMARY FOR CARDS)</label>
        <textarea id="excerpt" name="excerpt" class="form-control" rows="2"><?= e($article['excerpt'] ?? '') ?></textarea>
    </div>

    <div class="form-group">
        <label class="form-label" for="content">ARTICLE CONTENT (MARKDOWN OR HTML) *</label>
        <textarea id="content" name="content" class="form-control" rows="14" required><?= e($article['content'] ?? '') ?></textarea>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
        <div class="form-group">
            <label class="form-label" for="tags_input">TAGS (COMMA SEPARATED)</label>
            <input type="text" id="tags_input" name="tags_input" class="form-control" value="<?= e($articleTagNames ?? '') ?>">
        </div>
        <div class="form-group">
            <label class="form-label" for="featured_image">FEATURED IMAGE URL</label>
            <input type="text" id="featured_image" name="featured_image" class="form-control" value="<?= e($article['featured_image'] ?? '') ?>">
        </div>
    </div>

    <div style="border-top: 1px solid var(--admin-border); margin: 24px 0 20px 0; padding-top: 20px;">
        <h3 style="color: var(--admin-cyan); font-size: 0.95rem; margin-top: 0;">// SEO METADATA</h3>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div class="form-group">
                <label class="form-label" for="seo_title">SEO TITLE OVERRIDE</label>
                <input type="text" id="seo_title" name="seo_title" class="form-control" value="<?= e($article['seo_title'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label class="form-label" for="seo_description">SEO META DESCRIPTION</label>
                <input type="text" id="seo_description" name="seo_description" class="form-control" value="<?= e($article['seo_description'] ?? '') ?>">
            </div>
        </div>
    </div>

    <div style="display: flex; gap: 24px; align-items: center; margin-bottom: 24px; padding: 16px; background: rgba(0, 229, 255, 0.03); border: 1px solid var(--admin-border); border-radius: 4px;">
        <div class="form-group" style="margin-bottom: 0;">
            <label class="form-label" for="status">PUBLICATION STATUS</label>
            <select id="status" name="status" class="form-control" style="width: 160px;">
                <option value="draft" <?= ($article['status'] === 'draft') ? 'selected' : '' ?>>Draft (Private)</option>
                <option value="published" <?= ($article['status'] === 'published') ? 'selected' : '' ?>>Published (Live)</option>
                <option value="archived" <?= ($article['status'] === 'archived') ? 'selected' : '' ?>>Archived</option>
            </select>
        </div>
        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; margin-top: 18px; font-size: 0.85rem; color: #f8fafc;">
            <input type="checkbox" name="is_featured" value="1" <?= !empty($article['is_featured']) ? 'checked' : '' ?>>
            <span>Mark as Featured Article</span>
        </label>
    </div>

    <div style="display: flex; justify-content: flex-end; gap: 12px;">
        <a href="<?= url('admin/articles') ?>" class="admin-btn admin-btn-secondary">CANCEL</a>
        <button type="submit" class="admin-btn admin-btn-primary">UPDATE TRANSMISSION</button>
    </div>
</form>
