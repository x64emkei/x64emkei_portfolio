<div style="margin-bottom: 28px;">
    <h1 style="color: var(--admin-cyan); margin: 0 0 6px 0; font-size: 1.4rem;">CONTENT MANAGEMENT</h1>
    <p style="color: #64748b; margin: 0; font-size: 0.85rem;">Manage public pages, projects, services, articles, and contact information.</p>
</div>

<!-- Architecture Sections -->
<div style="display: flex; flex-direction: column; gap: 28px;">

    <!-- ABOUT SECTION MANAGEMENT -->
    <div class="admin-card">
        <div class="admin-card-header" style="border-bottom: 1px solid var(--admin-border); padding-bottom: 12px; margin-bottom: 18px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <span style="font-size: 1.2rem; color: var(--admin-cyan);">&#128100;</span>
                <h3 class="admin-card-title" style="margin: 0;">01 // ABOUT</h3>
            </div>
            <a href="<?= e(url('/about')) ?>" target="_blank" rel="noopener noreferrer" class="btn-admin btn-admin-outline" style="font-size: 0.72rem; padding: 4px 10px;">VIEW PUBLIC &nearr;</a>
        </div>
        <p style="color: #94a3b8; font-size: 0.85rem; margin-bottom: 16px;">Manage your profile, education, skills, experience, and certifications.</p>

        <div class="layout-auto-grid" style="gap: 14px;">
            <a href="<?= e(url('admin/profile')) ?>" style="text-decoration: none; display: block; background: rgba(7, 9, 14, 0.6); border: 1px solid var(--admin-border); padding: 16px; border-radius: 4px; transition: border-color 0.2s;">
                <div style="font-size: 0.75rem; color: var(--admin-cyan); font-weight: 700;">/about/biography</div>
                <div style="font-size: 0.95rem; font-weight: 600; color: #f8fafc; margin: 4px 0;">Biography & Profile</div>
                <div style="font-size: 0.75rem; color: #64748b;">Bio narrative, title & photo</div>
            </a>
            <a href="<?= e(url('admin/education')) ?>" style="text-decoration: none; display: block; background: rgba(7, 9, 14, 0.6); border: 1px solid var(--admin-border); padding: 16px; border-radius: 4px; transition: border-color 0.2s;">
                <div style="font-size: 0.75rem; color: var(--admin-cyan); font-weight: 700;">/about/education</div>
                <div style="font-size: 0.95rem; font-weight: 600; color: #f8fafc; margin: 4px 0;">Education (<?= (int)($counts['education'] ?? 0) ?>)</div>
                <div style="font-size: 0.75rem; color: #64748b;">Degrees, university & honors</div>
            </a>
            <a href="<?= e(url('admin/skills')) ?>" style="text-decoration: none; display: block; background: rgba(7, 9, 14, 0.6); border: 1px solid var(--admin-border); padding: 16px; border-radius: 4px; transition: border-color 0.2s;">
                <div style="font-size: 0.75rem; color: var(--admin-green); font-weight: 700;">/about/skills</div>
                <div style="font-size: 0.95rem; font-weight: 600; color: #f8fafc; margin: 4px 0;">Skills Matrix (<?= (int)($counts['skills'] ?? 0) ?>)</div>
                <div style="font-size: 0.75rem; color: #64748b;">Languages, tools & proficiencies</div>
            </a>
            <a href="<?= e(url('admin/experience')) ?>" style="text-decoration: none; display: block; background: rgba(7, 9, 14, 0.6); border: 1px solid var(--admin-border); padding: 16px; border-radius: 4px; transition: border-color 0.2s;">
                <div style="font-size: 0.75rem; color: var(--admin-cyan); font-weight: 700;">/about/experience</div>
                <div style="font-size: 0.95rem; font-weight: 600; color: #f8fafc; margin: 4px 0;">Experience (<?= (int)($counts['experience'] ?? 0) ?>)</div>
                <div style="font-size: 0.75rem; color: #64748b;">Roles, companies & affiliations</div>
            </a>
            <a href="<?= e(url('admin/certifications')) ?>" style="text-decoration: none; display: block; background: rgba(7, 9, 14, 0.6); border: 1px solid var(--admin-border); padding: 16px; border-radius: 4px; transition: border-color 0.2s;">
                <div style="font-size: 0.75rem; color: #FF5252; font-weight: 700;">/about/certifications</div>
                <div style="font-size: 0.95rem; font-weight: 600; color: #f8fafc; margin: 4px 0;">Certs & Honors (<?= (int)($counts['certifications'] ?? 0) + (int)($counts['achievements'] ?? 0) ?>)</div>
                <div style="font-size: 0.75rem; color: #64748b;">Certifications & recognitions</div>
            </a>
        </div>
    </div>

    <!-- WORK SECTION MANAGEMENT -->
    <div class="admin-card">
        <div class="admin-card-header" style="border-bottom: 1px solid rgba(255, 0, 127, 0.2); padding-bottom: 12px; margin-bottom: 18px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <span style="font-size: 1.2rem; color: var(--admin-magenta);">&#9881;</span>
                <h3 class="admin-card-title" style="margin: 0;">02 // WORK & SERVICES</h3>
            </div>
            <a href="<?= e(url('/work')) ?>" target="_blank" rel="noopener noreferrer" class="btn-admin btn-admin-outline" style="font-size: 0.72rem; padding: 4px 10px;">VIEW PUBLIC &nearr;</a>
        </div>
        <p style="color: #94a3b8; font-size: 0.85rem; margin-bottom: 16px;">Manage software projects, services, technical lab content, and hardware records.</p>

        <div class="layout-auto-grid" style="gap: 14px;">
            <a href="<?= e(url('admin/projects')) ?>" style="text-decoration: none; display: block; background: rgba(7, 9, 14, 0.6); border: 1px solid var(--admin-border); padding: 16px; border-radius: 4px; transition: border-color 0.2s;">
                <div style="font-size: 0.75rem; color: var(--admin-magenta); font-weight: 700;">/work/projects</div>
                <div style="font-size: 0.95rem; font-weight: 600; color: #f8fafc; margin: 4px 0;">Projects (<?= (int)($counts['projects'] ?? 0) ?>)</div>
                <div style="font-size: 0.75rem; color: #64748b;">Repositories, live URLs & stacks</div>
            </a>
            <a href="<?= e(url('admin/services')) ?>" style="text-decoration: none; display: block; background: rgba(7, 9, 14, 0.6); border: 1px solid var(--admin-border); padding: 16px; border-radius: 4px; transition: border-color 0.2s;">
                <div style="font-size: 0.75rem; color: var(--admin-cyan); font-weight: 700;">/work/services</div>
                <div style="font-size: 0.95rem; font-weight: 600; color: #f8fafc; margin: 4px 0;">Technical Services (<?= (int)($counts['services'] ?? 0) ?>)</div>
                <div style="font-size: 0.75rem; color: #64748b;">Consulting, architecture & dev</div>
            </a>
            <a href="<?= e(url('admin/sections')) ?>" style="text-decoration: none; display: block; background: rgba(7, 9, 14, 0.6); border: 1px solid var(--admin-border); padding: 16px; border-radius: 4px; transition: border-color 0.2s;">
                <div style="font-size: 0.75rem; color: var(--admin-green); font-weight: 700;">/work/laboratory</div>
                <div style="font-size: 0.95rem; font-weight: 600; color: #f8fafc; margin: 4px 0;">Technical Lab</div>
                <div style="font-size: 0.75rem; color: #64748b;">Experiments and technical notes</div>
            </a>
            <a href="<?= e(url('admin/hardware')) ?>" style="text-decoration: none; display: block; background: rgba(7, 9, 14, 0.6); border: 1px solid var(--admin-border); padding: 16px; border-radius: 4px; transition: border-color 0.2s;">
                <div style="font-size: 0.75rem; color: var(--admin-amber); font-weight: 700;">/work/hardware</div>
                <div style="font-size: 0.95rem; font-weight: 600; color: #f8fafc; margin: 4px 0;">Hardware Archive (<?= (int)($counts['hardware'] ?? 0) ?>)</div>
                <div style="font-size: 0.75rem; color: #64748b;">Vintage computing & test nodes</div>
            </a>
        </div>
    </div>

    <!-- JOURNAL SECTION MANAGEMENT -->
    <div class="admin-card">
        <div class="admin-card-header" style="border-bottom: 1px solid rgba(16, 185, 129, 0.2); padding-bottom: 12px; margin-bottom: 18px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <span style="font-size: 1.2rem; color: var(--admin-green);">&#9998;</span>
                <h3 class="admin-card-title" style="margin: 0;">03 // JOURNAL</h3>
            </div>
            <a href="<?= e(url('/journal')) ?>" target="_blank" rel="noopener noreferrer" class="btn-admin btn-admin-outline" style="font-size: 0.72rem; padding: 4px 10px;">VIEW PUBLIC &nearr;</a>
        </div>
        <p style="color: #94a3b8; font-size: 0.85rem; margin-bottom: 16px;">Publish articles, tutorials, research notes, and AI principles.</p>

        <div class="layout-auto-grid" style="gap: 14px;">
            <a href="<?= e(url('admin/articles')) ?>" style="text-decoration: none; display: block; background: rgba(7, 9, 14, 0.6); border: 1px solid var(--admin-border); padding: 16px; border-radius: 4px; transition: border-color 0.2s;">
                <div style="font-size: 0.75rem; color: var(--admin-green); font-weight: 700;">/journal/blog & /journal/articles</div>
                <div style="font-size: 0.95rem; font-weight: 600; color: #f8fafc; margin: 4px 0;">All Articles (<?= (int)($counts['articles'] ?? 0) ?>)</div>
                <div style="font-size: 0.75rem; color: #64748b;">Create, edit & categorize articles</div>
            </a>
            <a href="<?= e(url('admin/articles/create')) ?>" style="text-decoration: none; display: block; background: rgba(7, 9, 14, 0.6); border: 1px solid var(--admin-border); padding: 16px; border-radius: 4px; transition: border-color 0.2s;">
                <div style="font-size: 0.75rem; color: var(--admin-cyan); font-weight: 700;">+ CREATE</div>
                <div style="font-size: 0.95rem; font-weight: 600; color: #f8fafc; margin: 4px 0;">Publish New Article</div>
                <div style="font-size: 0.75rem; color: #64748b;">Markdown editor & tag assignment</div>
            </a>
            <a href="<?= e(url('/journal/ai-manifesto')) ?>" target="_blank" rel="noopener noreferrer" style="text-decoration: none; display: block; background: rgba(7, 9, 14, 0.6); border: 1px solid var(--admin-border); padding: 16px; border-radius: 4px; transition: border-color 0.2s;">
                <div style="font-size: 0.75rem; color: var(--admin-magenta); font-weight: 700;">/journal/ai-manifesto</div>
                <div style="font-size: 0.95rem; font-weight: 600; color: #f8fafc; margin: 4px 0;">AI Principles</div>
                <div style="font-size: 0.75rem; color: #64748b;">View the published article &nearr;</div>
            </a>
        </div>
    </div>

    <!-- CONTACT & HOME SECTIONS MANAGEMENT -->
    <div class="layout-form-grid" style="gap: 24px;">
        <!-- CONTACT MANAGEMENT -->
        <div class="admin-card">
            <div class="admin-card-header" style="border-bottom: 1px solid rgba(255, 82, 82, 0.2); padding-bottom: 12px; margin-bottom: 18px;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <span style="font-size: 1.2rem; color: #FF5252;">&#9993;</span>
                    <h3 class="admin-card-title" style="margin: 0;">04 // CONTACT</h3>
                </div>
                <a href="<?= e(url('/contact')) ?>" target="_blank" rel="noopener noreferrer" class="btn-admin btn-admin-outline" style="font-size: 0.72rem; padding: 4px 10px;">VIEW PUBLIC &nearr;</a>
            </div>
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <a href="<?= e(url('admin/messages')) ?>" style="text-decoration: none; display: block; background: rgba(7, 9, 14, 0.6); border: 1px solid var(--admin-border); padding: 14px; border-radius: 4px;">
                    <div style="font-size: 0.75rem; color: var(--admin-magenta); font-weight: 700;">/contact/inquiry</div>
                    <div style="font-size: 0.95rem; font-weight: 600; color: #f8fafc; margin: 4px 0;">Messages (<?= (int)($counts['messages'] ?? 0) ?>)</div>
                    <div style="font-size: 0.75rem; color: #64748b;">Read, reply and inspect contact inquiries</div>
                </a>
                <a href="<?= e(url('admin/social')) ?>" style="text-decoration: none; display: block; background: rgba(7, 9, 14, 0.6); border: 1px solid var(--admin-border); padding: 14px; border-radius: 4px;">
                    <div style="font-size: 0.75rem; color: #FF5252; font-weight: 700;">/contact/social</div>
                    <div style="font-size: 0.95rem; font-weight: 600; color: #f8fafc; margin: 4px 0;">Social Links (<?= (int)($counts['social'] ?? 0) ?>)</div>
                    <div style="font-size: 0.75rem; color: #64748b;">GitHub, LinkedIn, Discord, Telegram & email</div>
                </a>
            </div>
        </div>

        <!-- HOME SECTIONS ARCHITECTURE -->
        <div class="admin-card">
            <div class="admin-card-header" style="border-bottom: 1px solid rgba(168, 85, 247, 0.2); padding-bottom: 12px; margin-bottom: 18px;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <span style="font-size: 1.2rem; color: #a855f7;">&#8962;</span>
                    <h3 class="admin-card-title" style="margin: 0;">05 // HOME PAGE</h3>
                </div>
                <a href="<?= e(url('/')) ?>" target="_blank" rel="noopener noreferrer" class="btn-admin btn-admin-outline" style="font-size: 0.72rem; padding: 4px 10px;">VIEW PUBLIC &nearr;</a>
            </div>
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <a href="<?= e(url('admin/sections')) ?>" style="text-decoration: none; display: block; background: rgba(7, 9, 14, 0.6); border: 1px solid var(--admin-border); padding: 14px; border-radius: 4px;">
                    <div style="font-size: 0.75rem; color: #a855f7; font-weight: 700;">/</div>
                    <div style="font-size: 0.95rem; font-weight: 600; color: #f8fafc; margin: 4px 0;">Home Sections (<?= (int)($counts['sections'] ?? 0) ?>)</div>
                    <div style="font-size: 0.75rem; color: #64748b;">Configure order, visibility, and titles</div>
                </a>
                <a href="<?= e(url('admin/settings/navigation')) ?>" style="text-decoration: none; display: block; background: rgba(7, 9, 14, 0.6); border: 1px solid var(--admin-border); padding: 14px; border-radius: 4px;">
                    <div style="font-size: 0.75rem; color: var(--admin-cyan); font-weight: 700;">NAVIGATION SETTINGS</div>
                    <div style="font-size: 0.95rem; font-weight: 600; color: #f8fafc; margin: 4px 0;">Navigation Settings</div>
                    <div style="font-size: 0.75rem; color: #64748b;">Manage main categories and child pages</div>
                </a>
            </div>
        </div>
    </div>

</div>
