<#
.SYNOPSIS
    Automated Git Commit & Push utility with Conventional Commit labels.
.DESCRIPTION
    Stages all modified/new files, formats commit messages according to
    the project's Conventional Commits standard with proper labels,
    and automatically uploads to GitHub.
.EXAMPLE
    .\scripts\sync.ps1 -Type feat -Scope hud -Message "Add terminal telemetry widget"
.EXAMPLE
    .\scripts\sync.ps1 "fix(nav): fix mobile menu toggle"
.EXAMPLE
    .\scripts\sync.ps1 (Interactive mode)
#>
param (
    [Parameter(Position = 0)]
    [string]$QuickMessage,

    [ValidateSet("feat", "fix", "style", "docs", "perf", "refactor", "chore", "test", "ci", "build")]
    [string]$Type,

    [string]$Scope,
    [string]$Message
)

$ErrorActionPreference = "Stop"

Set-Location -Path "$PSScriptRoot\.."

Write-Host "`n>>> [Portfolio Git Sync & Auto-Upload] <<<" -ForegroundColor Cyan

# 1. Check git status
$status = git status --porcelain
if (-not $status) {
    Write-Host "No unstaged or uncommitted changes detected. Working tree clean." -ForegroundColor Green
    
    # Check if local commits are ahead
    $ahead = git status -sb | Select-String "ahead"
    if ($ahead) {
        Write-Host "Local commits are ahead of remote. Pushing to GitHub now..." -ForegroundColor Yellow
        git push origin main
        Write-Host "Successfully pushed to GitHub!" -ForegroundColor Green
    }
    return
}

# Display changed files
Write-Host "Changed files detected:" -ForegroundColor Yellow
git status --short

# 2. Determine Commit Message with proper labels
$finalCommitMsg = ""

if ($QuickMessage) {
    $finalCommitMsg = $QuickMessage
} elseif ($Type -and $Message) {
    if ($Scope) {
        $finalCommitMsg = "$($Type)($($Scope)): $Message"
    } else {
        $finalCommitMsg = "$($Type): $Message"
    }
} else {
    Write-Host "`nSelect Conventional Commit Label:" -ForegroundColor Magenta
    Write-Host "  1) feat     (New feature / component / section)"
    Write-Host "  2) fix      (Bug fix / layout glitch / script error)"
    Write-Host "  3) style    (CSS styling / layout adjustments / theme)"
    Write-Host "  4) docs     (Documentation / README / skills)"
    Write-Host "  5) perf     (Performance / image optimization / frame rate)"
    Write-Host "  6) refactor (Code cleanup without feature changes)"
    Write-Host "  7) chore    (Tooling / git config / maintenance)"
    
    $choice = Read-Host "Choose option [1-7] (default: 1)"
    switch ($choice) {
        "2" { $Type = "fix" }
        "3" { $Type = "style" }
        "4" { $Type = "docs" }
        "5" { $Type = "perf" }
        "6" { $Type = "refactor" }
        "7" { $Type = "chore" }
        Default { $Type = "feat" }
    }
    
    $Scope = Read-Host "Scope (optional, e.g. 'nav', 'hero', 'skills', 'css', or press Enter to skip)"
    $Message = Read-Host "Commit description"
    
    if (-not $Message) {
        Write-Host "Commit message cannot be empty. Aborting." -ForegroundColor Red
        return
    }
    
    if ($Scope) {
        $finalCommitMsg = "$($Type)($($Scope)): $Message"
    } else {
        $finalCommitMsg = "$($Type): $Message"
    }
}

Write-Host "`nStaging changes and committing with label:" -ForegroundColor Cyan
Write-Host "  --> $finalCommitMsg" -ForegroundColor Green

git add -A
git commit -m $finalCommitMsg

Write-Host "`nUploading to GitHub..." -ForegroundColor Cyan
git push origin main

Write-Host "`nDone! All changes successfully labeled, committed, and uploaded to GitHub." -ForegroundColor Green
