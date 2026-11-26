<#
.SYNOPSIS
    Builds the production-ready deployment package for InfinityFree / Shared Hosting.
.DESCRIPTION
    Compiles and copies only production runtime files into 'deploy/htdocs/' and
    compresses them into 'deploy/x64emkei_portfolio_deploy.zip'.
#>

$ErrorActionPreference = "Stop"

$rootDir = Resolve-Path "$PSScriptRoot\.."
$deployDir = "$rootDir\deploy\htdocs"
$zipFile = "$rootDir\deploy\x64emkei_portfolio_deploy.zip"

Write-Host "`n>>> [Building Production Deployment Package for InfinityFree] <<<" -ForegroundColor Cyan

# 1. Clean previous deploy directory
if (Test-Path $deployDir) {
    Remove-Item -Path $deployDir -Recurse -Force
}
if (Test-Path $zipFile) {
    Remove-Item -Path $zipFile -Force
}

New-Item -ItemType Directory -Path $deployDir -Force | Out-Null

# 2. Copy production directories
$copyDirs = @("app", "bootstrap", "config", "database", "images", "storage", "routes")
foreach ($d in $copyDirs) {
    $src = "$rootDir\$d"
    $dst = "$deployDir\$d"
    if (Test-Path $src) {
        Write-Host "  --> Copying directory: $d" -ForegroundColor Yellow
        Copy-Item -Path $src -Destination $dst -Recurse -Force
    }
}

# 3. Clean temporary files in deploy/storage
Get-ChildItem -Path "$deployDir\storage\logs" -Exclude ".gitkeep" | Remove-Item -Force -ErrorAction SilentlyContinue
Get-ChildItem -Path "$deployDir\storage\cache" -Exclude ".gitkeep" | Remove-Item -Force -ErrorAction SilentlyContinue

# 4. Copy individual root runtime files
$copyFiles = @(
    "index.php",
    "style.css",
    "script.js",
    ".htaccess",
    "composer.json"
)

foreach ($f in $copyFiles) {
    $src = "$rootDir\$f"
    if (Test-Path $src) {
        Write-Host "  --> Copying file: $f" -ForegroundColor Yellow
        Copy-Item -Path $src -Destination "$deployDir\$f" -Force
    }
}

# 5. Create deployment zip
Write-Host "`nCompressing production archive to: deploy\x64emkei_portfolio_deploy.zip" -ForegroundColor Cyan
Compress-Archive -Path "$deployDir\*" -DestinationPath $zipFile -CompressionLevel Optimal

$zipSize = (Get-Item $zipFile).Length / 1MB
Write-Host "[SUCCESS] Production package generated successfully! Size: $([math]::Round($zipSize, 2)) MB" -ForegroundColor Green
Write-Host "Upload the contents of 'deploy/htdocs/' directly to your InfinityFree '/htdocs/' folder via FileZilla.`n" -ForegroundColor Green
