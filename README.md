# 📝 To-Do List Application

A simple and interactive **To-Do List** web application built using **Laravel** and **AJAX** for real-time task management.

## 📌 Features
- ✅ Add new tasks dynamically.
- ✅ Mark tasks as completed/undo instantly.
- ✅ Delete tasks without reloading the page.
- ✅ Responsive & modern UI with Bootstrap.
- ✅ Uses Laravel's REST API for task management.

---

## 📦 Installation & Setup

### 1️⃣ Clone the Repository
```sh
git clone https://github.com/HeshanNavindu-7/ToDo-App-laravel-.git
cd filename
# 📝 To-Do List Application

A simple and interactive **To-Do List** web application built using **Laravel** and **AJAX** for real-time task management.

## 📦 Installation & Setup

### 1️⃣ Install Dependencies
Run the following commands to install the required dependencies:

```sh
composer install
npm install

 ### Configure Environment
Copy the .env.example file and rename it to .env:

```sh

cp .env.example .env
Generate the application key:

```sh

php artisan key:generate
###3️⃣ Set Up the Database
Edit the .env file and configure your database settings:

env

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=todo_db
DB_USERNAME=root
DB_PASSWORD=
Run migrations to create the necessary tables:

```sh

php artisan migrate
###4️⃣ Start the Application
Run the Laravel development server:

```sh

php artisan serve
Once the server is running, access the application at:
➡️ http://127.0.0.1:8000

###🎯 Technologies Used
Laravel (Backend Framework)
Bootstrap (Styling & UI)
AJAX + jQuery (Asynchronous updates)
MySQL (Database)
