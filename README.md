# Backend API for sample application "Cardz"

This is a demo API for a frontend (a mobile app or PWA). An imaginary domain of one-time bonus cards (loyalty program)
has been implemented. The application is intentionally small, so there is no need to understand a large domain.

The main idea is to demonstrate a mix of useful approaches to enterprise application development with a ready-made
web-framework. These approaches can be applied to the various frameworks (e.g. Laravel, Symfony, Zend) and codebases.

## Scenario

A cafe launches the loyalty program "Buy 5 cups of coffee and get one cup for free". The cafe issues a disposable card
to a customer, notes the purchased cups, and gives a bonus when the required number of cups is reached by the
cardholder. Another example of the program might be "Buy any 3 dishes from the list and get a discount."

## Glossary

- Achievement - a fact that a task has been completed.
- Task - some action that can be executed one or more times (optional). It can be active or inactive.
- Program - a set of tasks and a specified number of tasks to complete. It can be active or inactive.
- Card - a set of tasks that should be achieved by the holder. It can be cancelled by the holder, rejected, or rewarded.
- Company - a business that offers programs and cards.

## Features

- An authenticated user can found a company.
- As company founders, users can invite and manage the staff (TODO).
- As company founders or staff, users can manage programs, tasks, issue cards, and manage cards and achievements.
- As customers, users can view their cards and achievements.

Note: Customer and card identification must be implemented on the frontend (QR codes).

See endpoints [here](src/Api/endpoints.txt)

## Technical details

- Monolith with modular structure and shared database

The application is implemented as a monolith due to its small size. The division into the modules is implemented to
simplify the independent development of the application parts, possibly by different teams, perhaps in the form of
microservices. Also, due to the small size, the database is shared between all modules. More module independence seems
like an overcomplication at this point. Integration and possible data duplication between modules can be implemented
later.

- Layered module architecture

See modules [here](src/Modules)

Each module has a layered architecture. The layered architecture is the separation of concerns among components. It
provides guidance on source code organization and ease of testing. It is better to use this principle right from the
start.

Infrastructure layer - contains all the classes responsible for the technical stuff. The framework is a part of this
layer.

Application Layer − organizes domain objects to fulfill required use cases.

Domain level - contains business objects, rules, invariants, and other things related to the domain. This layer may be
absent in some modules. It should be isolated from the framework as much as possible.

- Detached API gateway

See gateway [here](src/Api)

The API gateway is a single entry point that forwards requests to the appropriate service or splits them into multiple
services. This is a kind of presentation layer of the layered architecture for all modules together. If there is a
significant difference in working with different clients, it should be easy enough to make a separate gateway for every
frontend - Backend for Frontend.

- Simple CQRS read-side

A read model pattern is used to separate the application logic from data presentation. In this project, Eloquent models
and transformers are very handy for cross-table querying and data transformation. The next step is the fully-separate
read model with projectors. This may require the frontend to support eventual consistency.

- DDD tactical patterns

Each module is a proposal for a future Bounded Context. So far, the scope of the application is quite small, and most of
the modules have CRUD operations. However, the module with main business logic (core domain) implements some DDD
tactical patterns - aggregates, value objects, repositories. This single context should probably be divided later into
the specification and customer service.

- Custom shared library for rapid development with Laravel

See library [here](codderz/YokoLite)

The library contains the code required for the rapid development and testing of the application with Laravel. For
example, there is an ABAC authorization based on default Gates, custom relation type, and advanced events testing.

- Testing

See tests [here](tests)

For the convenience of testing, a simple test DSL is written - traits, methods, asserts. There are feature tests for
essential use cases and unit tests for complex specifications. At the moment, the functionality of the application is
guaranteed mostly by feature tests, but the majority of the tests will move down the testing pyramid later.

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
