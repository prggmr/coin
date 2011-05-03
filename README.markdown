# coin

string token generation and validation in php

## Introduction

Coin is a simple means of generating tokens that are flexible, secure and
can contain an any arbitrary data which is stored within the token
itself. A coin is generated using the SHA-1 hashing algorithm and an algorithm
that randomly inserts the data within the hash for extraction.

Coin is to be used a means of adding a simple layer of security for applications,
it should NOT be used as a method of securing sensitive information and I make no guarantees that
this is 100% safe, the data is stored within the string so it is completely viewable by the world
and this is not a method of encrypting or hashing!

Now that I've covered those basics here are some examples.

## Generating a coin

    $coin = new Coin();
    $token = $coin->generate('mycoin', 'kB&(T#)G#&(t79 bvrc g0b72uxb479g&T087');

### Generates a coin of

bd-36-6-d131b7277331bc917ab780e47cd2a56d3cmycoin6dbf

Take note if you use this example your results will vary as each coin is randomly generated.

## Validating a coin

    $coin = new Coin();
    $validated = $coin->validate($token, 'kB&(T#)G#&(t79 bvrc g0b72uxb479g&T087')

    if (!$validated) {
        echo "Invalid coin";
    } else {
        echo $validated;
    }

    // Once validated the coin's value is returned

## About the Author

coin is created and maintained by Nickolas Whiting, a developer by day at [X Studios](http://www.xstudiosinc.com), and a [engineer by night](http://github.com/nwhitingx).

## License

coin is released under the Apache 2 license.