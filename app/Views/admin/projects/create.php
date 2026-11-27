<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title">&#10010; Deploy New System Project</h3>
        <a href="<?= e(url('admin/projects')) ?>" class="btn-admin btn-admin-outline">&larr; BACK TO MATRIX</a>
    </div>

    <form action="<?= e(url('admin/projects/create')) ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="layout-form-grid-3">
            <div class="form-group">
                <label class="form-label" for="title">// PROJECT TITLE</label>
                <input type="text" id="title" name="title" class="form-control" placeholder="e.g. Valkyrie POS Pro" required>
            </div>
            <div class="form-group">
            <label class="form-label" for="code_id">// PROJECT CODE ID</label>
                <input type="text" id="code_id" name="code_id" class="form-control" placeholder="CS.001 // ENTERPRISE_POS" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="category">// CATEGORY</label>
                <input type="text" id="category" name="category" class="form-control" placeholder="C# 12 / .NET 9" required>
            </div>
        </div>

        <div class="layout-form-grid-3">
            <div class="form-group">
                <label class="form-label" for="filter_tag">// FILTER TAG (csharp, python, cpp, web, systems)</label>
                <select id="filter_tag" name="filter_tag" class="form-control">
                    <option value="csharp">C# (.NET)</option>
                    <option value="python">Python</option>
                    <option value="cpp">C++</option>
                    <option value="web">WebDev</option>
                    <option value="systems">Systems & Network</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label" for="environment">// HOST ENVIRONMENT</label>
                <input type="text" id="environment" name="environment" class="form-control" placeholder="Windows 11 / .NET 9 Desktop / SQLite">
            </div>
            <div class="form-group">
                <label class="form-label" for="performance_metric">// PERFORMANCE BENCHMARK</label>
                <input type="text" id="performance_metric" name="performance_metric" class="form-control" placeholder="0.8ms write • Sub-10ms sync">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="tagline">// TAGLINE SPECIFICATION</label>
            <input type="text" id="tagline" name="tagline" class="form-control" placeholder="Autonomous offline retail terminal engine..." required>
        </div>

        <div class="form-group">
            <label class="form-label" for="description">// ARCHITECTURAL SPECIFICATION (DETAILED DESCRIPTION)</label>
            <textarea id="description" name="description" class="form-control" rows="4" required></textarea>
        </div>

        <div class="form-group">
            <label class="form-label" for="features_raw">// KEY CAPABILITIES (ONE BULLET PER LINE)</label>
            <textarea id="features_raw" name="features_raw" class="form-control" rows="4" placeholder="Local Write-Ahead Transaction Ledger&#10;Peer-to-peer multi-terminal sync&#10;Hardware abstraction layer for ESC/POS"></textarea>
        </div>

        <div class="layout-form-grid">
            <div class="form-group">
                <label class="form-label" for="code_filename">// SAMPLE CODE FILENAME</label>
                <input type="text" id="code_filename" name="code_filename" class="form-control" placeholder="ValkyrieEngine.cs">
            </div>
            <div class="form-group">
                <label class="form-label" for="technologies_raw">// TECHNOLOGIES (COMMA SEPARATED)</label>
                <input type="text" id="technologies_raw" name="technologies_raw" class="form-control" placeholder="C# 12, .NET 9, SQLite, gRPC">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="code_snippet">// CODE SNIPPET (SHOWN IN PROJECT DETAILS)</label>
            <textarea id="code_snippet" name="code_snippet" class="form-control" rows="6" style="font-family: monospace;"></textarea>
        </div>

        <div class="layout-form-grid-3">
            <div class="form-group">
                <label class="form-label" for="github_url">// GITHUB REPOSITORY URL</label>
                <input type="url" id="github_url" name="github_url" class="form-control" value="https://github.com/x64_emkei">
            </div>
            <div class="form-group">
                <label class="form-label" for="demo_url">// LIVE DEMONSTRATION URL (OPTIONAL)</label>
                <input type="url" id="demo_url" name="demo_url" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label" for="display_order">// DISPLAY ORDER INDEX</label>
                <input type="number" id="display_order" name="display_order" class="form-control" value="0">
            </div>
        </div>

        <div style="display: flex; gap: 20px; align-items: center; margin: 20px 0;">
            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                <input type="checkbox" name="is_published" value="1" checked style="width: auto;">
                <span>PUBLISH IMMEDIATELY</span>
            </label>
            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                <input type="checkbox" name="is_featured" value="1" checked style="width: auto;">
                <span>MARK AS FLAGSHIP FEATURED PROJECT</span>
            </label>
        </div>

        <button type="submit" class="btn-admin btn-admin-cyan">&#10004; CREATE PROJECT</button>
    </form>
</div>
