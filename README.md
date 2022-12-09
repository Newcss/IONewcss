# Description
The library provides input-output (I/O) processing when
working in the console with the ability to implement their own commands by the end developer.

## Starting project
```
docker-compose up
```
## Command for exec
Edit docker-compose.yml
```
command: sh -c 'php index.php newcssPrintIO {verbose,overwrite} [log_file=app.log] {unlimited} [methods={create,update,delete}] [paginate=50] {log}'
```

## Examples of commands
- A command that
accepts an unlimited number of arguments and parameters as input and displays them on the screen
in a user-readable form:
```
command: sh -c 'php index.php newcssPrintIO {verbose,overwrite} [log_file=app.log] {unlimited} [methods={create,update,delete}] [paginate=50] {log}'
```
- The function returns the sum of the arguments passed to it:
```
command: sh -c 'php index.php newcssSumm {1,2,3,4,5,6}'
```