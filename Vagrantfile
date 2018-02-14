# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|

  config.vm.box = "debian/contrib-stretch64"

  config.vm.synced_folder ".", "/vagrant", disabled: true
  config.vm.synced_folder ".", "/var/www/matters-repository", type: "virtualbox"

  config.vm.provision "shell", inline: <<-SHELL
    apt-get -qq install apt-transport-https lsb-release ca-certificates curl git unzip -y
    wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
    echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | tee /etc/apt/sources.list.d/php.list
    apt-get -qq update
    apt-get -qq install php7.2 php7.2-xdebug -y
    curl -Ss https://getcomposer.org/installer | php
    mv composer.phar /usr/bin/composer
    su vagrant
    cd /var/www/matters-repository
    composer install --quiet
  SHELL
end
