# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|

  config.vm.box = "ubuntu/jammy64"
  config.vm.hostname = "webfusion-vm"

  # Reenvío de puertos: WordPress accesible en http://localhost:8080
  config.vm.network "forwarded_port", guest: 80, host: 8081

  config.vm.provider "virtualbox" do |vb|
    vb.name   = "WebFusion-VM"
    vb.memory = "2048"
    vb.cpus   = 2
  end

  # Sincronizar el directorio del proyecto con la VM
  config.vm.synced_folder ".", "/vagrant"

  # Aprovisionamiento: instalar Docker + Docker Compose y levantar servicios
  config.vm.provision "shell", path: "scripts/provision.sh"

end
