@echo off
REM Auto-sync and upload to GitHub with proper Conventional Commit labels
powershell.exe -NoProfile -ExecutionPolicy Bypass -File "%~dp0scripts\sync.ps1" %*
