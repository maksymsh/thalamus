LOCAL_MYSQL_USER="admin"
LOCAL_MYSQL_PASS="jQ5dhXIxUjL754c"
LOCAL_MYSQL_DB="thalamus"

echo "SSH Password is: 8hVXgJBVpyipQnTw"
ssh thalamus@thalamus.io -p6622 '/home/thalamus.io/db_dump.sh'
echo "get /home/thalamus.io/thalamus.sql" | sftp -P 6622 thalamus@thalamus.io
mysql -u $LOCAL_MYSQL_USER -p$LOCAL_MYSQL_PASS $LOCAL_MYSQL_DB < thalamus.sql
