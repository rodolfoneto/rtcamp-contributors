### RtClass Contributors WP Plugin
Contributors: rodofoneto

Tags: wordpress, plugin, contributors

Requires at least: 5.2

Tested up to: 6.1.1

Requires PHP: 5.6

Stable tag: 0.1.0

License: GPLv2 or later.

License URI: https://www.gnu.org/licenses/gpl-2.0.html

### Description
Plugin to set contributors to a post.
Simple plugin to assing a job position in the RTCamp company


### Installation
To install the plugin and run the tests youll need
#### Required
- PHPUnit
- composer
- GIT
- SVN
- WP-CLI

Steps
1. wp core download --path=DIR_DEST
2. cd DIR_DEST
3. wp server
4. go to internet browser and access http://localhost:8080 and make the wordpress install
5. cd wp-content/plugins
6. git clone https://github.com/rodolfoneto/rtcamp-contributors.git
7. cd rtcamp-contributors
8. composer install
9. ./bin/install-wp-tests.sh wordpress_test 'USER_DATABASE' 'PASSWORD_DATABASE' 127.0.0.1 latest
10. phpunit

