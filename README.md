# ADVENT 2021

## Setup

Set your credentials in .env (copy to .env.local):  

```
ADVENT_COOKIE_GA=Kappa
ADVENT_COOKIE_GID=Kappa
ADVENT_COOKIE_SESSION=hegle-begle
```

( Go to https://adventofcode.com/2021/day/1 and copy it from the headers ;) ) 

## Usage

In order to add new solution, add a new Command extending `AbstractAdventCommand` and set the `protected static $defaultName` (command name).

### getDayNumber(): string

Self-explanatory (I hope :D)

Example:
```
    protected function getDayNumber(): string
    {
        return '1';
    }
```

### prepareInput($input): mixed (implementation optional)

Modify the input corresponding to the day of December, f.x explode the text into array. \
The prepared input will be used as the parameter for the `getFirstPartSolution` and `getSecondPartSolution` functions.

Example:
```
    protected function prepareInput($input): array
    {
        return explode(PHP_EOL, $input);
    }
```

### getFirstPartSolution($input): string
Get the desired result from the prepared input and return it as a string, so it will be displayed by the command.

Example:
```
    protected function getFirstPartSolution($input): string
    {
        $count = 0;

        foreach ($input as $key => $measurement) {
            if (isset($input[$key + 1]) && $input[$key + 1] > $measurement) {
                $count++;
            }
        }

        return (string)$count;
    }
```

### getSecondPartSolution($input): string
Same as above.

## For the result launch the newly created and implemented command :) good luck!
