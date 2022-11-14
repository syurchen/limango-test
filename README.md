### Usage
- Clone

- ```composer install```

- ```php bin/console purchase-cigarettes 5 50```

- ```php vendor/bin/phpunit tests/```



### Task
Your product owner has given you the task of developing a
small CLI cigarette machine. The input should be the amount
of packs a potential customer could want and the amount he is
going to give. The price per cigarette pack is a static -4,99€.
You *dont* have to think about currencies, there are only €!

The result should be printed on the screen with the count and 
the total amount of the purchased packs as well as a table 
which tells the customer in which coin combination he is going
to get his change.

Example:

```
╭─vicgey@limango:/home
╰─$ php bin/console purchase-cigarettes 2 10.00

You bought 2 packs of cigarettes for -9,98€, each for -4,99€.

Your change is:
+-------+-------+
| Coins | Count |
+-------+-------+
| 0.02  | 1     |
+-------+-------+
```
