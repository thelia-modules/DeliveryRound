# Delivery Round

Handle rounds to prevent customer you will be present into a given city to dispatch orders.

## Installation

### Manually

* Copy the module into ```<thelia_root>/local/modules/``` directory and be sure that the name of the module is DeliveryRound.
* Activate it in your thelia administration panel

### Composer

Add it in your main thelia composer.json file

```
composer require thelia/delivery-round-module:~1.0
```

## Usage

In the module configuration page, add information about where and when you'll be dispatching orders:
- zip code
- city
- address
- day
- period
- price for choosing this delivery method

You can add as much lines as you want or delete them.

## Hook

If your module use one or more hook, fill this part. Explain which hooks are used.


## Loop

If your module declare one or more loop, describe them here like this :

[loop name]

### Input arguments

|Argument |Description |
|---      |--- |
|**arg1** | describe arg1 with an exemple. |
|**arg2** | describe arg2 with an exemple. |

### Output arguments

|Variable   |Description |
|---        |--- |
|$VAR1    | describe $VAR1 variable |
|$VAR2    | describe $VAR2 variable |

### Exemple

Add a complete exemple of your loop

## Other ?

If you have other think to put, feel free to complete your readme as you want.
