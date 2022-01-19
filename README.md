# Backend API for sample application "Cardz"

This is a demo API for a frontend, as a mobile app or PWA. An imaginary domain of one-time bonus cards (loyalty program)
has been implemented. The application is intentionally small, so there is no need to understand a large domain.

The main idea is to demonstrate a mix of useful approaches to enterprise application development with ready-made
framework infrastructure. These approaches can be applied to various frameworks (e.g. Laravel, Symfony, Zend) and
codebases.

## Scenario

A cafe launches the loyalty program "Buy 5 cups of coffee and get one cup for free". The cafe issues the disposal card
to a customer, notes the purchased cups, and gives a bonus when the required number of cups is reached by the
cardholder. Another example of the program can be "Buy any 3 dishes from the list and get a discount."

## Glossary

- Achievement - the fact that a task has been completed.
- Task - some action that can be executed one or more times (optional). Can be active or inactive.
- Program - a set of tasks and a specified number of tasks to complete. Can be active or inactive.
- Card - a set of tasks that have been achieved by the holder. Can be cancelled by the holder, rejected, or rewarded.
- Company - a business that offers programs and cards.

## Features

- An authenticated user can found a company.
- As company founders, users can invite and manage the staff (TODO).
- As company founders or staff, users can manage programs, tasks, issues cards, and manages cards and achievements.
- As customers, the users can view their own cards and achievements.

Note: Customer and card identification must be implemented on the front-end (QR codes).

See endpoints [here](src/Api/endpoints.txt)

## Technical details

- Monolith with modular structure and shared database

The application is implemented as a monolith due to its small size. The division into modules is provided for the
possibility of independent development of parts of the application, possibly by different teams, possibly in the form of
microservices. Also, due to the small size, the database is common to all modules. At the moment, the more independent
existence of modules seems complex. Integration between modules and possible data replication seem redundant and planned
for the future.

- Layered module architecture

Each module has a layered architecture. A layered architecture gives us separation of concerns, guidance on source code
organization, and ease of testing. This principle is best followed from the beginning of development.

Infrastructure layer - contains all the classes responsible for performing technical tasks (the framework is considered
as part of the infrastructure).

Application Layer − organizes domain objects to fulfill required use cases.

Domain level - contains business objects, rules, invariants, and other things related to the domain where necessary (
does not depend or minimally depends on the framework).

- Detached API module

Implements an API gateway that is a single point of entry for all clients and forwards requests to the appropriate
service or forks to multiple services. This is a kind of presentation layer in a layered architecture for all the
modules together. If there is a significant difference in working with different clients, it will be quite easy to
switch to a separate gateway for each frontend - Backend for Frontend.

- Simple CQRS read-side

A separate read model is used because possible changes to the query results are expected. In this project, Eloquent
models and transformers are very handy for cross-table querying and data transformation. With the growth of the project,
it is worth thinking about switching to a separate reading model with projectors. This may require the interface to be
operational with eventual consistency.

- DDD tactical patterns - aggregates, value objects and repositories, strategical patterns - the language, contexts

Each module is a proposal for a future Bounded Context. So far, the scope of the application is quite small, and most of
the modules have CRUD operations. However, in a module that works with programs and maps and assumes the main business
logic (core domain), DDD tactical patterns are used - aggregates, value objects, repositories. Right now it's single "
context", but it's possible one day we'll have to think about separating the contexts of specification and customer
service.

- Custom shared library for rapid development with Laravel

The library contains the code required for the rapid development and testing of the application with Laravel. For
example, there is ABAC authorization based on default Gates, borrowed code for custom relation type, and isolated event
listener testing (with no events in the project).

- Testing

For the convenience of testing, a simple test DSL is written - traits, methods, asserts. Feature tests for general
functionality, unit tests for complex specifications. Now feature tests are a large part of the tests, due to the
simplicity of the project. But dependency injection, modularity, layered architecture, and other applied solutions will
allow in the future to move most of the checks down the testing pyramid to unit tests.

- A lot of Laravel features used

## Installation

Installation and test running are the same for any Laravel application (official documentation).

## Requirements

- PHP 8.1 (using named parameters, enums, etc.)
- PostgreSQL

# Laravel

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and
creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in
many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache)
  storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all
modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video
tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging
into our comprehensive video library.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
