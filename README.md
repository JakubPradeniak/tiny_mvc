# Tiny MVC project

Minimal functional MVC.

## About project

This project implements tiny but functional MVC framework, including:

* Simple HTTP request/response cycle handling
* Simple Router
* Simple templating (utilizing includes and output buffering)
* DB connection
* Various helper classes

## **Notice!**

This project is meant to be used for educational purposes and is not 100% production ready!

If you use this project (or its part) for your application, keep in mind that this software is provided **as is**
and all possible consequences of its usage (or its parts) in production environment are your responsibility!

## Branches

`main` - current "stable" branch

`commentary` - branch with thoroughly commented code (TBD)

`example-project` - branch with example project built upon tiny_mvc (simple blog) (TBD)

### Languages

This project is mainly focused on czech students/starting developers so all not prefixed branches will be
documented in czech (TBD - right now it's mixed).

Branches prefixed with `en/` will be documented in english.

### Versions

Version branch with the highest version number is current **work in progress** branch.

`versions/*` - all past versions of the framework

`commentary/*` - commentary branches of past versions

## Folder structure

```
tiny_mvc/
├── Core/
│   ├── Autoload/
│   ├── Database/
│   ├── Exceptions/
│   ├── Http/
│   ├── Persist/
│   ├── Routing/
│   ├── Security/
│   ├── Utils/
│   └── View/
├── public/
│   ├── resources/
│   └── index.php
└── src/
    ├── Controllers/
    ├── Models/
    ├── Routes/
    └── Views/
```

**Core** - tiny_mvc framework files\
**public** - publicly accessible resources and entrypoint to app (_index.php_)\
**src** - source code of application build upon the tiny_mvc

# Tiny info - app architecture

### MVC

**Models** are components which communicates with database.

**Views** are components which creates templates to be displayed to user.

**Controllers** are components which encapsulates business logic and secures communication between rest of system
components (Models, Views, service classes, etc.).

### 7 RESTful actions

| Method name | HTTP method | Description                                            |
|-------------|-------------|--------------------------------------------------------|
| index       | GET         | Render List of resources (posts etc.) -> main content. |
| show        | GET         | Render single resource (post).                         |
| create      | GET         | Render create Form.                                    |
| edit        | GET         | Render edit Form.                                      |
| store       | POST        | Store new data into DB.                                |
| update      | PATCH/PUT   | Update data in DB.                                     |
| destroy     | DELETE      | Remove data from DB.                                   |
