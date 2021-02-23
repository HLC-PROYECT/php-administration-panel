# ADMINISTRATION PANEL

## Run proyect

This proyect can be run by diferents ways:

### Run on XAMP

To run this proyect on XAMP you must reference the entry point on `app/public` folder.

### Run proyect on Docker

First to view the availables comands run:

```
  make all
```

To start this proyect on docker:

```
   make up
```

To delete entire container:
```
  make down
```


# Install libraries

To install proyect depencencies:

```
  make composer
```

This proyect implements `composer`, to install some library:

```
  make copmposer-require lib=libraryName
```

# Documentation

If you're interested to learn more about this proyect please visit: 

[administration panel docs](https://joserider.github.io/administration-panel-docs)




© 2021 - Docker image by Alberto Antequera 
