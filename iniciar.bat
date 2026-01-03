@echo off
:: ========================================
:: Sistema de Facturacion - Inicio Rapido
:: ========================================

echo.
echo ========================================
echo   Sistema de Facturacion
echo   Iniciando servidores...
echo ========================================
echo.

:: Iniciar servidor PHP en segundo plano
cd /d "%~dp0Proyectos\03MVC"
echo [1/2] Iniciando Backend PHP (Puerto 8000)...
start /min cmd /c "php -S localhost:8000"

:: Esperar un momento
timeout /t 2 /nobreak >nul

:: Iniciar servidor Angular
cd /d "%~dp0Proyectos\04Plantilla"
echo [2/2] Iniciando Frontend Angular (Puerto 4200)...
echo.
echo ========================================
echo   Accesos:
echo   Frontend: http://localhost:4200
echo   Backend:  http://localhost:8000
echo.
echo   Credenciales:
echo   Usuario: admin
echo   Password: admin123
echo ========================================
echo.

pnpm start
