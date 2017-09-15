WorkInZen
=========

How to install ?
---------------
````
git clone git@github.com:yitoo/wiz.git

````

How to run ?
------------
````
cd wiz
php bin/console server:start

so you can brows the app on http://127.0.0.1:8000

````

How to deploy?
--------------
Update your hosts
````
151.80.142.120    prod.yitoo.io
213.32.71.110    recette.yitoo.io
````

Add your ssh keys to recette en prod machines

````
ssh-copy-id -i ~/.ssh/id_rsa.pub deployer@prod.yitoo.io
ssh-copy-id -i ~/.ssh/id_rsa.pub root@prod.yitoo.io
ssh-copy-id -i ~/.ssh/id_rsa.pub deployer@recette.yitoo.io
ssh-copy-id -i ~/.ssh/id_rsa.pub root@recette.yitoo.io

````
You can now deploy

````
vendor/bin/dep deploy recette --branch master
vendor/bin/dep deploy prod --branch master

````