@echo off
chcp 65001 >nul
cd /d "%~dp0"
set XDEBUG_MODE=off
echo.
echo ===== Site Amset - acces reseau =====
echo.
echo Adresse IP de ce PC :
ipconfig | findstr /i "IPv4"
echo.
echo Les autres ouvrent dans leur navigateur :  http://ADRESSE_IP:8000/salarie
echo Pour arreter le site : Ctrl+C puis O
echo.
php -S 0.0.0.0:8000 -t public public/index.php
pause
