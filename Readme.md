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

In the module configuration page, add information about the price of this delivery method and about where and when you'll be dispatching orders:
- zip code *
- city *
- address
- day *
- period

You can use the *address* input to inform your customers where you will be dispatching their orders, or leave it blank if you deliver at home.

To display a message about your round or the time you need to prepare an order for example, use the description in the module edition.

This delivery method will be proposed to customer who have at least one address with the same zipcode as one of the ones you entered in the configuration.

## Loop

[deliveryround]

### Input arguments

|Argument |Description |
|---      |--- |
|**id** | ID of a specific delivery round entry |
|**zipcode** | Used to sort delivery round entries by zipcode |
|**day** | Used to sort delivery round entries by day. Values: *monday*, *tuesday*, *wednesday*, *thursday*, *friday*, *saturday*, *sunday*.  |

### Output arguments

|Variable   |Description |
|---        |--- |
|$ID    | ID of the returned delivery round entry |
|$ZIPCODE    | Zipcode |
|$CITY    | City |
|$ADDRESS    | Address from where you dispatch your orders |
|$DAY    | Day of the week |
|$DELIVERY_PERIOD    | Period during which one you'll be dispatching orders |

### Exemple

<ul>
    {loop type='deliveryround' name='deliveryround-loop'}
        <li>{$DAY|date_format:"%A"} : {$ZIPCODE} {$CITY}{if $ADDRESS}, {$ADDRESS}{/if}{if $DELIVERY_PERIOD}, {$DELIVERY_PERIOD}{/if}</li>
    {/loop}
</ul>
