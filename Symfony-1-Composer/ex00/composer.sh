#!/bin/bash
curl -Ss https://getcomposer.org/installer | php

sudo mv composer.phar /usr/local/bin/composer
chmod +x /usr/local/bin/composer

composer