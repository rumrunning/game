# Rewards

When an action is attempted there should be an array of awards available.
Rewards are obtained when a attempt results in a successful Outcome.
Some rewards may be subject to a chance finding; these types of rewards are determined to be "discovered"
(or not) when the Outcome claims are requested.

Here is an example of a crime and it's available rewards

```php
'crimes' => [
    [
        'code' => 'pickpocket',
        'description' => 'Pick-pocket someone',
        'difficulty' => 0.1,
        'outcomes' => [
            'rewards' => [
                new \App\RumRunning\Rewards\Money(50, 110),
                new \App\RumRunning\Rewards\Skill(100, 300),

                (new \App\RumRunning\Rewards\Bullet(1, 15))->setDiscoveryChance(0.1)
            ]
        ],
    ]
]
```

This example illustrates that the "pickpocket" crime has the rewards Money, Skill and Bullet.

- The money rewarded will be between 50 and 100
- The skill rewards will be between 1 and 3
- The bullets rewarded will be between 1 and 15. There is a 10% chance you will discover this reward,
this is illustrated by `Bullet::setDiscoveryChance(0.1)` method.

## Types of rewards

### Cash

```php
new \App\RumRunning\Rewards\Money(50, 110)
```

### Skill

Skill points are saved as a division of 1000. Therefore 1 skillpoint is equal to 100.
This enables fine-grained control over the amount of skill that can be rewarded. 

```php
new \App\RumRunning\Rewards\Skill(100, 300)
```

### Bullets

_To be implemented..._

```php
(new \App\RumRunning\Rewards\Bullet(1, 15))->setDiscoveryChance(0.1)
```