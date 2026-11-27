<div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 24px;">
    <div>
    <h1 style="color: var(--admin-cyan); margin: 0 0 4px 0; font-size: 1.3rem;">USER ACCESS // RBAC</h1>
        <p style="color: #64748b; margin: 0; font-size: 0.8rem;">Manage administrator and editor permissions, roles, and authentication security.</p>
    </div>
</div>

<div class="layout-split">
    <div class="admin-card">
        <h3 style="color: var(--admin-cyan); font-size: 0.95rem; margin-top: 0; margin-bottom: 16px;">// USER LIST</h3>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>USER</th>
                    <th>EMAIL</th>
                    <th>ROLE</th>
                    <th>STATUS</th>
                    <th style="text-align: right;">CONTROLS</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                <tr>
                    <td>
                        <strong style="color: #f8fafc;"><?= e($u['username']) ?></strong>
                        <?php if ((int)$u['id'] === (int)$currentUser['id']): ?>
                            <span style="font-size: 0.7rem; color: var(--admin-cyan); border: 1px solid var(--admin-cyan); padding: 1px 4px; border-radius: 3px; margin-left: 4px;">YOU</span>
                        <?php endif; ?>
                    </td>
                    <td style="color: #94a3b8; font-size: 0.8rem;"><?= e($u['email']) ?></td>
                    <td>
                        <?php if ($currentUser['role'] === 'superadmin' && (int)$u['id'] !== (int)$currentUser['id']): ?>
                        <form method="POST" action="<?= url('admin/users/' . $u['id'] . '/role') ?>" style="display: inline;">
                            <?= csrf_field() ?>
                            <select name="role" class="form-control" style="padding: 2px 6px; font-size: 0.75rem; width: auto;" onchange="this.form.submit()">
                                <option value="superadmin" <?= ($u['role'] === 'superadmin') ? 'selected' : '' ?>>Superadmin</option>
                                <option value="admin" <?= ($u['role'] === 'admin') ? 'selected' : '' ?>>Admin</option>
                                <option value="editor" <?= ($u['role'] === 'editor') ? 'selected' : '' ?>>Editor</option>
                                <option value="author" <?= ($u['role'] === 'author') ? 'selected' : '' ?>>Author</option>
                            </select>
                        </form>
                        <?php else: ?>
                            <span style="font-size: 0.75rem; text-transform: uppercase; color: var(--admin-cyan);"><?= e($u['role']) ?></span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!empty($u['is_active'])): ?>
                            <span style="color: var(--admin-green); font-size: 0.8rem;">● ACTIVE</span>
                        <?php else: ?>
                            <span style="color: var(--admin-magenta); font-size: 0.8rem;">■ SUSPENDED</span>
                        <?php endif; ?>
                    </td>
                    <td style="text-align: right;">
                        <?php if ((int)$u['id'] !== (int)$currentUser['id']): ?>
                        <form method="POST" action="<?= url('admin/users/' . $u['id'] . '/toggle') ?>" style="display: inline;">
                            <?= csrf_field() ?>
                            <button type="submit" class="admin-btn admin-btn-secondary" style="padding: 4px 8px; font-size: 0.75rem;">
                                <?= !empty($u['is_active']) ? 'SUSPEND' : 'ACTIVATE' ?>
                            </button>
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="admin-card">
        <h3 style="color: var(--admin-cyan); font-size: 0.95rem; margin-top: 0; margin-bottom: 16px;">// ADD USER</h3>
        <form method="POST" action="<?= url('admin/users') ?>" autocomplete="off">
            <?= csrf_field() ?>
            <div class="form-group">
                <label class="form-label" for="username">USERNAME *</label>
                <input type="text" id="username" name="username" class="form-control" required autocomplete="off" placeholder="operator_callsign">
            </div>
            <div class="form-group">
                <label class="form-label" for="email">EMAIL *</label>
                <input type="email" id="email" name="email" class="form-control" required autocomplete="off" placeholder="operator@x64emkei.dev">
            </div>
            <div class="form-group">
                <label class="form-label" for="password">PASSWORD *</label>
                <input type="password" id="password" name="password" class="form-control" required minlength="8" autocomplete="new-password" placeholder="••••••••••••">
            </div>
            <div class="form-group">
                <label class="form-label" for="role">ASSIGNED ROLE</label>
                <select id="role" name="role" class="form-control">
                    <option value="author">Author (Create/Draft Only)</option>
                    <option value="editor">Editor (Publish/Edit Content)</option>
                    <option value="admin" selected>Administrator (Full CMS Access)</option>
                    <?php if ($currentUser['role'] === 'superadmin'): ?>
                    <option value="superadmin">Super Administrator (Full System Control)</option>
                    <?php endif; ?>
                </select>
            </div>
            <button type="submit" class="admin-btn admin-btn-primary" style="width: 100%; margin-top: 10px;">CREATE ACCOUNT</button>
        </form>
    </div>
</div>
