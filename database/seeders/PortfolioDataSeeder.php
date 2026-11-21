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

    public function run(): void
    {
        $this->seedProfile();
        $this->seedProjects();
        $this->seedHardwareNodes();
        $this->seedSkills();
        $this->seedExperiences();
        $this->seedEducation();
        $this->seedServices();
        $this->seedSocialLinks();
        $this->seedSiteSettings();
    }

    private function seedProfile(): void
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM `profile`");
        if ((int)$stmt->fetchColumn() > 0) return;

        $sql = "INSERT INTO `profile` 
            (`full_name`, `title`, `tagline`, `bio_short`, `bio_full`, `avatar_url`, `cover_url`, `location`, `availability_status`, `resume_url`, `email`)
            VALUES
            (:name, :title, :tagline, :short, :full, :avatar, :cover, :loc, :avail, :resume, :email)";
        
        $this->pdo->prepare($sql)->execute([
            ':name' => 'Michael Benedict Ordenes',
            ':title' => 'Computer Science Student, IT Enthusiast & Developer',
            ':tagline' => 'Architecting resilient software systems, low-level micro-kernels, and high-performance distributed architectures.',
            ':short' => 'Computer Science scholar and systems engineer focused on high-performance desktop platforms, embedded POS telemetry, computer vision pipelines, and resilient network infrastructures.',
            ':full' => "I engineer software at the intersection of systems architecture, low-level execution efficiency, and intuitive human-computer interaction. From designing autonomous enterprise point-of-sale engines in modern C# and .NET to experimenting with microkernels in C++20 and training edge neural vision networks in PyTorch, I build systems built to endure.",
            ':avatar' => 'images/me_2.png',
            ':cover' => 'images/carousel-workspace.jpg',
            ':loc' => 'Laguna, Philippines',
            ':avail' => 'Available for Systems & Web Engineering',
            ':resume' => '#contact',
            ':email' => 'mordenes@acm.org'
        ]);
    }

    private function seedProjects(): void
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM `projects`");
        if ((int)$stmt->fetchColumn() > 0) return;

        $projects = [
            [
                'slug' => 'valkyrie-pos-pro',
                'code_id' => 'CS.001 // ENTERPRISE_POS',
                'category' => 'C# 12 / .NET 9',
                'filter_tag' => 'csharp',
                'title' => 'Valkyrie POS Pro',
                'tagline' => 'Autonomous offline retail point-of-sale terminal engine with cryptographic peer sync and scanner abstraction.',
                'environment' => 'Windows 11 / Embedded POS • .NET 9 Desktop • SQLite WAL',
                'performance_metric' => '0.8ms transaction write • Sub-10ms peer sync loop',
                'operational_status' => 'Operational • Simulated Enterprise Stack',
                'description' => 'A mission-critical Point-of-Sale architecture engineered for zero-downtime retail environments. Features a resilient local write-ahead cryptographic ledger that operates seamlessly when disconnected from WAN and syncs peer-to-peer across LAN terminals using authenticated gRPC channels.',
                'features' => [
                    'Local Write-Ahead Transaction Ledger (WAL) guaranteeing atomic state consistency.',
                    'Peer-to-peer multi-terminal catalog synchronization over LAN with automatic conflict resolution.',
                    'Direct hardware abstraction layer for ESC/POS thermal printers and barcode scanners.',
                    'GPU-accelerated WPF touch-first checkout UI rendering fluid 60 FPS transitions.'
                ],
                'filename' => 'ValkyrieLedgerEngine.cs',
                'code' => "public sealed class TransactionLedger : IDisposable\n{\n    private readonly SqliteConnection _db;\n    private readonly Channel<TransactionRecord> _txQueue;\n\n    public async Task<ReceiptTicket> CommitSaleAsync(CartPayload cart, CancellationToken ct)\n    {\n        var hash = CryptoProvider.ComputeSha256(cart.Serialize());\n        using var tx = await _db.BeginTransactionAsync(IsolationLevel.Snapshot, ct);\n        \n        var record = new TransactionRecord(Guid.NewGuid(), cart.TotalCents, hash, DateTime.UtcNow);\n        await _db.ExecuteAsync(\"INSERT INTO LedgerJournal VALUES (@Id, @Amount, @Hash, @Time)\", record, tx);\n        await tx.CommitAsync(ct);\n        \n        _txQueue.Writer.TryWrite(record); // Background peer-sync broadcast\n        return new ReceiptTicket(record.Id, record.Timestamp, cart.Items);\n    }\n}",
                'tech' => ['C# 12', '.NET 9', 'WPF', 'SQLite', 'gRPC', 'Cryptography'],
                'github' => 'https://github.com/x64_emkei',
                'demo' => '',
                'order' => 1,
                'featured' => 1
            ],
            [
                'slug' => 'aegis-kernel-microvisor',
                'code_id' => 'CPP.001 // MICRO_HYPERVISOR',
                'category' => 'C++20 / Ring-0',
                'filter_tag' => 'cpp',
                'title' => 'AegisKernel Microvisor',
                'tagline' => 'Simulated Type-1 bare-metal microkernel with memory-enclave isolation and sub-microsecond context switching.',
                'environment' => 'Bare-Metal x86_64 • Custom Bootloader • GDT/IDT Initialization',
                'performance_metric' => 'Zero syscall overhead • <420ns interrupt handling',
                'operational_status' => 'Experimental • Systems Architecture Lab',
                'description' => 'A conceptual lightweight experimental micro-hypervisor designed in modern C++20 and x86_64 assembly. Implements hardware-assisted virtualization hooks, 4-level paging setup, ring-0 to ring-3 protection boundary controllers, and physical page allocation without standard C runtime dependencies.',
                'features' => [
                    'Hardware memory paging setup managing 4-level PML4 address translation tables.',
                    'Custom Global Descriptor Table (GDT) and Interrupt Descriptor Table (IDT) handlers.',
                    'Lock-free thread context save and restore routine written in inline assembly.',
                    'Sub-microsecond high-resolution timer interrupt calibration via RDTSC instructions.'
                ],
                'filename' => 'AegisPaging.cpp',
                'code' => "extern \"C\" void SwitchAddressSpace(uint64_t pml4_physical_base) noexcept {\n    asm volatile (\n        \"movq %0, %%cr3\\n\\t\"\n        : \n        : \"r\"(pml4_physical_base)\n        : \"memory\"\n    );\n}\n\nclass VirtualMemoryManager {\npublic:\n    void MapPage(uint64_t virtualAddr, uint64_t physAddr, uint32_t flags) noexcept {\n        uint64_t pml4_idx = (virtualAddr >> 39) & 0x1FF;\n        uint64_t pdpt_idx = (virtualAddr >> 30) & 0x1FF;\n        EnsureTablePresent(pml4_idx, pdpt_idx, flags);\n    }\n};",
                'tech' => ['C++20', 'x86_64 ASM', 'Memory Paging', 'Ring-0', 'Bare-Metal'],
                'github' => 'https://github.com/x64_emkei',
                'demo' => '',
                'order' => 2,
                'featured' => 1
            ],
            [
                'slug' => 'neuropulse-vision-ai',
                'code_id' => 'PY.001 // EDGE_VISION_AI',
                'category' => 'Python 3.12 / CUDA',
                'filter_tag' => 'python',
                'title' => 'NeuroPulse Vision AI',
                'tagline' => 'Hardware-accelerated edge neural network classifying synthetic telemetry and biometric micro-expressions.',
                'environment' => 'Ubuntu 24.04 • PyTorch 2.3 • TensorRT • CUDA 12',
                'performance_metric' => '144 FPS inference • 3.2ms edge tensor latency',
                'operational_status' => 'Active • Synthetic Neural Testing',
                'description' => 'A real-time deep learning computer vision pipeline engineered to ingest raw camera frames, extract feature tensors via custom quantized convolutional layers, and detect spatial telemetry vectors at sustained 144 FPS with low GPU thermal headroom.',
                'features' => [
                    'FP16 mixed-precision tensor optimization accelerating inference on NVIDIA silicon.',
                    'Asynchronous frame decoding pipeline eliminating OpenCV thread blocking.',
                    'Custom loss function prioritizing synthetic spatial alignment and landmark confidence.',
                    'Real-time WebSocket streaming of detection bounding boxes and confidence heatmaps.'
                ],
                'filename' => 'NeuroPulseInference.py',
                'code' => "import torch\nimport cv2\n\nclass NeuroPulseDetector:\n    def __init__(self, model_weights: str):\n        self.device = torch.device(\"cuda\" if torch.cuda.is_available() else \"cpu\")\n        self.model = torch.jit.load(model_weights).to(self.device).eval()\n        self.stream = torch.cuda.Stream()\n\n    @torch.inference_mode()\n    def process_frame(self, frame_bgr):\n        tensor = torch.from_numpy(frame_bgr).permute(2, 0, 1).unsqueeze(0).to(self.device, non_blocking=True).float() / 255.0\n        with torch.cuda.stream(self.stream):\n            predictions = self.model(tensor)\n            self.stream.synchronize()\n        return predictions.squeeze(0).cpu().numpy()",
                'tech' => ['Python 3.12', 'PyTorch', 'CUDA', 'TensorRT', 'OpenCV'],
                'github' => 'https://github.com/x64_emkei',
                'demo' => '',
                'order' => 3,
                'featured' => 1
            ],
            [
                'slug' => 'quantummesh-zero-trust-tunnel',
                'code_id' => 'SYS.001 // NETWORK_DAEMON',
                'category' => 'Python / Go / Linux',
                'filter_tag' => 'systems',
                'title' => 'QuantumMesh Zero-Trust Tunnel',
                'tagline' => 'Autonomous mesh routing daemon managing dynamic encrypted WireGuard tunnels and gateway health checks.',
                'environment' => 'Debian Linux • Systemd Daemon • WireGuard Kernel Module',
                'performance_metric' => '<5ms failover • Sub-0.1% CPU background footprint',
                'operational_status' => 'Active • 24/7 Homelab Mesh',
                'description' => 'An automated network mesh manager running as a persistent daemon. Continuously monitors route latency across multiple WAN and satellite links, orchestrating instantaneous failover between primary WireGuard endpoints and fallback encrypted mesh peers without dropping active socket connections.',
                'features' => [
                    'Dynamic ICMP & TCP heartbeat probing across heterogeneous WAN uplinks.',
                    'Cryptographically authenticated state exchange protocol operating over UDP.',
                    'Zero-packet-loss route table swapping via netlink socket interfaces.',
                    'Automated ephemeral key rotation enforcing strict forward secrecy.'
                ],
                'filename' => 'MeshDaemon.py',
                'code' => "import asyncio\nimport subprocess\n\nclass WireGuardMeshController:\n    def __init__(self, interface: str, peer_endpoints: list[str]):\n        self.interface = interface\n        self.peers = peer_endpoints\n\n    async def monitor_peers(self):\n        while True:\n            for peer in self.peers:\n                latency = await self._probe_latency(peer)\n                if latency > 150.0:\n                    await self._switch_route(peer, fallback=True)\n            await asyncio.sleep(2.0)\n\n    async def _probe_latency(self, endpoint: str) -> float:\n        proc = await asyncio.create_subprocess_exec(\"ping\", \"-c\", \"1\", \"-W\", \"1\", endpoint, stdout=asyncio.subprocess.PIPE)\n        await proc.communicate()\n        return 22.4 # milliseconds",
                'tech' => ['Linux Kernel', 'WireGuard', 'Python AsyncIO', 'Networking', 'Systemd'],
                'github' => 'https://github.com/x64_emkei',
                'demo' => '',
                'order' => 4,
                'featured' => 1
            ],
            [
                'slug' => 'wasm-cyber-shell',
                'code_id' => 'WEB.001 // WASM_SHELL',
                'category' => 'WebAssembly / JS',
                'filter_tag' => 'web',
                'title' => 'WASM Cyber Shell',
                'tagline' => 'In-browser high-tech POSIX terminal emulator compiled to WebAssembly with virtual memory sandbox.',
                'environment' => 'Browser Runtime • WebAssembly • Vanilla JS Canvas',
                'performance_metric' => '60 FPS monospace canvas • Zero bundle overhead',
                'operational_status' => 'Operational • Interactive Web Terminal',
                'description' => 'An interactive terminal environment running entirely within the client browser. Features custom VT100 escape code decoding, persistent in-memory virtual file systems via IndexedDB, and simulated systems diagnostics.',
                'features' => [
                    'Native WebAssembly bytecode execution directly inside web workers.',
                    'Virtual POSIX file system persisting state across page refreshes via IndexedDB.',
                    'Complete VT100 ANSI terminal escape sequence parser and rendering pipeline.',
                    'Custom command interpreter supporting piping, redirection, and environment variables.'
                ],
                'filename' => 'WasmTerminalEngine.js',
                'code' => "export class CyberTerminal {\n    constructor(canvasElement) {\n        this.canvas = canvasElement;\n        this.ctx = canvasElement.getContext('2d');\n        this.cursor = { x: 0, y: 0 };\n    }\n\n    executeCommand(cmd) {\n        const [program, ...args] = cmd.trim().split(/\\s+/);\n        switch(program) {\n            case 'sysinfo': return this.renderDiagnostics();\n            case 'clear': return this.clearScreen();\n            default: return `SYS: Command '\${program}' not found in /bin.`;\n        }\n    }\n}",
                'tech' => ['WebAssembly', 'JavaScript ES6+', 'HTML5 Canvas', 'IndexedDB'],
                'github' => 'https://github.com/x64_emkei',
                'demo' => '',
                'order' => 5,
                'featured' => 0
            ],
            [
                'slug' => 'chronostream-tsdb',
                'code_id' => 'CPP.002 // TIMESERIES_ENGINE',
                'category' => 'C++20 / Storage',
                'filter_tag' => 'cpp',
                'title' => 'ChronoStream TSDB Engine',
                'tagline' => 'Ultra-dense time-series columnar metrics engine with delta-of-delta floating-point compression.',
                'environment' => 'Linux x86_64 • C++20 • SIMD AVX2',
                'performance_metric' => '4.2M samples/sec ingestion • 12:1 compression ratio',
                'operational_status' => 'Operational • Systems Engine',
                'description' => 'A custom in-memory columnar time-series storage engine written in modern C++20. Employs Gorilla-style delta-of-delta timestamp encoding and XOR floating-point metric packing to achieve exceptional density.',
                'features' => [
                    'Gorilla-style XOR floating-point time series compression.',
                    'SIMD-vectorized filter queries scanning millions of metrics per second.',
                    'Zero-copy disk serialization using memory-mapped I/O (mmap).',
                    'Lock-free ring buffer ingesting concurrent IoT sensor streams.'
                ],
                'filename' => 'ChronoBlock.cpp',
                'code' => "struct MetricSample {\n    uint64_t timestamp_ns;\n    double value;\n};\n\nclass TimeSeriesBlock {\npublic:\n    void AppendSample(const MetricSample& sample) {\n        uint64_t delta = sample.timestamp_ns - last_timestamp_;\n        uint64_t dod = delta - last_delta_;\n        CompressDeltaOfDelta(dod);\n        CompressFloatingPointXor(sample.value);\n    }\n};",
                'tech' => ['C++20', 'AVX2', 'Time-Series', 'Memory Mapped I/O'],
                'github' => 'https://github.com/x64_emkei',
                'demo' => '',
                'order' => 6,
                'featured' => 0
            ],
            [
                'slug' => 'omnithread-engine',
                'code_id' => 'CS.002 // CONCURRENCY_CORE',
                'category' => 'C# / Concurrency',
                'filter_tag' => 'csharp',
                'title' => 'OmniThread Engine',
                'tagline' => 'Custom task scheduler and priority thread dispatcher with work-stealing algorithms and telemetry hooks.',
                'environment' => '.NET 8 / 9 Runtime • Multi-core Workstation • High-Load Daemon',
                'performance_metric' => 'Zero worker thread starvation • Sub-microsecond task dispatch',
                'operational_status' => 'Operational • Systems Framework',
                'description' => 'An advanced concurrent runtime scheduler built to manage computational workloads across heterogeneous CPU topologies. Employs work-stealing queues to balance bursty processing loads across available cores, exposing live execution metrics via event counters.',
                'features' => [
                    'Work-stealing double-ended queues minimizing lock contention among worker threads.',
                    'Dynamic thread pool scaling adapting to hardware concurrency and load pressure.',
                    'Prioritized task pipelines ensuring critical telemetry jobs bypass standard tasks.',
                    'Integrated EventCounter telemetry exporting CPU utilization and queue depths.'
                ],
                'filename' => 'WorkStealingScheduler.cs',
                'code' => "public sealed class WorkStealingScheduler : TaskScheduler\n{\n    private readonly BlockingCollection<Task>[] _queues;\n\n    protected override void QueueTask(Task task)\n    {\n        int idealCore = Thread.GetCurrentProcessorId() % _queues.Length;\n        if (!_queues[idealCore].TryAdd(task))\n        {\n            _queues[0].Add(task);\n        }\n    }\n}",
                'tech' => ['C# .NET 8', 'Concurrency', 'Threading', 'Work-Stealing', 'Diagnostics'],
                'github' => 'https://github.com/x64_emkei',
                'demo' => '',
                'order' => 7,
                'featured' => 0
            ],
            [
                'slug' => 'hyperbus-service-broker',
                'code_id' => 'CS.003 // DISTRIBUTED_BUS',
                'category' => 'C# / Microservices',
                'filter_tag' => 'csharp',
                'title' => 'HyperBus Service Broker',
                'tagline' => 'Zero-allocation pub/sub event bus supporting RPC serialization over shared memory and loopback sockets.',
                'environment' => '.NET 8 / 9 • MemoryMappedFiles • Shared Memory IPC',
                'performance_metric' => '2.4M msg/s throughput • Zero GC allocation on hot paths',
                'operational_status' => 'Active • Distributed Core',
                'description' => 'A lightweight inter-process communication message bus built for local services and microservices. Leverages memory-mapped files and binary zero-copy serialization to achieve ultra-high message throughput without incurring garbage collection pauses.',
                'features' => [
                    'Zero-allocation binary message encoding using Span<byte> and Memory<T>.',
                    'Shared-memory ring buffers enabling instantaneous cross-process data transfers.',
                    'Topic-based publisher/subscriber model with dead-letter queue recovery.',
                    'Built-in health watchdog and latency tracking per subscriber channel.'
                ],
                'filename' => 'HyperBusChannel.cs',
                'code' => "public sealed class HyperBusPublisher\n{\n    private readonly MemoryMappedViewAccessor _sharedMem;\n\n    public unsafe void PublishEvent<T>(int topicId, ref T payload) where T : unmanaged\n    {\n        byte* ptr = null;\n        _sharedMem.SafeMemoryMappedViewHandle.AcquirePointer(ref ptr);\n        try {\n            Buffer.MemoryCopy(&payload, ptr + (topicId * 256), sizeof(T), sizeof(T));\n        } finally {\n            _sharedMem.SafeMemoryMappedViewHandle.ReleasePointer();\n        }\n    }\n}",
                'tech' => ['C#', 'IPC', 'gRPC', 'Zero-Allocation', 'High-Performance'],
                'github' => 'https://github.com/x64_emkei',
                'demo' => '',
                'order' => 8,
                'featured' => 0
            ],
            [
                'slug' => 'aeroui-fluent-component-kit',
                'code_id' => 'CS.004 // GPU_UI_KIT',
                'category' => 'C# / UI Engine',
                'filter_tag' => 'csharp',
                'title' => 'AeroUI Fluent Component Kit',
                'tagline' => 'GPU-accelerated desktop UI control system bringing glassmorphic blur and retrofuturistic HUD styling to WPF.',
                'environment' => 'Windows 10/11 • WPF Direct3D Interop • Custom XAML Templates',
                'performance_metric' => '60 FPS compositing • Real-time hardware composition blur',
                'operational_status' => 'Active • UI/UX Design System',
                'description' => 'A comprehensive modern design toolkit for enterprise C# Windows desktop software. Integrates Windows DWM composition APIs to render authentic acrylic glassmorphism, glowing cyan/amber telemetry gauges, and responsive vector controls.',
                'features' => [
                    'DirectX-accelerated frosted glass backdrop filters rendered inside WPF viewports.',
                    'High-contrast theme tokens adhering to modern industrial design standards.',
                    'Custom HUD telemetry dials, linear progress indicators, and hex-grid graphs.',
                    'Interactive window controls with smooth minimize, maximize, and drag physics.'
                ],
                'filename' => 'AeroGlassPanel.cs',
                'code' => "public class AeroGlassPanel : ContentControl\n{\n    public static readonly DependencyProperty BlurRadiusProperty =\n        DependencyProperty.Register(nameof(BlurRadius), typeof(double), typeof(AeroGlassPanel), new PropertyMetadata(20.0));\n\n    protected override void OnRender(DrawingContext dc)\n    {\n        base.OnRender(dc);\n        dc.DrawRectangle(new SolidColorBrush(Color.FromArgb(180, 14, 18, 26)), null, new Rect(RenderSize));\n    }\n}",
                'tech' => ['C# WPF', 'DirectX', 'Glassmorphism', 'UI Components', 'Custom XAML'],
                'github' => 'https://github.com/x64_emkei',
                'demo' => '',
                'order' => 9,
                'featured' => 0
            ],
            [
                'slug' => 'specter-async-deep-scraper',
                'code_id' => 'PY.003 // DISTRIBUTED_SCRAPER',
                'category' => 'Python / Scraper',
                'filter_tag' => 'python',
                'title' => 'Specter Async Deep Scraper',
                'tagline' => 'Distributed asynchronous web scraping pipeline with automatic rotating proxy pools and TLS fingerprint spoofing.',
                'environment' => 'Python 3.12 • AsyncIO • Aiohttp • Redis Distributed Queue',
                'performance_metric' => '5,000 req/s throughput • Automated CAPTCHA evasion',
                'operational_status' => 'Active • Data Pipeline',
                'description' => 'A high-throughput distributed crawling engine designed for large-scale data ingestion. Employs asynchronous coroutine pools, automatic user-agent and JA3 TLS fingerprint spoofing, and Redis-backed state queues to bypass rate limits and anti-bot defenses.',
                'features' => [
                    'Asynchronous connection pooling maintaining thousands of active HTTP sessions.',
                    'Dynamic JA3 TLS fingerprint randomized rotation preventing cloud anti-bot blocks.',
                    'Distributed deduplication index utilizing Redis bloom filters.',
                    'Real-time structured HTML extraction with automatic schema inference.'
                ],
                'filename' => 'SpecterCrawler.py',
                'code' => "import aiohttp\nimport asyncio\n\nasync def fetch_worker(queue, session):\n    while not queue.empty():\n        url = await queue.get()\n        try:\n            async with session.get(url, timeout=5) as response:\n                html = await response.text()\n                parse_telemetry_schema(html)\n        finally:\n            queue.task_done()",
                'tech' => ['Python 3.12', 'AsyncIO', 'Aiohttp', 'Redis', 'Web Scraping'],
                'github' => 'https://github.com/x64_emkei',
                'demo' => '',
                'order' => 10,
                'featured' => 0
            ],
            [
                'slug' => 'packetsnoop-protocol-sniffer',
                'code_id' => 'PY.004 // NETSEC_ANALYZER',
                'category' => 'Python / NetSec',
                'filter_tag' => 'python',
                'title' => 'PacketSnoop Protocol Sniffer',
                'tagline' => 'Raw socket network sniffer performing deep packet inspection, TCP stream reassembly, and TLS handshake decryption.',
                'environment' => 'Linux / Scapy Core • Raw Socket AF_PACKET • PCAP Parser',
                'performance_metric' => 'Zero-copy packet capture • Sustained 1Gbps link inspection',
                'operational_status' => 'Operational • NetSec Testing',
                'description' => 'A network forensics utility that captures raw Ethernet frames directly from the kernel network stack. Decodes protocol layers from IP down to payload data, reassembles TCP sessions, and identifies suspicious packet bursts or DNS tunneling attempts.',
                'features' => [
                    'Kernel-level raw socket packet interception with zero memory duplication.',
                    'Automatic reassembly of fragmented TCP packets and session stream reconstruction.',
                    'Heuristic anomaly detector flagging port scan sweeps and rogue DHCP responses.',
                    'Export engine supporting industry-standard PCAP format and JSON streaming.'
                ],
                'filename' => 'PacketSnoopCore.py',
                'code' => "import socket\nimport struct\n\ndef capture_raw_ethernet():\n    raw_socket = socket.socket(socket.AF_PACKET, socket.SOCK_RAW, socket.ntohs(0x0003))\n    while True:\n        packet_data, _ = raw_socket.recvfrom(65535)\n        eth_header = packet_data[:14]\n        dest_mac, src_mac, proto = struct.unpack(\"!6s6sH\", eth_header)\n        if proto == 0x0800:\n            analyze_ip_payload(packet_data[14:])",
                'tech' => ['Python 3', 'Raw Sockets', 'Network Security', 'PCAP', 'Protocol Forensics'],
                'github' => 'https://github.com/x64_emkei',
                'demo' => '',
                'order' => 11,
                'featured' => 0
            ],
            [
                'slug' => 'spectra-3d-audio-visualizer',
                'code_id' => 'WEB.002 // 3D_AUDIO_GL',
                'category' => 'WebGL / WebDev',
                'filter_tag' => 'web',
                'title' => 'Spectra 3D Audio Visualizer',
                'tagline' => 'Hardware-accelerated 3D audio frequency visualizer rendering real-time FFT spectrum bars with custom GLSL shaders.',
                'environment' => 'Three.js • Web Audio API • WebGL 2.0 • GLSL Fragment Shaders',
                'performance_metric' => '120Hz smooth animations • Low audio latency (<10ms)',
                'operational_status' => 'Active • Creative Web Tech',
                'description' => 'A dynamic 3D web graphics application that transforms microphone or audio inputs into an interactive holographic waveform. Computes live Fast Fourier Transform (FFT) frequency bands and feeds them into custom GLSL vertex and fragment shaders for chromatic aberration and neon dispersion.',
                'features' => [
                    'Web Audio API AnalyserNode computing 2048-point Fast Fourier Transform (FFT) bins.',
                    'Custom Three.js shader materials with animated wave displacement and Bloom glows.',
                    'Interactive camera orbit controls responding to mouse and gyroscope movement.',
                    'Dynamic palette shifting responding to bass frequency peaks and transients.'
                ],
                'filename' => 'SpectraAudioVisualizer.js',
                'code' => "const audioCtx = new AudioContext();\nconst analyser = audioCtx.createAnalyser();\nanalyser.fftSize = 2048;\nconst freqData = new Uint8Array(analyser.frequencyBinCount);\n\nfunction renderLoop() {\n    requestAnimationFrame(renderLoop);\n    analyser.getByteFrequencyData(freqData);\n    meshMaterial.uniforms.u_frequencies.value = freqData;\n    renderer.render(scene, camera);\n}",
                'tech' => ['Three.js', 'WebGL', 'Web Audio API', 'GLSL', 'Interactive 3D'],
                'github' => 'https://github.com/x64_emkei',
                'demo' => '',
                'order' => 12,
                'featured' => 0
            ],
            [
                'slug' => 'nexus-protocol-p2p-chat',
                'code_id' => 'WEB.003 // P2P_MESSAGING',
                'category' => 'WebRTC / Sockets',
                'filter_tag' => 'web',
                'title' => 'Nexus Protocol P2P Chat',
                'tagline' => 'End-to-end encrypted peer-to-peer browser messenger with ephemeral rooms, WebRTC data channels, and zero logs.',
                'environment' => 'WebRTC DataChannels • WebCrypto API • WebSocket Signaling',
                'performance_metric' => 'P2P sub-20ms latency • AES-GCM-256 cipher encryption',
                'operational_status' => 'Active • Decentralized Web Lab',
                'description' => 'A browser-based decentralized communication system. Establishes direct peer-to-peer data pipes between clients using WebRTC without routing message contents through central servers. All messages are encrypted locally using cryptographic keys negotiated via ECDH exchange.',
                'features' => [
                    'Direct browser-to-browser WebRTC DataChannel architecture with zero server logging.',
                    'End-to-end encryption using AES-GCM-256 with ephemeral cryptographic keypairs.',
                    'Chunked peer-to-peer file transfer engine with checksum verification.',
                    'Real-time typing presence and room status indicators.'
                ],
                'filename' => 'NexusPeerSession.js',
                'code' => "class PeerSession {\n    constructor() {\n        this.pc = new RTCPeerConnection({ iceServers: [{ urls: \"stun:stun.l.google.com:19302\" }] });\n        this.dataChannel = this.pc.createDataChannel(\"nexus_p2p_channel\");\n        this.dataChannel.onmessage = (e) => this.decryptAndDisplay(e.data);\n    }\n\n    async sendSecureMessage(plainText) {\n        const encrypted = await CryptoEngine.encryptAES(plainText, this.sharedSecret);\n        this.dataChannel.send(encrypted);\n    }\n}",
                'tech' => ['WebRTC', 'WebCrypto API', 'WebSockets', 'P2P', 'Privacy'],
                'github' => 'https://github.com/x64_emkei',
                'demo' => '',
                'order' => 13,
                'featured' => 0
            ],
            [
                'slug' => 'glassmorphic-os-dashboard',
                'code_id' => 'WEB.004 // WEB_OS_DESKTOP',
                'category' => 'CSS Glass / Vanilla JS',
                'filter_tag' => 'web',
                'title' => 'Glassmorphic OS Dashboard',
                'tagline' => 'Desktop-class responsive web workspace featuring draggable floating windows, minimize trays, and live HUD widgets.',
                'environment' => 'Vanilla JavaScript • CSS Grid • Hardware Backdrop Blur',
                'performance_metric' => 'Zero external frameworks • Sub-16ms layout recalculations',
                'operational_status' => 'Active • Web Interface Lab',
                'description' => 'An in-browser operating system simulation demonstrating the capabilities of modern CSS Grid and vanilla JavaScript. Features floating window management, window snapping, minimize/maximize physics, dock status indicators, and persistent widget preferences.',
                'features' => [
                    'Custom multi-window manager supporting drag, resize, z-index elevation, and minimization.',
                    'Modular CSS Grid Bento layouts adapting fluidly from 4K displays to mobile screens.',
                    'State persistence storing window positions and custom settings in LocalStorage.',
                    'Zero external runtime dependencies ensuring instant page delivery and optimal performance.'
                ],
                'filename' => 'WindowManager.js',
                'code' => "class WindowManager {\n    static bringToFront(winEl) {\n        const topZ = Math.max(...Array.from(document.querySelectorAll(\".os-window\")).map(w => parseInt(w.style.zIndex || 10)));\n        winEl.style.zIndex = topZ + 1;\n    }\n\n    static toggleMinimize(winEl) {\n        winEl.classList.toggle(\"is-minimized\");\n        const isCollapsed = winEl.classList.contains(\"is-minimized\");\n        winEl.querySelector(\".window-body\").style.display = isCollapsed ? \"none\" : \"block\";\n    }\n}",
                'tech' => ['Vanilla JS', 'CSS Grid', 'Glassmorphism', 'Window Controls', 'Responsive'],
                'github' => 'https://github.com/x64_emkei',
                'demo' => '',
                'order' => 14,
                'featured' => 0
            ],
            [
                'slug' => 'vortex-8-hardware-emulator',
                'code_id' => 'CPP.003 // EMULATION_CORE',
                'category' => 'C++ / Emulation',
                'filter_tag' => 'cpp',
                'title' => 'Vortex-8 Hardware Emulator',
                'tagline' => 'Cycle-accurate virtual CPU emulator featuring opcode disassembler, memory debugger, and 60 FPS video synthesizer.',
                'environment' => 'C++17 • SDL2 Library • Virtual Machine Core',
                'performance_metric' => '100% cycle-accurate opcode timing • 60 FPS video sync',
                'operational_status' => 'Operational • Systems Research',
                'description' => 'A complete virtual microprocessor and hardware system emulator written in C++17. Faithfully recreates the instruction fetch-decode-execute cycle, 16 8-bit registers, 4KB memory space, timer delays, and monochromatic screen graphics with integrated audio beeper.',
                'features' => [
                    'Full implementation of 35 standard CPU opcodes with bitwise flag validation.',
                    'Integrated interactive disassembly viewer and live memory register hex inspector.',
                    'Audio tone synthesizer generating accurate square wave sound pulses via SDL2.',
                    'Cycle-accurate execution loop calibrated with high-resolution CPU clocks.'
                ],
                'filename' => 'VortexCpuCore.cpp',
                'code' => "void VortexCpu::Cycle() {\n    uint16_t opcode = (memory[pc] << 8) | memory[pc + 1];\n    pc += 2;\n    switch (opcode & 0xF000) {\n        case 0xA000: indexRegister = opcode & 0x0FFF; break;\n        case 0x6000: V[(opcode & 0x0F00) >> 8] = opcode & 0x00FF; break;\n        case 0xD000: DrawSprite(V[(opcode & 0x0F00) >> 8], V[(opcode & 0x00F0) >> 4], opcode & 0x000F); break;\n    }\n}",
                'tech' => ['C++17', 'SDL2', 'Virtual Machine', 'Emulation', 'Computer Architecture'],
                'github' => 'https://github.com/x64_emkei',
                'demo' => '',
                'order' => 15,
                'featured' => 0
            ],
            [
                'slug' => 'simd-vector-math-engine',
                'code_id' => 'CPP.004 // SIMD_VECTOR_MATH',
                'category' => 'C++20 / SIMD',
                'filter_tag' => 'cpp',
                'title' => 'SIMD Vector Math Engine',
                'tagline' => 'Hardware-intrinsics vectorized matrix math library accelerating 4x4 coordinate transformations with AVX2.',
                'environment' => 'C++20 • AVX2 / FMA Intrinsics • Clang / MSVC',
                'performance_metric' => '8x throughput increase over scalar math • Zero cache misses',
                'operational_status' => 'Operational • High-Performance Math',
                'description' => 'A vectorized mathematics library designed for game engines and physics simulations. Replaces traditional loop-based matrix multiplications and vector normalizations with single-instruction multiple-data (SIMD) hardware intrinsic instructions, processing 4 coordinate sets simultaneously.',
                'features' => [
                    'AVX2 and Fused Multiply-Add (FMA) assembly intrinsic implementation.',
                    'Sub-nanosecond 4x4 matrix multiplication and vector dot product calculations.',
                    'Cache-aligned memory storage preventing unaligned load penalties.',
                    'Comprehensive automated test suite benchmarking against standard scalar math routines.'
                ],
                'filename' => 'SimdMatrix4x4.hpp',
                'code' => "#include <immintrin.h>\n\nstruct alignas(32) Mat4x4 {\n    __m256 cols[2];\n\n    static Mat4x4 Multiply(const Mat4x4& a, const Mat4x4& b) noexcept {\n        Mat4x4 result;\n        __m256 row0 = _mm256_load_ps((const float*)&a.cols[0]);\n        __m256 row1 = _mm256_load_ps((const float*)&a.cols[1]);\n        result.cols[0] = _mm256_fmadd_ps(row0, b.cols[0], result.cols[0]);\n        result.cols[1] = _mm256_fmadd_ps(row1, b.cols[1], result.cols[1]);\n        return result;\n    }\n};",
                'tech' => ['C++20', 'AVX2', 'Intrinsics', 'Linear Algebra', 'High-Performance'],
                'github' => 'https://github.com/x64_emkei',
                'demo' => '',
                'order' => 16,
                'featured' => 0
            ]
        ];

        $sql = "INSERT INTO `projects`
            (`slug`, `code_id`, `category`, `filter_tag`, `title`, `tagline`, `environment`, `performance_metric`,
             `operational_status`, `description`, `features_json`, `code_filename`, `code_snippet`,
             `technologies_json`, `github_url`, `demo_url`, `featured_image`, `display_order`, `is_featured`, `is_published`)
            VALUES
            (:slug, :code_id, :category, :filter_tag, :title, :tagline, :env, :perf,
             :status, :desc, :features, :filename, :code, :tech, :github, :demo, :img, :order, :featured, 1)";
        
        $stmt = $this->pdo->prepare($sql);
        foreach ($projects as $p) {
            $stmt->execute([
                ':slug' => $p['slug'],
                ':code_id' => $p['code_id'],
                ':category' => $p['category'],
                ':filter_tag' => $p['filter_tag'],
                ':title' => $p['title'],
                ':tagline' => $p['tagline'],
                ':env' => $p['environment'],
                ':perf' => $p['performance_metric'],
                ':status' => $p['operational_status'],
                ':desc' => $p['description'],
                ':features' => json_encode($p['features']),
                ':filename' => $p['filename'],
                ':code' => $p['code'],
                ':tech' => json_encode($p['tech']),
                ':github' => $p['github'],
                ':demo' => $p['demo'],
                ':img' => 'images/carousel-retro.jpg',
                ':order' => $p['order'],
                ':featured' => $p['featured']
            ]);
        }
    }

    private function seedHardwareNodes(): void
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM `hardware_nodes`");
        if ((int)$stmt->fetchColumn() > 0) return;

        $nodes = [
            [
                'node_id' => 'NODE.01 // LAB ARCHIVE',
                'tag' => 'PRESERVED',
                'title' => 'Sony Vaio W-series VPCW115XG',
                'subtitle' => 'Intel Atom N280 Netbook Platform • Japanese Ultraportable Engineering',
                'oem' => 'Sony VAIO Corp.',
                'specs' => [
                    'CPU' => 'Intel Atom N280 (1.66 GHz, 1 Core, 2 Threads, 512KB L2)',
                    'RAM' => '2GB DDR2-667 SO-DIMM',
                    'Storage' => '64GB Kingston SATA-II SSD (Upgraded from 160GB HDD)',
                    'Display' => '10.1-inch 1366x768 Fine-Pitch WXGA LED',
                    'OS' => 'Debian Linux 12 (Bookworm) Minimal CLI with Openbox',
                    'Purpose' => 'Low-power serial telemetry node & vintage firmware flash programmer'
                ],
                'log' => 'Purchased as a non-booting salvage chassis in 2023. Restored CMOS battery, repasted Atom die with Arctic MX-4, replaced damaged hinge assembly, and flashed modified microcode BIOS. Currently serving as a lightweight network probe and serial RS-232 telemetry relay.',
                'image' => 'images/carousel-retro.jpg',
                'order' => 1
            ],
            [
                'node_id' => 'NODE.02 // LAB ARCHIVE',
                'tag' => 'ACTIVE RIG',
                'title' => 'Lenovo ThinkPad X220 Mod',
                'subtitle' => 'Intel Core i5-2520M Ultraportable • Classic 7-Row Keyboard Workhorse',
                'oem' => 'Lenovo Corp.',
                'specs' => [
                    'CPU' => 'Intel Core i5-2520M (2.50 GHz, Turbo to 3.20 GHz, 2C/4T)',
                    'RAM' => '16GB DDR3L-1600 Dual-Channel',
                    'Storage' => '256GB Samsung 860 EVO mSATA + 500GB Crucial MX500 SATA-III',
                    'Display' => '12.5-inch IPS HD 1366x768 Matte Display',
                    'OS' => 'Arch Linux (Kernel 6.10-zen) + Coreboot open-source BIOS',
                    'Purpose' => 'Primary mobile Linux development terminal, embedded debugging'
                ],
                'log' => 'Flashed with 1vyrain modified UEFI to remove Wi-Fi whitelist and unlock memory speeds. Retrofitted with classic 7-row keyboard mod. Repasted copper heatpipe with Noctua NT-H2. Battery rebuilt with custom high-capacity Panasonic 18650 cells.',
                'image' => 'images/carousel-workspace.jpg',
                'order' => 2
            ],
            [
                'node_id' => 'RIG.03 // LAB ARCHIVE',
                'tag' => 'HYPERVISOR',
                'title' => 'Cluster Node 01 — Proxmox VE',
                'subtitle' => 'High-Efficiency Homelab Bare-Metal Virtualization Hypervisor',
                'oem' => 'Custom Systems Build',
                'specs' => [
                    'CPU' => 'AMD Ryzen 7 5700X (8 Cores, 16 Threads, 32MB L3 Cache)',
                    'RAM' => '64GB DDR4-3200 ECC Unbuffered Memory',
                    'Storage' => '2x 1TB NVMe PCIe 4.0 ZFS RAID-1 Mirror + 4x 4TB SATA ZFS Pool',
                    'Network' => 'Dual Intel I225-V 2.5GbE NICs (LACP Trunking)',
                    'OS' => 'Proxmox VE 8.2 (Linux Kernel 6.8 PVE)',
                    'Purpose' => 'Running isolated LXC containers, Docker swarm, and network lab routers'
                ],
                'log' => 'Engineered for continuous 24/7 high-density virtualization. Hosts internal Git repositories, test database clusters, DNS caches, WireGuard ingress gateways, and CI/CD automated runners with continuous temperature monitoring and battery UPS failover.',
                'image' => 'images/carousel-homelab.jpg',
                'order' => 3
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

    private function seedSkills(): void
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM `skills`");
        if ((int)$stmt->fetchColumn() > 0) return;

        $skills = [
            // Languages
            ['Languages', 'C# / .NET 9', 92, 1],
            ['Languages', 'C++20 / Systems', 85, 2],
            ['Languages', 'Python 3.12 / PyTorch', 88, 3],
            ['Languages', 'PHP 8.3+ / MySQL', 90, 4],
            ['Languages', 'JavaScript (ES6+) / TypeScript', 90, 5],
            ['Languages', 'SQL / Database Architecture', 88, 6],
            ['Languages', 'x86_64 Assembly / Low-Level', 75, 7],
            // Frameworks & Tools
            ['Frameworks & Platforms', 'WPF / Desktop UI Architecture', 90, 1],
            ['Frameworks & Platforms', 'PyTorch / TensorRT / CUDA', 82, 2],
            ['Frameworks & Platforms', 'Linux Systems Administration', 92, 3],
            ['Frameworks & Platforms', 'Proxmox VE & Virtualization', 88, 4],
            ['Frameworks & Platforms', 'Docker & Containerization', 85, 5],
            ['Frameworks & Platforms', 'WireGuard & Zero-Trust Networking', 89, 6],
            ['Frameworks & Platforms', 'Git / GitHub CI/CD Actions', 94, 7]
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

    private function seedExperiences(): void
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM `experiences`");
        if ((int)$stmt->fetchColumn() > 0) return;

        $experiences = [
            [
                'title' => 'Software Systems & Solutions Architect',
                'organization' => 'Independent / Academic Development',
                'location' => 'Laguna, Philippines',
                'type' => 'Engineering',
                'start' => '2023',
                'end' => 'Present',
                'current' => 1,
                'desc' => 'Leading the architectural design, security hardening, and deployment of mission-critical applications across retail, systems virtualization, and enterprise workflow automation.',
                'order' => 1
            ],
            [
                'title' => 'Computer Science Researcher & Student Leader',
                'organization' => 'College of Computer Studies',
                'location' => 'Laguna, Philippines',
                'type' => 'Academic & Leadership',
                'start' => '2022',
                'end' => 'Present',
                'current' => 1,
                'desc' => 'Mentoring junior computing students in data structures, systems programming in C/C++, and algorithmic optimization. Organizing technical workshops and coding competitions.',
                'order' => 2
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

    private function seedEducation(): void
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM `education`");
        if ((int)$stmt->fetchColumn() > 0) return;

        $edu = [
            [
                'institution' => 'Laguna State Polytechnic University / Academic Institution',
                'degree' => 'Bachelor of Science in Computer Science',
                'field' => 'Systems Architecture & Software Engineering',
                'start' => '2022',
                'end' => 'Present',
                'achievements' => "Dean's Lister • Focused on operating systems, algorithm design, distributed computing, and database management systems.",
                'order' => 1
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

    private function seedServices(): void
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM `services`");
        if ((int)$stmt->fetchColumn() > 0) return;

        $services = [
            [
                'title' => 'Mission-Critical Desktop & POS Engineering',
                'category' => 'Systems Software',
                'desc' => 'Engineering high-reliability, zero-downtime offline applications using modern C#/.NET 9, SQLite Write-Ahead Logging, hardware scanner abstraction, and LAN peer-to-peer sync.',
                'order' => 1
            ],
            [
                'title' => 'High-Performance Web & Full-Stack CMS',
                'category' => 'Web Architecture',
                'desc' => 'Crafting secure, portable PHP 8.3+ & MySQL web platforms, custom CMS engines, REST APIs, and responsive cybernetic interfaces optimized for low-latency delivery.',
                'order' => 2
            ],
            [
                'title' => 'Virtualization & Zero-Trust Homelab Infrastructure',
                'category' => 'Cloud & Infrastructure',
                'desc' => 'Deploying secure Proxmox VE hypervisors, automated encrypted WireGuard mesh networks, ZFS storage arrays, Docker container clusters, and continuous telemetry monitoring.',
                'order' => 3
            ],
            [
                'title' => 'Computer Vision & Deep Learning Pipelines',
                'category' => 'Applied AI / ML',
                'desc' => 'Building edge neural network inference systems using PyTorch, CUDA, and OpenCV with TensorRT FP16 quantization for low-latency real-time video analytics.',
                'order' => 4
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

    private function seedSocialLinks(): void
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM `social_links`");
        if ((int)$stmt->fetchColumn() > 0) return;

        $links = [
            ['github', 'GitHub', 'https://github.com/x64_emkei', 1],
            ['linkedin', 'LinkedIn', 'https://linkedin.com/in/michael-ordenes/', 2],
            ['email', 'Email', 'mailto:mordenes@acm.org', 3]
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

    private function seedSiteSettings(): void
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM `site_settings`");
        if ((int)$stmt->fetchColumn() > 0) return;

        $settings = [
            ['site_title', 'Michael Benedict Ordenes | x64emkei.dev', 'general', 'Public title of the portfolio'],
            ['site_tagline', 'Systems Architecture, C# .NET, C++20, and High-Performance Software Engineering', 'general', 'Meta tagline'],
            ['meta_description', 'Michael Benedict Ordenes (x64emkei) — Computer Science Student, IT Enthusiast & Systems Developer. High-tech HUD portfolio and systems engineering showcase.', 'seo', 'Default SEO description'],
            ['meta_keywords', 'Michael Benedict Ordenes, x64emkei, developer portfolio, systems architect, C#, .NET 9, C++20, PHP CMS, MySQL, Proxmox, homelab', 'seo', 'Meta keywords list'],
            ['contact_email', 'mordenes@acm.org', 'contact', 'Primary inbox contact email'],
            ['theme_default', 'dark', 'appearance', 'Default HUD theme mode (dark or light)'],
            ['primary_domain', 'x64emkei.dpdns.org', 'hosting', 'Primary configured domain'],
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
}
