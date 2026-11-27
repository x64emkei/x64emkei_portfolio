<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title">&#9881; Edit Identity & Profile Telemetry</h3>
    </div>

    <form action="<?= e(url('admin/profile')) ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="layout-form-grid">
            <div class="form-group">
                <label class="form-label" for="full_name">// FULL NAME</label>
                <input type="text" id="full_name" name="full_name" class="form-control" value="<?= e($profile['full_name'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="title">// PROFESSIONAL TITLE</label>
                <input type="text" id="title" name="title" class="form-control" value="<?= e($profile['title'] ?? '') ?>" required>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="tagline">// HEADLINE TAGLINE</label>
            <input type="text" id="tagline" name="tagline" class="form-control" value="<?= e($profile['tagline'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label class="form-label" for="bio_short">// BRIEF BIO (HERO VIEW)</label>
            <textarea id="bio_short" name="bio_short" class="form-control" rows="3"><?= e($profile['bio_short'] ?? '') ?></textarea>
        </div>

        <div class="form-group">
            <label class="form-label" for="bio_full">// COMPREHENSIVE BIOGRAPHY (ABOUT VIEW)</label>
            <textarea id="bio_full" name="bio_full" class="form-control" rows="5"><?= e($profile['bio_full'] ?? '') ?></textarea>
        </div>

        <div class="layout-form-grid-3">
            <div class="form-group">
                <label class="form-label" for="location">// LOCATION</label>
                <input type="text" id="location" name="location" class="form-control" value="<?= e($profile['location'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label class="form-label" for="availability_status">// AVAILABILITY STATUS</label>
                <input type="text" id="availability_status" name="availability_status" class="form-control" value="<?= e($profile['availability_status'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label class="form-label" for="email">// PRIMARY CONTACT EMAIL</label>
                <input type="email" id="email" name="email" class="form-control" value="<?= e($profile['email'] ?? '') ?>">
            </div>
        </div>

        <div class="layout-form-grid">
            <div class="form-group">
                <label class="form-label" for="avatar_url">// AVATAR IMAGE PATH / URL</label>
                <input type="text" id="avatar_url" name="avatar_url" class="form-control" value="<?= e($profile['avatar_url'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label class="form-label" for="avatar_file">// UPLOAD NEW AVATAR (OPTIONAL)</label>
                <input type="file" id="avatar_file" name="avatar_file" class="form-control" accept="image/*">
            </div>
        </div>

        <button type="submit" class="btn-admin btn-admin-cyan" style="margin-top: 10px;">
            &#128190; SYNCHRONIZE PROFILE TELEMETRY
        </button>
    </form>
</div>
