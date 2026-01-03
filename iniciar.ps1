# Script de inicio para PowerShell
# Sistema de Facturacion

Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "   Sistema de Facturacion" -ForegroundColor Cyan
Write-Host "   Iniciando servidores..." -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

$scriptPath = Split-Path -Parent $MyInvocation.MyCommand.Path

# Iniciar servidor PHP en segundo plano
Write-Host "[1/2] Iniciando Backend PHP (Puerto 8000)..." -ForegroundColor Yellow
$phpPath = Join-Path $scriptPath "Proyectos\03MVC"
Start-Process -FilePath "php" -ArgumentList "-S", "localhost:8000" -WorkingDirectory $phpPath -WindowStyle Minimized

Start-Sleep -Seconds 2

# Mostrar información
Write-Host ""
Write-Host "========================================" -ForegroundColor Green
Write-Host "   Accesos:" -ForegroundColor Green
Write-Host "   Frontend: http://localhost:4200" -ForegroundColor White
Write-Host "   Backend:  http://localhost:8000" -ForegroundColor White
Write-Host ""
Write-Host "   Credenciales:" -ForegroundColor Green
Write-Host "   Usuario: admin" -ForegroundColor White
Write-Host "   Password: admin123" -ForegroundColor White
Write-Host "========================================" -ForegroundColor Green
Write-Host ""

# Iniciar servidor Angular
Write-Host "[2/2] Iniciando Frontend Angular (Puerto 4200)..." -ForegroundColor Yellow
$angularPath = Join-Path $scriptPath "Proyectos\04Plantilla"
Set-Location $angularPath
pnpm start
