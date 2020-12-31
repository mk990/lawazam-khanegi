@ECHO OFF
start "" http://localhost:8080
taskkill /F /IM php.exe
php -S localhost:8080 -t public

