# MySQLBackupTool
PHP script to backup several databases in one server.

## How to install ##
1. First clone the repository using 
```bash
git clone https://github.com/adbarbosa/MySQLBackupTool.git
```
2. Enter folder *MySQLBackupTool* and create a copy of file **config.default.json** with new name **config.json**

3. Edit the new file **config.json** to reflect your username, password, host for acessing MySQL server and alter batabase name to backup

4. change permissions to execute the file main.php:
```bash
sudo chown +x main.php
```

5. To make a backup of the databases simply run the following command inside folder **MySQLBackupTool**:
```bash
./main.php
```
