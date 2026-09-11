<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

Api Documentation

Business:
1. Business Register: http://127.0.0.1:8000/api/register (post)
Request=>{"name"
"email"
"password"
"password_confirmation"}
Response=>{"User details","Token"}
2. Business Login: http://127.0.0.1:8000/api/login (post)
Request=>{"email","password"}
Response=>{"User details", "Token"}
3. Business Logout: http://127.0.0.1:8000/api/logout (post)
Request=>{Authorization Token from login}
Response=>{null}

Client:
1. Create Client: http://127.0.0.1:8000/api/clients (post)
Request=>{"client_name", "email", "phone_number", "Authorization Token"}
Response=>{"client details"}
2. Get all client: http://127.0.0.1:8000/api/clients (get)
Request=>{Authorization Token}
Response=>{All business's clients}
3. Get client by id: http://127.0.0.1:8000/api/clients/{id} (get)
Request=>{Authorization Token}
Response=>{Client details}
4. Update client: http://127.0.0.1:8000/api/clients/{id} (put)
Request=>{ "client_name":"",
    "email":"",
    "phone_number":""}
Response=>{Update User's details}
5. Delete client: http://127.0.0.1:8000/api/clients/{id} (delete)
Request=>{Authorization Token}
Response=>{Null}

Invoice:
1. Create Invoice: http://127.0.0.1:8000/api/invoices (post)
Request=>{"client_id":
    "invoice_number":
    "due_date":
    "items":[ "item":
    "quantity":
    "unit_price":
    ]
   }
Response=>{"Invoice details", "Client details"}
2. Get all Invoice: http://127.0.0.1:8000/api/invoices (get)
Request=>{Authorization Token}
Response=>{"Invoice details", "Client details"}
3. Get Invoice by Id: http://127.0.0.1:8000/api/invoices/{id} (get)
Request=>{Authorization Token}
Response=>{"Invoice details", "Client details"}
4. Update Invoice: http://127.0.0.1:8000/api/invoices/{id} (put)
Request=>{
    "invoice_number":"",
    "due_date":"",
    "items":[
        {
            "item":"",
            "quantity":"",
            "unit_price":""
        }
    ]
}
Response=>{"Invoice details", "Client details"}
5. Delete Invoice: http://127.0.0.1:8000/api/invoices{id} (delete)
Request=>{Authorization Token}
Response=>{Null}
6. Send Invoice: http://127.0.0.1:8000/api/invoices/{id}/send (post)
Request=>{Authorization Token}
Response=> {Invoice details}
7. Mark Paid Invoice: http://127.0.0.1:8000/api/invoices/{id}/mark-paid (post)
Request=>{Authorization Token}
Response=> {Invoice details}
8. Download Pdf: http://127.0.0.1:8000/api/invoices/{id}/pdf (get)
Request=>{Authorization Token}
Response=> {Invoice download}
9. Overdue Invoices: http://127.0.0.1:8000/api/invoices/overdue (get)
Request=>{Authorization Token}
Response=> {Overdue Invoice details}

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
