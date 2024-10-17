#!/bin/bash

mariadb -u root -proot <<EOF
GRANT ALL PRIVILEGES ON appdb.* TO 'app'@'%';
FLUSH PRIVILEGES;
EOF