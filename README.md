[![Build Status](https://travis-ci.org/Dargmuesli/randomwinpicker.de.svg?branch=master)](https://travis-ci.org/Dargmuesli/randomwinpicker.de)
[![Known Vulnerabilities](https://snyk.io/test/github/dargmuesli/randomwinpicker.de/badge.svg)](https://snyk.io/test/github/dargmuesli/randomwinpicker.de)
[![Greenkeeper Badge](https://badges.greenkeeper.io/Dargmuesli/randomwinpicker.de.svg)](https://greenkeeper.io/)

# randomwinpicker.de
This website chooses a "true" random winner for CS:GO case openings.

![Welcome](images/welcome.jpg "Welcome to RandomWinPicker")

## Table of contents
1. **[Description](#Description)**
2. **[History](#History)**
3. **[Build & Deploy](#Build-Deploy)**
4. **[Usage](#Usage)**
5. **[Status](#Status)**

<a name="Description"></a>

## Description

### What is this website for?

This website chooses a "true" random winner for any type of raffle.
It's made especially for CS:GO Case openings.

### A "true" random winner?

RandomWinPicker uses the [random.org](https://www.random.org/) API to choose a winner based on the randomness of atmospheric noise.
This is one of the best - if not the best - way to generate random data. It is better than the pseudo-random number algorithms typically used in computer programs.
But there is one limit: Every day only 1,000 requests can be sent to random.org and 250,000 bits can be in the requested answers from random.org. After that the Javascript function Math.random() of your Browser is used.


### How do I start?

All the information RandomWinPicker needs is given in 2 simple steps:

1. Tell RandomWinPicker who participates in your raffle and how great the chance of winning for each user is.
   For example, the chances of winning may depend on the amount of CS:GO keys a user has donated.
2. Choose all items that can be won by any user in a certain winning category.
   Maybe a knife skin can be won on the first place.

That's it!

<a name="History"></a>

## History

One day a YouTuber, [Megaquest](https://www.youtube.com/user/dragonflygames), who I was subscribed to, asked in one of his CS:GO case opening videos if a subscriber of his channel could create a way for him to improve the way he draws the case opening's winner. Until then he made lists and used random.org to pick a winner manually from the list. This method was relatively unoptimized visually as well as methodically. I decided to jump in, contact him and create a website for that purpose.

This website was not my absolutely first one to create, but the first one to finish. I stopped working on other projects and focused on finishing this one. I was by no way a professional in creating websites and thus the original code contains many flaws. Another step I skipped was building and deploying. I had no idea that tools like [Gulp](https://gulpjs.com/) or [Travis](https://travis-ci.org/) existed. Therefore there was only *production* mode: I developed the live site. On one hand the site was up as fast as possible, on the other hand it contained many bugs. Those can be seen in Megaquest's first videos, in which he used my website for his case openings.

Regarding hosting and availability I completely relied on my Raspberry Pi at home. It served the site via Apache and went down a few times rendering the site unusable. This was especially critical when I was not at home and not able to restart the Pi right away. I had a website downtime alert service in place though.

Well, one way or another, the website found its use in some of Megaquests videos. Unfortunately not for a long time. Pretty soon new case opening videos became less and less until he created no new ones any more. I can't tell whether he was completely satisfied with my website. He made the impression that he liked this new and comfortable way to arrange his case opening videos, but did not like it when he found bugs ... of course. Sadly he stopped making those videos and, as far as I can tell, noone else used my site as extensively as he did. I decided to stop paying for the domain [randomwinpicker.de](https://randomwinpicker.de/) in mid-2017. Megaquest stopped uploading videos in January 2018.

<a name="Build-Deploy"></a>

## Build & Deploy

### Environment Variables
Remember to create the `credentials/.env` file using the provided template to enable complete functionality.

### Yarn

All required Node.js dependencies can be installed using [Yarn](https://yarnpkg.com/). By default the `yarn` command utilizes the `package.json` file to automatically install the dependencies to a local `node_modules` folder. Instructions on how to install Yarn can be found [here](https://yarnpkg.com/lang/en/docs/install/).

### Gulp

This repository contains all scripts needed to build this project. The `gulpfile.js` automatically manages tasks like cleaning the build (`dist`) folder, copying files to it, managing dependencies with composer and yarn, creating symlinks and a zip file and finally watching for any changes.

By default the `gulp` command executes all necessary functions to build the website. If the [gulp-cli](https://yarnpkg.com/en/package/gulp-cli) is not installed globally, you need to run `yarn global add gulp-cli` first.

#### Composer
For the `Composer` task to be executed you need to have PHP installed. Make sure that the following settings are made in your `php.ini`:

##### Linux

```PHP
date.timezone = UTC
extension=gd
```

##### Windows

```PHP
date.timezone = UTC
extension=gd2
extension_dir = "ext"
```

### Docker

How you choose to integrate the built project is up to you. A `dockerfile` (and a `docker-compose.yml` template inside `docker-management.json`) is provided to make deployment a breeze.

The given `dockerfile` enables you to build a PHP/Apache-Server with the configuration files in the `docker` folder. It can be run as a Docker container just as you wish, but this alone makes the site not fully functional. Additional services like [a reverse proxy](https://traefik.io/) are needed. Those can be defined in the `docker-compose.yml` file, which describes a [stack that can be deployed on a swarm](https://docs.docker.com/engine/reference/commandline/stack_deploy/). With this file the deployment is complete. To generate a development version of this file you can use [PS-Docker-Management](https://github.com/dargmuesli/ps-docker-management). It simplifies development of Docker projects like this one. To setup this project's full Docker stack locally just run this command:

```PowerShell
./Invoke-PSDockerManagement.ps1 -ProjectPath ../randomwinpicker.de/
```

#### Secrets
To keep confidential data, like usernames and passwords, out of the source code they need to be accessible as [Docker secrets](https://docs.docker.com/engine/swarm/secrets/). These secrets do need to exist:
- postgres_password
- postgres_db
- postgres_user

#### Certificates
HTTPs/SSL encryption requires certificates. Those can easily be generated using the `docker/conf/certs/New-Certificates.ps1` script. The `root.cer` certificate needs to be imported in your browser.

<a name="Usage"></a>

## Usage

### DNS
The default configuration assumes that the local development is done on `randomwinpicker.test`. Therefore one needs to configure the local DNS resolution to make this address resolvable. This can either be done by simply adding this domain and all subdomains to the operation system's hosts file or by settings up a local DNS server. An advantage of the latter method is that subdomain wildcards can be used and thus not every subdomain needs to be defined separately.

Here is an example configuration for [dnsmasq](https://en.wikipedia.org/wiki/Dnsmasq) on [Arch Linux](https://www.archlinux.org/) that uses the local DNS server on top of the router's advertised DNS server:

`/etc/dnsmasq.conf`
```Conf
# Use NetworkManager's resolv.conf
resolv-file=/run/NetworkManager/resolv.conf

# Limit to machine-wide requests
listen-address=127.0.0.1

# Wildcard DNS
address=/randomwinpicker.test/127.0.0.1

# Enable logging (systemctl status dnsmasq)
#log-queries
```

`/etc/NetworkManager/NetworkManager.conf`
```Conf
[main]

# Don't touch /etc/resolv.conf
rc-manager=unmanaged
```

### Adminer / PostgreSQL

Connect to the PostgreSQL instance via [Adminer](https://www.adminer.org/) on [adminer.randomwinpicker.test](https://adminer.randomwinpicker.test) using:

|          |                     |
| -------- | ------------------- |
| System   | PostgreSQL          |
| Server   | postgres            |
| Username | [postgres_user]     |
| Password | [postgres_password] |
| Database | [postgres_db]       |

Values in square brackets are Docker secrets.

### Apache

You can access the website at [randomwinpicker.test](https://randomwinpicker.test).

### Traefik

You can access the reverse proxy's dashboard at [traefik.randomwinpicker.test](https://traefik.randomwinpicker.test).

<a name="Status"></a>

## Status

The original creation of this website consumed way too many hours of my free time to let it vanish somewhere on my harddrive. Thus, I decided to publish the source code to GitHub. My plan is to migrate the website to a subsite of my website [jonas-thelemann.de](https://jonas-thelemann.de/) to keep it available.

Creating this repository from the legacy code I initially wrote was time consuming too, but I learned to use tools like Gulp, Yarn, Docker, Composer, environment variables and a reverse proxy, which moves me one step closer to publishing the source code of my main website. I learned many best practises on how to create a website repository and about state of the art web technologies (which this website does *not* but *could* include). Over the next months I hope that I'll find time to improve the source code to meet my own quality requirements. But until then I hope someone else finds this repository useful. Be it that you want to create your own website or try to hack mine ;)
