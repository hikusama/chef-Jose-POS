@echo off
echo Stopping XAMPP Apache...
cd C:\xampp\apache\bin
httpd.exe -k stop
echo XAMPP apache stopped.

echo Stopping MySQL...
cd C:\xampp\mysql\bin
mysqladmin-u root -p shutdown
echo MysSQL stopped.

echo Stopping Chef-Jose Apache...
taskkill /F /IM php.exe
echo Chef-Jose Apache stopped.