**QR Code content app (media)**

**OVERVIEW**

Objective of this application is to build an API + UI using Laravel + MYSQL to allow clients to self register accounts to gain login access on xyz applications and render QR code preview of selected text.

**GOALS**

Goal is to build an app where users can register and login using laravel built in auth mechanism.
To be able to self register accounts and login using login form.
Only authenticated users should be able to access QR code builder page.
Ensure to apply proper validations on all fields of registration + login pages.

**QR code builder page**

Sample payload + response body: https://i.imgur.com/BhzUyGU.png This page can only be access by authenticated users.
QR code preview page and all pages UI must be to build using VueJS, if possible Following information should be asked from form inorder to generate QR code: content, size, background_color, fill_color.

**SPECIFICATIONS**

Candidates are expected to build API endpoints using laravel (ver 9) repository design pattern and mysql as DB server.
Please write unit test cases for all developed endpoints. This is a TEST Task. DO NOT seek outside guidance/help to complete this task.
