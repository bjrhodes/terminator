# Terminator

Command Line wrappers for all the PHPs

## Using it

### Setup

**Using composer:** I'm not on packagist so you'll need to specify a repositry:

    "require": {
        "bjrhodes/terminator": "*"
    },
    "repositories": [
        {
            "type": "git",
            "url": "https://github.com/bjrhodes/terminator.git"
        }
    ],

It's then as simple as including composers autoload.

**Without composer:** grab the source and add this require where appropriate

    require /path/to/src/Autoload.php


### Output

**For more examples, see examples directory.**

The Output object expects you to add output, then flush it, so that your app can
control the output timings.

Get started with some simple output

    $Out = new Terminator\Out();
    echo $Out->put('This is some text!')
         ->newLine()
         ->flush();

Colour that output:

    $Out = new Terminator\Out();
    echo $Out->fg('green')
         ->put('This is green!')
         ->newLine()
         ->flush();

Set a background colour (with bg() and fg() no args means reset) :

    $Out->fg('black')
        ->bg('light_green')
        ->put('this condition passed!')
        ->bg()
        ->flush();

Flush expects you'll be capturing the output into a variable for later use. To
push to output immediately, pass in true:

    $Out = new Terminator\Out();
    $Out->put('This is some text that will magically appear!')
         ->newLine()
         ->flush(true);


## Building it

If you wanna hack on this, you'll probably want composer and grunt to help run the tests. If you've got those setup
just run `npm install` then run `grunt`. Once you're ready to start work, `grunt watch` will make sure you're on track.

The build is pretty simple, so feel free to reverse engineer it if you don't want nodejs for any reason. running
`phpunit` whilst in the tests directory will get you most of the way there, the rest is just PHP linting, PHPMD and PHPCS.
