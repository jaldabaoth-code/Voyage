<h1>Voyage (Checkpoint 4, WCS Web PHP)</h1>

### The goal is to create site web with Symfony using what we have learned during WCS PHP


---

### index

1. [Prerequisites](#Prerequisites)
2. [Installation](#Steps)
3. [Users](#Users)

### Prerequisites

* [PHP 7.4.*](https://www.php.net/releases/7_4_0.php) (check by running php -v in your console)
* [Composer 2.*](https://getcomposer.org/) (check by running composer --version in your console)
* [node 14.*](https://nodejs.org/en/) (check by running node -v in your console)
* [Yarn 1.*](https://yarnpkg.com/) (check by running yarn -v in your console)
* [MySQL 8.0.*](https://www.mysql.com/fr/) (check by running mysql --version in your console)
* [Git 2.*](https://git-scm.com/) (check by running git --version in your console)

### Steps

If you meet the prerequisites, you can proceed to the installation of the project 

1. Clone the repo from GitHub : `git@github.com:jaldabaoth-code/Voyage.git`
2. Enter the directory : `cd Voyage`
3. Open with your code editor
4. Run `composer install` to install PHP dependencies
5. Run `yarn install` to install JS dependencies
6. Copy the `.env` file, name it `.env.local` and fill all informations (Database, Symfony/Mailer)
    - MAILER_DSN=smtp://xxx<br/>
        * "Retrieve and copy MAILER_DSN from : <a href="https://mailtrap.io/inboxes">MAILTRAP</a>
        * Then you go to : -> <b>My Inbox</b> -> <b>SMTP Settings</b> -> <b>Integrations</b> -> <b>PHP</b> -> <b>Symfony 5+</b>
7. Run `symfony console doctrine:database:create` to create database
8. Run `symfony console doctrine:migration:migrate` to create structure of database
9. Run `symfony console doctrine:fixtures:load` to load the fixtures in database
10. Run `yarn encore dev` to build assets
11. Run `symfony server:start` to launch symfony server
12. Go to <b>localhost:8000</b> with your favorite browser

### Users

Admin User<br/>
login: admin@admin.com<br/>
password: admin123456789

Demo User<br/>
login: user@user.com<br/>
password: 123456789
