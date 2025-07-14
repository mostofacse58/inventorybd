@echo off
d:\xampp\mysql\bin\mysql --user=root --password= vlmbd_inventory -e "source vlmcom_bdinv.sql;"
echo Done!
exit


mysql -u root -p   inventory_backup  < "C:\db\1751288402.sql"
