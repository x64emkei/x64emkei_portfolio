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
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `activity_logs`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `action` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_action` (`action`),
  KEY `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_logs`
--

LOCK TABLES `activity_logs` WRITE;
/*!40000 ALTER TABLE `activity_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `activity_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `certifications`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `certifications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `issuer` varchar(150) NOT NULL,
  `issue_date` varchar(50) DEFAULT NULL,
  `credential_id` varchar(100) DEFAULT NULL,
  `credential_url` varchar(255) DEFAULT NULL,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_is_published` (`is_published`),
  KEY `idx_display_order` (`display_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `certifications`
--

LOCK TABLES `certifications` WRITE;
/*!40000 ALTER TABLE `certifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `certifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `education`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `education` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `institution` varchar(150) NOT NULL,
  `degree` varchar(150) NOT NULL,
  `field_of_study` varchar(150) DEFAULT NULL,
  `period_start` varchar(50) NOT NULL,
  `period_end` varchar(50) DEFAULT NULL,
  `achievements` text DEFAULT NULL,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_is_published` (`is_published`),
  KEY `idx_display_order` (`display_order`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `education`
--

LOCK TABLES `education` WRITE;
/*!40000 ALTER TABLE `education` DISABLE KEYS */;
INSERT INTO `education` VALUES (2,'Laguna State Polytechnic University / Academic Institution','Bachelor of Science in Computer Science','Systems Architecture & Software Engineering','2022','Present','Dean\'s Lister • Focused on operating systems, algorithm design, distributed computing, and database management systems.',1,1,'2026-11-21 16:57:48');
/*!40000 ALTER TABLE `education` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `experiences`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `experiences` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `organization` varchar(150) NOT NULL,
  `location` varchar(100) DEFAULT NULL,
  `type` varchar(50) NOT NULL DEFAULT 'Professional',
  `period_start` varchar(50) NOT NULL,
  `period_end` varchar(50) DEFAULT NULL,
  `is_current` tinyint(1) NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `responsibilities_json` text DEFAULT NULL,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_is_published` (`is_published`),
  KEY `idx_display_order` (`display_order`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `experiences`
--

LOCK TABLES `experiences` WRITE;
/*!40000 ALTER TABLE `experiences` DISABLE KEYS */;
INSERT INTO `experiences` VALUES (3,'Software Systems & Solutions Architect','Independent / Academic Development','Laguna, Philippines','Engineering','2023','Present',1,'Leading the architectural design, security hardening, and deployment of mission-critical applications across retail, systems virtualization, and enterprise workflow automation.',NULL,1,1,'2026-11-21 16:57:48'),(4,'Computer Science Researcher & Student Leader','College of Computer Studies','Laguna, Philippines','Academic & Leadership','2022','Present',1,'Mentoring junior computing students in data structures, systems programming in C/C++, and algorithmic optimization. Organizing technical workshops and coding competitions.',NULL,2,1,'2026-11-21 16:57:48');
/*!40000 ALTER TABLE `experiences` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hardware_nodes`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hardware_nodes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `node_id` varchar(50) NOT NULL,
  `tag` varchar(50) DEFAULT 'PRESERVED',
  `title` varchar(150) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `oem` varchar(100) NOT NULL,
  `specs_json` text NOT NULL,
  `diagnostics_log` text NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_is_published` (`is_published`),
  KEY `idx_display_order` (`display_order`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hardware_nodes`
--

LOCK TABLES `hardware_nodes` WRITE;
/*!40000 ALTER TABLE `hardware_nodes` DISABLE KEYS */;
INSERT INTO `hardware_nodes` VALUES (4,'NODE.01 // LAB ARCHIVE','PRESERVED','Sony Vaio W-series VPCW115XG','Intel Atom N280 Netbook Platform • Japanese Ultraportable Engineering','Sony VAIO Corp.','{\"CPU\":\"Intel Atom N280 (1.66 GHz, 1 Core, 2 Threads, 512KB L2)\",\"RAM\":\"2GB DDR2-667 SO-DIMM\",\"Storage\":\"64GB Kingston SATA-II SSD (Upgraded from 160GB HDD)\",\"Display\":\"10.1-inch 1366x768 Fine-Pitch WXGA LED\",\"OS\":\"Debian Linux 12 (Bookworm) Minimal CLI with Openbox\",\"Purpose\":\"Low-power serial telemetry node & vintage firmware flash programmer\"}','Purchased as a non-booting salvage chassis in 2023. Restored CMOS battery, repasted Atom die with Arctic MX-4, replaced damaged hinge assembly, and flashed modified microcode BIOS. Currently serving as a lightweight network probe and serial RS-232 telemetry relay.','images/carousel-retro.jpg',1,1,'2026-11-21 16:57:48','2026-11-21 16:57:48'),(5,'NODE.02 // LAB ARCHIVE','ACTIVE RIG','Lenovo ThinkPad X220 Mod','Intel Core i5-2520M Ultraportable • Classic 7-Row Keyboard Workhorse','Lenovo Corp.','{\"CPU\":\"Intel Core i5-2520M (2.50 GHz, Turbo to 3.20 GHz, 2C\\/4T)\",\"RAM\":\"16GB DDR3L-1600 Dual-Channel\",\"Storage\":\"256GB Samsung 860 EVO mSATA + 500GB Crucial MX500 SATA-III\",\"Display\":\"12.5-inch IPS HD 1366x768 Matte Display\",\"OS\":\"Arch Linux (Kernel 6.10-zen) + Coreboot open-source BIOS\",\"Purpose\":\"Primary mobile Linux development terminal, embedded debugging\"}','Flashed with 1vyrain modified UEFI to remove Wi-Fi whitelist and unlock memory speeds. Retrofitted with classic 7-row keyboard mod. Repasted copper heatpipe with Noctua NT-H2. Battery rebuilt with custom high-capacity Panasonic 18650 cells.','images/carousel-workspace.jpg',2,1,'2026-11-21 16:57:48','2026-11-21 16:57:48'),(6,'RIG.03 // LAB ARCHIVE','HYPERVISOR','Cluster Node 01 — Proxmox VE','High-Efficiency Homelab Bare-Metal Virtualization Hypervisor','Custom Systems Build','{\"CPU\":\"AMD Ryzen 7 5700X (8 Cores, 16 Threads, 32MB L3 Cache)\",\"RAM\":\"64GB DDR4-3200 ECC Unbuffered Memory\",\"Storage\":\"2x 1TB NVMe PCIe 4.0 ZFS RAID-1 Mirror + 4x 4TB SATA ZFS Pool\",\"Network\":\"Dual Intel I225-V 2.5GbE NICs (LACP Trunking)\",\"OS\":\"Proxmox VE 8.2 (Linux Kernel 6.8 PVE)\",\"Purpose\":\"Running isolated LXC containers, Docker swarm, and network lab routers\"}','Engineered for continuous 24/7 high-density virtualization. Hosts internal Git repositories, test database clusters, DNS caches, WireGuard ingress gateways, and CI/CD automated runners with continuous temperature monitoring and battery UPS failover.','images/carousel-homelab.jpg',3,1,'2026-11-21 16:57:48','2026-11-21 16:57:48');
/*!40000 ALTER TABLE `hardware_nodes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `media` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) NOT NULL,
  `original_name` varchar(255) NOT NULL,
  `mime_type` varchar(100) NOT NULL,
  `file_size` int(10) unsigned NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media`
--

LOCK TABLES `media` WRITE;
/*!40000 ALTER TABLE `media` DISABLE KEYS */;
/*!40000 ALTER TABLE `media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sender_name` varchar(100) NOT NULL,
  `sender_email` varchar(150) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message_body` text NOT NULL,
  `sender_ip` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `is_archived` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_is_read` (`is_read`),
  KEY `idx_created_at` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  `executed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `migration` (`migration`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'001_create_users_table.sql',1,'2026-11-21 13:29:48'),(2,'002_create_profile_table.sql',2,'2026-11-21 13:30:04'),(3,'003_create_projects_table.sql',2,'2026-11-21 13:30:04'),(4,'004_create_hardware_nodes_table.sql',2,'2026-11-21 13:30:04'),(5,'005_create_skills_table.sql',2,'2026-11-21 13:30:04'),(6,'006_create_experiences_table.sql',2,'2026-11-21 13:30:04'),(7,'007_create_education_table.sql',2,'2026-11-21 13:30:05'),(8,'008_create_certifications_table.sql',2,'2026-11-21 13:30:05'),(9,'009_create_services_table.sql',2,'2026-11-21 13:30:05'),(10,'010_create_social_links_table.sql',2,'2026-11-21 13:30:05'),(11,'011_create_site_settings_table.sql',2,'2026-11-21 13:30:05'),(12,'012_create_messages_table.sql',2,'2026-11-21 13:30:05'),(13,'013_create_media_table.sql',2,'2026-11-21 13:30:05'),(14,'014_create_activity_logs_table.sql',2,'2026-11-21 13:30:05');
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profile`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profile` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `title` varchar(150) NOT NULL,
  `tagline` varchar(255) DEFAULT NULL,
  `bio_short` text DEFAULT NULL,
  `bio_full` mediumtext DEFAULT NULL,
  `avatar_url` varchar(255) DEFAULT NULL,
  `cover_url` varchar(255) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `availability_status` varchar(100) DEFAULT 'Available for Systems & Web Engineering',
  `resume_url` varchar(255) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profile`
--

LOCK TABLES `profile` WRITE;
/*!40000 ALTER TABLE `profile` DISABLE KEYS */;
INSERT INTO `profile` VALUES (2,'Michael Benedict Ordenes','Computer Science Student, IT Enthusiast & Developer','Architecting resilient software systems, low-level micro-kernels, and high-performance distributed architectures.','Computer Science scholar and systems engineer focused on high-performance desktop platforms, embedded POS telemetry, computer vision pipelines, and resilient network infrastructures.','I engineer software at the intersection of systems architecture, low-level execution efficiency, and intuitive human-computer interaction. From designing autonomous enterprise point-of-sale engines in modern C# and .NET to experimenting with microkernels in C++20 and training edge neural vision networks in PyTorch, I build systems built to endure.','images/me_2.png','images/carousel-workspace.jpg','Laguna, Philippines','Available for Systems & Web Engineering','#contact','mordenes@acm.org','2026-11-21 16:57:48','2026-11-21 16:57:48');
/*!40000 ALTER TABLE `profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projects`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(100) NOT NULL,
  `code_id` varchar(50) NOT NULL,
  `category` varchar(50) NOT NULL,
  `filter_tag` varchar(50) NOT NULL,
  `title` varchar(150) NOT NULL,
  `tagline` varchar(255) NOT NULL,
  `environment` varchar(150) DEFAULT NULL,
  `performance_metric` varchar(150) DEFAULT NULL,
  `operational_status` varchar(100) DEFAULT 'Operational',
  `description` text NOT NULL,
  `features_json` text DEFAULT NULL,
  `code_filename` varchar(100) DEFAULT NULL,
  `code_snippet` text DEFAULT NULL,
  `technologies_json` text NOT NULL,
  `github_url` varchar(255) DEFAULT NULL,
  `demo_url` varchar(255) DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `idx_slug` (`slug`),
  KEY `idx_filter_tag` (`filter_tag`),
  KEY `idx_is_published` (`is_published`),
  KEY `idx_display_order` (`display_order`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES (17,'valkyrie-pos-pro','CS.001 // ENTERPRISE_POS','C# 12 / .NET 9','csharp','Valkyrie POS Pro','Autonomous offline retail point-of-sale terminal engine with cryptographic peer sync and scanner abstraction.','Windows 11 / Embedded POS • .NET 9 Desktop • SQLite WAL','0.8ms transaction write • Sub-10ms peer sync loop','Operational • Simulated Enterprise Stack','A mission-critical Point-of-Sale architecture engineered for zero-downtime retail environments. Features a resilient local write-ahead cryptographic ledger that operates seamlessly when disconnected from WAN and syncs peer-to-peer across LAN terminals using authenticated gRPC channels.','[\"Local Write-Ahead Transaction Ledger (WAL) guaranteeing atomic state consistency.\",\"Peer-to-peer multi-terminal catalog synchronization over LAN with automatic conflict resolution.\",\"Direct hardware abstraction layer for ESC\\/POS thermal printers and barcode scanners.\",\"GPU-accelerated WPF touch-first checkout UI rendering fluid 60 FPS transitions.\"]','ValkyrieLedgerEngine.cs','public sealed class TransactionLedger : IDisposable\n{\n    private readonly SqliteConnection _db;\n    private readonly Channel<TransactionRecord> _txQueue;\n\n    public async Task<ReceiptTicket> CommitSaleAsync(CartPayload cart, CancellationToken ct)\n    {\n        var hash = CryptoProvider.ComputeSha256(cart.Serialize());\n        using var tx = await _db.BeginTransactionAsync(IsolationLevel.Snapshot, ct);\n        \n        var record = new TransactionRecord(Guid.NewGuid(), cart.TotalCents, hash, DateTime.UtcNow);\n        await _db.ExecuteAsync(\"INSERT INTO LedgerJournal VALUES (@Id, @Amount, @Hash, @Time)\", record, tx);\n        await tx.CommitAsync(ct);\n        \n        _txQueue.Writer.TryWrite(record); // Background peer-sync broadcast\n        return new ReceiptTicket(record.Id, record.Timestamp, cart.Items);\n    }\n}','[\"C# 12\",\".NET 9\",\"WPF\",\"SQLite\",\"gRPC\",\"Cryptography\"]','https://github.com/x64_emkei','','images/carousel-retro.jpg',1,1,1,'2026-11-21 16:57:48','2026-11-21 16:57:48'),(18,'aegis-kernel-microvisor','CPP.001 // MICRO_HYPERVISOR','C++20 / Ring-0','cpp','AegisKernel Microvisor','Simulated Type-1 bare-metal microkernel with memory-enclave isolation and sub-microsecond context switching.','Bare-Metal x86_64 • Custom Bootloader • GDT/IDT Initialization','Zero syscall overhead • <420ns interrupt handling','Experimental • Systems Architecture Lab','A conceptual lightweight experimental micro-hypervisor designed in modern C++20 and x86_64 assembly. Implements hardware-assisted virtualization hooks, 4-level paging setup, ring-0 to ring-3 protection boundary controllers, and physical page allocation without standard C runtime dependencies.','[\"Hardware memory paging setup managing 4-level PML4 address translation tables.\",\"Custom Global Descriptor Table (GDT) and Interrupt Descriptor Table (IDT) handlers.\",\"Lock-free thread context save and restore routine written in inline assembly.\",\"Sub-microsecond high-resolution timer interrupt calibration via RDTSC instructions.\"]','AegisPaging.cpp','extern \"C\" void SwitchAddressSpace(uint64_t pml4_physical_base) noexcept {\n    asm volatile (\n        \"movq %0, %%cr3\\n\\t\"\n        : \n        : \"r\"(pml4_physical_base)\n        : \"memory\"\n    );\n}\n\nclass VirtualMemoryManager {\npublic:\n    void MapPage(uint64_t virtualAddr, uint64_t physAddr, uint32_t flags) noexcept {\n        uint64_t pml4_idx = (virtualAddr >> 39) & 0x1FF;\n        uint64_t pdpt_idx = (virtualAddr >> 30) & 0x1FF;\n        EnsureTablePresent(pml4_idx, pdpt_idx, flags);\n    }\n};','[\"C++20\",\"x86_64 ASM\",\"Memory Paging\",\"Ring-0\",\"Bare-Metal\"]','https://github.com/x64_emkei','','images/carousel-retro.jpg',2,1,1,'2026-11-21 16:57:48','2026-11-21 16:57:48'),(19,'neuropulse-vision-ai','PY.001 // EDGE_VISION_AI','Python 3.12 / CUDA','python','NeuroPulse Vision AI','Hardware-accelerated edge neural network classifying synthetic telemetry and biometric micro-expressions.','Ubuntu 24.04 • PyTorch 2.3 • TensorRT • CUDA 12','144 FPS inference • 3.2ms edge tensor latency','Active • Synthetic Neural Testing','A real-time deep learning computer vision pipeline engineered to ingest raw camera frames, extract feature tensors via custom quantized convolutional layers, and detect spatial telemetry vectors at sustained 144 FPS with low GPU thermal headroom.','[\"FP16 mixed-precision tensor optimization accelerating inference on NVIDIA silicon.\",\"Asynchronous frame decoding pipeline eliminating OpenCV thread blocking.\",\"Custom loss function prioritizing synthetic spatial alignment and landmark confidence.\",\"Real-time WebSocket streaming of detection bounding boxes and confidence heatmaps.\"]','NeuroPulseInference.py','import torch\nimport cv2\n\nclass NeuroPulseDetector:\n    def __init__(self, model_weights: str):\n        self.device = torch.device(\"cuda\" if torch.cuda.is_available() else \"cpu\")\n        self.model = torch.jit.load(model_weights).to(self.device).eval()\n        self.stream = torch.cuda.Stream()\n\n    @torch.inference_mode()\n    def process_frame(self, frame_bgr):\n        tensor = torch.from_numpy(frame_bgr).permute(2, 0, 1).unsqueeze(0).to(self.device, non_blocking=True).float() / 255.0\n        with torch.cuda.stream(self.stream):\n            predictions = self.model(tensor)\n            self.stream.synchronize()\n        return predictions.squeeze(0).cpu().numpy()','[\"Python 3.12\",\"PyTorch\",\"CUDA\",\"TensorRT\",\"OpenCV\"]','https://github.com/x64_emkei','','images/carousel-retro.jpg',3,1,1,'2026-11-21 16:57:48','2026-11-21 16:57:48'),(20,'quantummesh-zero-trust-tunnel','SYS.001 // NETWORK_DAEMON','Python / Go / Linux','systems','QuantumMesh Zero-Trust Tunnel','Autonomous mesh routing daemon managing dynamic encrypted WireGuard tunnels and gateway health checks.','Debian Linux • Systemd Daemon • WireGuard Kernel Module','<5ms failover • Sub-0.1% CPU background footprint','Active • 24/7 Homelab Mesh','An automated network mesh manager running as a persistent daemon. Continuously monitors route latency across multiple WAN and satellite links, orchestrating instantaneous failover between primary WireGuard endpoints and fallback encrypted mesh peers without dropping active socket connections.','[\"Dynamic ICMP & TCP heartbeat probing across heterogeneous WAN uplinks.\",\"Cryptographically authenticated state exchange protocol operating over UDP.\",\"Zero-packet-loss route table swapping via netlink socket interfaces.\",\"Automated ephemeral key rotation enforcing strict forward secrecy.\"]','MeshDaemon.py','import asyncio\nimport subprocess\n\nclass WireGuardMeshController:\n    def __init__(self, interface: str, peer_endpoints: list[str]):\n        self.interface = interface\n        self.peers = peer_endpoints\n\n    async def monitor_peers(self):\n        while True:\n            for peer in self.peers:\n                latency = await self._probe_latency(peer)\n                if latency > 150.0:\n                    await self._switch_route(peer, fallback=True)\n            await asyncio.sleep(2.0)\n\n    async def _probe_latency(self, endpoint: str) -> float:\n        proc = await asyncio.create_subprocess_exec(\"ping\", \"-c\", \"1\", \"-W\", \"1\", endpoint, stdout=asyncio.subprocess.PIPE)\n        await proc.communicate()\n        return 22.4 # milliseconds','[\"Linux Kernel\",\"WireGuard\",\"Python AsyncIO\",\"Networking\",\"Systemd\"]','https://github.com/x64_emkei','','images/carousel-retro.jpg',4,1,1,'2026-11-21 16:57:48','2026-11-21 16:57:48'),(21,'wasm-cyber-shell','WEB.001 // WASM_SHELL','WebAssembly / JS','web','WASM Cyber Shell','In-browser high-tech POSIX terminal emulator compiled to WebAssembly with virtual memory sandbox.','Browser Runtime • WebAssembly • Vanilla JS Canvas','60 FPS monospace canvas • Zero bundle overhead','Operational • Interactive Web Terminal','An interactive terminal environment running entirely within the client browser. Features custom VT100 escape code decoding, persistent in-memory virtual file systems via IndexedDB, and simulated systems diagnostics.','[\"Native WebAssembly bytecode execution directly inside web workers.\",\"Virtual POSIX file system persisting state across page refreshes via IndexedDB.\",\"Complete VT100 ANSI terminal escape sequence parser and rendering pipeline.\",\"Custom command interpreter supporting piping, redirection, and environment variables.\"]','WasmTerminalEngine.js','export class CyberTerminal {\n    constructor(canvasElement) {\n        this.canvas = canvasElement;\n        this.ctx = canvasElement.getContext(\'2d\');\n        this.cursor = { x: 0, y: 0 };\n    }\n\n    executeCommand(cmd) {\n        const [program, ...args] = cmd.trim().split(/\\s+/);\n        switch(program) {\n            case \'sysinfo\': return this.renderDiagnostics();\n            case \'clear\': return this.clearScreen();\n            default: return `SYS: Command \'${program}\' not found in /bin.`;\n        }\n    }\n}','[\"WebAssembly\",\"JavaScript ES6+\",\"HTML5 Canvas\",\"IndexedDB\"]','https://github.com/x64_emkei','','images/carousel-retro.jpg',5,0,1,'2026-11-21 16:57:48','2026-11-21 16:57:48'),(22,'chronostream-tsdb','CPP.002 // TIMESERIES_ENGINE','C++20 / Storage','cpp','ChronoStream TSDB Engine','Ultra-dense time-series columnar metrics engine with delta-of-delta floating-point compression.','Linux x86_64 • C++20 • SIMD AVX2','4.2M samples/sec ingestion • 12:1 compression ratio','Operational • Systems Engine','A custom in-memory columnar time-series storage engine written in modern C++20. Employs Gorilla-style delta-of-delta timestamp encoding and XOR floating-point metric packing to achieve exceptional density.','[\"Gorilla-style XOR floating-point time series compression.\",\"SIMD-vectorized filter queries scanning millions of metrics per second.\",\"Zero-copy disk serialization using memory-mapped I\\/O (mmap).\",\"Lock-free ring buffer ingesting concurrent IoT sensor streams.\"]','ChronoBlock.cpp','struct MetricSample {\n    uint64_t timestamp_ns;\n    double value;\n};\n\nclass TimeSeriesBlock {\npublic:\n    void AppendSample(const MetricSample& sample) {\n        uint64_t delta = sample.timestamp_ns - last_timestamp_;\n        uint64_t dod = delta - last_delta_;\n        CompressDeltaOfDelta(dod);\n        CompressFloatingPointXor(sample.value);\n    }\n};','[\"C++20\",\"AVX2\",\"Time-Series\",\"Memory Mapped I\\/O\"]','https://github.com/x64_emkei','','images/carousel-retro.jpg',6,0,1,'2026-11-21 16:57:48','2026-11-21 16:57:48'),(23,'omnithread-engine','CS.002 // CONCURRENCY_CORE','C# / Concurrency','csharp','OmniThread Engine','Custom task scheduler and priority thread dispatcher with work-stealing algorithms and telemetry hooks.','.NET 8 / 9 Runtime • Multi-core Workstation • High-Load Daemon','Zero worker thread starvation • Sub-microsecond task dispatch','Operational • Systems Framework','An advanced concurrent runtime scheduler built to manage computational workloads across heterogeneous CPU topologies. Employs work-stealing queues to balance bursty processing loads across available cores, exposing live execution metrics via event counters.','[\"Work-stealing double-ended queues minimizing lock contention among worker threads.\",\"Dynamic thread pool scaling adapting to hardware concurrency and load pressure.\",\"Prioritized task pipelines ensuring critical telemetry jobs bypass standard tasks.\",\"Integrated EventCounter telemetry exporting CPU utilization and queue depths.\"]','WorkStealingScheduler.cs','public sealed class WorkStealingScheduler : TaskScheduler\n{\n    private readonly BlockingCollection<Task>[] _queues;\n\n    protected override void QueueTask(Task task)\n    {\n        int idealCore = Thread.GetCurrentProcessorId() % _queues.Length;\n        if (!_queues[idealCore].TryAdd(task))\n        {\n            _queues[0].Add(task);\n        }\n    }\n}','[\"C# .NET 8\",\"Concurrency\",\"Threading\",\"Work-Stealing\",\"Diagnostics\"]','https://github.com/x64_emkei','','images/carousel-retro.jpg',7,0,1,'2026-11-21 16:57:48','2026-11-21 16:57:48'),(24,'hyperbus-service-broker','CS.003 // DISTRIBUTED_BUS','C# / Microservices','csharp','HyperBus Service Broker','Zero-allocation pub/sub event bus supporting RPC serialization over shared memory and loopback sockets.','.NET 8 / 9 • MemoryMappedFiles • Shared Memory IPC','2.4M msg/s throughput • Zero GC allocation on hot paths','Active • Distributed Core','A lightweight inter-process communication message bus built for local services and microservices. Leverages memory-mapped files and binary zero-copy serialization to achieve ultra-high message throughput without incurring garbage collection pauses.','[\"Zero-allocation binary message encoding using Span<byte> and Memory<T>.\",\"Shared-memory ring buffers enabling instantaneous cross-process data transfers.\",\"Topic-based publisher\\/subscriber model with dead-letter queue recovery.\",\"Built-in health watchdog and latency tracking per subscriber channel.\"]','HyperBusChannel.cs','public sealed class HyperBusPublisher\n{\n    private readonly MemoryMappedViewAccessor _sharedMem;\n\n    public unsafe void PublishEvent<T>(int topicId, ref T payload) where T : unmanaged\n    {\n        byte* ptr = null;\n        _sharedMem.SafeMemoryMappedViewHandle.AcquirePointer(ref ptr);\n        try {\n            Buffer.MemoryCopy(&payload, ptr + (topicId * 256), sizeof(T), sizeof(T));\n        } finally {\n            _sharedMem.SafeMemoryMappedViewHandle.ReleasePointer();\n        }\n    }\n}','[\"C#\",\"IPC\",\"gRPC\",\"Zero-Allocation\",\"High-Performance\"]','https://github.com/x64_emkei','','images/carousel-retro.jpg',8,0,1,'2026-11-21 16:57:48','2026-11-21 16:57:48'),(25,'aeroui-fluent-component-kit','CS.004 // GPU_UI_KIT','C# / UI Engine','csharp','AeroUI Fluent Component Kit','GPU-accelerated desktop UI control system bringing glassmorphic blur and retrofuturistic HUD styling to WPF.','Windows 10/11 • WPF Direct3D Interop • Custom XAML Templates','60 FPS compositing • Real-time hardware composition blur','Active • UI/UX Design System','A comprehensive modern design toolkit for enterprise C# Windows desktop software. Integrates Windows DWM composition APIs to render authentic acrylic glassmorphism, glowing cyan/amber telemetry gauges, and responsive vector controls.','[\"DirectX-accelerated frosted glass backdrop filters rendered inside WPF viewports.\",\"High-contrast theme tokens adhering to modern industrial design standards.\",\"Custom HUD telemetry dials, linear progress indicators, and hex-grid graphs.\",\"Interactive window controls with smooth minimize, maximize, and drag physics.\"]','AeroGlassPanel.cs','public class AeroGlassPanel : ContentControl\n{\n    public static readonly DependencyProperty BlurRadiusProperty =\n        DependencyProperty.Register(nameof(BlurRadius), typeof(double), typeof(AeroGlassPanel), new PropertyMetadata(20.0));\n\n    protected override void OnRender(DrawingContext dc)\n    {\n        base.OnRender(dc);\n        dc.DrawRectangle(new SolidColorBrush(Color.FromArgb(180, 14, 18, 26)), null, new Rect(RenderSize));\n    }\n}','[\"C# WPF\",\"DirectX\",\"Glassmorphism\",\"UI Components\",\"Custom XAML\"]','https://github.com/x64_emkei','','images/carousel-retro.jpg',9,0,1,'2026-11-21 16:57:48','2026-11-21 16:57:48'),(26,'specter-async-deep-scraper','PY.003 // DISTRIBUTED_SCRAPER','Python / Scraper','python','Specter Async Deep Scraper','Distributed asynchronous web scraping pipeline with automatic rotating proxy pools and TLS fingerprint spoofing.','Python 3.12 • AsyncIO • Aiohttp • Redis Distributed Queue','5,000 req/s throughput • Automated CAPTCHA evasion','Active • Data Pipeline','A high-throughput distributed crawling engine designed for large-scale data ingestion. Employs asynchronous coroutine pools, automatic user-agent and JA3 TLS fingerprint spoofing, and Redis-backed state queues to bypass rate limits and anti-bot defenses.','[\"Asynchronous connection pooling maintaining thousands of active HTTP sessions.\",\"Dynamic JA3 TLS fingerprint randomized rotation preventing cloud anti-bot blocks.\",\"Distributed deduplication index utilizing Redis bloom filters.\",\"Real-time structured HTML extraction with automatic schema inference.\"]','SpecterCrawler.py','import aiohttp\nimport asyncio\n\nasync def fetch_worker(queue, session):\n    while not queue.empty():\n        url = await queue.get()\n        try:\n            async with session.get(url, timeout=5) as response:\n                html = await response.text()\n                parse_telemetry_schema(html)\n        finally:\n            queue.task_done()','[\"Python 3.12\",\"AsyncIO\",\"Aiohttp\",\"Redis\",\"Web Scraping\"]','https://github.com/x64_emkei','','images/carousel-retro.jpg',10,0,1,'2026-11-21 16:57:48','2026-11-21 16:57:48'),(27,'packetsnoop-protocol-sniffer','PY.004 // NETSEC_ANALYZER','Python / NetSec','python','PacketSnoop Protocol Sniffer','Raw socket network sniffer performing deep packet inspection, TCP stream reassembly, and TLS handshake decryption.','Linux / Scapy Core • Raw Socket AF_PACKET • PCAP Parser','Zero-copy packet capture • Sustained 1Gbps link inspection','Operational • NetSec Testing','A network forensics utility that captures raw Ethernet frames directly from the kernel network stack. Decodes protocol layers from IP down to payload data, reassembles TCP sessions, and identifies suspicious packet bursts or DNS tunneling attempts.','[\"Kernel-level raw socket packet interception with zero memory duplication.\",\"Automatic reassembly of fragmented TCP packets and session stream reconstruction.\",\"Heuristic anomaly detector flagging port scan sweeps and rogue DHCP responses.\",\"Export engine supporting industry-standard PCAP format and JSON streaming.\"]','PacketSnoopCore.py','import socket\nimport struct\n\ndef capture_raw_ethernet():\n    raw_socket = socket.socket(socket.AF_PACKET, socket.SOCK_RAW, socket.ntohs(0x0003))\n    while True:\n        packet_data, _ = raw_socket.recvfrom(65535)\n        eth_header = packet_data[:14]\n        dest_mac, src_mac, proto = struct.unpack(\"!6s6sH\", eth_header)\n        if proto == 0x0800:\n            analyze_ip_payload(packet_data[14:])','[\"Python 3\",\"Raw Sockets\",\"Network Security\",\"PCAP\",\"Protocol Forensics\"]','https://github.com/x64_emkei','','images/carousel-retro.jpg',11,0,1,'2026-11-21 16:57:48','2026-11-21 16:57:48'),(28,'spectra-3d-audio-visualizer','WEB.002 // 3D_AUDIO_GL','WebGL / WebDev','web','Spectra 3D Audio Visualizer','Hardware-accelerated 3D audio frequency visualizer rendering real-time FFT spectrum bars with custom GLSL shaders.','Three.js • Web Audio API • WebGL 2.0 • GLSL Fragment Shaders','120Hz smooth animations • Low audio latency (<10ms)','Active • Creative Web Tech','A dynamic 3D web graphics application that transforms microphone or audio inputs into an interactive holographic waveform. Computes live Fast Fourier Transform (FFT) frequency bands and feeds them into custom GLSL vertex and fragment shaders for chromatic aberration and neon dispersion.','[\"Web Audio API AnalyserNode computing 2048-point Fast Fourier Transform (FFT) bins.\",\"Custom Three.js shader materials with animated wave displacement and Bloom glows.\",\"Interactive camera orbit controls responding to mouse and gyroscope movement.\",\"Dynamic palette shifting responding to bass frequency peaks and transients.\"]','SpectraAudioVisualizer.js','const audioCtx = new AudioContext();\nconst analyser = audioCtx.createAnalyser();\nanalyser.fftSize = 2048;\nconst freqData = new Uint8Array(analyser.frequencyBinCount);\n\nfunction renderLoop() {\n    requestAnimationFrame(renderLoop);\n    analyser.getByteFrequencyData(freqData);\n    meshMaterial.uniforms.u_frequencies.value = freqData;\n    renderer.render(scene, camera);\n}','[\"Three.js\",\"WebGL\",\"Web Audio API\",\"GLSL\",\"Interactive 3D\"]','https://github.com/x64_emkei','','images/carousel-retro.jpg',12,0,1,'2026-11-21 16:57:48','2026-11-21 16:57:48'),(29,'nexus-protocol-p2p-chat','WEB.003 // P2P_MESSAGING','WebRTC / Sockets','web','Nexus Protocol P2P Chat','End-to-end encrypted peer-to-peer browser messenger with ephemeral rooms, WebRTC data channels, and zero logs.','WebRTC DataChannels • WebCrypto API • WebSocket Signaling','P2P sub-20ms latency • AES-GCM-256 cipher encryption','Active • Decentralized Web Lab','A browser-based decentralized communication system. Establishes direct peer-to-peer data pipes between clients using WebRTC without routing message contents through central servers. All messages are encrypted locally using cryptographic keys negotiated via ECDH exchange.','[\"Direct browser-to-browser WebRTC DataChannel architecture with zero server logging.\",\"End-to-end encryption using AES-GCM-256 with ephemeral cryptographic keypairs.\",\"Chunked peer-to-peer file transfer engine with checksum verification.\",\"Real-time typing presence and room status indicators.\"]','NexusPeerSession.js','class PeerSession {\n    constructor() {\n        this.pc = new RTCPeerConnection({ iceServers: [{ urls: \"stun:stun.l.google.com:19302\" }] });\n        this.dataChannel = this.pc.createDataChannel(\"nexus_p2p_channel\");\n        this.dataChannel.onmessage = (e) => this.decryptAndDisplay(e.data);\n    }\n\n    async sendSecureMessage(plainText) {\n        const encrypted = await CryptoEngine.encryptAES(plainText, this.sharedSecret);\n        this.dataChannel.send(encrypted);\n    }\n}','[\"WebRTC\",\"WebCrypto API\",\"WebSockets\",\"P2P\",\"Privacy\"]','https://github.com/x64_emkei','','images/carousel-retro.jpg',13,0,1,'2026-11-21 16:57:48','2026-11-21 16:57:48'),(30,'glassmorphic-os-dashboard','WEB.004 // WEB_OS_DESKTOP','CSS Glass / Vanilla JS','web','Glassmorphic OS Dashboard','Desktop-class responsive web workspace featuring draggable floating windows, minimize trays, and live HUD widgets.','Vanilla JavaScript • CSS Grid • Hardware Backdrop Blur','Zero external frameworks • Sub-16ms layout recalculations','Active • Web Interface Lab','An in-browser operating system simulation demonstrating the capabilities of modern CSS Grid and vanilla JavaScript. Features floating window management, window snapping, minimize/maximize physics, dock status indicators, and persistent widget preferences.','[\"Custom multi-window manager supporting drag, resize, z-index elevation, and minimization.\",\"Modular CSS Grid Bento layouts adapting fluidly from 4K displays to mobile screens.\",\"State persistence storing window positions and custom settings in LocalStorage.\",\"Zero external runtime dependencies ensuring instant page delivery and optimal performance.\"]','WindowManager.js','class WindowManager {\n    static bringToFront(winEl) {\n        const topZ = Math.max(...Array.from(document.querySelectorAll(\".os-window\")).map(w => parseInt(w.style.zIndex || 10)));\n        winEl.style.zIndex = topZ + 1;\n    }\n\n    static toggleMinimize(winEl) {\n        winEl.classList.toggle(\"is-minimized\");\n        const isCollapsed = winEl.classList.contains(\"is-minimized\");\n        winEl.querySelector(\".window-body\").style.display = isCollapsed ? \"none\" : \"block\";\n    }\n}','[\"Vanilla JS\",\"CSS Grid\",\"Glassmorphism\",\"Window Controls\",\"Responsive\"]','https://github.com/x64_emkei','','images/carousel-retro.jpg',14,0,1,'2026-11-21 16:57:48','2026-11-21 16:57:48'),(31,'vortex-8-hardware-emulator','CPP.003 // EMULATION_CORE','C++ / Emulation','cpp','Vortex-8 Hardware Emulator','Cycle-accurate virtual CPU emulator featuring opcode disassembler, memory debugger, and 60 FPS video synthesizer.','C++17 • SDL2 Library • Virtual Machine Core','100% cycle-accurate opcode timing • 60 FPS video sync','Operational • Systems Research','A complete virtual microprocessor and hardware system emulator written in C++17. Faithfully recreates the instruction fetch-decode-execute cycle, 16 8-bit registers, 4KB memory space, timer delays, and monochromatic screen graphics with integrated audio beeper.','[\"Full implementation of 35 standard CPU opcodes with bitwise flag validation.\",\"Integrated interactive disassembly viewer and live memory register hex inspector.\",\"Audio tone synthesizer generating accurate square wave sound pulses via SDL2.\",\"Cycle-accurate execution loop calibrated with high-resolution CPU clocks.\"]','VortexCpuCore.cpp','void VortexCpu::Cycle() {\n    uint16_t opcode = (memory[pc] << 8) | memory[pc + 1];\n    pc += 2;\n    switch (opcode & 0xF000) {\n        case 0xA000: indexRegister = opcode & 0x0FFF; break;\n        case 0x6000: V[(opcode & 0x0F00) >> 8] = opcode & 0x00FF; break;\n        case 0xD000: DrawSprite(V[(opcode & 0x0F00) >> 8], V[(opcode & 0x00F0) >> 4], opcode & 0x000F); break;\n    }\n}','[\"C++17\",\"SDL2\",\"Virtual Machine\",\"Emulation\",\"Computer Architecture\"]','https://github.com/x64_emkei','','images/carousel-retro.jpg',15,0,1,'2026-11-21 16:57:48','2026-11-21 16:57:48'),(32,'simd-vector-math-engine','CPP.004 // SIMD_VECTOR_MATH','C++20 / SIMD','cpp','SIMD Vector Math Engine','Hardware-intrinsics vectorized matrix math library accelerating 4x4 coordinate transformations with AVX2.','C++20 • AVX2 / FMA Intrinsics • Clang / MSVC','8x throughput increase over scalar math • Zero cache misses','Operational • High-Performance Math','A vectorized mathematics library designed for game engines and physics simulations. Replaces traditional loop-based matrix multiplications and vector normalizations with single-instruction multiple-data (SIMD) hardware intrinsic instructions, processing 4 coordinate sets simultaneously.','[\"AVX2 and Fused Multiply-Add (FMA) assembly intrinsic implementation.\",\"Sub-nanosecond 4x4 matrix multiplication and vector dot product calculations.\",\"Cache-aligned memory storage preventing unaligned load penalties.\",\"Comprehensive automated test suite benchmarking against standard scalar math routines.\"]','SimdMatrix4x4.hpp','#include <immintrin.h>\n\nstruct alignas(32) Mat4x4 {\n    __m256 cols[2];\n\n    static Mat4x4 Multiply(const Mat4x4& a, const Mat4x4& b) noexcept {\n        Mat4x4 result;\n        __m256 row0 = _mm256_load_ps((const float*)&a.cols[0]);\n        __m256 row1 = _mm256_load_ps((const float*)&a.cols[1]);\n        result.cols[0] = _mm256_fmadd_ps(row0, b.cols[0], result.cols[0]);\n        result.cols[1] = _mm256_fmadd_ps(row1, b.cols[1], result.cols[1]);\n        return result;\n    }\n};','[\"C++20\",\"AVX2\",\"Intrinsics\",\"Linear Algebra\",\"High-Performance\"]','https://github.com/x64_emkei','','images/carousel-retro.jpg',16,0,1,'2026-11-21 16:57:48','2026-11-21 16:57:48');
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `services` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `category` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `capabilities_json` text DEFAULT NULL,
  `icon_name` varchar(50) DEFAULT NULL,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_is_published` (`is_published`),
  KEY `idx_display_order` (`display_order`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES (5,'Mission-Critical Desktop & POS Engineering','Systems Software','Engineering high-reliability, zero-downtime offline applications using modern C#/.NET 9, SQLite Write-Ahead Logging, hardware scanner abstraction, and LAN peer-to-peer sync.',NULL,NULL,1,1,'2026-11-21 16:57:48'),(6,'High-Performance Web & Full-Stack CMS','Web Architecture','Crafting secure, portable PHP 8.3+ & MySQL web platforms, custom CMS engines, REST APIs, and responsive cybernetic interfaces optimized for low-latency delivery.',NULL,NULL,2,1,'2026-11-21 16:57:48'),(7,'Virtualization & Zero-Trust Homelab Infrastructure','Cloud & Infrastructure','Deploying secure Proxmox VE hypervisors, automated encrypted WireGuard mesh networks, ZFS storage arrays, Docker container clusters, and continuous telemetry monitoring.',NULL,NULL,3,1,'2026-11-21 16:57:48'),(8,'Computer Vision & Deep Learning Pipelines','Applied AI / ML','Building edge neural network inference systems using PyTorch, CUDA, and OpenCV with TensorRT FP16 quantization for low-latency real-time video analytics.',NULL,NULL,4,1,'2026-11-21 16:57:48');
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_settings`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `site_settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `setting_group` varchar(50) NOT NULL DEFAULT 'general',
  `description` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`),
  KEY `idx_setting_key` (`setting_key`),
  KEY `idx_setting_group` (`setting_group`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_settings`
--

LOCK TABLES `site_settings` WRITE;
/*!40000 ALTER TABLE `site_settings` DISABLE KEYS */;
INSERT INTO `site_settings` VALUES (9,'site_title','Michael Benedict Ordenes | x64emkei.dev','general','Public title of the portfolio','2026-11-21 16:57:48'),(10,'site_tagline','Systems Architecture, C# .NET, C++20, and High-Performance Software Engineering','general','Meta tagline','2026-11-21 16:57:48'),(11,'meta_description','Michael Benedict Ordenes (x64emkei) — Computer Science Student, IT Enthusiast & Systems Developer. High-tech HUD portfolio and systems engineering showcase.','seo','Default SEO description','2026-11-21 16:57:48'),(12,'meta_keywords','Michael Benedict Ordenes, x64emkei, developer portfolio, systems architect, C#, .NET 9, C++20, PHP CMS, MySQL, Proxmox, homelab','seo','Meta keywords list','2026-11-21 16:57:48'),(13,'contact_email','mordenes@acm.org','contact','Primary inbox contact email','2026-11-21 16:57:48'),(14,'theme_default','dark','appearance','Default HUD theme mode (dark or light)','2026-11-21 16:57:48'),(15,'primary_domain','x64emkei.dpdns.org','hosting','Primary configured domain','2026-11-21 16:57:48'),(16,'copyright_text','© 2026 Michael Benedict Ordenes. Systems Architecture // All telemetry active.','general','Footer copyright label','2026-11-21 16:57:48');
/*!40000 ALTER TABLE `site_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `skills`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `skills` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `proficiency_level` int(11) NOT NULL DEFAULT 85,
  `icon_svg` text DEFAULT NULL,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_category` (`category`),
  KEY `idx_display_order` (`display_order`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `skills`
--

LOCK TABLES `skills` WRITE;
/*!40000 ALTER TABLE `skills` DISABLE KEYS */;
INSERT INTO `skills` VALUES (15,'Languages','C# / .NET 9',92,NULL,1,1,'2026-11-21 16:57:48'),(16,'Languages','C++20 / Systems',85,NULL,2,1,'2026-11-21 16:57:48'),(17,'Languages','Python 3.12 / PyTorch',88,NULL,3,1,'2026-11-21 16:57:48'),(18,'Languages','PHP 8.3+ / MySQL',90,NULL,4,1,'2026-11-21 16:57:48'),(19,'Languages','JavaScript (ES6+) / TypeScript',90,NULL,5,1,'2026-11-21 16:57:48'),(20,'Languages','SQL / Database Architecture',88,NULL,6,1,'2026-11-21 16:57:48'),(21,'Languages','x86_64 Assembly / Low-Level',75,NULL,7,1,'2026-11-21 16:57:48'),(22,'Frameworks & Platforms','WPF / Desktop UI Architecture',90,NULL,1,1,'2026-11-21 16:57:48'),(23,'Frameworks & Platforms','PyTorch / TensorRT / CUDA',82,NULL,2,1,'2026-11-21 16:57:48'),(24,'Frameworks & Platforms','Linux Systems Administration',92,NULL,3,1,'2026-11-21 16:57:48'),(25,'Frameworks & Platforms','Proxmox VE & Virtualization',88,NULL,4,1,'2026-11-21 16:57:48'),(26,'Frameworks & Platforms','Docker & Containerization',85,NULL,5,1,'2026-11-21 16:57:48'),(27,'Frameworks & Platforms','WireGuard & Zero-Trust Networking',89,NULL,6,1,'2026-11-21 16:57:48'),(28,'Frameworks & Platforms','Git / GitHub CI/CD Actions',94,NULL,7,1,'2026-11-21 16:57:48');
/*!40000 ALTER TABLE `skills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `social_links`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `social_links` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `platform` varchar(50) NOT NULL,
  `label` varchar(100) NOT NULL,
  `url` varchar(255) NOT NULL,
  `icon_svg` text DEFAULT NULL,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_display_order` (`display_order`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `social_links`
--

LOCK TABLES `social_links` WRITE;
/*!40000 ALTER TABLE `social_links` DISABLE KEYS */;
INSERT INTO `social_links` VALUES (4,'github','GitHub','https://github.com/x64_emkei',NULL,1,1,'2026-11-21 16:57:48'),(5,'linkedin','LinkedIn','https://linkedin.com/in/michael-ordenes/',NULL,2,1,'2026-11-21 16:57:48'),(6,'email','Email','mailto:mordenes@acm.org',NULL,3,1,'2026-11-21 16:57:48');
/*!40000 ALTER TABLE `social_links` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'admin',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `failed_logins` int(11) NOT NULL DEFAULT 0,
  `locked_until` datetime DEFAULT NULL,
  `last_login_at` datetime DEFAULT NULL,
  `last_login_ip` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `idx_username` (`username`),
  KEY `idx_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-11-22  0:58:50
