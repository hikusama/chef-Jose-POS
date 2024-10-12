@echo off
cd C:\Users\Hikusama\Desktop\chef-Jose-POS\app
echo starting XAMPP apache...
call app1.bat
echo XAMPP apache started...

cd C:\Users\Hikusama\Desktop\chef-Jose-POS\app
echo starting MySQL...
call app2.bat
echo MySQL started...

echo Starting Chef-Jose Apache...
cd C:\Users\Hikusama\Desktop\chef-Jose-POS
php -S localhost:8080
start http://localhost:8080
echo Chef-Jose apache started.

pause

cd C:\Users\Hikusama\Desktop\chef-Jose-POS\app
call stop.bat
echo service stopped.

pause