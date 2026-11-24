/**
 * Portfolio Website Client-Side Logic
 * - View Routing: Separate view per section in a centered fixed-width main view
 * - Theme Management (Dark Mode / Light Mode)
 * - Mobile Sidebar Navigation Toggle & Backdrop
 * - Portfolio Category Filtering
 * - Contact Form Validation & Toast Notification
 */

document.addEventListener('DOMContentLoaded', () => {
    // ==========================================
    // 0. MOBILE SIDEBAR & DRAWER ENGINE (HOISTED)
    const mobileToggle = document.getElementById('mobileToggle');
    const sidebar = document.getElementById('sidebar');
    const sidebarBackdrop = document.getElementById('sidebarBackdrop');
    const sidebarCloseBtn = document.getElementById('sidebarCloseBtn');

    function openSidebar() {
        if (sidebar && mobileToggle && sidebarBackdrop) {
            sidebar.classList.add('open');
            mobileToggle.classList.add('active');
            mobileToggle.setAttribute('aria-expanded', 'true');
            sidebarBackdrop.classList.add('active');
            document.body.classList.add('sidebar-locked');
        }
    }

    function closeSidebar() {
        if (sidebar && mobileToggle && sidebarBackdrop) {
            sidebar.classList.remove('open');
            mobileToggle.classList.remove('active');
            mobileToggle.setAttribute('aria-expanded', 'false');
            sidebarBackdrop.classList.remove('active');
            document.body.classList.remove('sidebar-locked');
        }
    }

    if (mobileToggle) {
        mobileToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            const isOpen = sidebar && sidebar.classList.contains('open');
            if (isOpen) {
                closeSidebar();
            } else {
                openSidebar();
            }
        });
    }

    if (sidebarCloseBtn) {
        sidebarCloseBtn.addEventListener('click', closeSidebar);
    }

    if (sidebarBackdrop) {
        sidebarBackdrop.addEventListener('click', closeSidebar);
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && sidebar && sidebar.classList.contains('open')) {
            closeSidebar();
        }
    });

    // Clean up drawer state if viewport expands to tablet or desktop (>= 768px)
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 768 && sidebar && sidebar.classList.contains('open')) {
            closeSidebar();
        }
    });

    // Touch swipe left to close off-canvas drawer
    let touchStartX = 0;
    if (sidebar) {
        sidebar.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].clientX;
        }, { passive: true });

        sidebar.addEventListener('touchend', (e) => {
            const touchEndX = e.changedTouches[0].clientX;
            if (touchStartX - touchEndX > 60 && sidebar.classList.contains('open')) {
                closeSidebar();
            }
        }, { passive: true });
    }

    // Sub-navigation accordion toggles
    document.querySelectorAll('.subnav-accordion-toggle').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            const isExpanded = btn.classList.contains('expanded');
            btn.classList.toggle('expanded', !isExpanded);
            btn.setAttribute('aria-expanded', !isExpanded ? 'true' : 'false');
            const subnav = btn.closest('.nav-item')?.querySelector('.sidebar-sub-nav');
            if (subnav) {
                subnav.classList.toggle('open', !isExpanded);
            }
        });
    });

    // ==========================================
    // 1. COLOR SWEEP TRANSITION & NAVIGATION
    // ==========================================
    const pageViews = document.querySelectorAll('.page-view');
    const navLinks = document.querySelectorAll('.nav-link');
    const navTriggers = document.querySelectorAll('.nav-trigger');
    const colorSweepCurtain = document.getElementById('colorSweepCurtain');
    const pixelDissolveCanvas = document.getElementById('pixelDissolveCanvas');
    const sweepText = document.getElementById('sweepText');

    // ----------------------------------------------------
    // PIXEL DISSOLVE EFFECT ENGINE
    // ----------------------------------------------------
    let pixelAnimFrame = null;
    const triggerPixelDissolve = (duration = 750, isExiting = false) => {
        if (!pixelDissolveCanvas) return;
        const ctx = pixelDissolveCanvas.getContext('2d');
        if (!ctx) return;

        const rect = pixelDissolveCanvas.getBoundingClientRect();
        pixelDissolveCanvas.width = rect.width;
        pixelDissolveCanvas.height = rect.height;

        const pixelSize = Math.max(16, Math.floor(rect.width / 45));
        const cols = Math.ceil(rect.width / pixelSize);
        const rows = Math.ceil(rect.height / pixelSize);
        const total = cols * rows;

        // Shuffle pixel indices for pseudo-random organic matrix dissolve
        const indices = [];
        for (let i = 0; i < total; i++) indices.push(i);
        for (let i = indices.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [indices[i], indices[j]] = [indices[j], indices[i]];
        }

        const startTime = performance.now();
        if (pixelAnimFrame) cancelAnimationFrame(pixelAnimFrame);

        const renderPixels = (now) => {
            const elapsed = now - startTime;
            const progress = Math.min(1, elapsed / duration);
            ctx.clearRect(0, 0, rect.width, rect.height);

            const countToDraw = isExiting 
                ? Math.floor((1 - progress) * total) 
                : Math.floor(progress * total);

            ctx.fillStyle = '#080A0E';
            for (let i = 0; i < countToDraw; i++) {
                const idx = indices[i];
                const x = (idx % cols) * pixelSize;
                const y = Math.floor(idx / cols) * pixelSize;
                ctx.fillRect(x, y, pixelSize, pixelSize);

                // Add subtle cyan & neon edge glints on randomly dissolved pixels
                if (idx % 7 === 0) {
                    ctx.strokeStyle = 'rgba(0, 229, 255, 0.4)';
                    ctx.lineWidth = 1;
                    ctx.strokeRect(x, y, pixelSize, pixelSize);
                }
            }

            if (progress < 1) {
                pixelAnimFrame = requestAnimationFrame(renderPixels);
            } else {
                ctx.clearRect(0, 0, rect.width, rect.height);
            }
        };

        pixelAnimFrame = requestAnimationFrame(renderPixels);
    };

    let isProgrammaticScroll = false;
    let isTransitioning = false;
    let scrollTimeout = null;

    const sectorMeta = {
        home: { num: '00', label: 'HOME // SECTOR.00' },
        about: { num: '01', label: 'ABOUT // SECTOR.01' },
        services: { num: '02', label: 'SERVICES // SECTOR.02' },
        portfolio: { num: '03', label: 'PORTFOLIO // SECTOR.03' },
        contact: { num: '04', label: 'CONTACT // SECTOR.04' }
    };

    const setActiveNavLink = (sectionId) => {
        navLinks.forEach((link) => {
            if (link.getAttribute('data-section') === sectionId) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        });
    };

    const triggerColorSweepTransition = (targetId, onMidpoint) => {
        const cleanId = targetId.replace('#', '');
        const meta = sectorMeta[cleanId] || { num: 'XX', label: cleanId.toUpperCase() };

        if (!colorSweepCurtain) {
            if (onMidpoint) onMidpoint();
            return;
        }

        if (sweepText) {
            sweepText.textContent = `SYS.TRANSITION // SEC.${meta.num} // ${meta.label}`;
        }

        isTransitioning = true;
        colorSweepCurtain.classList.remove('sweep-in', 'sweep-out');
        colorSweepCurtain.classList.add('animating', 'sweep-in');
        triggerPixelDissolve(340, false);

        // Midpoint: screen is fully covered by the color sweep from the right
        setTimeout(() => {
            if (onMidpoint) onMidpoint();

            // Continue sweep moving out to the left with pixel dissolve reveal
            colorSweepCurtain.classList.remove('sweep-in');
            colorSweepCurtain.classList.add('sweep-out');
            triggerPixelDissolve(420, true);

            setTimeout(() => {
                colorSweepCurtain.classList.remove('animating', 'sweep-out');
                isTransitioning = false;
            }, 420);
        }, 340);
    };

    const navigateToSection = (targetId, withSweep = true) => {
        if (!targetId) return;

        const cleanId = targetId.replace('#', '');
        const targetSection = document.getElementById(cleanId);
        if (!targetSection) return;

        // Prevent double trigger if already active
        const currentActive = document.querySelector('.page-view.active-view');
        if (currentActive && currentActive.id === cleanId && withSweep && !isTransitioning) {
            window.scrollTo({ top: 0, behavior: 'smooth' });
            return;
        }

        if (isTransitioning) return;

        isProgrammaticScroll = true;
        clearTimeout(scrollTimeout);

        const applySectionSwitch = () => {
            setActiveNavLink(cleanId);
            pageViews.forEach((v) => v.classList.remove('active-view'));
            targetSection.classList.add('active-view');

            // Clean independent view: reset scroll to top of section
            window.scrollTo({
                top: 0,
                behavior: 'auto'
            });

            if (window.location.hash !== `#${cleanId}`) {
                history.pushState(null, '', `#${cleanId}`);
            }

            // Trigger text decoding effect on target section title & main header
            decodeSectionHeaders(targetSection);

            scrollTimeout = setTimeout(() => {
                isProgrammaticScroll = false;
            }, 350);
        };

        if (withSweep) {
            triggerColorSweepTransition(cleanId, applySectionSwitch);
        } else {
            applySectionSwitch();
        }
    };

    // Sidebar navigation clicks
    navLinks.forEach((link) => {
        link.addEventListener('click', (e) => {
            const section = link.getAttribute('data-section');
            const href = link.getAttribute('href');
            const targetSection = section ? document.getElementById(section) : null;

            // If on SPA page (e.g. home with .page-view) and target exists
            if (targetSection && document.querySelector('.page-view')) {
                e.preventDefault();
                navigateToSection(section, true);
                closeSidebar();
            } else if (href && href !== '#' && !href.startsWith('javascript:')) {
                const currentPath = window.location.pathname.replace(/\/$/, '') || '/';
                const linkUrl = new URL(link.href, window.location.origin);
                const targetPath = linkUrl.pathname.replace(/\/$/, '') || '/';

                if (currentPath === targetPath) {
                    // Already on target page: toggle accordion and scroll to top
                    e.preventDefault();
                    const parentItem = link.closest('.nav-item');
                    const subnav = parentItem?.querySelector('.sidebar-sub-nav');
                    const toggleBtn = parentItem?.querySelector('.subnav-accordion-toggle');
                    if (subnav) {
                        const isOpen = subnav.classList.contains('open');
                        subnav.classList.toggle('open', !isOpen);
                        if (toggleBtn) {
                            toggleBtn.classList.toggle('expanded', !isOpen);
                            toggleBtn.setAttribute('aria-expanded', !isOpen ? 'true' : 'false');
                        }
                    }
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                    closeSidebar();
                } else {
                    // Let standard navigation load the page
                    closeSidebar();
                }
            }
        });
    });

    // In-page navigation triggers (e.g. "View Projects", "Contact Me")
    navTriggers.forEach((trigger) => {
        trigger.addEventListener('click', (e) => {
            e.preventDefault();
            const targetSection = trigger.getAttribute('data-target');
            if (targetSection) {
                navigateToSection(targetSection, true);
            }
        });
    });

    // ==========================================
    // FIRST WEBPAGE LOAD DECODE EFFECT SEQUENCE
    // ==========================================
    const triggerFirstLoadDecode = () => {
        setTimeout(() => {
            // Decode hero title ("Michael Benedict Ordenes") and main hero headers
            const heroTitle = document.querySelector('.hero-title');
            const heroSubtitle = document.querySelector('.hero-subtitle-badge');
            const heroTagText = document.querySelector('.hero-tag span:last-child');
            const brandTitle = document.querySelector('.brand-title');
            const brandSubtitle = document.querySelector('.brand-subtitle');

            if (heroTitle) decodeElementText(heroTitle);
            if (heroSubtitle) decodeElementText(heroSubtitle);
            if (heroTagText) decodeElementText(heroTagText);
            if (brandTitle) decodeElementText(brandTitle);
            if (brandSubtitle) decodeElementText(brandSubtitle);

            // Also decode the active section if loaded on a deep hash
            const activeSec = document.querySelector('.page-view.active-view');
            if (activeSec && activeSec.id !== 'home') {
                decodeSectionHeaders(activeSec);
            }
        }, 180);
    };

    // Initial page load hash handling & first load decoding
    const handleInitialHash = () => {
        const hash = window.location.hash.replace('#', '');
        if (hash === 'manifesto') {
            setActiveNavLink('home');
            const homeSec = document.getElementById('home');
            if (homeSec) homeSec.classList.add('active-view');
            setTimeout(() => {
                if (typeof openManifestoModal === 'function') {
                    openManifestoModal(0);
                }
            }, 250);
        } else if (hash && document.getElementById(hash)) {
            setTimeout(() => {
                navigateToSection(hash, false);
            }, 100);
        } else {
            setActiveNavLink('home');
            const homeSec = document.getElementById('home');
            if (homeSec) homeSec.classList.add('active-view');
        }
        triggerFirstLoadDecode();
    };

    handleInitialHash();
    window.addEventListener('popstate', () => {
        const hash = window.location.hash.replace('#', '') || 'home';
        if (hash === 'manifesto') {
            if (typeof openManifestoModal === 'function') {
                openManifestoModal(0);
            }
        } else {
            if (typeof closeManifestoModal === 'function') {
                closeManifestoModal();
            }
            navigateToSection(hash, true);
        }
    });

    // Interactive Hover Replay on Section Titles & Main Headers
    document.querySelectorAll('.section-title, .hero-title, .section-subtitle, .hero-subtitle-badge, .portfolio-subsection-title').forEach((el) => {
        el.addEventListener('mouseenter', () => {
            decodeElementText(el);
        });
    });

    // ==========================================
    // 2. THEME TOGGLE (DARK MODE / LIGHT MODE)
    // ==========================================
    const themeToggleBtn = document.getElementById('themeToggle');
    const themeLabel = document.getElementById('themeLabel');

    // Retrieve saved theme preference or default to dark
    const savedTheme = localStorage.getItem('portfolio-theme') || 'dark';

    const applyTheme = (theme) => {
        if (theme === 'light') {
            document.body.classList.add('light-theme');
            if (themeLabel) themeLabel.textContent = 'Light Mode';
        } else {
            document.body.classList.remove('light-theme');
            if (themeLabel) themeLabel.textContent = 'Dark Mode';
        }
    };

    // Apply initial theme
    applyTheme(savedTheme);

    const utilityThemeToggle = document.getElementById('utilityThemeToggle');
    const handleThemeToggle = () => {
        const isLight = document.body.classList.contains('light-theme');
        const newTheme = isLight ? 'dark' : 'light';
        applyTheme(newTheme);
        localStorage.setItem('portfolio-theme', newTheme);
    };

    if (themeToggleBtn) {
        themeToggleBtn.addEventListener('click', handleThemeToggle);
    }
    if (utilityThemeToggle) {
        utilityThemeToggle.addEventListener('click', handleThemeToggle);
    }

    // ==========================================
    // 5. CYBER TEXT SCRAMBLE / DECODER EFFECT ENGINE
    // ==========================================
    const glyphs = '0123456789ABCDEF_//<>[]#*+!~=%&$';

    function scrambleText(rawText, onUpdate, onComplete, speed = 20) {
        let iteration = 0;
        const maxIterations = rawText.length;
        const timer = setInterval(() => {
            const result = rawText
                .split('')
                .map((char, index) => {
                    if (char === ' ' || char === '\n' || char === '\t' || char === '\r') return char;
                    if (index < iteration) {
                        return rawText[index];
                    }
                    return glyphs[Math.floor(Math.random() * glyphs.length)];
                })
                .join('');

            onUpdate(result);

            if (iteration >= maxIterations) {
                clearInterval(timer);
                onUpdate(rawText);
                if (onComplete) onComplete();
            }
            iteration += 1 / 2;
        }, speed);
        return timer;
    }

    function decodeElementText(el) {
        if (!el) return;

        // If element has mixed text nodes and element children (e.g. hero-title with .text-gradient)
        if (el.childNodes && el.childNodes.length > 1) {
            Array.from(el.childNodes).forEach((node) => {
                if (node.nodeType === Node.TEXT_NODE && node.textContent.trim()) {
                    if (!node._originalText) node._originalText = node.textContent;
                    if (node._scrambleTimer) clearInterval(node._scrambleTimer);
                    node._scrambleTimer = scrambleText(node._originalText, (val) => {
                        node.textContent = val;
                    });
                } else if (node.nodeType === Node.ELEMENT_NODE) {
                    decodeElementText(node);
                }
            });
        } else if (el.firstElementChild) {
            decodeElementText(el.firstElementChild);
        } else {
            const raw = el.getAttribute('data-raw-text') || el.textContent;
            if (!raw || !raw.trim()) return;
            el.setAttribute('data-raw-text', raw);
            if (el._scrambleTimer) clearInterval(el._scrambleTimer);
            el._scrambleTimer = scrambleText(raw, (val) => {
                el.textContent = val;
            });
        }
    }

    function scrambleElement(el) {
        decodeElementText(el);
    }

    function decodeSectionHeaders(sectionEl) {
        if (!sectionEl) return;
        const targets = sectionEl.querySelectorAll('.section-title, .hero-title, .section-subtitle, .hero-subtitle-badge, .portfolio-subsection-title');
        targets.forEach((t) => decodeElementText(t));
    }

    // ==========================================
    // 6. LIVE SYS.TIME / ACTUAL CLOCK DISPLAY
    // ==========================================
    const liveClockEl = document.getElementById('liveSysClock');
    if (liveClockEl) {
        let is24Hour = false;

        const updateClock = () => {
            const now = new Date();
            try {
                const options = {
                    timeZone: 'Asia/Manila',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: !is24Hour
                };
                const timeStr = new Intl.DateTimeFormat('en-US', options).format(now);
                liveClockEl.textContent = `${timeStr} PHT`;

                const hudContainer = liveClockEl.closest('.sidebar-telemetry-hud');
                if (hudContainer) {
                    const dateOptions = {
                        timeZone: 'Asia/Manila',
                        weekday: 'short',
                        month: 'short',
                        day: 'numeric',
                        year: 'numeric'
                    };
                    const dateStr = new Intl.DateTimeFormat('en-US', dateOptions).format(now);
                    hudContainer.setAttribute(
                        'title',
                        `Philippine Standard Time (PST / UTC+8 / Asia/Manila) • ${is24Hour ? '24H' : '12H'} Mode • ${dateStr}`
                    );
                }
            } catch (err) {
                const hours = (now.getUTCHours() + 8) % 24;
                const minutes = String(now.getUTCMinutes()).padStart(2, '0');
                const seconds = String(now.getUTCSeconds()).padStart(2, '0');
                if (is24Hour) {
                    liveClockEl.textContent = `${String(hours).padStart(2, '0')}:${minutes}:${seconds} PHT`;
                } else {
                    const ampm = hours >= 12 ? 'PM' : 'AM';
                    const h12 = String(hours % 12 || 12).padStart(2, '0');
                    liveClockEl.textContent = `${h12}:${minutes}:${seconds} ${ampm} PHT`;
                }
            }
        };

        const hudContainer = liveClockEl.closest('.sidebar-telemetry-hud');
        if (hudContainer) {
            hudContainer.addEventListener('click', () => {
                is24Hour = !is24Hour;
                updateClock();
            });
        }

        updateClock();
        setInterval(updateClock, 1000);
    }

    // ==========================================
    // 7. TECHNO EQUALIZER BARS DYNAMIC PULSE
    // ==========================================
    const eqBars = document.querySelectorAll('.eq-bar');
    if (eqBars.length > 0) {
        setInterval(() => {
            eqBars.forEach((bar) => {
                const heightPercent = Math.floor(Math.random() * 80) + 20;
                bar.style.height = `${heightPercent}%`;
            });
        }, 150);
    }

    // ==========================================
    // 8. AI MANIFESTO MODAL & BUTTON CAROUSEL
    // ==========================================
    const manifestoModalBackdrop = document.getElementById('manifestoModalBackdrop');
    const manifestoModal = document.getElementById('manifestoModal');
    const manifestoModalBody = document.getElementById('manifestoModalBody');
    const manifestoCloseBtn = document.getElementById('manifestoCloseBtn');
    const manifestoTrack = document.getElementById('manifestoCarouselTrack');
    const manifestoSlides = document.querySelectorAll('.manifesto-slide');
    const manifestoNavBtns = document.querySelectorAll('.carousel-nav-btn');
    const prevSlideBtn = document.getElementById('prevSlideBtn');
    const nextSlideBtn = document.getElementById('nextSlideBtn');
    const currentSlideDisplay = document.getElementById('currentSlideDisplay');
    const currentSectionName = document.getElementById('currentSectionName');
    const carouselProgressBar = document.getElementById('carouselProgressBar');
    const manifestoViewToggle = document.getElementById('manifestoViewToggle');
    const copyManifestoBtn = document.getElementById('copyManifestoBtn');
    const copyManifestoText = document.getElementById('copyManifestoText');

    const manifestoTriggerButtons = [
        document.getElementById('sidebarManifestoBtn'),
        document.getElementById('heroManifestoBtn'),
        document.getElementById('aboutManifestoBtn')
    ].filter(Boolean);

    const sectionTitles = [
        'Preamble',
        'I. Tool vs Skill',
        'II. Creativity',
        'III. Prof. Development',
        'IV. Responsibility',
        'V. Opportunities',
        'VI. Capable Future',
        'VII. Governance',
        'VIII. Aspirations & Creed'
    ];

    const fullManifestoText = `# MY AI MANIFESTO
### A Personal Position on AI, Human Skill, and Responsible Progress

Artificial intelligence is becoming part of the way people learn, work, create, and solve problems. As a student preparing for a professional career in technology, its presence is impossible to ignore.

There is excitement in what AI can accomplish, but there is also a responsibility to understand what should remain distinctly human.

This manifesto represents the principles that will guide my relationship with AI—not as something to fear or reject, but as something to understand, use responsibly, and keep in its proper place.

## I. AI Is a Tool, Not a Substitute for Skill

AI should remain a tool for developing and extending human capability.

As a student, learning should not be reduced to asking an AI for an answer. The purpose of education is not simply to produce an output, but to develop the ability to understand, reason, create, solve problems, and make decisions independently.

AI can help explain a difficult concept, suggest an approach, assist with code, or provide another perspective. These capabilities are valuable.

But they should not replace the process of actually learning.

There is a fundamental difference between knowing how to use a tool and possessing the skill that the tool assists.

Years of studying, practicing, experimenting, failing, improving, and gaining experience cannot simply be equated with learning how to write an effective prompt within minutes.

The value of professional skill lies not only in producing an output, but in understanding why it works, whether it is correct, how it can be improved, and what consequences may follow from using it.

For that reason, AI should supplement skill—not become a substitute for developing it.

## II. Human Creativity Still Matters

Much of what AI can produce is connected to knowledge and creative work that originated from people.

Art, writing, programming, research, engineering, design, and other forms of human work have contributed to the knowledge from which modern AI systems derive their capabilities.

That reality makes human creativity and expertise even more important, not less.

The emergence of AI should not create the belief that human effort has suddenly become worthless.

A person who has spent years developing a craft possesses something that cannot be reduced to a prompt: experience.

That experience shapes judgment, taste, intuition, creativity, and the ability to recognize possibilities that may not be immediately apparent.

The goal should therefore not be to choose between humans and AI.

The goal should be:
> Human capability enhanced by AI.

## III. AI Should Strengthen Professional Development

As a future professional, AI literacy will be important—but it should exist alongside genuine professional competence.

The tools used in technology will continue to change. AI models will improve. Programming languages and platforms will evolve. What remains important is the ability to learn and adapt.

A strong professional should therefore be capable of working with AI without becoming dependent upon it.

That means developing the fundamentals:
- Understanding the code behind the abstraction.
- Understanding the reasoning behind the answer.
- Knowing when an AI-generated solution is wrong.
- Being able to verify information.
- Being capable of solving a problem even when the tool is unavailable.

These are the qualities that turn AI from a shortcut into a meaningful professional instrument.

## IV. Responsibility Cannot Be Automated

AI can generate an answer, but it cannot carry the professional responsibility for that answer.

When AI contributes to a project, the human using it remains responsible for the final result.

This principle is especially important in professional environments where mistakes can affect people, organizations, finances, privacy, security, or public welfare.

AI should therefore be questioned, tested, and verified rather than blindly trusted.

The presence of an AI system should never become an excuse for avoiding accountability.

> A tool can assist with the work, but responsibility remains human.

## V. Technology Should Create Opportunities

Technological progress should not be measured only by how much work can be automated or how much profit can be generated.

It should also be measured by what opportunities technology creates for people.

This principle is particularly important when considering initiatives such as PAX Silica.

Large technological investments should create meaningful opportunities for workers, professionals, students, businesses, researchers, and communities.

Investment should have the potential to produce:
* jobs and professional opportunities;
* education and training;
* opportunities for Filipino workers and businesses;
* research and development;
* technology and knowledge transfer;
* new industries and supporting businesses; and
* long-term economic opportunities.

The principle is simple:
> Walang dapat agrabyado; lahat dapat may pagkakataong makinabang.

Technology should not simply ask:
> “What jobs can be replaced?”

It should also ask:
> “What new opportunities can be created?”

## VI. A Future Where People Become More Capable

The purpose of technology should ultimately be to expand what people are capable of doing.

AI can help a student understand a difficult subject.
It can help a programmer explore solutions.
It can help a researcher analyze information.
It can help an engineer develop ideas.
It can help businesses operate more efficiently.
It can help governments improve public services.

These possibilities are valuable precisely because people remain at the center of them.

The ideal future is not one where people become unnecessary because machines can do everything.

It is one where people have better tools to learn, create, solve problems, and build meaningful things.

## VII. Progress Must Come With Responsible Governance

Technological progress also requires responsible governance.

Innovation should be encouraged, but it should exist alongside transparency, accountability, and public responsibility.

For the Philippines, technological development should not simply mean becoming a market for technologies developed elsewhere.

It should also mean developing Filipino talent and capability.

Students should have opportunities to learn.
Professionals should have opportunities to work.
Researchers should have opportunities to contribute.
Businesses should have opportunities to grow.
Communities should have opportunities to benefit.

And government should have the responsibility to ensure that technological development serves more than a narrow group of interests.

Good governance should allow innovation to grow while ensuring that the benefits of progress reach the people who make that progress possible.

## VIII. The Professional I Aspire to Become

The kind of professional worth becoming is not defined by the ability to use the newest technology alone.

It is defined by the ability to understand technology, use it responsibly, and remain accountable for its consequences.

The foundation begins as a student:
- Learn the fundamentals.
- Develop genuine skills.
- Use AI without becoming dependent on it.
- Question and verify its outputs.
- Respect human creativity and expertise.
- Keep learning even when technology makes things easier.
- Use technological knowledge to create opportunities for others.
- Support innovation while demanding responsibility.

The tools may change throughout a professional career.
The principles should not.

### Core Belief
> AI should make people more capable, not more disposable.
> Human skill should be strengthened, not devalued.
> Technology should create opportunities, not merely eliminate them.
> Innovation should serve people, not leave them behind.
> And professional competence should always remain greater than the ability to simply operate a tool.`;

    let currentSlide = 0;
    const totalSlides = manifestoSlides.length; // 9

    function updateCarouselUI(index) {
        if (totalSlides === 0) return;
        currentSlide = Math.max(0, Math.min(index, totalSlides - 1));

        // Horizontal transform in Carousel mode
        if (manifestoTrack && manifestoModal && !manifestoModal.classList.contains('full-read-mode')) {
            manifestoTrack.style.transform = `translateX(-${currentSlide * 100}%)`;
        }

        // Active state on individual slide cards
        manifestoSlides.forEach((slide, idx) => {
            if (idx === currentSlide) {
                slide.classList.add('active-slide');
            } else {
                slide.classList.remove('active-slide');
            }
        });

        // Active state on Button Carousel Nav Bar
        manifestoNavBtns.forEach((btn, idx) => {
            const isSelected = idx === currentSlide;
            btn.classList.toggle('active', isSelected);
            btn.setAttribute('aria-selected', isSelected ? 'true' : 'false');
            if (isSelected) {
                btn.scrollIntoView({ behavior: 'smooth', inline: 'nearest', block: 'nearest' });
            }
        });

        // Reset slide scroll position
        if (manifestoModalBody && !manifestoModal.classList.contains('full-read-mode')) {
            manifestoModalBody.scrollTop = 0;
        }

        // Update Prev / Next button states
        if (prevSlideBtn) prevSlideBtn.disabled = currentSlide === 0;
        if (nextSlideBtn) nextSlideBtn.disabled = currentSlide === totalSlides - 1;

        // Update HUD telemetry and Progress Bar
        if (currentSlideDisplay) {
            currentSlideDisplay.textContent = `SEC 0${currentSlide} / 08`;
        }
        if (currentSectionName) {
            currentSectionName.textContent = sectionTitles[currentSlide] || 'SECTION';
        }
        if (carouselProgressBar) {
            const progressPercent = ((currentSlide + 1) / totalSlides) * 100;
            carouselProgressBar.style.width = `${progressPercent}%`;
        }
    }

    function openManifestoModal(initialSlide = 0) {
        if (!manifestoModalBackdrop) return;
        manifestoModalBackdrop.classList.add('active');
        manifestoModalBackdrop.setAttribute('aria-hidden', 'false');
        document.body.classList.add('sidebar-locked');
        updateCarouselUI(initialSlide);
    }

    function closeManifestoModal() {
        if (!manifestoModalBackdrop) return;
        manifestoModalBackdrop.classList.remove('active');
        manifestoModalBackdrop.setAttribute('aria-hidden', 'true');
        const isMobileSidebarOpen = sidebar && sidebar.classList.contains('open');
        if (!isMobileSidebarOpen) {
            document.body.classList.remove('sidebar-locked');
        }
        if (window.location.hash === '#manifesto') {
            history.replaceState(null, '', ' ');
        }
    }

    // Attach trigger listeners
    manifestoTriggerButtons.forEach((btn) => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            openManifestoModal(0);
        });
    });

    if (manifestoCloseBtn) {
        manifestoCloseBtn.addEventListener('click', closeManifestoModal);
    }

    if (manifestoModalBackdrop) {
        manifestoModalBackdrop.addEventListener('click', (e) => {
            if (e.target === manifestoModalBackdrop) {
                closeManifestoModal();
            }
        });
    }

    // Button Carousel Nav Button Clicks
    manifestoNavBtns.forEach((btn) => {
        btn.addEventListener('click', () => {
            const targetIndex = parseInt(btn.getAttribute('data-slide'), 10);
            if (!isNaN(targetIndex)) {
                if (manifestoModal && manifestoModal.classList.contains('full-read-mode')) {
                    const targetSlide = manifestoSlides[targetIndex];
                    if (targetSlide) {
                        targetSlide.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                    manifestoNavBtns.forEach((b) => b.classList.remove('active'));
                    btn.classList.add('active');
                } else {
                    updateCarouselUI(targetIndex);
                }
            }
        });
    });

    // Prev / Next button listeners
    if (prevSlideBtn) {
        prevSlideBtn.addEventListener('click', () => {
            if (currentSlide > 0) updateCarouselUI(currentSlide - 1);
        });
    }

    if (nextSlideBtn) {
        nextSlideBtn.addEventListener('click', () => {
            if (currentSlide < totalSlides - 1) updateCarouselUI(currentSlide + 1);
        });
    }

    // Keyboard navigation (Arrow keys + Esc)
    window.addEventListener('keydown', (e) => {
        if (!manifestoModalBackdrop || !manifestoModalBackdrop.classList.contains('active')) return;

        if (e.key === 'Escape') {
            closeManifestoModal();
        } else if (e.key === 'ArrowRight' || e.key === 'PageDown') {
            if (manifestoModal && !manifestoModal.classList.contains('full-read-mode') && currentSlide < totalSlides - 1) {
                e.preventDefault();
                updateCarouselUI(currentSlide + 1);
            }
        } else if (e.key === 'ArrowLeft' || e.key === 'PageUp') {
            if (manifestoModal && !manifestoModal.classList.contains('full-read-mode') && currentSlide > 0) {
                e.preventDefault();
                updateCarouselUI(currentSlide - 1);
            }
        }
    });

    // Touch swipe gestures for mobile carousel
    let touchStartX = 0;
    let touchStartY = 0;
    let touchEndX = 0;
    let touchEndY = 0;

    if (manifestoModalBody) {
        manifestoModalBody.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
            touchStartY = e.changedTouches[0].screenY;
        }, { passive: true });

        manifestoModalBody.addEventListener('touchend', (e) => {
            if (manifestoModal && manifestoModal.classList.contains('full-read-mode')) return;
            touchEndX = e.changedTouches[0].screenX;
            touchEndY = e.changedTouches[0].screenY;
            const diffX = touchStartX - touchEndX;
            const diffY = touchStartY - touchEndY;

            if (Math.abs(diffX) > 55 && Math.abs(diffX) > Math.abs(diffY) * 1.5) {
                if (diffX > 0 && currentSlide < totalSlides - 1) {
                    updateCarouselUI(currentSlide + 1);
                } else if (diffX < 0 && currentSlide > 0) {
                    updateCarouselUI(currentSlide - 1);
                }
            }
        }, { passive: true });
    }

    // View toggle: Carousel mode vs Full Document mode
    if (manifestoViewToggle) {
        manifestoViewToggle.addEventListener('click', () => {
            const isFullRead = manifestoModal.classList.toggle('full-read-mode');
            manifestoViewToggle.classList.toggle('active-mode', isFullRead);
            const toggleIcon = manifestoViewToggle.querySelector('.view-toggle-icon');
            const toggleText = manifestoViewToggle.querySelector('.view-toggle-text');

            if (isFullRead) {
                if (toggleIcon) toggleIcon.textContent = '☷';
                if (toggleText) toggleText.textContent = 'Carousel View';
                manifestoTrack.style.transform = 'none';
                if (prevSlideBtn) prevSlideBtn.style.display = 'none';
                if (nextSlideBtn) nextSlideBtn.style.display = 'none';
            } else {
                if (toggleIcon) toggleIcon.textContent = '📜';
                if (toggleText) toggleText.textContent = 'Full Read View';
                if (prevSlideBtn) prevSlideBtn.style.display = '';
                if (nextSlideBtn) nextSlideBtn.style.display = '';
                updateCarouselUI(currentSlide);
            }
        });
    }

    // Copy Manifesto text to clipboard
    if (copyManifestoBtn && copyManifestoText) {
        copyManifestoBtn.addEventListener('click', async () => {
            try {
                await navigator.clipboard.writeText(fullManifestoText);
                copyManifestoText.textContent = '✓ Copied!';
                copyManifestoBtn.style.borderColor = 'var(--accent-green)';
                copyManifestoBtn.style.color = 'var(--accent-green)';
                setTimeout(() => {
                    copyManifestoText.textContent = 'Copy Text';
                    copyManifestoBtn.style.borderColor = '';
                    copyManifestoBtn.style.color = '';
                }, 2200);
            } catch (err) {
                copyManifestoText.textContent = 'Copied!';
                setTimeout(() => {
                    copyManifestoText.textContent = 'Copy Text';
                }, 2000);
            }
        });
    }

    // ==========================================
    // 9. PORTFOLIO CATEGORY FILTERING
    // ==========================================
    const filterButtons = document.querySelectorAll('.filter-btn');
    const programCards = document.querySelectorAll('.program-card');
    const portfolioSubsections = document.querySelectorAll('.portfolio-subsection');

    function applyPortfolioFilter(filter) {
        // Filter subsections
        portfolioSubsections.forEach((sub) => {
            const subCat = sub.getAttribute('data-section-category');
            if (filter === 'all' || filter === subCat) {
                sub.classList.remove('is-filtered-out');
            } else {
                sub.classList.add('is-filtered-out');
            }
        });

        // Filter individual cards within visible subsections
        programCards.forEach((card) => {
            const categoryStr = card.getAttribute('data-category') || '';
            const categories = categoryStr.split(' ');
            if (filter === 'all' || categories.includes(filter)) {
                card.classList.remove('is-filtered-out');
                card.classList.add('is-filtered-in');
            } else {
                card.classList.remove('is-filtered-in');
                card.classList.add('is-filtered-out');
            }
        });
    }

    if (filterButtons.length > 0) {
        filterButtons.forEach((btn) => {
            btn.addEventListener('click', () => {
                const filter = btn.getAttribute('data-filter') || 'featured';
                filterButtons.forEach((b) => b.classList.remove('active'));
                btn.classList.add('active');
                applyPortfolioFilter(filter);
            });
        });

        // Run initial filter (default: featured)
        const initialActiveBtn = document.querySelector('.filter-btn.active');
        const defaultFilter = initialActiveBtn ? (initialActiveBtn.getAttribute('data-filter') || 'featured') : 'featured';
        applyPortfolioFilter(defaultFilter);
    }

    // ==========================================
    // 10. CONTACT FORM VALIDATION & TOAST SYSTEM
    // ==========================================
    const contactForm = document.getElementById('contactForm');
    const toastContainer = document.getElementById('toastContainer');
    const toastTitle = document.getElementById('toastTitle');
    const toastMessage = document.getElementById('toastMessage');

    if (contactForm) {
        const nameInput = document.getElementById('userName');
        const emailInput = document.getElementById('userEmail');
        const subjectInput = document.getElementById('userSubject');
        const messageInput = document.getElementById('userMessage');
        const submitBtn = document.getElementById('submitBtn');

        const nameError = document.getElementById('nameError');
        const emailError = document.getElementById('emailError');
        const subjectError = document.getElementById('subjectError');
        const messageError = document.getElementById('messageError');

        let toastTimeout = null;

        const showToast = (title, message, isSuccess = true) => {
            if (!toastContainer) return;
            if (toastTitle) toastTitle.textContent = title;
            if (toastMessage) toastMessage.textContent = message;

            const toastCard = document.getElementById('toastCard');
            if (toastCard) {
                if (isSuccess) {
                    toastCard.style.borderColor = 'var(--accent-green)';
                } else {
                    toastCard.style.borderColor = 'var(--primary)';
                }
            }

            toastContainer.classList.add('active');
            clearTimeout(toastTimeout);
            toastTimeout = setTimeout(() => {
                toastContainer.classList.remove('active');
            }, 4000);
        };

        const validateEmail = (email) => {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        };

        // Real-time error clearing on input
        [nameInput, emailInput, subjectInput, messageInput].forEach((input) => {
            if (input) {
                input.addEventListener('input', () => {
                    input.classList.remove('input-error');
                    const fieldName = input.id.replace('user', '').toLowerCase();
                    const errEl = document.getElementById(`${fieldName}Error`);
                    if (errEl) errEl.classList.remove('active');
                });
            }
        });

        contactForm.addEventListener('submit', (e) => {
            e.preventDefault();
            let isValid = true;

            // Validate Name
            if (!nameInput || !nameInput.value.trim()) {
                if (nameInput) nameInput.classList.add('input-error');
                if (nameError) nameError.classList.add('active');
                isValid = false;
            } else {
                if (nameInput) nameInput.classList.remove('input-error');
                if (nameError) nameError.classList.remove('active');
            }

            // Validate Email
            if (!emailInput || !emailInput.value.trim() || !validateEmail(emailInput.value.trim())) {
                if (emailInput) emailInput.classList.add('input-error');
                if (emailError) emailError.classList.add('active');
                isValid = false;
            } else {
                if (emailInput) emailInput.classList.remove('input-error');
                if (emailError) emailError.classList.remove('active');
            }

            // Validate Subject
            if (!subjectInput || !subjectInput.value.trim()) {
                if (subjectInput) subjectInput.classList.add('input-error');
                if (subjectError) subjectError.classList.add('active');
                isValid = false;
            } else {
                if (subjectInput) subjectInput.classList.remove('input-error');
                if (subjectError) subjectError.classList.remove('active');
            }

            // Validate Message
            if (!messageInput || messageInput.value.trim().length < 10) {
                if (messageInput) messageInput.classList.add('input-error');
                if (messageError) messageError.classList.add('active');
                isValid = false;
            } else {
                if (messageInput) messageInput.classList.remove('input-error');
                if (messageError) messageError.classList.remove('active');
            }

            if (!isValid) return;

            // Simulate form submission
            if (submitBtn) {
                submitBtn.disabled = true;
                const btnText = submitBtn.querySelector('.btn-text');
                const origText = btnText ? btnText.textContent : 'Send Message';
                if (btnText) btnText.textContent = 'Transmitting...';

                setTimeout(() => {
                    contactForm.reset();
                    submitBtn.disabled = false;
                    if (btnText) btnText.textContent = origText;
                    showToast('Transmission Confirmed!', 'Your message has been dispatched successfully.', true);
                }, 700);
            }
        });
    }

    // =========================================================================
    // 11. INTERACTIVE PROJECT INSPECTOR & CODE MODAL
    // =========================================================================
    const projectModalBackdrop = document.getElementById('projectModalBackdrop');
    const projectModalCloseBtn = document.getElementById('projectModalCloseBtn');
    const modalProjectCloseActionBtn = document.getElementById('modalProjectCloseActionBtn');
    const btnCopyProjectCode = document.getElementById('btnCopyProjectCode');
    const copyCodeText = document.getElementById('copyCodeText');

    const modalProjectId = document.getElementById('modalProjectId');
    const modalProjectCategory = document.getElementById('modalProjectCategory');
    const modalProjectTitle = document.getElementById('modalProjectTitle');
    const modalProjectTagline = document.getElementById('modalProjectTagline');
    const modalProjectEnv = document.getElementById('modalProjectEnv');
    const modalProjectPerf = document.getElementById('modalProjectPerf');
    const modalProjectStatus = document.getElementById('modalProjectStatus');
    const modalProjectDesc = document.getElementById('modalProjectDesc');
    const modalProjectFeatures = document.getElementById('modalProjectFeatures');
    const modalCodeFileName = document.getElementById('modalCodeFileName');
    const modalProjectCode = document.getElementById('modalProjectCode');
    const modalProjectTechPills = document.getElementById('modalProjectTechPills');

    const PROJECTS_DB = (typeof window !== 'undefined' && window.__SERVER_PROJECTS__) ? window.__SERVER_PROJECTS__ : {
        valkyriepos: {
            id: 'CS.001 // ENTERPRISE_POS',
            category: 'C# 12 / .NET 9',
            title: 'Valkyrie POS Pro',
            tagline: 'Autonomous offline retail point-of-sale terminal engine with cryptographic peer sync and scanner abstraction.',
            env: 'Windows 11 / Embedded POS • .NET 9 Desktop • SQLite WAL',
            perf: '0.8ms transaction write • Sub-10ms peer sync loop',
            status: 'Operational • Simulated Enterprise Stack',
            desc: 'A mission-critical Point-of-Sale architecture engineered for zero-downtime retail environments. Features a resilient local write-ahead cryptographic ledger that operates seamlessly when disconnected from WAN and syncs peer-to-peer across LAN terminals using authenticated gRPC channels.',
            features: [
                'Local Write-Ahead Transaction Ledger (WAL) guaranteeing atomic state consistency.',
                'Peer-to-peer multi-terminal catalog synchronization over LAN with automatic conflict resolution.',
                'Direct hardware abstraction layer for ESC/POS thermal printers and barcode scanners.',
                'GPU-accelerated WPF touch-first checkout UI rendering fluid 60 FPS transitions.'
            ],
            fileName: 'ValkyrieLedgerEngine.cs',
            code: 'public sealed class TransactionLedger : IDisposable\n{\n    private readonly SqliteConnection _db;\n    private readonly Channel<TransactionRecord> _txQueue;\n\n    public async Task<ReceiptTicket> CommitSaleAsync(CartPayload cart, CancellationToken ct)\n    {\n        var hash = CryptoProvider.ComputeSha256(cart.Serialize());\n        using var tx = await _db.BeginTransactionAsync(IsolationLevel.Snapshot, ct);\n        \n        var record = new TransactionRecord(Guid.NewGuid(), cart.TotalCents, hash, DateTime.UtcNow);\n        await _db.ExecuteAsync("INSERT INTO LedgerJournal VALUES (@Id, @Amount, @Hash, @Time)", record, tx);\n        await tx.CommitAsync(ct);\n        \n        _txQueue.Writer.TryWrite(record); // Background peer-sync broadcast\n        return new ReceiptTicket(record.Id, record.Timestamp, cart.Items);\n    }\n}',
            tech: ['C# 12', '.NET 9', 'WPF', 'SQLite', 'gRPC', 'Cryptography']
        },
        aegiskernel: {
            id: 'CPP.001 // MICRO_HYPERVISOR',
            category: 'C++20 / Ring-0',
            title: 'AegisKernel Microvisor',
            tagline: 'Simulated Type-1 bare-metal microkernel with memory-enclave isolation and sub-microsecond context switching.',
            env: 'Bare-Metal x86_64 • Custom Bootloader • GDT/IDT Initialization',
            perf: 'Zero syscall overhead • <420ns interrupt handling',
            status: 'Experimental • Systems Architecture Lab',
            desc: 'A conceptual lightweight experimental micro-hypervisor designed in modern C++20 and x86_64 assembly. Implements hardware-assisted virtualization hooks, 4-level paging setup, ring-0 to ring-3 protection boundary controllers, and physical page allocation without standard C runtime dependencies.',
            features: [
                'Hardware memory paging setup managing 4-level PML4 address translation tables.',
                'Custom Global Descriptor Table (GDT) and Interrupt Descriptor Table (IDT) handlers.',
                'Lock-free thread context save and restore routine written in inline assembly.',
                'Sub-microsecond high-resolution timer interrupt calibration via RDTSC instructions.'
            ],
            fileName: 'AegisPaging.cpp',
            code: 'extern "C" void SwitchAddressSpace(uint64_t pml4_physical_base) noexcept {\n    asm volatile (\n        "movq %0, %%cr3\\n\\t"\n        : \n        : "r"(pml4_physical_base)\n        : "memory"\n    );\n}\n\nclass VirtualMemoryManager {\npublic:\n    void MapPage(uint64_t virtualAddr, uint64_t physAddr, uint32_t flags) noexcept {\n        uint64_t pml4_idx = (virtualAddr >> 39) & 0x1FF;\n        uint64_t pdpt_idx = (virtualAddr >> 30) & 0x1FF;\n        EnsureTablePresent(pml4_idx, pdpt_idx, flags);\n    }\n};',
            tech: ['C++20', 'x86_64 ASM', 'Memory Paging', 'Ring-0', 'Bare-Metal']
        },
        neuropulse: {
            id: 'PY.001 // EDGE_VISION_AI',
            category: 'Python 3.12 / CUDA',
            title: 'NeuroPulse Vision AI',
            tagline: 'Hardware-accelerated edge neural network classifying synthetic telemetry and biometric micro-expressions.',
            env: 'Ubuntu 24.04 • PyTorch 2.3 • TensorRT • CUDA 12',
            perf: '144 FPS inference • 3.2ms edge tensor latency',
            status: 'Active • Synthetic Neural Testing',
            desc: 'A real-time deep learning computer vision pipeline engineered to ingest raw camera frames, extract feature tensors via custom quantized convolutional layers, and detect spatial telemetry vectors at sustained 144 FPS with low GPU thermal headroom.',
            features: [
                'FP16 mixed-precision tensor optimization accelerating inference on NVIDIA silicon.',
                'Asynchronous frame decoding pipeline eliminating OpenCV thread blocking.',
                'Custom loss function prioritizing synthetic spatial alignment and landmark confidence.',
                'Real-time WebSocket streaming of detection bounding boxes and confidence heatmaps.'
            ],
            fileName: 'NeuroPulseInference.py',
            code: 'import torch\nimport cv2\n\nclass NeuroPulseDetector:\n    def __init__(self, model_weights: str):\n        self.device = torch.device("cuda" if torch.cuda.is_available() else "cpu")\n        self.model = torch.jit.load(model_weights).to(self.device).eval()\n        self.stream = torch.cuda.Stream()\n\n    @torch.inference_mode()\n    def process_frame(self, frame_bgr):\n        tensor = torch.from_numpy(frame_bgr).permute(2, 0, 1).unsqueeze(0).to(self.device, non_blocking=True).float() / 255.0\n        with torch.cuda.stream(self.stream):\n            predictions = self.model(tensor)\n            self.stream.synchronize()\n        return predictions.squeeze(0).cpu().numpy()',
            tech: ['Python 3.12', 'PyTorch', 'CUDA', 'TensorRT', 'OpenCV']
        },
        quantummesh: {
            id: 'SYS.001 // NETWORK_DAEMON',
            category: 'Python / Go / Linux',
            title: 'QuantumMesh Zero-Trust Tunnel',
            tagline: 'Autonomous mesh routing daemon managing dynamic encrypted WireGuard tunnels and gateway health checks.',
            env: 'Debian Linux • Systemd Daemon • WireGuard Kernel Module',
            perf: '<5ms failover • Sub-0.1% CPU background footprint',
            status: 'Active • 24/7 Homelab Mesh',
            desc: 'An automated network mesh manager running as a persistent daemon. Continuously monitors route latency across multiple WAN and satellite links, orchestrating instantaneous failover between primary WireGuard endpoints and fallback encrypted mesh peers without dropping active socket connections.',
            features: [
                'Non-blocking asyncio heartbeat monitoring with sub-second route degradation detection.',
                'Automated Linux kernel routing table manipulation via netlink socket interfaces.',
                'Encrypted zero-trust key rotation daemon coordinating with remote homelab nodes.',
                'Integrated DNS sinkhole verification ensuring zero unencrypted DNS leaks.'
            ],
            fileName: 'QuantumMeshDaemon.py',
            code: 'import asyncio\nimport subprocess\n\nasync def probe_endpoint_latency(endpoint_ip: str) -> float:\n    proc = await asyncio.create_subprocess_exec(\n        "ping", "-c", "1", "-W", "1", endpoint_ip,\n        stdout=subprocess.PIPE, stderr=subprocess.PIPE\n    )\n    stdout, _ = await proc.communicate()\n    return parse_ping_latency(stdout.decode())\n\nasync def monitor_mesh_routes(nodes):\n    while True:\n        results = await asyncio.gather(*(probe_endpoint_latency(n.ip) for n in nodes))\n        best_node = min(zip(nodes, results), key=lambda x: x[1])\n        if best_node[0].needs_switch():\n            apply_kernel_route(best_node[0].gateway)\n        await asyncio.sleep(5)',
            tech: ['Python 3', 'WireGuard', 'Linux Kernel', 'Netlink', 'Networking']
        },
        cyberterm: {
            id: 'WEB.001 // WASM_SHELL',
            category: 'WebAssembly / WebDev',
            title: 'CyberTerm x64 Shell',
            tagline: 'In-browser WebAssembly virtual machine executing an interactive retro Unix terminal with CRT phosphor shaders.',
            env: 'HTML5 Canvas • WebAssembly C++ Core • Web Audio API',
            perf: '60 FPS WebGL CRT post-processing • <15ms key response',
            status: 'Active • Interactive Web Engine',
            desc: 'A full-featured virtual shell embedded directly in modern browsers. Powered by a WebAssembly-compiled C++ command parser, it features a mock in-memory virtual filesystem, piped command syntax (cat | grep), programmable color schemes, and authentic retro green phosphor scanline GLSL shaders.',
            features: [
                'WebAssembly virtual environment simulating POSIX terminal input and output streams.',
                'Interactive CRT phosphor shader simulating scanline curvature and Bloom filters.',
                'Real-time retro terminal sound synthesizer using Web Audio API oscillator nodes.',
                'Hierarchical virtual file system supporting mkdir, touch, cat, and grep commands.'
            ],
            fileName: 'VirtualTerminalCore.js',
            code: 'class VirtualTerminal {\n    constructor(canvasEl) {\n        this.ctx = canvasEl.getContext("2d");\n        this.vfs = new VirtualFileSystem();\n        this.audioSynth = new TerminalKeyclickAudio();\n    }\n\n    executeCommand(input) {\n        this.audioSynth.playKeystroke();\n        const [cmd, ...args] = input.trim().split(" ");\n        switch(cmd) {\n            case "sysinfo": return this.renderTelemetryHUD();\n            case "cat":     return this.vfs.readFile(args[0]);\n            case "clear":   return this.clearScreen();\n            default:        return "command not found: " + cmd + ". Type \"help\" for nodes.";\n        }\n    }\n}',
            tech: ['WebAssembly', 'HTML5 Canvas', 'Web Audio API', 'JavaScript', 'CSS Shaders']
        },
        chronosdb: {
            id: 'CPP.002 // TIMESERIES_ENGINE',
            category: 'C++20 / Storage',
            title: 'Chronos Time-Series DB',
            tagline: 'Lock-free in-memory time-series database ingesting millions of sensor telemetry ticks via ring buffers.',
            env: 'Linux / Windows x64 • AVX-512 Vectorization • HugePages',
            perf: '12.5M ticks/sec ingestion • Zero mutex contention',
            status: 'Operational • Systems Research',
            desc: 'A specialized in-memory database built from the ground up for high-frequency telemetry ingestion. Utilizes lock-free single-producer single-consumer ring buffers, cache-line padding to avoid false sharing, and AVX2/AVX-512 SIMD vectorization to compute running averages and anomalies in real-time.',
            features: [
                'Lock-free atomic circular ring buffer eliminating thread lock stalls.',
                'AVX-512 SIMD vectorized aggregations computing moving averages across millions of records.',
                'Cache-line 64-byte alignment ensuring optimal CPU cache fill line utilization.',
                'Memory-mapped disk persistence with asynchronous write-behind flushes.'
            ],
            fileName: 'ChronosRingBuffer.hpp',
            code: '#include <atomic>\n#include <immintrin.h>\n\ntemplate<typename T, size_t Capacity>\nclass LockFreeTelemetryBuffer {\n    static_assert((Capacity & (Capacity - 1)) == 0, "Capacity must be power of 2");\n    alignas(64) std::atomic<size_t> m_head{0};\n    alignas(64) std::atomic<size_t> m_tail{0};\n    alignas(64) T m_buffer[Capacity];\n\npublic:\n    bool Push(const T& item) noexcept {\n        size_t head = m_head.load(std::memory_order_relaxed);\n        if (head - m_tail.load(std::memory_order_acquire) >= Capacity) return false;\n        m_buffer[head & (Capacity - 1)] = item;\n        m_head.store(head + 1, std::memory_order_release);\n        return true;\n    }\n};',
            tech: ['C++20', 'AVX-512', 'Atomics', 'Lock-Free', 'High-Concurrency']
        },
        omnithread: {
            id: 'CS.002 // CONCURRENCY_CORE',
            category: 'C# / Concurrency',
            title: 'OmniThread Engine',
            tagline: 'Custom task scheduler and priority thread dispatcher with work-stealing algorithms and telemetry hooks.',
            env: '.NET 8 / 9 Runtime • Multi-core Workstation • High-Load Daemon',
            perf: 'Zero worker thread starvation • Sub-microsecond task dispatch',
            status: 'Operational • Systems Framework',
            desc: 'An advanced concurrent runtime scheduler built to manage computational workloads across heterogeneous CPU topologies. Employs work-stealing queues to balance bursty processing loads across available cores, exposing live execution metrics via event counters.',
            features: [
                'Work-stealing double-ended queues minimizing lock contention among worker threads.',
                'Dynamic thread pool scaling adapting to hardware concurrency and load pressure.',
                'Prioritized task pipelines ensuring critical telemetry jobs bypass standard tasks.',
                'Integrated EventCounter telemetry exporting CPU utilization and queue depths.'
            ],
            fileName: 'WorkStealingScheduler.cs',
            code: 'public sealed class WorkStealingScheduler : TaskScheduler\n{\n    private readonly BlockingCollection<Task>[] _queues;\n\n    protected override void QueueTask(Task task)\n    {\n        int idealCore = Thread.GetCurrentProcessorId() % _queues.Length;\n        if (!_queues[idealCore].TryAdd(task))\n        {\n            _queues[0].Add(task);\n        }\n    }\n}',
            tech: ['C# .NET 8', 'Concurrency', 'Threading', 'Work-Stealing', 'Diagnostics']
        },
        hyperbus: {
            id: 'CS.003 // DISTRIBUTED_BUS',
            category: 'C# / Microservices',
            title: 'HyperBus Service Broker',
            tagline: 'Zero-allocation pub/sub event bus supporting RPC serialization over shared memory and loopback sockets.',
            env: '.NET 8 / 9 • MemoryMappedFiles • Shared Memory IPC',
            perf: '2.4M msg/s throughput • Zero GC allocation on hot paths',
            status: 'Active • Distributed Core',
            desc: 'A lightweight inter-process communication message bus built for local services and microservices. Leverages memory-mapped files and binary zero-copy serialization to achieve ultra-high message throughput without incurring garbage collection pauses.',
            features: [
                'Zero-allocation binary message encoding using Span<byte> and Memory<T>.',
                'Shared-memory ring buffers enabling instantaneous cross-process data transfers.',
                'Topic-based publisher/subscriber model with dead-letter queue recovery.',
                'Built-in health watchdog and latency tracking per subscriber channel.'
            ],
            fileName: 'HyperBusChannel.cs',
            code: 'public sealed class HyperBusPublisher\n{\n    private readonly MemoryMappedViewAccessor _sharedMem;\n\n    public unsafe void PublishEvent<T>(int topicId, ref T payload) where T : unmanaged\n    {\n        byte* ptr = null;\n        _sharedMem.SafeMemoryMappedViewHandle.AcquirePointer(ref ptr);\n        try {\n            Buffer.MemoryCopy(&payload, ptr + (topicId * 256), sizeof(T), sizeof(T));\n        } finally {\n            _sharedMem.SafeMemoryMappedViewHandle.ReleasePointer();\n        }\n    }\n}',
            tech: ['C#', 'IPC', 'gRPC', 'Zero-Allocation', 'High-Performance']
        },
        aeroui: {
            id: 'CS.004 // GPU_UI_KIT',
            category: 'C# / UI Engine',
            title: 'AeroUI Fluent Component Kit',
            tagline: 'GPU-accelerated desktop UI control system bringing glassmorphic blur and retrofuturistic HUD styling to WPF.',
            env: 'Windows 10/11 • WPF Direct3D Interop • Custom XAML Templates',
            perf: '60 FPS compositing • Real-time hardware composition blur',
            status: 'Active • UI/UX Design System',
            desc: 'A comprehensive modern design toolkit for enterprise C# Windows desktop software. Integrates Windows DWM composition APIs to render authentic acrylic glassmorphism, glowing cyan/amber telemetry gauges, and responsive vector controls.',
            features: [
                'DirectX-accelerated frosted glass backdrop filters rendered inside WPF viewports.',
                'High-contrast theme tokens adhering to modern industrial design standards.',
                'Custom HUD telemetry dials, linear progress indicators, and hex-grid graphs.',
                'Interactive window controls with smooth minimize, maximize, and drag physics.'
            ],
            fileName: 'AeroGlassPanel.cs',
            code: 'public class AeroGlassPanel : ContentControl\n{\n    public static readonly DependencyProperty BlurRadiusProperty =\n        DependencyProperty.Register(nameof(BlurRadius), typeof(double), typeof(AeroGlassPanel), new PropertyMetadata(20.0));\n\n    protected override void OnRender(DrawingContext dc)\n    {\n        base.OnRender(dc);\n        dc.DrawRectangle(new SolidColorBrush(Color.FromArgb(180, 14, 18, 26)), null, new Rect(RenderSize));\n    }\n}',
            tech: ['C# WPF', 'DirectX', 'Glassmorphism', 'UI Components', 'Custom XAML']
        },
        spectercrawler: {
            id: 'PY.003 // DISTRIBUTED_SCRAPER',
            category: 'Python / Scraper',
            title: 'Specter Async Deep Scraper',
            tagline: 'Distributed asynchronous web scraping pipeline with automatic rotating proxy pools and TLS fingerprint spoofing.',
            env: 'Python 3.12 • AsyncIO • Aiohttp • Redis Distributed Queue',
            perf: '5,000 req/s throughput • Automated CAPTCHA evasion',
            status: 'Active • Data Pipeline',
            desc: 'A high-throughput distributed crawling engine designed for large-scale data ingestion. Employs asynchronous coroutine pools, automatic user-agent and JA3 TLS fingerprint spoofing, and Redis-backed state queues to bypass rate limits and anti-bot defenses.',
            features: [
                'Asynchronous connection pooling maintaining thousands of active HTTP sessions.',
                'Dynamic JA3 TLS fingerprint randomized rotation preventing cloud anti-bot blocks.',
                'Distributed deduplication index utilizing Redis bloom filters.',
                'Real-time structured HTML extraction with automatic schema inference.'
            ],
            fileName: 'SpecterCrawler.py',
            code: 'import aiohttp\nimport asyncio\n\nasync def fetch_worker(queue, session):\n    while not queue.empty():\n        url = await queue.get()\n        try:\n            async with session.get(url, timeout=5) as response:\n                html = await response.text()\n                parse_telemetry_schema(html)\n        finally:\n            queue.task_done()',
            tech: ['Python 3.12', 'AsyncIO', 'Aiohttp', 'Redis', 'Web Scraping']
        },
        packetsnoop: {
            id: 'PY.004 // NETSEC_ANALYZER',
            category: 'Python / NetSec',
            title: 'PacketSnoop Protocol Sniffer',
            tagline: 'Raw socket network sniffer performing deep packet inspection, TCP stream reassembly, and TLS handshake decryption.',
            env: 'Linux / Scapy Core • Raw Socket AF_PACKET • PCAP Parser',
            perf: 'Zero-copy packet capture • Sustained 1Gbps link inspection',
            status: 'Operational • NetSec Testing',
            desc: 'A network forensics utility that captures raw Ethernet frames directly from the kernel network stack. Decodes protocol layers from IP down to payload data, reassembles TCP sessions, and identifies suspicious packet bursts or DNS tunneling attempts.',
            features: [
                'Kernel-level raw socket packet interception with zero memory duplication.',
                'Automatic reassembly of fragmented TCP packets and session stream reconstruction.',
                'Heuristic anomaly detector flagging port scan sweeps and rogue DHCP responses.',
                'Export engine supporting industry-standard PCAP format and JSON streaming.'
            ],
            fileName: 'PacketSnoopCore.py',
            code: 'import socket\nimport struct\n\ndef capture_raw_ethernet():\n    raw_socket = socket.socket(socket.AF_PACKET, socket.SOCK_RAW, socket.ntohs(0x0003))\n    while True:\n        packet_data, _ = raw_socket.recvfrom(65535)\n        eth_header = packet_data[:14]\n        dest_mac, src_mac, proto = struct.unpack("!6s6sH", eth_header)\n        if proto == 0x0800:\n            analyze_ip_payload(packet_data[14:])',
            tech: ['Python 3', 'Raw Sockets', 'Network Security', 'PCAP', 'Protocol Forensics']
        },
        spectraviz: {
            id: 'WEB.002 // 3D_AUDIO_GL',
            category: 'WebGL / WebDev',
            title: 'Spectra 3D Audio Visualizer',
            tagline: 'Hardware-accelerated 3D audio frequency visualizer rendering real-time FFT spectrum bars with custom GLSL shaders.',
            env: 'Three.js • Web Audio API • WebGL 2.0 • GLSL Fragment Shaders',
            perf: '120Hz smooth animations • Low audio latency (<10ms)',
            status: 'Active • Creative Web Tech',
            desc: 'A dynamic 3D web graphics application that transforms microphone or audio inputs into an interactive holographic waveform. Computes live Fast Fourier Transform (FFT) frequency bands and feeds them into custom GLSL vertex and fragment shaders for chromatic aberration and neon dispersion.',
            features: [
                'Web Audio API AnalyserNode computing 2048-point Fast Fourier Transform (FFT) bins.',
                'Custom Three.js shader materials with animated wave displacement and Bloom glows.',
                'Interactive camera orbit controls responding to mouse and gyroscope movement.',
                'Dynamic palette shifting responding to bass frequency peaks and transients.'
            ],
            fileName: 'SpectraAudioVisualizer.js',
            code: 'const audioCtx = new AudioContext();\nconst analyser = audioCtx.createAnalyser();\nanalyser.fftSize = 2048;\nconst freqData = new Uint8Array(analyser.frequencyBinCount);\n\nfunction renderLoop() {\n    requestAnimationFrame(renderLoop);\n    analyser.getByteFrequencyData(freqData);\n    meshMaterial.uniforms.u_frequencies.value = freqData;\n    renderer.render(scene, camera);\n}',
            tech: ['Three.js', 'WebGL', 'Web Audio API', 'GLSL', 'Interactive 3D']
        },
        nexuschat: {
            id: 'WEB.003 // P2P_MESSAGING',
            category: 'WebRTC / Sockets',
            title: 'Nexus Protocol P2P Chat',
            tagline: 'End-to-end encrypted peer-to-peer browser messenger with ephemeral rooms, WebRTC data channels, and zero logs.',
            env: 'WebRTC DataChannels • WebCrypto API • WebSocket Signaling',
            perf: 'P2P sub-20ms latency • AES-GCM-256 cipher encryption',
            status: 'Active • Decentralized Web Lab',
            desc: 'A browser-based decentralized communication system. Establishes direct peer-to-peer data pipes between clients using WebRTC without routing message contents through central servers. All messages are encrypted locally using cryptographic keys negotiated via ECDH exchange.',
            features: [
                'Direct browser-to-browser WebRTC DataChannel architecture with zero server logging.',
                'End-to-end encryption using AES-GCM-256 with ephemeral cryptographic keypairs.',
                'Chunked peer-to-peer file transfer engine with checksum verification.',
                'Real-time typing presence and room status indicators.'
            ],
            fileName: 'NexusPeerSession.js',
            code: 'class PeerSession {\n    constructor() {\n        this.pc = new RTCPeerConnection({ iceServers: [{ urls: "stun:stun.l.google.com:19302" }] });\n        this.dataChannel = this.pc.createDataChannel("nexus_p2p_channel");\n        this.dataChannel.onmessage = (e) => this.decryptAndDisplay(e.data);\n    }\n\n    async sendSecureMessage(plainText) {\n        const encrypted = await CryptoEngine.encryptAES(plainText, this.sharedSecret);\n        this.dataChannel.send(encrypted);\n    }\n}',
            tech: ['WebRTC', 'WebCrypto API', 'WebSockets', 'P2P', 'Privacy']
        },
        glassos: {
            id: 'WEB.004 // WEB_OS_DESKTOP',
            category: 'CSS Glass / Vanilla JS',
            title: 'Glassmorphic OS Dashboard',
            tagline: 'Desktop-class responsive web workspace featuring draggable floating windows, minimize trays, and live HUD widgets.',
            env: 'Vanilla JavaScript • CSS Grid • Hardware Backdrop Blur',
            perf: 'Zero external frameworks • Sub-16ms layout recalculations',
            status: 'Active • Web Interface Lab',
            desc: 'An in-browser operating system simulation demonstrating the capabilities of modern CSS Grid and vanilla JavaScript. Features floating window management, window snapping, minimize/maximize physics, dock status indicators, and persistent widget preferences.',
            features: [
                'Custom multi-window manager supporting drag, resize, z-index elevation, and minimization.',
                'Modular CSS Grid Bento layouts adapting fluidly from 4K displays to mobile screens.',
                'State persistence storing window positions and custom settings in LocalStorage.',
                'Zero external runtime dependencies ensuring instant page delivery and optimal performance.'
            ],
            fileName: 'WindowManager.js',
            code: 'class WindowManager {\n    static bringToFront(winEl) {\n        const topZ = Math.max(...Array.from(document.querySelectorAll(".os-window")).map(w => parseInt(w.style.zIndex || 10)));\n        winEl.style.zIndex = topZ + 1;\n    }\n\n    static toggleMinimize(winEl) {\n        winEl.classList.toggle("is-minimized");\n        const isCollapsed = winEl.classList.contains("is-minimized");\n        winEl.querySelector(".window-body").style.display = isCollapsed ? "none" : "block";\n    }\n}',
            tech: ['Vanilla JS', 'CSS Grid', 'Glassmorphism', 'Window Controls', 'Responsive']
        },
        vortex8: {
            id: 'CPP.003 // EMULATION_CORE',
            category: 'C++ / Emulation',
            title: 'Vortex-8 Hardware Emulator',
            tagline: 'Cycle-accurate virtual CPU emulator featuring opcode disassembler, memory debugger, and 60 FPS video synthesizer.',
            env: 'C++17 • SDL2 Library • Virtual Machine Core',
            perf: '100% cycle-accurate opcode timing • 60 FPS video sync',
            status: 'Operational • Systems Research',
            desc: 'A complete virtual microprocessor and hardware system emulator written in C++17. Faithfully recreates the instruction fetch-decode-execute cycle, 16 8-bit registers, 4KB memory space, timer delays, and monochromatic screen graphics with integrated audio beeper.',
            features: [
                'Full implementation of 35 standard CPU opcodes with bitwise flag validation.',
                'Integrated interactive disassembly viewer and live memory register hex inspector.',
                'Audio tone synthesizer generating accurate square wave sound pulses via SDL2.',
                'Cycle-accurate execution loop calibrated with high-resolution CPU clocks.'
            ],
            fileName: 'VortexCpuCore.cpp',
            code: 'void VortexCpu::Cycle() {\n    uint16_t opcode = (memory[pc] << 8) | memory[pc + 1];\n    pc += 2;\n    switch (opcode & 0xF000) {\n        case 0xA000: indexRegister = opcode & 0x0FFF; break;\n        case 0x6000: V[(opcode & 0x0F00) >> 8] = opcode & 0x00FF; break;\n        case 0xD000: DrawSprite(V[(opcode & 0x0F00) >> 8], V[(opcode & 0x00F0) >> 4], opcode & 0x000F); break;\n    }\n}',
            tech: ['C++17', 'SDL2', 'Virtual Machine', 'Emulation', 'Computer Architecture']
        },
        simdmath: {
            id: 'CPP.004 // SIMD_VECTOR_MATH',
            category: 'C++20 / SIMD',
            title: 'SIMD Vector Math Engine',
            tagline: 'Hardware-intrinsics vectorized matrix math library accelerating 4x4 coordinate transformations with AVX2.',
            env: 'C++20 • AVX2 / FMA Intrinsics • Clang / MSVC',
            perf: '8x throughput increase over scalar math • Zero cache misses',
            status: 'Operational • High-Performance Math',
            desc: 'A vectorized mathematics library designed for game engines and physics simulations. Replaces traditional loop-based matrix multiplications and vector normalizations with single-instruction multiple-data (SIMD) hardware intrinsic instructions, processing 4 coordinate sets simultaneously.',
            features: [
                'AVX2 and Fused Multiply-Add (FMA) assembly intrinsic implementation.',
                'Sub-nanosecond 4x4 matrix multiplication and vector dot product calculations.',
                'Cache-aligned memory storage preventing unaligned load penalties.',
                'Comprehensive automated test suite benchmarking against standard scalar math routines.'
            ],
            fileName: 'SimdMatrix4x4.hpp',
            code: '#include <immintrin.h>\n\nstruct alignas(32) Mat4x4 {\n    __m256 cols[2];\n\n    static Mat4x4 Multiply(const Mat4x4& a, const Mat4x4& b) noexcept {\n        Mat4x4 result;\n        __m256 row0 = _mm256_load_ps((const float*)&a.cols[0]);\n        __m256 row1 = _mm256_load_ps((const float*)&a.cols[1]);\n        result.cols[0] = _mm256_fmadd_ps(row0, b.cols[0], result.cols[0]);\n        result.cols[1] = _mm256_fmadd_ps(row1, b.cols[1], result.cols[1]);\n        return result;\n    }\n};',
            tech: ['C++20', 'AVX2', 'Intrinsics', 'Linear Algebra', 'High-Performance']
        }
    };

    // Open Project Inspector Modal
    // SVG Icon Helper for Dynamic Project Modals & Badges
    function getTechSvgIcon(name) {
        if (!name) return '';
        const n = name.toLowerCase();

        if (n.includes('c#') || n.includes('.net')) {
            return '<svg class="tech-icon-svg" viewBox="0 0 24 24" fill="none"><path d="M12 2L3 7.2v9.6L12 22l9-5.2V7.2L12 2z" stroke="#A855F7" stroke-width="1.8" fill="rgba(168, 85, 247, 0.15)"/><path d="M9.5 8.8c-.9 0-1.8.8-1.8 2.7s.9 2.7 1.8 2.7c.6 0 1.1-.3 1.4-.7" stroke="#A855F7" stroke-width="1.8" stroke-linecap="round"/><path d="M14 9.5v5M16.5 9.5v5M13 11h4.5M13 13h4.5" stroke="#A855F7" stroke-width="1.2" stroke-linecap="round"/></svg>';
        }
        if (n.includes('c++')) {
            return '<svg class="tech-icon-svg" viewBox="0 0 24 24" fill="none"><path d="M12 2L3 7.2v9.6L12 22l9-5.2V7.2L12 2z" stroke="#00A4EF" stroke-width="1.8" fill="rgba(0, 164, 239, 0.15)"/><path d="M9.5 8.8c-.9 0-1.8.8-1.8 2.7s.9 2.7 1.8 2.7c.6 0 1.1-.3 1.4-.7" stroke="#00A4EF" stroke-width="1.8" stroke-linecap="round"/><path d="M13 12h2.5M14.2 10.7v2.6M17 12h2.5M18.2 10.7v2.6" stroke="#00E5FF" stroke-width="1.3" stroke-linecap="round"/></svg>';
        }
        if (n.includes('python')) {
            return '<svg class="tech-icon-svg" viewBox="0 0 24 24" fill="none"><path d="M11.9 2c-3.1 0-5 .9-5 2.6v2.2h5.1v.7H4.7C3 7.5 2 9.2 2 11.8c0 2.5 1.1 4.2 2.7 4.2h1.6v-2.3c0-1.8 1.5-3.3 3.3-3.3h5.2c1.4 0 2.6-1.1 2.6-2.5V4.6C17.4 3 15.3 2 11.9 2zm-1.8 1.5c.5 0 .9.4.9.9s-.4.9-.9.9-.9-.4-.9-.9.4-.9.9-.9z" fill="#387EB8"/><path d="M12.1 22c3.1 0 5-.9 5-2.6v-2.2H12v-.7h7.3c1.7 0 2.7-1.7 2.7-4.3 0-2.5-1.1-4.2-2.7-4.2h-1.6v2.3c0 1.8-1.5 3.3-3.3 3.3H8.7c-1.4 0-2.6 1.1-2.6 2.5v3.3c0 1.6 2.1 2.6 6 2.6zm1.8-1.5c-.5 0-.9-.4-.9-.9s.4-.9.9-.9.9.4.9.9-.4.9-.9.9z" fill="#FFD43B"/></svg>';
        }
        if (n.includes('wasm') || n.includes('webassembly')) {
            return '<svg class="tech-icon-svg" viewBox="0 0 24 24" fill="none"><rect width="20" height="20" x="2" y="2" rx="3" fill="#654FF0"/><path d="M5 8.5l2.5 7L10 8.5l2.5 7L15 8.5" stroke="#FFFFFF" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><path d="M17 12l2 3.5" stroke="#FFFFFF" stroke-width="1.8" stroke-linecap="round"/></svg>';
        }
        if (n.includes('javascript') || n.includes('js')) {
            return '<svg class="tech-icon-svg" viewBox="0 0 24 24" fill="none"><rect width="20" height="20" x="2" y="2" rx="3" fill="#F7DF1E"/><path d="M8 12.5v4.5c0 1-.7 1.4-1.7 1.4-.7 0-1.3-.3-1.6-.7l.9-1c.2.2.4.4.7.4.3 0 .4-.2.4-.5v-3.7H8zm8.5 0c1 0 1.8.6 1.8 1.6 0 .7-.4 1.2-1 1.4l-.8.3c-.4.1-.6.3-.6.6 0 .3.3.4.6.4.4 0 .8-.2 1-.5l.8 1c-.5.5-1.1.7-1.8.7-1.2 0-2-.7-2-1.8 0-.7.4-1.3 1.1-1.5l.8-.3c.4-.1.5-.3.5-.5 0-.3-.3-.4-.6-.4-.3 0-.7.2-.9.4l-.8-1c.6-.5 1.2-.8 1.8-.8z" fill="#000000"/></svg>';
        }
        if (n.includes('html')) {
            return '<svg class="tech-icon-svg" viewBox="0 0 24 24" fill="none"><path d="M3 2l1.6 18.5L12 23l7.4-2.5L21 2H3z" fill="#E44D26"/><path d="M12 3.7v17.4l5.9-2 1.4-15.4H12z" fill="#F16529"/><path d="M12 7.7H7.7l.3 3.3H12v-3.3zm0 5.6H9.7l.2 2.3 2.1.6v-2.9z" fill="#EBEBEB"/><path d="M12 7.7h4.3l-.4 4.5h-3.9v3.3l-2.1-.6-.1-1.5H8.3l.3 3.2 3.4.9 3.4-.9.4-4.8.1-1.3.3-3.6H12v.7z" fill="#FFFFFF"/></svg>';
        }
        if (n.includes('css')) {
            return '<svg class="tech-icon-svg" viewBox="0 0 24 24" fill="none"><path d="M3 2l1.6 18.5L12 23l7.4-2.5L21 2H3z" fill="#1572B6"/><path d="M12 3.7v17.4l5.9-2 1.4-15.4H12z" fill="#33A9DC"/><path d="M12 7.7H7.7l.3 3.3H12v-3.3zm0 5.6H9.7l.2 2.3 2.1.6v-2.9z" fill="#EBEBEB"/><path d="M12 7.7h4.3l-.4 4.5h-3.9v3.3l-2.1-.6-.1-1.5H8.3l.3 3.2 3.4.9 3.4-.9.4-4.8.1-1.3.3-3.6H12v.7z" fill="#FFFFFF"/></svg>';
        }
        if (n.includes('wpf') || n.includes('windows') || n.includes('directx')) {
            return '<svg class="tech-icon-svg" viewBox="0 0 24 24" fill="#0078D4"><path d="M3 4.2l7.5-1v8.3H3V4.2zm0 8.3h7.5v8.3L3 19.8v-7.3zm8.5-9.4L21 2v9.5h-9.5V3.1zm0 9.4H21V22l-9.5-1.3v-8.2z"/></svg>';
        }
        if (n.includes('sqlite') || n.includes('mysql') || n.includes('sql') || n.includes('db') || n.includes('storage')) {
            return '<svg class="tech-icon-svg" viewBox="0 0 24 24" fill="none" stroke="#00758F" stroke-width="1.8"><ellipse cx="12" cy="5" rx="8" ry="3" fill="rgba(0, 117, 143, 0.2)"/><path d="M4 5v6c0 1.66 3.58 3 8 3s8-1.34 8-3V5"/><path d="M4 11v6c0 1.66 3.58 3 8 3s8-1.34 8-3v-6"/></svg>';
        }
        if (n.includes('pytorch')) {
            return '<svg class="tech-icon-svg" viewBox="0 0 24 24" fill="none"><path d="M13 2.5a6 6 0 0 0-6 6c0 1.6.6 3 1.6 4.1L7 14.2a8 8 0 1 1 11.3 0l-1.6-1.6a6 6 0 0 0 1.6-4.1 6 6 0 0 0-5.3-6z" fill="#EE4C2C"/><circle cx="15.5" cy="5" r="1.5" fill="#EE4C2C"/></svg>';
        }
        if (n.includes('cuda') || n.includes('tensorrt') || n.includes('nvidia')) {
            return '<svg class="tech-icon-svg" viewBox="0 0 24 24" fill="none"><path d="M3 12c0-5 4-9 9-9 4.5 0 8.3 3.3 9 7.8-.3-1.6-1.7-2.8-3.4-2.8-2 0-3.6 1.6-3.6 3.6 0 1.2.6 2.3 1.5 2.9-1.2 1-2.8 1.5-4.5 1.5-4 0-7-3-7-7z" stroke="#76B900" stroke-width="1.8" fill="rgba(118, 185, 0, 0.15)"/><circle cx="12" cy="12" r="2.5" fill="#76B900"/></svg>';
        }
        if (n.includes('opencv')) {
            return '<svg class="tech-icon-svg" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="7" r="4" stroke="#EA2D2E" stroke-width="2"/><circle cx="7" cy="16" r="4" stroke="#2496ED" stroke-width="2"/><circle cx="17" cy="16" r="4" stroke="#39FF14" stroke-width="2"/></svg>';
        }
        if (n.includes('tailscale')) {
            return '<svg class="tech-icon-svg" viewBox="0 0 24 24" fill="none"><circle cx="6" cy="12" r="2.5" fill="#2E3440" stroke="#4C566A" stroke-width="1.2"/><circle cx="12" cy="12" r="3" fill="#00C48C"/><circle cx="18" cy="12" r="2.5" fill="#2E3440" stroke="#4C566A" stroke-width="1.2"/><circle cx="12" cy="6" r="2.5" fill="#2E3440" stroke="#4C566A" stroke-width="1.2"/><circle cx="12" cy="18" r="2.5" fill="#2E3440" stroke="#4C566A" stroke-width="1.2"/><line x1="8.5" y1="12" x2="9" y2="12" stroke="#00C48C" stroke-width="1.5"/><line x1="15" y1="12" x2="15.5" y2="12" stroke="#00C48C" stroke-width="1.5"/><line x1="12" y1="8.5" x2="12" y2="9" stroke="#00C48C" stroke-width="1.5"/><line x1="12" y1="15" x2="12" y2="15.5" stroke="#00C48C" stroke-width="1.5"/></svg>';
        }
        if (n.includes('wireguard') || n.includes('crypto')) {
            return '<svg class="tech-icon-svg" viewBox="0 0 24 24" fill="none"><path d="M12 2L4 6v6c0 5.5 3.4 10.7 8 12 4.6-1.3 8-6.5 8-12V6l-8-4z" stroke="#88171A" stroke-width="1.8" fill="rgba(136, 23, 26, 0.15)"/><path d="M9 12c1-2 2-3 3-3s2 1 3 3-1 3-3 3-2-1-3-3z" stroke="#FF414D" stroke-width="1.6"/><circle cx="12" cy="12" r="1.5" fill="#FF414D"/></svg>';
        }
        if (n.includes('three.js') || n.includes('webgl') || n.includes('glsl')) {
            return '<svg class="tech-icon-svg" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="1.8"><polygon points="12 2 2 19.5 22 19.5"/><polygon points="12 2 12 19.5 2 19.5"/><line x1="12" y1="11" x2="22" y2="19.5"/></svg>';
        }
        if (n.includes('webrtc')) {
            return '<svg class="tech-icon-svg" viewBox="0 0 24 24" fill="none" stroke="#3399FF" stroke-width="1.8"><circle cx="6" cy="12" r="3" fill="rgba(51, 153, 255, 0.2)"/><circle cx="18" cy="6" r="3" fill="rgba(51, 153, 255, 0.2)"/><circle cx="18" cy="18" r="3" fill="rgba(51, 153, 255, 0.2)"/><path d="M8.5 10.5l7-3M8.5 13.5l7 3" stroke-dasharray="2 2"/></svg>';
        }
        if (n.includes('network') || n.includes('socket') || n.includes('pcap') || n.includes('grpc') || n.includes('ipc') || n.includes('mesh')) {
            return '<svg class="tech-icon-svg" viewBox="0 0 24 24" fill="none" stroke="#00E5FF" stroke-width="1.6"><circle cx="12" cy="12" r="9"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 3a15 15 0 0 1 0 18M12 3a15 15 0 0 0 0 18"/></svg>';
        }
        if (n.includes('simd') || n.includes('avx') || n.includes('thread') || n.includes('ring-0') || n.includes('bare-metal') || n.includes('asm') || n.includes('sdl2') || n.includes('hardware') || n.includes('intrinsics') || n.includes('atomics')) {
            return '<svg class="tech-icon-svg" viewBox="0 0 24 24" fill="none" stroke="#39FF14" stroke-width="1.6"><rect x="5" y="5" width="14" height="14" rx="2" fill="rgba(57, 255, 20, 0.08)"/><path d="M9 9h6v6H9zM9 1v4M15 1v4M9 19v4M15 19v4M1 9h4M1 15h4M19 9h4M19 15h4"/></svg>';
        }
        // Generic code tag
        return '<svg class="tech-icon-svg" viewBox="0 0 24 24" fill="none" stroke="#FF4545" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>';
    }

    function openProjectModal(projectId) {
        const data = PROJECTS_DB[projectId];
        if (!data || !projectModalBackdrop) return;

        if (modalProjectId) modalProjectId.textContent = data.id;
        if (modalProjectCategory) modalProjectCategory.innerHTML = `${getTechSvgIcon(data.category)}<span>${data.category}</span>`;
        if (modalProjectTitle) modalProjectTitle.textContent = data.title;
        if (modalProjectTagline) modalProjectTagline.textContent = data.tagline;
        if (modalProjectEnv) modalProjectEnv.textContent = data.env;
        if (modalProjectPerf) modalProjectPerf.textContent = data.perf;
        if (modalProjectStatus) modalProjectStatus.textContent = data.status;
        if (modalProjectDesc) modalProjectDesc.textContent = data.desc;
        if (modalCodeFileName) modalCodeFileName.textContent = data.fileName;
        if (modalProjectCode) modalProjectCode.textContent = data.code;

        // Populate Features List
        if (modalProjectFeatures) {
            modalProjectFeatures.innerHTML = '';
            data.features.forEach(feat => {
                const li = document.createElement('li');
                li.textContent = feat;
                modalProjectFeatures.appendChild(li);
            });
        }

        // Populate Tech Pills with SVG Icons
        if (modalProjectTechPills) {
            modalProjectTechPills.innerHTML = '';
            data.tech.forEach(t => {
                const pill = document.createElement('span');
                pill.className = 'skill-badge';
                const iconSvg = getTechSvgIcon(t);
                pill.innerHTML = `${iconSvg}<span>${t}</span>`;
                modalProjectTechPills.appendChild(pill);
            });
        }

        if (copyCodeText) copyCodeText.textContent = 'Copy Snippet';
        projectModalBackdrop.classList.add('active');
        projectModalBackdrop.setAttribute('aria-hidden', 'false');
    }

    function closeProjectModal() {
        if (!projectModalBackdrop) return;
        projectModalBackdrop.classList.remove('active');
        projectModalBackdrop.setAttribute('aria-hidden', 'true');
    }

    // Attach click events to project cards & inspect buttons
    document.querySelectorAll('.program-card').forEach(card => {
        const projectId = card.getAttribute('data-project-id');
        const inspectBtn = card.querySelector('.btn-inspect-project');

        if (inspectBtn && projectId) {
            inspectBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                openProjectModal(projectId);
            });
        }

        if (projectId) {
            card.addEventListener('click', (e) => {
                if (e.target.closest('a') || e.target.closest('.btn-inspect-project')) return;
                openProjectModal(projectId);
            });
        }
    });

    if (projectModalCloseBtn) projectModalCloseBtn.addEventListener('click', closeProjectModal);
    if (modalProjectCloseActionBtn) modalProjectCloseActionBtn.addEventListener('click', closeProjectModal);
    if (projectModalBackdrop) {
        projectModalBackdrop.addEventListener('click', (e) => {
            if (e.target === projectModalBackdrop) closeProjectModal();
        });
    }

    // Copy project code snippet button
    if (btnCopyProjectCode) {
        btnCopyProjectCode.addEventListener('click', async () => {
            if (!modalProjectCode) return;
            try {
                await navigator.clipboard.writeText(modalProjectCode.textContent);
                if (copyCodeText) copyCodeText.textContent = 'Copied!';
                setTimeout(() => {
                    if (copyCodeText) copyCodeText.textContent = 'Copy Snippet';
                }, 2000);
            } catch (err) {
                if (copyCodeText) copyCodeText.textContent = 'Failed';
            }
        });
    }

    // =========================================================================
    // 12. VINTAGE HARDWARE NODE TELEMETRY INSPECTOR MODAL
    // =========================================================================
    const hardwareModalBackdrop = document.getElementById('hardwareModalBackdrop');
    const hardwareModalCloseBtn = document.getElementById('hardwareModalCloseBtn');
    const hardwareModalCloseActionBtn = document.getElementById('hardwareModalCloseActionBtn');
    const modalHwNodeId = document.getElementById('modalHwNodeId');
    const modalHwTag = document.getElementById('modalHwTag');
    const modalHwTitle = document.getElementById('modalHwTitle');
    const modalHwSubtitle = document.getElementById('modalHwSubtitle');
    const modalHwSpecsMatrix = document.getElementById('modalHwSpecsMatrix');
    const modalHwLog = document.getElementById('modalHwLog');
    const modalHwOem = document.getElementById('modalHwOem');

    const HARDWARE_DB = (typeof window !== 'undefined' && window.__SERVER_HARDWARE__) ? window.__SERVER_HARDWARE__ : [
        {
            nodeId: 'NODE.01 // LAB ARCHIVE',
            tag: 'PRESERVED',
            title: 'Sony Vaio W-series VPCW115XG',
            subtitle: 'Intel Atom N280 Netbook Platform • Japanese Ultraportable Engineering',
            oem: 'OEM: Sony VAIO Corp. (Japan)',
            specs: [
                { label: 'Processor', val: 'Intel Atom N280 (1.66 GHz, 512KB Cache)' },
                { label: 'Memory', val: '1 GB DDR2-800 MHz' },
                { label: 'Display Panel', val: '10.1" WXGA (1366×768) 16:9 CCFL' },
                { label: 'Storage', val: '160 GB SATA HDD (5400 RPM)' },
                { label: 'Operating System', val: 'Windows XP Home SP3 / Debian Minimal' },
                { label: 'Lab Purpose', val: 'Legacy Micro-Terminal & Netbook Preservation' }
            ],
            log: 'Repasted with Arctic MX-4 thermal compound. CMOS battery replaced. Keyboard contact ribbon cleaned and calibrated. Retains 100% original Sony chassis aesthetics.'
        },
        {
            nodeId: 'NODE.02 // LAB ARCHIVE',
            tag: 'OPERATIONAL',
            title: "Panasonic Let's Note CF-T4GW5AXR",
            subtitle: 'Intel Pentium M ULV 753 • Magnesium Alloy Bonnet • Silent Fanless Architecture',
            oem: 'OEM: Panasonic Industrial Japan',
            specs: [
                { label: 'Processor', val: 'Intel Pentium M ULV 753 (1.20 GHz, Dothan)' },
                { label: 'Memory', val: '512 MB Micro-DIMM DDR2' },
                { label: 'Display Panel', val: '12.1" XGA (1024×768) Anti-Glare Matte' },
                { label: 'Chassis Material', val: 'Magnesium Alloy Bonnet Shock-Resistant' },
                { label: 'Cooling Design', val: '100% Fanless Silent Architecture' },
                { label: 'Lab Purpose', val: 'Silent Diagnostic Terminal & Field Mobility' }
            ],
            log: 'Original circular optical touchpad driver restored for gesture navigation. Zero moving parts silent operation verified. Battery cells tested at 82% design capacity.'
        },
        {
            nodeId: 'RIG.03 // LAB ARCHIVE',
            tag: 'DIAGNOSTIC RIG',
            title: 'HP Compaq nx6320',
            subtitle: 'Intel Core 2 Duo T5600 Platform • Native Serial & Parallel Diagnostic Terminal',
            oem: 'OEM: HP / Compaq Commercial Systems',
            specs: [
                { label: 'Processor', val: 'Intel Core 2 Duo T5600 (1.83 GHz, 2MB L2)' },
                { label: 'Memory', val: '2 GB Dual-Channel DDR2' },
                { label: 'Display Panel', val: '15.0" XGA (1024×768) 4:3 Ratio Matte' },
                { label: 'I/O Interfaces', val: 'Native RS-232 Serial & DB-25 Parallel' },
                { label: 'Operating System', val: 'Windows XP Pro SP3 / FreeDOS' },
                { label: 'Lab Purpose', val: 'Hardware EEPROM Flashing & Console Terminal' }
            ],
            log: 'Full chassis disassembly with thermal pad replacement. Native RS-232 serial port actively utilized for hardware console debugging and network switch configuration.'
        },
        {
            nodeId: 'RIG.04 // LAB ARCHIVE',
            tag: 'SLEEPER BUILD',
            title: 'HP Pavilion a6000 (Sleeper Build)',
            subtitle: 'Mid-2000s Wave-Front Aesthetic Housing Modern High-Efficiency Architecture',
            oem: 'OEM: HP Custom Sleeper Engineering',
            specs: [
                { label: 'Chassis Model', val: 'Authentic 2007 HP Pavilion a6000 Wave Front' },
                { label: 'Processor Core', val: 'Modern High-Efficiency Multi-Core Silicon' },
                { label: 'Memory', val: '32 GB High-Speed DDR4 Memory' },
                { label: 'Storage Array', val: 'NVMe Gen4 SSD + Secondary Mechanical Pool' },
                { label: 'Cooling Refit', val: 'Custom High-Flow Modular Quiet Airflow' },
                { label: 'Lab Purpose', val: 'Daily Development Workstation & Compilation Rig' }
            ],
            log: 'Front-panel audio and power headers custom-pinned to ATX standards. Internal drive bays modified for modern SSD brackets. Retains authentic retro sleeper disguise with silent thermals.'
        },
        {
            nodeId: 'NODE.05 // LAB ARCHIVE',
            tag: 'ONLINE // 24/7',
            title: 'Dell OptiPlex 3010 Homelab Server',
            tagline: 'Intel Core Host • Proxmox VE Virtualization Cluster & Gateway Node',
            subtitle: 'Intel Core Host • Proxmox VE Virtualization Cluster & Gateway Node',
            oem: 'OEM: Dell Enterprise Systems',
            specs: [
                { label: 'Processor', val: 'Intel Core Host Quad-Core Processor' },
                { label: 'Memory', val: '16 GB High-Reliability DDR3' },
                { label: 'Hypervisor', val: 'Proxmox VE 8.x (Debian Kernel)' },
                { label: 'Networking', val: 'Dual Gigabit Ethernet Interface Cards' },
                { label: 'Container Stacks', val: 'Docker, Portainer, Pi-hole, Tailscale' },
                { label: 'Lab Purpose', val: '24/7 Virtualization Host & Cluster Gateway' }
            ],
            log: 'Configured automated ZFS snapshots, Tailscale mesh subnet routing, and watchdog daemon monitoring storage health and network gateway availability.'
        },
        {
            nodeId: 'NODE.06 // LAB ARCHIVE',
            tag: 'BENCH TEST',
            title: 'Dell OptiPlex 760 USFF',
            subtitle: 'Ultra Small Form Factor Desktop • Intel Core 2 Duo E8400 Headless Node',
            oem: 'OEM: Dell Legacy Systems',
            specs: [
                { label: 'Processor', val: 'Intel Core 2 Duo E8400 @ 3.00 GHz' },
                { label: 'Memory', val: '4 GB Low-Profile DDR2-800' },
                { label: 'Form Factor', val: 'Ultra Small Form Factor (USFF) Micro' },
                { label: 'Display Output', val: 'DisplayPort / VGA Legacy Ports' },
                { label: 'Operating System', val: 'Minimal Headless Linux Distribution' },
                { label: 'Lab Purpose', val: 'Network Test Bench & Packet Capture Host' }
            ],
            log: 'Capacitor inspection passed. Refitted with low-noise fan profile and headless boot configuration for isolated network packet verification and subnet benchmarking.'
        }
    ];

    function openHardwareModal(index) {
        const node = HARDWARE_DB[index];
        if (!node || !hardwareModalBackdrop) return;

        if (modalHwNodeId) modalHwNodeId.textContent = node.nodeId;
        if (modalHwTag) modalHwTag.textContent = node.tag;
        if (modalHwTitle) modalHwTitle.textContent = node.title;
        if (modalHwSubtitle) modalHwSubtitle.textContent = node.subtitle;
        if (modalHwLog) modalHwLog.textContent = node.log;
        if (modalHwOem) modalHwOem.textContent = node.oem;

        if (modalHwSpecsMatrix) {
            modalHwSpecsMatrix.innerHTML = '';
            node.specs.forEach(s => {
                const cell = document.createElement('div');
                cell.className = 'hw-matrix-cell';
                cell.innerHTML = `
                    <span class="hw-matrix-label">${s.label}</span>
                    <span class="hw-matrix-val">${s.val}</span>
                `;
                modalHwSpecsMatrix.appendChild(cell);
            });
        }

        hardwareModalBackdrop.classList.add('active');
        hardwareModalBackdrop.setAttribute('aria-hidden', 'false');
    }

    function closeHardwareModal() {
        if (!hardwareModalBackdrop) return;
        hardwareModalBackdrop.classList.remove('active');
        hardwareModalBackdrop.setAttribute('aria-hidden', 'true');
    }

    // Attach click events to vintage hardware cards
    const retroCards = document.querySelectorAll('.retro-machine-card');
    retroCards.forEach((card, idx) => {
        card.style.cursor = 'pointer';
        card.setAttribute('title', 'Click to inspect vintage hardware telemetry & restoration log');
        card.addEventListener('click', () => {
            openHardwareModal(idx);
        });
    });

    if (hardwareModalCloseBtn) hardwareModalCloseBtn.addEventListener('click', closeHardwareModal);
    if (hardwareModalCloseActionBtn) hardwareModalCloseActionBtn.addEventListener('click', closeHardwareModal);
    if (hardwareModalBackdrop) {
        hardwareModalBackdrop.addEventListener('click', (e) => {
            if (e.target === hardwareModalBackdrop) closeHardwareModal();
        });
    }

    // Global ESC key listener for all open modal windows
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeProjectModal();
            closeHardwareModal();
        }
    });

    // =========================================================================
    // 13. INTERACTIVE BENTO CARD WINDOW CONTROLS (_ Minimize / × Close)
    // =========================================================================
    document.querySelectorAll('.bento-card .win-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            const card = btn.closest('.bento-card');
            if (!card) return;

            if (btn.classList.contains('win-close')) {
                card.classList.toggle('is-minimized');
                const isMini = card.classList.contains('is-minimized');
                if (typeof showToast === 'function') {
                    showToast(
                        isMini ? 'Widget Minimized' : 'Widget Restored',
                        isMini ? 'Card body collapsed. Click window buttons to restore.' : 'Card full view restored.',
                        true
                    );
                }
            } else {
                card.classList.toggle('is-minimized');
            }
        });
    });

    // =========================================================================
    // 14. TWO-COLUMN SPLIT-SCREEN HERO WIPE REVEAL (INTERSECTION OBSERVER)
    // =========================================================================
    function initHeroSplitReveal() {
        const heroSection = document.getElementById('home');
        const heroContainer = document.querySelector('.hero-container');
        const heroPanel = document.getElementById('heroImagePanel') || document.querySelector('.hero-image-panel');
        const heroContent = document.querySelector('.hero-content');

        if (!heroSection && !heroContainer) return;

        let hasHeroTriggered = false;

        const triggerFinalState = () => {
            if (hasHeroTriggered) return;
            hasHeroTriggered = true;

            if (heroSection) heroSection.classList.add('hero-revealed');
            if (heroContainer) heroContainer.classList.add('hero-revealed');
            if (heroPanel) heroPanel.classList.add('hero-revealed');
            if (heroContent) heroContent.classList.add('hero-revealed');
        };

        // Accessibility: prefers-reduced-motion fallback (render final state at once with no movement)
        const motionQuery = window.matchMedia('(prefers-reduced-motion: reduce)');
        if (motionQuery.matches) {
            triggerFinalState();
            return;
        }

        // Reduced-motion change listener
        if (typeof motionQuery.addEventListener === 'function') {
            motionQuery.addEventListener('change', (e) => {
                if (e.matches) {
                    triggerFinalState();
                }
            });
        }

        // Trigger once on load or on entering the viewport with an IntersectionObserver
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries, obs) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting && !hasHeroTriggered) {
                        triggerFinalState();
                        obs.unobserve(entry.target);
                        obs.disconnect();
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px'
            });

            const targetElement = heroContainer || heroSection;
            if (targetElement) {
                observer.observe(targetElement);
            }
        } else {
            // Fallback for environments without IntersectionObserver
            triggerFinalState();
        }
    }

    initHeroSplitReveal();

    // ==========================================
    // UNIFIED SECTION ANCHOR SCROLL & HIGHLIGHT ENGINE
    // ==========================================
    const highlightSection = (targetElement) => {
        if (!targetElement) return;
        targetElement.classList.remove('section-highlight');
        void targetElement.offsetWidth; // Force reflow
        targetElement.classList.add('section-highlight');
        setTimeout(() => {
            targetElement.classList.remove('section-highlight');
        }, 2600);
    };

    const scrollToAndHighlightSection = (sectionId, updateHash = true) => {
        if (!sectionId) return false;
        const cleanId = sectionId.replace('#', '');
        const targetElement = document.getElementById(cleanId);
        if (!targetElement) return false;

        targetElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
        highlightSection(targetElement);

        // Update active subnav link
        document.querySelectorAll('.sidebar-sub-link, .subnav-btn, .section-anchor-link').forEach(btn => {
            const target = btn.getAttribute('data-target-section') || btn.getAttribute('href')?.split('#')[1];
            if (target === cleanId) {
                btn.classList.add('child-active', 'active');
            } else if (btn.classList.contains('sidebar-sub-link') || btn.classList.contains('section-anchor-link')) {
                btn.classList.remove('child-active', 'active');
            }
        });

        // Ensure parent accordion is open
        const activeChildLink = document.querySelector(`.sidebar-sub-link[data-target-section="${cleanId}"]`);
        if (activeChildLink) {
            const parentSubNav = activeChildLink.closest('.sidebar-sub-nav');
            if (parentSubNav) {
                parentSubNav.classList.add('open');
                const toggleBtn = parentSubNav.closest('.nav-item')?.querySelector('.subnav-accordion-toggle');
                if (toggleBtn) {
                    toggleBtn.classList.add('expanded');
                    toggleBtn.setAttribute('aria-expanded', 'true');
                }
            }
        }

        if (updateHash && window.location.hash !== `#${cleanId}`) {
            history.pushState(null, '', `#${cleanId}`);
        }

        return true;
    };

    // Intercept clicks on child links, tab anchors, and hash links
    document.addEventListener('click', (e) => {
        const anchor = e.target.closest('a[href*="#"], .section-anchor-link, .sidebar-sub-link');
        if (!anchor) return;

        const href = anchor.getAttribute('href');
        if (!href || href === '#' || href.startsWith('javascript:')) return;

        const hashIndex = href.indexOf('#');
        if (hashIndex === -1) return;

        const hash = href.slice(hashIndex + 1);
        const linkPath = href.slice(0, hashIndex);
        const currentPath = window.location.pathname.replace(/\/$/, '') || '/';
        const targetUrl = new URL(anchor.href, window.location.origin);
        const targetPath = targetUrl.pathname.replace(/\/$/, '') || '/';

        // Check if target is on the current page
        if (targetPath === currentPath || linkPath === '' || linkPath === currentPath) {
            const targetEl = document.getElementById(hash);
            if (targetEl) {
                e.preventDefault();
                scrollToAndHighlightSection(hash, true);
                closeSidebar();
            }
        }
    });

    // Check hash on initial page load
    window.addEventListener('DOMContentLoaded', () => {
        if (window.location.hash) {
            const hash = window.location.hash.replace('#', '');
            setTimeout(() => {
                scrollToAndHighlightSection(hash, false);
            }, 300);
        }
    });

    // IntersectionObserver to update active child link during continuous reading/scrolling
    const contentSections = document.querySelectorAll('.content-section[id]');
    if (contentSections.length > 0 && 'IntersectionObserver' in window) {
        const sectionObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    const secId = entry.target.id;
                    document.querySelectorAll('.sidebar-sub-link, .subnav-btn, .section-anchor-link').forEach(btn => {
                        const target = btn.getAttribute('data-target-section') || btn.getAttribute('href')?.split('#')[1];
                        if (target === secId) {
                            btn.classList.add('child-active', 'active');
                        } else if (btn.classList.contains('sidebar-sub-link') || btn.classList.contains('section-anchor-link')) {
                            btn.classList.remove('child-active', 'active');
                        }
                    });
                }
            });
        }, {
            root: null,
            rootMargin: '-20% 0px -60% 0px',
            threshold: 0
        });

        contentSections.forEach(section => sectionObserver.observe(section));
    }
});

