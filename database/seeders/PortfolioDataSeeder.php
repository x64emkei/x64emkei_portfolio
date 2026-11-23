<?php
declare(strict_types=1);

namespace Database\Seeders;

use PDO;

class PortfolioDataSeeder
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function run(bool $force = false): void
    {
        $this->seedProfile($force);
        $this->seedProjects($force);
        $this->seedHardwareNodes($force);
        $this->seedSkills($force);
        $this->seedExperiences($force);
        $this->seedEducation($force);
        $this->seedCertifications($force);
        $this->seedAchievements($force);
        $this->seedServices($force);
        $this->seedSocialLinks($force);
        $this->seedSiteSettings($force);
        $this->seedSections($force);
        $this->seedManifestoArticle($force);
    }

    private function seedProfile(bool $force = false): void
    {
        if ($force) {
            $this->pdo->exec("DELETE FROM `profile`");
        } else {
            $stmt = $this->pdo->query("SELECT COUNT(*) FROM `profile`");
            if ((int)$stmt->fetchColumn() > 0) return;
        }

        $sql = "INSERT INTO `profile` 
            (`full_name`, `title`, `tagline`, `bio_short`, `bio_full`, `avatar_url`, `cover_url`, `location`, `availability_status`, `resume_url`, `email`)
            VALUES
            (:name, :title, :tagline, :short, :full, :avatar, :cover, :loc, :avail, :resume, :email)";
        
        $this->pdo->prepare($sql)->execute([
            ':name' => 'Michael Benedict Ordenes',
            ':title' => 'Computer Science Student, IT Enthusiast & Systems Builder',
            ':tagline' => 'Building resilient software architectures, deploying virtualized server homelabs, and experimenting across the boundary of modern edge systems and vintage computing hardware.',
            ':short' => 'A Computer Science student interested in software development, IT infrastructure, networking, systems administration, and emerging technologies. Enjoys turning ideas into functional projects and experimenting with modern and legacy hardware/software.',
            ':full' => "Building resilient software architectures, deploying virtualized server homelabs, and experimenting across the boundary of modern edge systems and vintage computing hardware.\n\nPrimary areas of discipline:\n• Software and web development\n• Systems programming and desktop engineering\n• AI / computer vision and automation\n• Homelab, virtualization, and containers\n• Networking, DNS, VPN, and remote access\n• Hardware diagnostics, restoration, and legacy platforms",
            ':avatar' => 'images/me_2.png',
            ':cover' => 'images/carousel-workspace.jpg',
            ':loc' => 'Laguna, Philippines',
            ':avail' => 'Available for Systems & Web Engineering',
            ':resume' => '#contact',
            ':email' => 'mordenes@acm.org'
        ]);
    }

    private function seedProjects(bool $force = false): void
    {
        if ($force) {
            $this->pdo->exec("DELETE FROM `projects`");
        }
        // Projects table is kept empty as specified in catalog: "PROJECT CATALOG (NONE YET)"
    }

    private function seedHardwareNodes(bool $force = false): void
    {
        if ($force) {
            $this->pdo->exec("DELETE FROM `hardware_nodes`");
        } else {
            $stmt = $this->pdo->query("SELECT COUNT(*) FROM `hardware_nodes`");
            if ((int)$stmt->fetchColumn() > 0) return;
        }

        $nodes = [
            [
                'node_id' => 'NODE.01 // NETBOOK',
                'tag' => 'PRESERVED',
                'title' => 'Sony Vaio W-series VPCW115XG',
                'subtitle' => 'Japanese Ultraportable Engineering • 10.1-inch WXGA Display',
                'oem' => 'Sony VAIO',
                'specs' => [
                    'CPU' => 'Intel Atom N280 (1.66 GHz, 1 Core, 2 Threads, 512KB L2)',
                    'Display' => '10.1-inch WXGA (1366 × 768) Fine-Pitch LED',
                    'Keyboard' => 'Signature Island Keyboard Design',
                    'Status' => 'Preserved / Diagnostic Node'
                ],
                'log' => 'Hands-on hardware diagnostics, BIOS recovery, and preservation. Refurbished CMOS battery, repasted Atom die, and configured for low-power serial telemetry and vintage firmware inspection.',
                'image' => 'images/carousel-retro.jpg',
                'order' => 1
            ],
            [
                'node_id' => 'NODE.02 // TOUGHBOOK ULTRA',
                'tag' => 'OPERATIONAL',
                'title' => 'Panasonic Let\'s Note CF-T4GW5AXR',
                'subtitle' => 'Magnesium Alloy Bonnet Chassis • Fanless Silent Architecture',
                'oem' => 'Panasonic Japan',
                'specs' => [
                    'CPU' => 'Intel Pentium M Ultra Low Voltage (ULV) 753',
                    'Chassis' => 'Magnesium Alloy Bonnet Construction',
                    'Touchpad' => 'Circular Optical Touchpad Interface',
                    'Cooling' => 'Fanless Silent Thermal Dissipation'
                ],
                'log' => 'Restored Japanese enterprise ultraportable. Cleaned thermal dissipation plates, verified fanless heatsink efficiency, and benchmarked legacy architecture under specialized diagnostic loads.',
                'image' => 'images/carousel-retro.jpg',
                'order' => 2
            ],
            [
                'node_id' => 'RIG.03 // BUSINESS NOTEBOOK',
                'tag' => 'DIAGNOSTIC RIG',
                'title' => 'HP Compaq nx6320',
                'subtitle' => 'Dedicated Diagnostic Terminal • Native Serial & Parallel I/O',
                'oem' => 'HP / Compaq',
                'specs' => [
                    'Platform' => 'Intel Core 2 Duo Platform',
                    'Panel' => '15.0-inch 4:3 Matte Anti-Glare Panel',
                    'Interfaces' => 'Native Hardware RS-232 Serial & Parallel Ports',
                    'Role' => 'Dedicated Hardware Diagnostic Terminal'
                ],
                'log' => 'Maintained as an active bench diagnostic terminal. Native legacy serial and parallel interfaces enable direct out-of-band communication with network switches, microcontrollers, and retro motherboards.',
                'image' => 'images/carousel-workspace.jpg',
                'order' => 3
            ],
            [
                'node_id' => 'RIG.04 // SLEEPER BUILD',
                'tag' => 'DAILY WORKSTATION',
                'title' => 'HP Pavilion a6000 (Sleeper)',
                'subtitle' => 'Mid-2000s Glossy Wave-Front Chassis Refitted with Modern Internals',
                'oem' => 'HP Custom Sleeper',
                'specs' => [
                    'Chassis' => 'Mid-2000s OEM Glossy Wave-Front Vintage Enclosure',
                    'Modifications' => 'Modular Cooling, Quiet Airflow Routing, High-Efficiency PSU',
                    'Internals' => 'Modern Multi-Core Desktop Platform',
                    'Status' => 'Daily Production Workstation'
                ],
                'log' => 'Complete stealth build combining retro mid-2000s desktop aesthetics with modern high-performance engineering internals, custom intake filtration, and whisper-quiet acoustic profiling.',
                'image' => 'images/carousel-homelab.jpg',
                'order' => 4
            ],
            [
                'node_id' => 'NODE.05 // HOMELAB SERVER',
                'tag' => 'ONLINE / 24/7',
                'title' => 'Dell OptiPlex 3010 Server',
                'subtitle' => 'Intel Core Host • Proxmox VE Virtualization Cluster Node',
                'oem' => 'Dell Homelab',
                'specs' => [
                    'Host' => 'Intel Core Host Platform with Expanded Memory',
                    'Networking' => 'Gigabit Uplink with VLAN Trunking',
                    'Hypervisor' => 'Proxmox VE Virtual Environment',
                    'Workloads' => 'Linux Containers (LXC), Docker Microservices, DNS Caching'
                ],
                'log' => 'Engineered for continuous 24/7 uptime. Runs virtualized DNS resolvers, internal reverse proxies, WireGuard mesh entry points, and local development test databases with continuous monitoring.',
                'image' => 'images/carousel-homelab.jpg',
                'order' => 5
            ],
            [
                'node_id' => 'NODE.06 // ULTRA SFF',
                'tag' => 'BENCH TEST',
                'title' => 'Dell OptiPlex 760 USFF',
                'subtitle' => 'Ultra-Small Form Factor Desktop • Low-Power Compact Footprint',
                'oem' => 'Dell Legacy',
                'specs' => [
                    'Chassis' => 'Ultra-Small Form Factor (USFF)',
                    'CPU' => 'Intel Core 2 Duo Processor',
                    'Power' => 'Low-Power High-Efficiency Compact Footprint',
                    'Role' => 'Headless Network Test Node & Diagnostic Sandbox'
                ],
                'log' => 'Deployed as a standalone headless bench node for testing bare-metal kernel configurations, lightweight network routines, and simulated network drops without touching production rigs.',
                'image' => 'images/carousel-retro.jpg',
                'order' => 6
            ]
        ];

        $sql = "INSERT INTO `hardware_nodes`
            (`node_id`, `tag`, `title`, `subtitle`, `oem`, `specs_json`, `diagnostics_log`, `image_url`, `display_order`, `is_published`)
            VALUES
            (:node_id, :tag, :title, :subtitle, :oem, :specs, :log, :img, :order, 1)";
        
        $stmt = $this->pdo->prepare($sql);
        foreach ($nodes as $n) {
            $stmt->execute([
                ':node_id' => $n['node_id'],
                ':tag' => $n['tag'],
                ':title' => $n['title'],
                ':subtitle' => $n['subtitle'],
                ':oem' => $n['oem'],
                ':specs' => json_encode($n['specs']),
                ':log' => $n['log'],
                ':img' => $n['image'],
                ':order' => $n['order']
            ]);
        }
    }

    private function seedSkills(bool $force = false): void
    {
        if ($force) {
            $this->pdo->exec("DELETE FROM `skills`");
        } else {
            $stmt = $this->pdo->query("SELECT COUNT(*) FROM `skills`");
            if ((int)$stmt->fetchColumn() > 0) return;
        }

        $skills = [
            // Programming & Databases
            ['Programming & Databases', 'HTML5', 95, 1],
            ['Programming & Databases', 'CSS3 / Grid', 92, 2],
            ['Programming & Databases', 'JavaScript (ES6+)', 90, 3],
            ['Programming & Databases', 'Python', 88, 4],
            ['Programming & Databases', 'Java', 85, 5],
            ['Programming & Databases', 'C#', 88, 6],
            ['Programming & Databases', 'C++', 84, 7],
            ['Programming & Databases', 'MySQL', 88, 8],
            // Systems & Virtualization
            ['Systems & Virtualization', 'Windows OS', 95, 1],
            ['Systems & Virtualization', 'Linux (Debian / Ubuntu)', 90, 2],
            ['Systems & Virtualization', 'Proxmox VE', 88, 3],
            ['Systems & Virtualization', 'Docker Containers', 85, 4],
            ['Systems & Virtualization', 'Tailscale Mesh VPN', 90, 5],
            ['Systems & Virtualization', 'DNS & Routing', 88, 6],
            // Creative & Digital Media
            ['Creative & Digital Media', 'Adobe Photoshop', 85, 1],
            ['Creative & Digital Media', 'Adobe Illustrator', 82, 2],
            ['Creative & Digital Media', 'DaVinci Resolve', 80, 3],
            ['Creative & Digital Media', 'Office Suite', 95, 4],
            // Workflow & Operations
            ['Workflow & Operations', 'Git', 92, 1],
            ['Workflow & Operations', 'GitHub', 92, 2],
            ['Workflow & Operations', 'Visual Studio Code', 95, 3],
            ['Workflow & Operations', 'Antigravity', 90, 4],
            ['Workflow & Operations', 'Hardware Diagnostics', 94, 5],
        ];

        $sql = "INSERT INTO `skills` (`category`, `name`, `proficiency_level`, `display_order`, `is_published`)
                VALUES (:cat, :name, :level, :order, 1)";
        $stmt = $this->pdo->prepare($sql);
        foreach ($skills as $s) {
            $stmt->execute([
                ':cat' => $s[0],
                ':name' => $s[1],
                ':level' => $s[2],
                ':order' => $s[3]
            ]);
        }
    }

    private function seedExperiences(bool $force = false): void
    {
        if ($force) {
            $this->pdo->exec("DELETE FROM `experiences`");
        } else {
            $stmt = $this->pdo->query("SELECT COUNT(*) FROM `experiences`");
            if ((int)$stmt->fetchColumn() > 0) return;
        }

        $experiences = [
            [
                'title' => 'Secretary',
                'organization' => 'Alliance of Computer Engineering and Computer Science Students',
                'location' => 'Laguna College of Business and Arts',
                'type' => 'Academic Organization',
                'start' => '2023',
                'end' => 'Present',
                'current' => 1,
                'desc' => 'Managing academic records, technical documentation, student event coordination, and inter-organizational communication across computing departments.',
                'order' => 1
            ],
            [
                'title' => 'Laguna Chapter Chairperson',
                'organization' => 'National Youth Movement for the West Philippine Sea',
                'location' => 'Laguna, Philippines',
                'type' => 'Youth Leadership',
                'start' => '2023',
                'end' => 'Present',
                'current' => 1,
                'desc' => 'Leading youth chapter leadership, community awareness, policy advocacy, and public engagement initiatives.',
                'order' => 2
            ],
            [
                'title' => 'Director for Communications and Publications',
                'organization' => 'FPJ Youth',
                'location' => 'Laguna, Philippines',
                'type' => 'Media & Communications',
                'start' => '2023',
                'end' => 'Present',
                'current' => 1,
                'desc' => 'Directing digital publication pipelines, graphic design assets, public releases, and youth communication strategies.',
                'order' => 3
            ],
            [
                'title' => 'Member',
                'organization' => 'International Association of Engineers (IAENG)',
                'location' => 'International',
                'type' => 'Professional Organization',
                'start' => '2023',
                'end' => 'Present',
                'current' => 1,
                'desc' => 'Active member participating in professional research exchanges, engineering publications, and technical conferences.',
                'order' => 4
            ]
        ];

        $sql = "INSERT INTO `experiences` (`title`, `organization`, `location`, `type`, `period_start`, `period_end`, `is_current`, `description`, `display_order`, `is_published`)
                VALUES (:title, :org, :loc, :type, :start, :end, :cur, :desc, :order, 1)";
        $stmt = $this->pdo->prepare($sql);
        foreach ($experiences as $e) {
            $stmt->execute([
                ':title' => $e['title'],
                ':org' => $e['organization'],
                ':loc' => $e['location'],
                ':type' => $e['type'],
                ':start' => $e['start'],
                ':end' => $e['end'],
                ':cur' => $e['current'],
                ':desc' => $e['desc'],
                ':order' => $e['order']
            ]);
        }
    }

    private function seedEducation(bool $force = false): void
    {
        if ($force) {
            $this->pdo->exec("DELETE FROM `education`");
        } else {
            $stmt = $this->pdo->query("SELECT COUNT(*) FROM `education`");
            if ((int)$stmt->fetchColumn() > 0) return;
        }

        $edu = [
            [
                'institution' => 'Laguna College of Business and Arts',
                'degree' => 'Bachelor of Science in Computer Science',
                'field' => 'Computer Science',
                'start' => '2022',
                'end' => 'Present',
                'achievements' => 'Undergraduate — In Progress. Rigorous study in algorithms, data structures, software engineering, systems administration, and database design.',
                'order' => 1
            ],
            [
                'institution' => 'St. Vincent College of Cabuyao',
                'degree' => 'Senior High School Diploma',
                'field' => 'Science, Technology, Engineering & Mathematics (STEM)',
                'start' => '2020',
                'end' => '2022',
                'achievements' => 'Completed Senior High School curriculum under the STEM academic strand.',
                'order' => 2
            ]
        ];

        $sql = "INSERT INTO `education` (`institution`, `degree`, `field_of_study`, `period_start`, `period_end`, `achievements`, `display_order`, `is_published`)
                VALUES (:inst, :deg, :field, :start, :end, :ach, :order, 1)";
        $stmt = $this->pdo->prepare($sql);
        foreach ($edu as $ed) {
            $stmt->execute([
                ':inst' => $ed['institution'],
                ':deg' => $ed['degree'],
                ':field' => $ed['field'],
                ':start' => $ed['start'],
                ':end' => $ed['end'],
                ':ach' => $ed['achievements'],
                ':order' => $ed['order']
            ]);
        }
    }

    private function seedCertifications(bool $force = false): void
    {
        if ($force) {
            $this->pdo->exec("DELETE FROM `certifications`");
        } else {
            $stmt = $this->pdo->query("SELECT COUNT(*) FROM `certifications`");
            if ((int)$stmt->fetchColumn() > 0) return;
        }

        $certs = [
            [
                'title' => 'Certified Six Sigma White Belt',
                'issuer' => 'Continuous Quality Improvement & Process Optimization',
                'issue_date' => '2023',
                'credential_id' => 'CSSWB-VERIFIED',
                'credential_url' => '',
                'order' => 1
            ],
            [
                'title' => 'EF SET English Certificate — C1 Advanced',
                'issuer' => 'EF Standard English Test',
                'issue_date' => '2023',
                'credential_id' => 'EFSET-C1-ADVANCED',
                'credential_url' => '',
                'order' => 2
            ]
        ];

        $sql = "INSERT INTO `certifications` (`title`, `issuer`, `issue_date`, `credential_id`, `credential_url`, `display_order`, `is_published`)
                VALUES (:title, :issuer, :issue_date, :credential_id, :credential_url, :display_order, 1)";
        $stmt = $this->pdo->prepare($sql);
        foreach ($certs as $c) {
            $stmt->execute([
                ':title' => $c['title'],
                ':issuer' => $c['issuer'],
                ':issue_date' => $c['issue_date'],
                ':credential_id' => $c['credential_id'],
                ':credential_url' => $c['credential_url'],
                ':display_order' => $c['order']
            ]);
        }
    }

    private function seedServices(bool $force = false): void
    {
        if ($force) {
            $this->pdo->exec("DELETE FROM `services`");
        } else {
            $stmt = $this->pdo->query("SELECT COUNT(*) FROM `services`");
            if ((int)$stmt->fetchColumn() > 0) return;
        }

        $services = [
            [
                'title' => 'Web & Software Development',
                'category' => 'Software Engineering',
                'desc' => 'Designing and coding responsive web applications and reliable software solutions with clean, structured, dependency-conscious code in Vanilla JS, PHP, Python, C#, C++, Java, and MySQL.',
                'order' => 1
            ],
            [
                'title' => 'Homelab & Virtualization',
                'category' => 'Cloud & Virtualization',
                'desc' => 'Building and administering resilient virtual environments, Proxmox VE hypervisors, and containerized Docker stacks on Debian/Linux servers with uptime monitoring.',
                'order' => 2
            ],
            [
                'title' => 'Networking & Systems Administration',
                'category' => 'Infrastructure',
                'desc' => 'Configuring encrypted mesh routing with Tailscale, local DNS resolution, subdomain routing, and reliable Windows and Linux systems administration.',
                'order' => 3
            ],
            [
                'title' => 'Hardware Diagnostics & Restoration',
                'category' => 'Hardware Engineering',
                'desc' => 'Refurbishing, troubleshooting, and diagnosing modern and vintage computing platforms, BIOS recovery, thermal repasting, and component-level benchmarking.',
                'order' => 4
            ],
            [
                'title' => 'Technical Problem Solving & Quality',
                'category' => 'Optimization',
                'desc' => 'Systematic troubleshooting, technical architecture documentation, and continuous process optimization applying Six Sigma White Belt methodologies.',
                'order' => 5
            ]
        ];

        $sql = "INSERT INTO `services` (`title`, `category`, `description`, `display_order`, `is_published`)
                VALUES (:title, :cat, :desc, :order, 1)";
        $stmt = $this->pdo->prepare($sql);
        foreach ($services as $s) {
            $stmt->execute([
                ':title' => $s['title'],
                ':cat' => $s['category'],
                ':desc' => $s['desc'],
                ':order' => $s['order']
            ]);
        }
    }

    private function seedSocialLinks(bool $force = false): void
    {
        if ($force) {
            $this->pdo->exec("DELETE FROM `social_links`");
        } else {
            $stmt = $this->pdo->query("SELECT COUNT(*) FROM `social_links`");
            if ((int)$stmt->fetchColumn() > 0) return;
        }

        $links = [
            ['github', 'GitHub', 'https://github.com/x64_emkei', 1],
            ['email', 'Email', 'mailto:mordenes@acm.org', 2]
        ];

        $sql = "INSERT INTO `social_links` (`platform`, `label`, `url`, `display_order`, `is_published`)
                VALUES (:p, :l, :u, :o, 1)";
        $stmt = $this->pdo->prepare($sql);
        foreach ($links as $lk) {
            $stmt->execute([
                ':p' => $lk[0],
                ':l' => $lk[1],
                ':u' => $lk[2],
                ':o' => $lk[3]
            ]);
        }
    }

    private function seedSiteSettings(bool $force = false): void
    {
        if ($force) {
            $this->pdo->exec("DELETE FROM `site_settings`");
        } else {
            $stmt = $this->pdo->query("SELECT COUNT(*) FROM `site_settings`");
            if ((int)$stmt->fetchColumn() > 0) return;
        }

        $settings = [
            ['site_title', 'Michael Benedict Ordenes | x64emkei.dev', 'general', 'Public title of the portfolio'],
            ['site_tagline', 'Computer Science Student, IT Enthusiast & Systems Builder', 'general', 'Meta tagline'],
            ['meta_description', 'Michael Benedict Ordenes (x64emkei) — Computer Science student at Laguna College of Business and Arts. Software development, systems architecture, homelab, and hardware restoration.', 'seo', 'Default SEO description'],
            ['meta_keywords', 'Michael Benedict Ordenes, x64emkei, developer portfolio, LCBA, Computer Science, Proxmox, homelab, networking, C#, C++, Python, MySQL', 'seo', 'Meta keywords list'],
            ['contact_email', 'mordenes@acm.org', 'contact', 'Primary inbox contact email'],
            ['theme_default', 'dark', 'appearance', 'Default HUD theme mode (dark or light)'],
            ['primary_domain', 'welcome.x64emkei.dpdns.org', 'hosting', 'Primary configured domain'],
            ['copyright_text', '© 2026 Michael Benedict Ordenes. Systems Architecture // All telemetry active.', 'general', 'Footer copyright label']
        ];

        $sql = "INSERT INTO `site_settings` (`setting_key`, `setting_value`, `setting_group`, `description`)
                VALUES (:k, :v, :g, :d)";
        $stmt = $this->pdo->prepare($sql);
        foreach ($settings as $st) {
            $stmt->execute([
                ':k' => $st[0],
                ':v' => $st[1],
                ':g' => $st[2],
                ':d' => $st[3]
            ]);
        }
    }

    private function seedAchievements(bool $force = false): void
    {
        if ($force) {
            $this->pdo->exec("DELETE FROM `achievements`");
        } else {
            $stmt = $this->pdo->query("SELECT COUNT(*) FROM `achievements`");
            if ((int)$stmt->fetchColumn() > 0) return;
        }

        $achievements = [
            [
                'Undergraduate Scholar in Computer Science',
                'Laguna College of Business and Arts',
                'Engaged in rigorous undergraduate studies focusing on computer systems, software engineering, database design, and algorithmic problem-solving.',
                '2022 - Present',
                'Academic',
                1,
                1
            ],
            [
                'Secretary & Academic Committee Steward',
                'Alliance of Computer Engineering and Computer Science Students',
                'Elected secretary managing departmental records, documentation, technical initiatives, and student assemblies.',
                'AY 2023 - Present',
                'Leadership',
                1,
                2
            ]
        ];

        $sql = "INSERT INTO `achievements` (`title`, `issuer`, `description`, `award_date`, `category`, `is_featured`, `display_order`, `is_published`)
                VALUES (:title, :issuer, :description, :award_date, :category, :is_featured, :display_order, 1)";
        $stmt = $this->pdo->prepare($sql);
        foreach ($achievements as $ach) {
            $stmt->execute([
                ':title' => $ach[0],
                ':issuer' => $ach[1],
                ':description' => $ach[2],
                ':award_date' => $ach[3],
                ':category' => $ach[4],
                ':is_featured' => $ach[5],
                ':display_order' => $ach[6],
            ]);
        }
    }

    private function seedSections(bool $force = false): void
    {
        if ($force) {
            $this->pdo->exec("DELETE FROM `portfolio_sections`");
        } else {
            $stmt = $this->pdo->query("SELECT COUNT(*) FROM `portfolio_sections`");
            if ((int)$stmt->fetchColumn() > 0) return;
        }

        $sections = [
            ['hero', 'OPERATIONAL ARCHITECTURE', 'SYSTEMS SCHOLAR // HARDWARE SPECIALIST', 'Computer Science student, systems builder, and IT infrastructure enthusiast.', 1, 1, 'default', 0],
            ['about', 'BIOGRAPHY // CORE DIRECTIVE', 'IDENTITY & SCHOLASTIC DISCIPLINE', 'Computer Science student at Laguna College of Business and Arts exploring systems, homelabs, and hardware preservation.', 1, 2, 'default', 0],
            ['projects', 'FEATURED PRODUCTION ARCHITECTURES', 'DEPLOYED PLATFORMS & SOFTWARE CODEBASES', 'Software and systems builds catalog.', 1, 3, 'cards', 1],
            ['hardware', 'VINTAGE HARDWARE DIAGNOSTICS & RESTORATION LAB', 'LAB FLEET TELEMETRY & RETRO HARDWARE REPOSITORY', 'Hands-on hardware diagnostics, BIOS recovery, and preservation across modern and legacy computing architectures (6 operational nodes).', 1, 4, 'cards', 1],
            ['skills', 'TECHNICAL SKILLS & TOOLS', 'ENGINEERING MATRIX // PROFICIENCY CATALOG', 'Programming, systems, virtualization, networking, creative media, and operational workflows.', 1, 5, 'default', 1],
            ['experience', 'ORGANIZATIONAL INVOLVEMENT & LEADERSHIP', 'CHRONOLOGY & RESPONSIBILITIES', 'Track record of student leadership, organizational communications, and professional engineering affiliations.', 1, 6, 'timeline', 1],
            ['education', 'EDUCATION & CREDENTIALS', 'SCHOLASTIC FORMATION', 'Higher education history, senior high STEM foundation, and industry certifications.', 1, 7, 'cards', 1],
            ['achievements', 'HONORS & RECOGNITIONS', 'ACADEMIC & LEADERSHIP DISTINCTIONS', 'Academic milestones and organizational leadership recognitions.', 1, 8, 'cards', 1],
            ['certifications', 'CERTIFICATIONS & CREDENTIALS', 'VERIFIED SPECIALIZATIONS', 'Certified Six Sigma White Belt & EF SET English C1 Advanced qualifications.', 1, 9, 'cards', 1],
            ['services', 'SERVICES & SPECIALTIES', 'CAPABILITIES & OFFERINGS', 'Web development, homelab virtualization, networking, hardware restoration, and systematic technical problem solving.', 1, 10, 'cards', 1],
            ['laboratory', 'TECHNICAL LABORATORY & EXPERIMENTATION', 'ACTIVE RESEARCH TRACKS & VIRTUALIZATION NODES', 'Hands-on experimentation with bare-metal hypervisors, encrypted mesh networks, and legacy operating systems.', 1, 11, 'cards', 0],
            ['journal', 'ENGINEERING JOURNAL & PUBLICATIONS', 'TRANSMISSION ARCHIVES & ARCHITECTURAL ESSAYS', 'Technical documentation, systems engineering guides, zero-trust protocols, and architectural positions.', 1, 12, 'stream', 0],
            ['tutorials', 'TUTORIALS & IMPLEMENTATION GUIDES', 'PRACTICAL ENGINEERING WALKTHROUGHS', 'Step-by-step guides for zero-trust clusters, PHP 8 security architectures, and Linux system management.', 1, 13, 'cards', 0],
            ['technical-notes', 'TECHNICAL NOTES & SYSTEM DIAGNOSTICS', 'LAB NOTEBOOK & FIELD DIAGNOSTICS', 'Thermal profiling, CORS/CSP policy hardening, low-level memory debugging, and runtime telemetry.', 1, 14, 'list', 0],
            ['research', 'RESEARCH & ARCHITECTURAL INSIGHTS', 'INVESTIGATION & HARDWARE LONGEVITY', 'Hardware longevity, circular technology, and digital preservation in modern computing.', 1, 15, 'cards', 0],
            ['ai-manifesto', 'MY AI MANIFESTO', 'A PERSONAL POSITION ON AI, HUMAN SKILL, AND RESPONSIBLE PROGRESS', 'Principles guiding learning, craft, professional development, accountability, and Filipino opportunity.', 1, 16, 'callout', 0],
            ['contact', 'CONTACT & TECHNICAL CONSULTATION', 'SECURE TELEMETRY CHANNEL & DIRECT DISPATCH', 'Direct inquiry channels for systems engineering, software consultation, homelab architecture, or collaborative initiatives.', 1, 17, 'default', 0],
            ['information', 'CONTACT INFORMATION & DIRECT CHANNELS', 'OPERATOR TELEMETRY & AVAILABILITY', 'Verified operator email, timezone, and operational availability status.', 1, 18, 'cards', 0],
            ['inquiry', 'SEND AN INQUIRY', 'SECURE TRANSMISSION DISPATCH FORM', 'Submit inquiries regarding systems architecture, software consulting, or project collaborations.', 1, 19, 'form', 0],
            ['social', 'VERIFIED SOCIAL TELEMETRY & NETWORKS', 'PUBLIC REPOSITORIES & PROFESSIONAL PROFILES', 'Direct connections through GitHub, LinkedIn, and professional engineering associations.', 1, 20, 'cards', 0],
        ];

        $sql = "INSERT INTO `portfolio_sections` (`section_key`, `title`, `subtitle`, `intro_text`, `is_enabled`, `display_order`, `layout_variation`, `hide_if_empty`)
                VALUES (:key, :title, :subtitle, :intro, :enabled, :order, :layout, :hide)";
        $stmt = $this->pdo->prepare($sql);
        foreach ($sections as $s) {
            $stmt->execute([
                ':key' => $s[0],
                ':title' => $s[1],
                ':subtitle' => $s[2],
                ':intro' => $s[3],
                ':enabled' => $s[4],
                ':order' => $s[5],
                ':layout' => $s[6],
                ':hide' => $s[7],
            ]);
        }
    }

    private function seedManifestoArticle(bool $force = false): void
    {
        $manifestoContent = <<<MARKDOWN
# My AI Manifesto: A Personal Position on AI, Human Skill, and Responsible Progress

**Author:** Michael Benedict Ordenes  
**Source:** AI Manifesto v1.0 section in the portfolio website  

---

## PREAMBLE

Artificial intelligence is becoming part of the way people learn, work, create, and solve problems. As a student preparing for a professional career in technology, its presence is impossible to ignore.

There is excitement in what AI can accomplish, but there is also a responsibility to understand what should remain distinctly human.

This manifesto represents the principles that will guide my relationship with AI—not as something to fear or reject, but as something to understand, use responsibly, and keep in its proper place.

---

## I. AI IS A TOOL, NOT A SUBSTITUTE FOR SKILL

AI should remain a tool for developing and extending human capability.

As a student, learning should not be reduced to asking an AI for an answer. The purpose of education is not simply to produce an output, but to develop the ability to understand, reason, create, solve problems, and make decisions independently.

* **TOOL.ASSIST — Assistance:** AI can help explain a difficult concept, suggest an approach, assist with code, or provide another perspective.
* **HUMAN.SKILL — Mastery:** Years of studying, practicing, experimenting, failing, and gaining experience cannot be equated to writing an effective prompt in minutes.

> **CORE PRINCIPLE:**  
> The value of professional skill lies not only in producing an output, but in understanding why it works, whether it is correct, how it can be improved, and what consequences follow from using it.

---

## II. HUMAN CREATIVITY STILL MATTERS

Human capability enhanced by AI.

Much of what AI can produce is connected to knowledge and creative work that originated from people. Art, writing, programming, research, engineering, design, and other forms of human work have contributed to the knowledge from which modern AI systems derive their capabilities.

* **CRAFT / TASTE:** A person who has spent years developing a craft possesses something that cannot be reduced to a prompt: experience. That experience shapes judgment, taste, intuition, creativity, and the ability to recognize possibilities that may not be immediately apparent.
* **MANDATE:** The goal should not be to choose between humans and AI. The goal must be human capability enhanced by AI.

---

## III. AI SHOULD STRENGTHEN PROFESSIONAL DEVELOPMENT

Competence over dependency.

A strong professional should be capable of working with AI without becoming dependent upon it. That means developing the fundamentals:

1. Understanding the code behind the abstraction.
2. Understanding the reasoning behind the answer.
3. Knowing when an AI-generated solution is wrong or hallucinated.
4. Being able to independently verify and validate information.
5. Being capable of solving a problem even when the tool is unavailable.

---

## IV. RESPONSIBILITY CANNOT BE AUTOMATED

Accountability remains human.

AI can generate an answer, but it cannot carry professional responsibility for that answer. When AI contributes to a project, the human using it remains responsible for the final result.

> **CRITICAL ETHICAL AXIOM:**  
> This principle is especially important in professional environments where mistakes can affect people, organizations, finances, privacy, security, or public welfare.
> 
> AI should therefore be questioned, tested, and verified rather than blindly trusted. The presence of an AI system should never become an excuse for avoiding accountability.

---

## V. TECHNOLOGY SHOULD CREATE OPPORTUNITIES

Progress measured by opportunities created for communities.

### Policy & Investment / PAX Silica
Large technological investments such as PAX Silica must create tangible opportunities for workers, students, researchers, and local industries.

* High-quality tech careers and jobs
* Knowledge and technology transfer
* Opportunities for Filipino talent
* Resilient economic growth

> **FILIPINO GUIDING MAXIM:**  
> *"Walang dapat agrabyado; lahat dapat may pagkakataong makinabang."*

---

## VI. A FUTURE WHERE PEOPLE BECOME MORE CAPABLE

Expanding human capability rather than rendering people disposable.

* **Stale Question:** "What jobs can be replaced?"
* **Generative Question:** "What new capabilities and opportunities can be created?"

### Potential Benefits:
* **Students** → Understand complex concepts deeper
* **Developers** → Explore solutions and build resilient code
* **Researchers** → Analyze data and synthesize insights
* **Citizens** → Benefit from efficient, transparent services

---

## VII. PROGRESS MUST COME WITH RESPONSIBLE GOVERNANCE

Developing talent, transparency, and public responsibility.

For the Philippines, technological development should not simply mean becoming a market for technologies developed elsewhere. It must mean developing Filipino talent and capability.

* **Students** → Opportunities to learn and innovate
* **Professionals** → Opportunities to work with dignity
* **Researchers** → Resources to contribute to global science
* **Communities** → Equitable access to technological benefits

Good governance allows innovation to flourish while ensuring that the benefits of progress reach the people who make that progress possible.

---

## VIII. THE PROFESSIONAL I ASPIRE TO BECOME

Core Principles & Creed

### The Foundation Begins As A Student:
1. Learn the fundamentals thoroughly.
2. Develop genuine, independent skills.
3. Use AI without becoming dependent on it.
4. Question and verify outputs rigorously.
5. Use technological knowledge to create opportunities for others.

### x64emkei // CREED:
* AI should make people more capable, not more disposable.
* Human skill should be strengthened, not devalued.
* Technology should create opportunities, not merely eliminate them.
* Innovation should serve people, not leave them behind.
* Professional competence should always remain greater than the ability to simply operate a tool.
MARKDOWN;

        $slug = 'my-ai-manifesto';
        $title = 'My AI Manifesto: A Personal Position on AI, Human Skill, and Responsible Progress';
        $excerpt = 'A personal position on AI, human skill, and responsible progress by Michael Benedict Ordenes. Principles guiding learning, craft, professional development, and Filipino technological opportunity.';
        
        $sql = "INSERT INTO `articles` 
            (`author_id`, `category_id`, `title`, `slug`, `excerpt`, `content`, `featured_image`, `seo_title`, `seo_description`, `is_featured`, `status`, `published_at`)
            VALUES (NULL, 1, :title, :slug, :excerpt, :content, :img, :seo_title, :seo_desc, 1, 'published', NOW())
            ON DUPLICATE KEY UPDATE 
            `title` = VALUES(`title`),
            `excerpt` = VALUES(`excerpt`),
            `content` = VALUES(`content`),
            `is_featured` = 1,
            `status` = 'published'";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':title' => $title,
            ':slug' => $slug,
            ':excerpt' => $excerpt,
            ':content' => $manifestoContent,
            ':img' => 'images/carousel-workspace.jpg',
            ':seo_title' => 'My AI Manifesto // Michael Benedict Ordenes',
            ':seo_desc' => $excerpt
        ]);

        $artId = (int)$this->pdo->lastInsertId();
        if ($artId <= 0) {
            $q = $this->pdo->prepare("SELECT id FROM `articles` WHERE `slug` = :slug");
            $q->execute([':slug' => $slug]);
            $artId = (int)$q->fetchColumn();
        }

        if ($artId > 0) {
            // Attach Tags: Security, Zero-Trust, Ethics
            $insPivot = $this->pdo->prepare("INSERT IGNORE INTO `article_tag_pivot` (`article_id`, `tag_id`) VALUES (:aid, :tid)");
            foreach ([6, 7] as $tid) {
                $insPivot->execute([':aid' => $artId, ':tid' => $tid]);
            }
        }
    }
}
