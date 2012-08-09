#SMS Plan Social: Powered by Twilio SMS

This services allows groups of friends to organize all their "Todos" when planning events. You can add/view/delete todos from the web browser as well as using a cell phone. This is a great way for groups to plan events while all staying on the same page. Test it out [here](http://mattsauerbach.com/smsplansocial/)

## Usage 

Group members can add, view their own todos as well as others and mark as complete. 

![Browser View](https://raw.github.com/mauerbac/SMS-Plan-Social/master/img/img1.png)

Using a Cell phone has the same functionality 

![On Cell Phone](https://raw.github.com/mauerbac/SMS-Plan-Social/master/img/img2.png)


## Installation

Step-by-step on how to deploy, configure and develop this app.

### Create Credentials

1) Add a phone number to your Twilio account. (This will be your SMS number). In the Voice Request URl put the location of tw.php

### Setup MySQL Database

1) Create a new MySQL Database

2) Use table.sql for setup 

###Configuration 

1) Include Twilio [PHP Helper Library](https://github.com/twilio/twilio-php)

2) Edit constants.php. Add all Credentials and MySQL info. 




