[<img src="https://cdn.rawgit.com/lutsen/lagan/master/lagan-logo.svg" width="100" alt="Lagan">](https://github.com/lutsen/lagan)

Lagan Upload Property Controller
================================

Controller for the Lagan upload property, built with the [Sirius upload handler library](https://github.com/siriusphp/upload). Lets the user upload a file.

You can validate the uploaded files by specifying the [upload rules](http://www.sirius.ro/php/sirius/upload/validation_rules.html) in the 'validate' value in the property array. Each rule and the optional values must be in a seperate nested value, where the rule is the first value, and the optional values are the second value. Example: `'validate' => [ ['extension', 'allowed=jpeg,jpg,gif,png'], ['size', 'size=1M'] ]`

To be used with [Lagan](https://github.com/lutsen/lagan). Lagan lets you create flexible content objects with a simple class, and manage them with a web interface.

Lagan is a project of [Lútsen Stellingwerff](http://lutsen.net/).