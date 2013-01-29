# Testrig for Magento
Testrig is a tool for quickly setting up, potentially, multiple versions of Magento for extension testing.  Testrig is designed for [modman](https://github.com/colinmollenhour/modman) compatible extensions, supports the installation of sample data and runs the entire installation process automatically.

![image](http://up.nicksays.co.uk/image/3h0G052l0j3D/Screen%20Shot%202012-11-26%20at%2022.31.37.png)

### Features

* Caches copies of the Magento installation .tar.gz files
* Can install multiple versions of Magento at the same time
* Can automatically `modman deploy` any number of extensions in a single execution

### Installation

#### Requirements

* PHP version 5.3.0+

#### GIT

The most common way, I'd imagine, of people installing `testrig` is by cloning a local copy.

    git clone -b master https://github.com/punkstar/testrig.git ~/testrig
    cd ~/testrig
    composer install
    echo "alias testrig=~/testrig/bin/testrig" >> ~/.zshrc

#### Composer

If you'd like to install `testrig` as a dependency of your project, then:

    {
        "require": {
            "meanbee/testrig": "*"
        }
    }

### Using testrig

#### Basic Usage

    testrig --name <value> --dir <value> --url <value> --version <value>[,<value>]* --db_user <value> --db_pass <version> [<extension>[,<extension>]+]

#### Example Usage

The follow incantation will set up three Magento installations (1.5, 1.6 and 1.7) with the Royal Mail Magento extension added and deployed.

    testrig --name royalmail \
            --dir ~/Sites/test/royalmail \
            --url http://bartley.local:8888/test/royalmail \
            --version 1.5,1.6,1.7 \
            --db_user root \
            --db_pass toor \
            https://github.com/meanbee/royalmail.git
            
* `--name <value>`: Use to construct the database name
* `--dir <value>`: The location on direct that the `--url` refers to
* `--url <value>`: The web accessible address of the `--dir` directory
* `--version <value>`: The version(s) of Magento you'd like to install. If multiple versions are required, then separate with a comma
* `--db_user <value>`: The username of a MySQL user that has permission to create databases
* `--db_pass <value>`: The password of the `--db_user` MySQL user
* `https://github.com/meanbee/royalmail.git`: The git remote of a modman compatibile Magento extension.  You can list as many as you like, each separated with a space.

The `~/Sites/test/royalmail` directory will contain three directories after this command, each with a different version of Magento fully setup and configured.

#### Optional Parameters

* `--sample`: Install sample data

### Testing

Unit tests are held in the `tests/` directory and are written with `phpunit`.  To run all tests, run `phpunit` from the root directory.

Current build status:

* [![Build Status](https://travis-ci.org/punkstar/testrig.png?branch=master)](https://travis-ci.org/punkstar/testrig) [master](https://github.com/punkstar/testrig/tree/master)
* [![Build Status](https://travis-ci.org/punkstar/testrig.png?branch=develop)](https://travis-ci.org/punkstar/testrig) [develop](https://github.com/punkstar/testrig/tree/develop)

### License

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
