-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: x64emkei_portfolio
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `achievements`
--

LOCK TABLES `achievements` WRITE;
/*!40000 ALTER TABLE `achievements` DISABLE KEYS */;
INSERT INTO `achievements` VALUES (4,'Undergraduate Scholar in Computer Science','Laguna College of Business and Arts','Engaged in rigorous undergraduate studies focusing on computer systems, software engineering, database design, and algorithmic problem-solving.','2022 - Present','Academic',NULL,NULL,NULL,1,1,1,'2026-11-23 19:27:18','2026-11-23 19:27:18'),(5,'Secretary & Academic Committee Steward','Alliance of Computer Engineering and Computer Science Students','Elected secretary managing departmental records, documentation, technical initiatives, and student assemblies.','AY 2023 - Present','Leadership',NULL,NULL,NULL,1,2,1,'2026-11-23 19:27:18','2026-11-23 19:27:18');
/*!40000 ALTER TABLE `achievements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `activity_logs`
--

LOCK TABLES `activity_logs` WRITE;
/*!40000 ALTER TABLE `activity_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `activity_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `article_categories`
--

LOCK TABLES `article_categories` WRITE;
/*!40000 ALTER TABLE `article_categories` DISABLE KEYS */;
INSERT INTO `article_categories` VALUES (1,'Systems Architecture','systems-architecture','Deep-dives into systems engineering, kernel architecture, and low-level development.',1,'2026-11-23 19:08:16','2026-11-23 19:08:16'),(2,'Cybersecurity','cybersecurity','Security analysis, threat intelligence, and zero-trust engineering.',2,'2026-11-23 19:08:16','2026-11-23 19:08:16'),(3,'Web & Cloud','web-and-cloud','High-performance web backends, microservices, and distributed architecture.',3,'2026-11-23 19:08:16','2026-11-23 19:08:16'),(4,'Homelab & Hardware','homelab-and-hardware','Bare-metal virtualization, Proxmox VE, networking, and server maintenance.',4,'2026-11-23 19:08:16','2026-11-23 19:08:16');
/*!40000 ALTER TABLE `article_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `article_tag_pivot`
--

LOCK TABLES `article_tag_pivot` WRITE;
/*!40000 ALTER TABLE `article_tag_pivot` DISABLE KEYS */;
/*!40000 ALTER TABLE `article_tag_pivot` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `article_tags`
--

LOCK TABLES `article_tags` WRITE;
/*!40000 ALTER TABLE `article_tags` DISABLE KEYS */;
INSERT INTO `article_tags` VALUES (1,'PHP','php','2026-11-23 19:08:16'),(2,'C# .NET','csharp-dotnet','2026-11-23 19:08:16'),(3,'C++20','cpp20','2026-11-23 19:08:16'),(4,'Linux','linux','2026-11-23 19:08:16'),(5,'MySQL','mysql','2026-11-23 19:08:16'),(6,'Security','security','2026-11-23 19:08:16'),(7,'Zero-Trust','zero-trust','2026-11-23 19:08:16'),(8,'Virtualization','virtualization','2026-11-23 19:08:16');
/*!40000 ALTER TABLE `article_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `articles`
--

LOCK TABLES `articles` WRITE;
/*!40000 ALTER TABLE `articles` DISABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `certifications`
--

LOCK TABLES `certifications` WRITE;
/*!40000 ALTER TABLE `certifications` DISABLE KEYS */;
INSERT INTO `certifications` VALUES (1,'Certified Six Sigma White Belt','Continuous Quality Improvement & Process Optimization','2023','CSSWB-VERIFIED','',1,1,'2026-11-23 19:27:18'),(2,'EF SET English Certificate — C1 Advanced','EF Standard English Test','2023','EFSET-C1-ADVANCED','',2,1,'2026-11-23 19:27:18');
/*!40000 ALTER TABLE `certifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `education`
--

LOCK TABLES `education` WRITE;
/*!40000 ALTER TABLE `education` DISABLE KEYS */;
INSERT INTO `education` VALUES (4,'Laguna College of Business and Arts','Bachelor of Science in Computer Science','Computer Science','2022','Present','Undergraduate — In Progress. Rigorous study in algorithms, data structures, software engineering, systems administration, and database design.',1,1,'2026-11-23 19:27:18'),(5,'St. Vincent College of Cabuyao','Senior High School Diploma','Science, Technology, Engineering & Mathematics (STEM)','2020','2022','Completed Senior High School curriculum under the STEM academic strand.',2,1,'2026-11-23 19:27:18');
/*!40000 ALTER TABLE `education` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `experiences`
--

LOCK TABLES `experiences` WRITE;
/*!40000 ALTER TABLE `experiences` DISABLE KEYS */;
INSERT INTO `experiences` VALUES (7,'Secretary','Alliance of Computer Engineering and Computer Science Students','Laguna College of Business and Arts','Academic Organization','2023','Present',1,'Managing academic records, technical documentation, student event coordination, and inter-organizational communication across computing departments.',NULL,1,1,'2026-11-23 19:27:18'),(8,'Laguna Chapter Chairperson','National Youth Movement for the West Philippine Sea','Laguna, Philippines','Youth Leadership','2023','Present',1,'Leading youth chapter leadership, community awareness, policy advocacy, and public engagement initiatives.',NULL,2,1,'2026-11-23 19:27:18'),(9,'Director for Communications and Publications','FPJ Youth','Laguna, Philippines','Media & Communications','2023','Present',1,'Directing digital publication pipelines, graphic design assets, public releases, and youth communication strategies.',NULL,3,1,'2026-11-23 19:27:18'),(10,'Member','International Association of Engineers (IAENG)','International','Professional Organization','2023','Present',1,'Active member participating in professional research exchanges, engineering publications, and technical conferences.',NULL,4,1,'2026-11-23 19:27:18');
/*!40000 ALTER TABLE `experiences` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `hardware_nodes`
--

LOCK TABLES `hardware_nodes` WRITE;
/*!40000 ALTER TABLE `hardware_nodes` DISABLE KEYS */;
INSERT INTO `hardware_nodes` VALUES (10,'NODE.01 // NETBOOK','PRESERVED','Sony Vaio W-series VPCW115XG','Japanese Ultraportable Engineering • 10.1-inch WXGA Display','Sony VAIO','{\"CPU\":\"Intel Atom N280 (1.66 GHz, 1 Core, 2 Threads, 512KB L2)\",\"Display\":\"10.1-inch WXGA (1366 \\u00d7 768) Fine-Pitch LED\",\"Keyboard\":\"Signature Island Keyboard Design\",\"Status\":\"Preserved \\/ Diagnostic Node\"}','Hands-on hardware diagnostics, BIOS recovery, and preservation. Refurbished CMOS battery, repasted Atom die, and configured for low-power serial telemetry and vintage firmware inspection.','images/carousel-retro.jpg',1,1,'2026-11-23 19:27:18','2026-11-23 19:27:18'),(11,'NODE.02 // TOUGHBOOK ULTRA','OPERATIONAL','Panasonic Let\'s Note CF-T4GW5AXR','Magnesium Alloy Bonnet Chassis • Fanless Silent Architecture','Panasonic Japan','{\"CPU\":\"Intel Pentium M Ultra Low Voltage (ULV) 753\",\"Chassis\":\"Magnesium Alloy Bonnet Construction\",\"Touchpad\":\"Circular Optical Touchpad Interface\",\"Cooling\":\"Fanless Silent Thermal Dissipation\"}','Restored Japanese enterprise ultraportable. Cleaned thermal dissipation plates, verified fanless heatsink efficiency, and benchmarked legacy architecture under specialized diagnostic loads.','images/carousel-retro.jpg',2,1,'2026-11-23 19:27:18','2026-11-23 19:27:18'),(12,'RIG.03 // BUSINESS NOTEBOOK','DIAGNOSTIC RIG','HP Compaq nx6320','Dedicated Diagnostic Terminal • Native Serial & Parallel I/O','HP / Compaq','{\"Platform\":\"Intel Core 2 Duo Platform\",\"Panel\":\"15.0-inch 4:3 Matte Anti-Glare Panel\",\"Interfaces\":\"Native Hardware RS-232 Serial & Parallel Ports\",\"Role\":\"Dedicated Hardware Diagnostic Terminal\"}','Maintained as an active bench diagnostic terminal. Native legacy serial and parallel interfaces enable direct out-of-band communication with network switches, microcontrollers, and retro motherboards.','images/carousel-workspace.jpg',3,1,'2026-11-23 19:27:18','2026-11-23 19:27:18'),(13,'RIG.04 // SLEEPER BUILD','DAILY WORKSTATION','HP Pavilion a6000 (Sleeper)','Mid-2000s Glossy Wave-Front Chassis Refitted with Modern Internals','HP Custom Sleeper','{\"Chassis\":\"Mid-2000s OEM Glossy Wave-Front Vintage Enclosure\",\"Modifications\":\"Modular Cooling, Quiet Airflow Routing, High-Efficiency PSU\",\"Internals\":\"Modern Multi-Core Desktop Platform\",\"Status\":\"Daily Production Workstation\"}','Complete stealth build combining retro mid-2000s desktop aesthetics with modern high-performance engineering internals, custom intake filtration, and whisper-quiet acoustic profiling.','images/carousel-homelab.jpg',4,1,'2026-11-23 19:27:18','2026-11-23 19:27:18'),(14,'NODE.05 // HOMELAB SERVER','ONLINE / 24/7','Dell OptiPlex 3010 Server','Intel Core Host • Proxmox VE Virtualization Cluster Node','Dell Homelab','{\"Host\":\"Intel Core Host Platform with Expanded Memory\",\"Networking\":\"Gigabit Uplink with VLAN Trunking\",\"Hypervisor\":\"Proxmox VE Virtual Environment\",\"Workloads\":\"Linux Containers (LXC), Docker Microservices, DNS Caching\"}','Engineered for continuous 24/7 uptime. Runs virtualized DNS resolvers, internal reverse proxies, WireGuard mesh entry points, and local development test databases with continuous monitoring.','images/carousel-homelab.jpg',5,1,'2026-11-23 19:27:18','2026-11-23 19:27:18'),(15,'NODE.06 // ULTRA SFF','BENCH TEST','Dell OptiPlex 760 USFF','Ultra-Small Form Factor Desktop • Low-Power Compact Footprint','Dell Legacy','{\"Chassis\":\"Ultra-Small Form Factor (USFF)\",\"CPU\":\"Intel Core 2 Duo Processor\",\"Power\":\"Low-Power High-Efficiency Compact Footprint\",\"Role\":\"Headless Network Test Node & Diagnostic Sandbox\"}','Deployed as a standalone headless bench node for testing bare-metal kernel configurations, lightweight network routines, and simulated network drops without touching production rigs.','images/carousel-retro.jpg',6,1,'2026-11-23 19:27:18','2026-11-23 19:27:18');
/*!40000 ALTER TABLE `hardware_nodes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `media`
--

LOCK TABLES `media` WRITE;
/*!40000 ALTER TABLE `media` DISABLE KEYS */;
/*!40000 ALTER TABLE `media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'001_create_users_table.sql',1,'2026-11-21 13:29:48'),(2,'002_create_profile_table.sql',2,'2026-11-21 13:30:04'),(3,'003_create_projects_table.sql',2,'2026-11-21 13:30:04'),(4,'004_create_hardware_nodes_table.sql',2,'2026-11-21 13:30:04'),(5,'005_create_skills_table.sql',2,'2026-11-21 13:30:04'),(6,'006_create_experiences_table.sql',2,'2026-11-21 13:30:04'),(7,'007_create_education_table.sql',2,'2026-11-21 13:30:05'),(8,'008_create_certifications_table.sql',2,'2026-11-21 13:30:05'),(9,'009_create_services_table.sql',2,'2026-11-21 13:30:05'),(10,'010_create_social_links_table.sql',2,'2026-11-21 13:30:05'),(11,'011_create_site_settings_table.sql',2,'2026-11-21 13:30:05'),(12,'012_create_messages_table.sql',2,'2026-11-21 13:30:05'),(13,'013_create_media_table.sql',2,'2026-11-21 13:30:05'),(14,'014_create_activity_logs_table.sql',2,'2026-11-21 13:30:05'),(15,'015_create_portfolio_sections_table.sql',3,'2026-11-21 17:20:25'),(16,'016_create_achievements_table.sql',3,'2026-11-21 17:20:25'),(17,'017_create_journal_tables.sql',4,'2026-11-23 19:08:15'),(18,'018_enhance_users_roles.sql',4,'2026-11-23 19:08:16');
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `portfolio_sections`
--

LOCK TABLES `portfolio_sections` WRITE;
/*!40000 ALTER TABLE `portfolio_sections` DISABLE KEYS */;
INSERT INTO `portfolio_sections` VALUES (12,'hero','OPERATIONAL ARCHITECTURE','SYSTEMS SCHOLAR // HARDWARE SPECIALIST','Computer Science student, systems builder, and IT infrastructure enthusiast.',1,1,'default',0,'2026-11-23 19:27:18','2026-11-23 19:27:18'),(13,'about','BIOGRAPHY // CORE DIRECTIVE','IDENTITY & SCHOLASTIC DISCIPLINE','Computer Science student at Laguna College of Business and Arts exploring systems, homelabs, and hardware preservation.',1,2,'default',0,'2026-11-23 19:27:18','2026-11-23 19:27:18'),(14,'projects','FEATURED PRODUCTION ARCHITECTURES','DEPLOYED PLATFORMS & SOFTWARE CODEBASES','Software and systems builds catalog.',1,3,'cards',1,'2026-11-23 19:27:18','2026-11-23 19:27:18'),(15,'hardware','VINTAGE HARDWARE DIAGNOSTICS & RESTORATION LAB','LAB FLEET TELEMETRY & RETRO HARDWARE REPOSITORY','Hands-on hardware diagnostics, BIOS recovery, and preservation across modern and legacy computing architectures (6 operational nodes).',1,4,'cards',1,'2026-11-23 19:27:18','2026-11-23 19:27:18'),(16,'skills','TECHNICAL SKILLS & TOOLS','ENGINEERING MATRIX // PROFICIENCY CATALOG','Programming, systems, virtualization, networking, creative media, and operational workflows.',1,5,'default',1,'2026-11-23 19:27:18','2026-11-23 19:27:18'),(17,'experience','ORGANIZATIONAL INVOLVEMENT & LEADERSHIP','CHRONOLOGY & RESPONSIBILITIES','Track record of student leadership, organizational communications, and professional engineering affiliations.',1,6,'timeline',1,'2026-11-23 19:27:18','2026-11-23 19:27:18'),(18,'education','EDUCATION & CREDENTIALS','SCHOLASTIC FORMATION','Higher education history, senior high STEM foundation, and industry certifications.',1,7,'cards',1,'2026-11-23 19:27:18','2026-11-23 19:27:18'),(19,'achievements','HONORS & RECOGNITIONS','ACADEMIC & LEADERSHIP DISTINCTIONS','Academic milestones and organizational leadership recognitions.',1,8,'cards',1,'2026-11-23 19:27:18','2026-11-23 19:27:18'),(20,'certifications','CERTIFICATIONS & CREDENTIALS','VERIFIED SPECIALIZATIONS','Certified Six Sigma White Belt & EF SET English C1 Advanced qualifications.',1,9,'cards',1,'2026-11-23 19:27:18','2026-11-23 19:27:18'),(21,'services','SERVICES & SPECIALTIES','CAPABILITIES & OFFERINGS','Web development, homelab virtualization, networking, hardware restoration, and systematic technical problem solving.',1,10,'cards',1,'2026-11-23 19:27:18','2026-11-23 19:27:18'),(22,'contact','INITIALIZE SECURE TRANSMISSION','TELEMETRY UPLINK & DIRECT DISPATCH','Connect directly via encrypted transmission or explore active communication channels.',1,11,'default',0,'2026-11-23 19:27:18','2026-11-23 19:27:18');
/*!40000 ALTER TABLE `portfolio_sections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `profile`
--

LOCK TABLES `profile` WRITE;
/*!40000 ALTER TABLE `profile` DISABLE KEYS */;
INSERT INTO `profile` VALUES (4,'Michael Benedict Ordenes','Computer Science Student, IT Enthusiast & Systems Builder','Building resilient software architectures, deploying virtualized server homelabs, and experimenting across the boundary of modern edge systems and vintage computing hardware.','A Computer Science student interested in software development, IT infrastructure, networking, systems administration, and emerging technologies. Enjoys turning ideas into functional projects and experimenting with modern and legacy hardware/software.','Building resilient software architectures, deploying virtualized server homelabs, and experimenting across the boundary of modern edge systems and vintage computing hardware.\n\nPrimary areas of discipline:\n• Software and web development\n• Systems programming and desktop engineering\n• AI / computer vision and automation\n• Homelab, virtualization, and containers\n• Networking, DNS, VPN, and remote access\n• Hardware diagnostics, restoration, and legacy platforms','images/me_2.png','images/carousel-workspace.jpg','Laguna, Philippines','Available for Systems & Web Engineering','#contact','mordenes@acm.org','2026-11-23 19:27:18','2026-11-23 19:27:18');
/*!40000 ALTER TABLE `profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES (13,'Web & Software Development','Software Engineering','Designing and coding responsive web applications and reliable software solutions with clean, structured, dependency-conscious code in Vanilla JS, PHP, Python, C#, C++, Java, and MySQL.',NULL,NULL,1,1,'2026-11-23 19:27:18'),(14,'Homelab & Virtualization','Cloud & Virtualization','Building and administering resilient virtual environments, Proxmox VE hypervisors, and containerized Docker stacks on Debian/Linux servers with uptime monitoring.',NULL,NULL,2,1,'2026-11-23 19:27:18'),(15,'Networking & Systems Administration','Infrastructure','Configuring encrypted mesh routing with Tailscale, local DNS resolution, subdomain routing, and reliable Windows and Linux systems administration.',NULL,NULL,3,1,'2026-11-23 19:27:18'),(16,'Hardware Diagnostics & Restoration','Hardware Engineering','Refurbishing, troubleshooting, and diagnosing modern and vintage computing platforms, BIOS recovery, thermal repasting, and component-level benchmarking.',NULL,NULL,4,1,'2026-11-23 19:27:18'),(17,'Technical Problem Solving & Quality','Optimization','Systematic troubleshooting, technical architecture documentation, and continuous process optimization applying Six Sigma White Belt methodologies.',NULL,NULL,5,1,'2026-11-23 19:27:18');
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `site_settings`
--

LOCK TABLES `site_settings` WRITE;
/*!40000 ALTER TABLE `site_settings` DISABLE KEYS */;
INSERT INTO `site_settings` VALUES (25,'site_title','Michael Benedict Ordenes | x64emkei.dev','general','Public title of the portfolio','2026-11-23 19:27:18'),(26,'site_tagline','Computer Science Student, IT Enthusiast & Systems Builder','general','Meta tagline','2026-11-23 19:27:18'),(27,'meta_description','Michael Benedict Ordenes (x64emkei) — Computer Science student at Laguna College of Business and Arts. Software development, systems architecture, homelab, and hardware restoration.','seo','Default SEO description','2026-11-23 19:27:18'),(28,'meta_keywords','Michael Benedict Ordenes, x64emkei, developer portfolio, LCBA, Computer Science, Proxmox, homelab, networking, C#, C++, Python, MySQL','seo','Meta keywords list','2026-11-23 19:27:18'),(29,'contact_email','mordenes@acm.org','contact','Primary inbox contact email','2026-11-23 19:27:18'),(30,'theme_default','dark','appearance','Default HUD theme mode (dark or light)','2026-11-23 19:27:18'),(31,'primary_domain','welcome.x64emkei.dpdns.org','hosting','Primary configured domain','2026-11-23 19:27:18'),(32,'copyright_text','© 2026 Michael Benedict Ordenes. Systems Architecture // All telemetry active.','general','Footer copyright label','2026-11-23 19:27:18');
/*!40000 ALTER TABLE `site_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `skills`
--

LOCK TABLES `skills` WRITE;
/*!40000 ALTER TABLE `skills` DISABLE KEYS */;
INSERT INTO `skills` VALUES (43,'Programming & Databases','HTML5',95,NULL,1,1,'2026-11-23 19:27:18'),(44,'Programming & Databases','CSS3 / Grid',92,NULL,2,1,'2026-11-23 19:27:18'),(45,'Programming & Databases','JavaScript (ES6+)',90,NULL,3,1,'2026-11-23 19:27:18'),(46,'Programming & Databases','Python',88,NULL,4,1,'2026-11-23 19:27:18'),(47,'Programming & Databases','Java',85,NULL,5,1,'2026-11-23 19:27:18'),(48,'Programming & Databases','C#',88,NULL,6,1,'2026-11-23 19:27:18'),(49,'Programming & Databases','C++',84,NULL,7,1,'2026-11-23 19:27:18'),(50,'Programming & Databases','MySQL',88,NULL,8,1,'2026-11-23 19:27:18'),(51,'Systems & Virtualization','Windows OS',95,NULL,1,1,'2026-11-23 19:27:18'),(52,'Systems & Virtualization','Linux (Debian / Ubuntu)',90,NULL,2,1,'2026-11-23 19:27:18'),(53,'Systems & Virtualization','Proxmox VE',88,NULL,3,1,'2026-11-23 19:27:18'),(54,'Systems & Virtualization','Docker Containers',85,NULL,4,1,'2026-11-23 19:27:18'),(55,'Systems & Virtualization','Tailscale Mesh VPN',90,NULL,5,1,'2026-11-23 19:27:18'),(56,'Systems & Virtualization','DNS & Routing',88,NULL,6,1,'2026-11-23 19:27:18'),(57,'Creative & Digital Media','Adobe Photoshop',85,NULL,1,1,'2026-11-23 19:27:18'),(58,'Creative & Digital Media','Adobe Illustrator',82,NULL,2,1,'2026-11-23 19:27:18'),(59,'Creative & Digital Media','DaVinci Resolve',80,NULL,3,1,'2026-11-23 19:27:18'),(60,'Creative & Digital Media','Office Suite',95,NULL,4,1,'2026-11-23 19:27:18'),(61,'Workflow & Operations','Git',92,NULL,1,1,'2026-11-23 19:27:18'),(62,'Workflow & Operations','GitHub',92,NULL,2,1,'2026-11-23 19:27:18'),(63,'Workflow & Operations','Visual Studio Code',95,NULL,3,1,'2026-11-23 19:27:18'),(64,'Workflow & Operations','Antigravity',90,NULL,4,1,'2026-11-23 19:27:18'),(65,'Workflow & Operations','Hardware Diagnostics',94,NULL,5,1,'2026-11-23 19:27:18');
/*!40000 ALTER TABLE `skills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `social_links`
--

LOCK TABLES `social_links` WRITE;
/*!40000 ALTER TABLE `social_links` DISABLE KEYS */;
INSERT INTO `social_links` VALUES (10,'github','GitHub','https://github.com/x64_emkei',NULL,1,1,'2026-11-23 19:27:18'),(11,'email','Email','mailto:mordenes@acm.org',NULL,2,1,'2026-11-23 19:27:18');
/*!40000 ALTER TABLE `social_links` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-11-24  3:41:22
