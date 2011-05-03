# coin

string token generation and validation in php

## Introduction

Coin is a simple means of generating tokens that are flexible, secure and
can contain an inifite amount of arbitrary data that is stored within the token
itself. A coin is generated using the SHA-1 hashing algorithm and a simple algorithm
that randomly inserts the data within the hash for extraction when needed providing.

## Usage

### Generating a coin

    $coin = new Coin();
    $token = $coin->generate('mycoin', 'kB&(T#)G#&(t79 bvrc g0b72uxb479g&T087');

### Validating a coin

    $coin = new Coin();
    $validated = $coin->validate($token, 'kB&(T#)G#&(t79 bvrc g0b72uxb479g&T087')

    if (!$validated) {
        echo "Invalid coin";
    } else {
        echo $validated;
    }

## About the Author

coin is created and maintained by Nickolas Whiting, a developer by day at [X Studios](http://www.xstudiosinc.com), and a [engineer by night](http://github.com/nwhitingx).

## License

coin is released under the Apache 2 license.