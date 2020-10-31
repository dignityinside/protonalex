# rooland

Source code of the rooland blog.

## Technology

- Nginx or Apache
- HTML5 + CSS3 (Bootstrap), Javascript
- PHP 7.2+, MySQL, Yii Framework 2
- Composer (PHP), Bower and NPM (CSS, JavaScript)
- Docker for local development
- Markdown + CodeMirror Editor
- PSR-12 Coding Standard

## Clone project via GIT

```
git clone https://github.com/dignityinside/rooland
cd rooland
```

#### Install Docker (Ubuntu-Linux)

```
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -
sudo add-apt-repository "deb [arch=amd64] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable"
sudo apt-get update
apt-cache policy docker-ce
sudo apt-get install -y docker-ce docker-ce-cli containerd.io
sudo systemctl status docker
```


#### Install Docker-Compose (Ubuntu-Linux)

```
sudo curl -L "https://github.com/docker/compose/releases/download/1.26.0/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose
sudo ln -s /usr/local/bin/docker-compose /usr/bin/docker-compose
sudo usermod -aG docker <username>
su - <username>
```

#### Build and run Docker

- `docker-compose build` - Build Docker
- `docker-compose up -d` - Start Docker
- `docker-compose exec php /bin/bash` - SSH Login to Docker
- `docker-compose down` - Stop Docker

#### Add new hosts to your `hosts` File:

```
127.0.0.1 rooland.local
```

#### Development links
```
http://rooland.local:8025
```

## Install all dependencies via Composer

```
composer install
```

## Apply post create project script

```
composer run-script post-create-project-cmd
```

## Copy config files from "/config/dist"

```
cp -r config/dist/* config
```

Remove "-dist" from this config files.

## Apply migrations

Setup DB settings in "config/db.php" and run migrations.

```
php yii migrate
```

## Apply RBAC

```
php yii rbac/init 
```

## Register new user and assign the roles

Setup reCAPTCHA settings in config/params.php and register a new user.

```
php yii rbac/assign admin dignity
php yii rbac/assign moderator dignity
```

## Generate sitemap.xml

```
php yii sitemap
```

## Fetch new videos

```
php yii video
```

## License
This project is licensed under the MIT License. See the LICENSE file for details.

## Contributing
1. Fork it
2. Create your feature branch (git checkout -b my-new-feature)
3. Make your changes
4. Commit your changes (git commit -am 'Added some feature')
5. Push to the branch (git push origin my-new-feature)
6. Create new Pull Request
