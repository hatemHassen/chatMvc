#!/usr/bin/env bash
composer dump-autoload -o
sudo ln -sf /home/hatem/PhpstormProjects/tchat/app/apache/apache.conf /etc/apache2/sites-enabled/chat.conf
sudo chown www-data:www-data -R var/
sudo -u www-data chmod -R 755 var/
sudo service apache2 reload