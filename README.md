terminator
==========

Command Line wrappers for all the PHPs


building it
===========

If you wanna hack on this, you'll probably want composer and grunt to help run the tests. If you've got those setup just run
    npm install
then run
    grunt

Once you're ready to start work,
    grunt watch
will make sure you're on track.

The build is pretty simple, so feel free to reverse engineer it if you don't want nodejs for any reason. running
    phpunit
from in the tests directory will get you most of the way there, the rest is just PHP linting, PHPMD and PHPCS
