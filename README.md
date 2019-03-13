[![Build Status](https://travis-ci.org/Dargmuesli/randomwinpicker.svg?branch=develop)](https://travis-ci.org/Dargmuesli/randomwinpicker)
[![Known Vulnerabilities](https://snyk.io/test/github/dargmuesli/randomwinpicker/badge.svg)](https://snyk.io/test/github/dargmuesli/randomwinpicker)
[![Greenkeeper Badge](https://badges.greenkeeper.io/Dargmuesli/randomwinpicker.svg)](https://greenkeeper.io/)
[![Website Uptime Monitoring](https://app.statuscake.com/button/index.php?Track=VRBItScv8j&Days=1000&Design=3)](https://www.statuscake.com) <!-- randomwinpicker.jonas-thelemann.de -->

# randomwinpicker
This website chooses a "true" random winner for CS:GO case openings.

![Welcome](images/welcome.jpg "Welcome to RandomWinPicker")

## Table of Contents
1. **[Context](#context)**
    - **[Description](#description)**
    - **[History](#history)**
    - **[Status](#status)**
1. **[Development](#development)**
    - **[Deployment](#deployment)**

## Context

### Description

#### What is this website for?
This website chooses a "true" random winner for any type of raffle.
It's made especially for CS:GO Case openings.

#### A "true" random winner?
RandomWinPicker uses the [random.org](https://www.random.org/) API to choose a winner based on the randomness of atmospheric noise.
This is one of the best - if not the best - way to generate random data. It is better than the pseudo-random number algorithms typically used in computer programs.
But there is one limit: Every day only 1,000 requests can be sent to random.org and 250,000 bits can be in the requested answers from random.org. After that the Javascript function Math.random() of your Browser is used.

#### How do I start?
All the information RandomWinPicker needs is given in 2 simple steps:

1. Tell RandomWinPicker who participates in your raffle and how great the chance of winning for each user is.
   For example, the chances of winning may depend on the amount of CS:GO keys a user has donated.
2. Choose all items that can be won by any user in a certain winning category.
   Maybe a knife skin can be won on the first place.

That's it!

### History
One day a YouTuber, [Megaquest](https://www.youtube.com/user/dragonflygames), who I was subscribed to, asked in one of his CS:GO case opening videos if a subscriber of his channel could create a way for him to improve the way he draws the case opening's winner. Until then he made lists and used random.org to pick a winner manually from the list. This method was relatively unoptimized visually as well as methodically. I decided to jump in, contact him and create a website for that purpose.

This website was not my absolutely first one to create, but the first one to finish. I stopped working on other projects and focused on finishing this one. I was by no way a professional in creating websites and thus the original code contains many flaws. Another step I skipped was building and deploying. I had no idea that tools like [Gulp](https://gulpjs.com/) or [Travis](https://travis-ci.org/) existed. Therefore there was only *production* mode: I developed the live site. On one hand the site was up as fast as possible, on the other hand it contained many bugs. Those can be seen in Megaquest's first videos, in which he used my website for his case openings.

Regarding hosting and availability I completely relied on my Raspberry Pi at home. It served the site via Apache and went down a few times rendering the site unusable. This was especially critical when I was not at home and not able to restart the Pi right away. I had a website downtime alert service in place though.

Well, one way or another, the website found its use in some of Megaquests videos. Unfortunately not for a long time. Pretty soon new case opening videos became less and less until he created no new ones any more. I can't tell whether he was completely satisfied with my website. He made the impression that he liked this new and comfortable way to arrange his case opening videos, but did not like it when he found bugs ... of course. Sadly he stopped making those videos and, as far as I can tell, noone else used my site as extensively as he did. I decided to stop paying for the domain [randomwinpicker.de](https://randomwinpicker.de/) in mid-2017. Megaquest stopped uploading videos in January 2018.

### Status
This website is not available at the original domain anymore. It is now available at [randomwinpicker.jonas-thelemann.de](https://randomwinpicker.jonas-thelemann.de/), a subdomain of my personal website.

The original creation of this website consumed way too many hours of my free time to let it vanish somewhere on my harddrive. Thus, I decided to publish the source code to GitHub. Creating this repository from the legacy code I initially wrote was time consuming too, but I learned to use tools like Gulp, Yarn, Docker, Composer, environment variables and a reverse proxy, which moves me one step closer to publishing the source code of my main website. I learned many best practises on how to create a website repository and about state of the art web technologies (which this website does *not* but *could* include). Over the next months I hope that I'll find time to improve the source code to meet my own quality requirements. But until then I hope someone else finds this repository useful. Be it that you want to create your own website or try to hack mine ;)

## Development
This project is deployed within the [randomwinpicker_stack](https://github.com/Dargmuesli/randomwinpicker_stack/) in accordance to the [DargStack template](https://github.com/Dargmuesli/dargstack-template/) to make deployment a breeze.

The provided `Dockerfile` lets you build an Apache-PHP server image with the configuration files in the `docker` folder. Build it with the following command:

```bash
docker build -t dargmuesli/randomwinpicker .
```

The following information is therefore only useful if you decide to deploy this project containerless.

### Build

#### Yarn
All required [Node.js](https://nodejs.org/) dependencies can be installed using [Yarn](https://yarnpkg.com/). By default the `yarn` command utilizes the `package.json` file to automatically install the dependencies to a local `node_modules` folder. Instructions on how to install Yarn can be found [here](https://yarnpkg.com/lang/en/docs/install/).

#### Gulp
This repository contains all scripts required to build this project. The `gulpfile.js` automatically manages tasks like cleaning the build (`dist`) folder, copying files to it, managing dependencies with composer and yarn, creating symlinks and a zip file and, finally, watching for changes too.

By default the `gulp` command executes all necessary functions to build the website. If the [gulp-cli](https://yarnpkg.com/en/package/gulp-cli/) is not installed globally, you need to run `yarn global add gulp-cli` first.

### Deployment

#### Environment Variables
Create the `credentials/randomwinpicker.env` file using the provided template to enable complete functionality.

#### PHP
[PHP](https://php.net/) needs to be installed for the Gulp `composerUpdate` task to be executed. Make sure that the following settings are set in your `php.ini`:

```PHP
# Linux
date.timezone = UTC
extension=gd

# Windows
date.timezone = UTC
extension=gd2
extension_dir = "ext"
```
