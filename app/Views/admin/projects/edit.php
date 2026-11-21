<?php
$featuresRaw = implode("\n", json_decode($project['features_json'] ?: '[]', true) ?: []);
$techRaw = implode(", ", json_decode($project['technologies_json'] ?: '[]', true) ?: []);
?>
<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title">&#9998; Edit Project: <?= e($project['title']) ?></h3>
        <a href="<?= e(url('admin/projects')) ?>" class="btn-admin btn-admin-outline">&larr; BACK TO MATRIX</a>
    </div>

    <form action="<?= e(url('admin/projects/' . $project['id'] . '/edit')) ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label class="form-label" for="title">// PROJECT TITLE</label>
                <input type="text" id="title" name="title" class="form-control" value="<?= e($project['title']) ?>" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="code_id">// TELEMETRY CODE ID</label>
                <input type="text" id="code_id" name="code_id" class="form-control" value="<?= e($project['code_id']) ?>" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="category">// CATEGORY</label>
                <input type="text" id="category" name="category" class="form-control" value="<?= e($project['category']) ?>" required>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label class="form-label" for="filter_tag">// FILTER TAG</label>
                <select id="filter_tag" name="filter_tag" class="form-control">
                    <option value="csharp" <?= $project['filter_tag'] === 'csharp' ? 'selected' : '' ?>>C# (.NET)</option>
                    <option value="python" <?= $project['filter_tag'] === 'python' ? 'selected' : '' ?>>Python</option>
                    <option value="cpp" <?= $project['filter_tag'] === 'cpp' ? 'selected' : '' ?>>C++</option>
                    <option value="web" <?= $project['filter_tag'] === 'web' ? 'selected' : '' ?>>WebDev</option>
                    <option value="systems" <?= $project['filter_tag'] === 'systems' ? 'selected' : '' ?>>Systems & Network</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label" for="environment">// HOST ENVIRONMENT</label>
                <input type="text" id="environment" name="environment" class="form-control" value="<?= e($project['environment'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label class="form-label" for="performance_metric">// PERFORMANCE BENCHMARK</label>
                <input type="text" id="performance_metric" name="performance_metric" class="form-control" value="<?= e($project['performance_metric'] ?? '') ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="tagline">// TAGLINE SPECIFICATION</label>
            <input type="text" id="tagline" name="tagline" class="form-control" value="<?= e($project['tagline']) ?>" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="description">// ARCHITECTURAL SPECIFICATION</label>
            <textarea id="description" name="description" class="form-control" rows="4" required><?= e($project['description']) ?></textarea>
        </div>

        <div class="form-group">
            <label class="form-label" for="features_raw">// KEY CAPABILITIES (ONE BULLET PER LINE)</label>
            <textarea id="features_raw" name="features_raw" class="form-control" rows="4"><?= e($featuresRaw) ?></textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label class="form-label" for="code_filename">// SAMPLE CODE FILENAME</label>
                <input type="text" id="code_filename" name="code_filename" class="form-control" value="<?= e($project['code_filename'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label class="form-label" for="technologies_raw">// TECHNOLOGIES (COMMA SEPARATED)</label>
                <input type="text" id="technologies_raw" name="technologies_raw" class="form-control" value="<?= e($techRaw) ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="code_snippet">// ARCHITECTURAL CODE SNIPPET</label>
            <textarea id="code_snippet" name="code_snippet" class="form-control" rows="6" style="font-family: monospace;"><?= e($project['code_snippet'] ?? '') ?></textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label class="form-label" for="github_url">// GITHUB REPOSITORY URL</label>
                <input type="url" id="github_url" name="github_url" class="form-control" value="<?= e($project['github_url'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label class="form-label" for="demo_url">// LIVE DEMONSTRATION URL</label>
                <input type="url" id="demo_url" name="demo_url" class="form-control" value="<?= e($project['demo_url'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label class="form-label" for="display_order">// DISPLAY ORDER INDEX</label>
                <input type="number" id="display_order" name="display_order" class="form-control" value="<?= (int)$project['display_order'] ?>">
            </div>
        </div>

        <div style="display: flex; gap: 20px; align-items: center; margin: 20px 0;">
            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                <input type="checkbox" name="is_published" value="1" <?= $project['is_published'] ? 'checked' : '' ?> style="width: auto;">
                <span>PUBLISHED LIVE</span>
            </label>
            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                <input type="checkbox" name="is_featured" value="1" <?= $project['is_featured'] ? 'checked' : '' ?> style="width: auto;">
                <span>FEATURED ON HOMEPAGE</span>
            </label>
        </div>

        <button type="submit" class="btn-admin btn-admin-cyan">&#128190; UPDATE PROJECT RECORD</button>
    </form>
</div>
