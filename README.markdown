# coin

Token system for PHP.

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

## Requirements

* PHP >= 5.3

## Generating and validating coin using the API

    $token = coin('mycoin', 'kB&(T#)G#&(t79 bvrc g0b72uxb479g&T087');

## Generating a coin using the Coin Class

    $coin = new Coin();
    $token = $coin->generate('mycoin', 'kB&(T#)G#&(t79 bvrc g0b72uxb479g&T087');

### Both generate a coin of

bd-36-6-d131b7277331bc917ab780e47cd2a56d3cmycoin6dbf

Take note if you use this example your results will vary as each coin is randomly generated.

## Validating a coin using the API

    $token = coin('mycoin', 'kB&(T#)G#&(t79 bvrc g0b72uxb479g&T087');
    $coin = validate_coin($token, 'kB&(T#)G#&(t79 bvrc g0b72uxb479g&T087');
    
    if (!$coin) {
        echo "Invalid Coin";
    } else {
        // If valid the value of the coin is returned from coin_validate
        echo 'Value contained in the coin : ' . $coin;
    }

## Validating a coin using the Coin Class

    $coin = new Coin();
    $valid_coin = $coin->validate($token, 'kB&(T#)G#&(t79 bvrc g0b72uxb479g&T087')

    if (!$valid_coin) {
        echo "Invalid coin";
    } else {
        // If valid the value of the coin is returned from validate
        echo 'Value contained in the coin : ' .  $valid_coin;
    }

## About the Author

coin is created and maintained by Nickolas Whiting, a developer by day at [X Studios](http://www.xstudiosinc.com), and a [engineer by night](http://github.com/nwhitingx).

## License

coin is released under the Apache 2 license.
