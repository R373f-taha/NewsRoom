📰 NewsRoom API
💛💛💛 A Modern News & Articles Management System 💛💛💛

📌 About The Project
NewsRoom  for managing news articles with:

Feature	Description

🎯 RBAC	Role-Based Access Control (Admin, Writer, Reader)
📱 API Versioning	V1 for Web, V2 for Mobile clients
🏗️ Clean Architecture	Repository, Service, Observer, and Event-Driven patterns
⚡ Background Processing	Queues, Jobs, and Events for async operations
🔍 Advanced Caching	Redis integration for optimal performance
📎 Polymorphic Relations	Comments and Attachments on multiple entity types
💡 Live API Documentation: NewsRoom Postman Collection

🚀 Quick Start (5 Minutes)

Prerequisites
bash
PHP 8.2+
Composer
MySQL 8.0+
Redis
Installation Steps

bash
# 1. Clone the repository
git clone https://github.com/R373f-taha/NewsRoom.git
cd NewsRoom

# 2. Install dependencies
composer install

# 3. Environment setup
cp .env.example .env
php artisan key:generate

# 4. Configure database (.env file)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=NewsRoom
DB_USERNAME=root
DB_PASSWORD=

# 5. Run migrations & seeders
php artisan migrate --seed

# 6. Start the server
php artisan serve

---------

📧 Email Configuration

To activate the email responsible for sending emails:

Prerequisites 💛:
The email must have two-factor authentication enabled.

Access Gmail settings and navigate to "App Passwords" under security settings.

Generate a new app password by specifying the app name and copying the generated password.

Email Configuration in .env file:

bash
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=[Your Email]
MAIL_PASSWORD=[Generated App Password Here]
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=[Your Email]
MAIL_FROM_NAME=[App Name]


🔐 Authentication Accounts

Role      	    Email	                  Password
👑 Admin	admin@NewsRoom.com      	admin123
👤 Reader	reader@NewsRoom.com	        reader123
✍️ Writer	Writer@hirehub.com	        Writer123

📂 Project Structure

text
app/
├── Actions/              # Single-action classes (CreateUserAction)
├── Events/               # Application events
├── Jobs/                 # Queue jobs (SendWelcomeEmailJob)
├── Listeners/            # Event listeners
├── Observers/            # Model observers
├── Repositories/         # Data access layer
│   ├── Contracts/        # Interfaces
│   └── Eloquent/         # Implementations
├── Services/             # Business logic
│   ├── Contracts/        # Service interfaces
│   └── Notifications/    # Notification services
├── Http/
│   ├── Controllers/      # API controllers (V1/V2)
│   ├── Resources/        # API Resources (V1/V2)
│   ├── Requests/         # Form requests (validation)
│   └── Middleware/       # Role-based middleware
└── Console/
    └── Commands/         # Artisan commands


🔗 Quick Links

Resource	Link

📖 Postman Collection	https://documenter.getpostman.com/view/50321677/2sBXwmQYKr

---------

👩‍💻 Developer

Rahaf Taha
