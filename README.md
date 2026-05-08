# DevTrack

DevTrack Laravel — outil de gestion de projets et tâches pour équipes de développement. Un Team Lead crée des projets, invite des développeurs, et assigne des tâches. Les développeurs voient uniquement les projets dont ils font partie et mettent à jour leurs propres tâches. Pense mini Jira — sans la complexité.


## Features

### Project Management
- Create new projects with title, description, and status
- Edit and update project details
- View all projects on the dashboard
- Archive projects (soft delete)
- Restore archived projects
- Permanent project deletion

### Task Management
- Create tasks with title, description, due date, and priority
- Assign tasks to projects
- Assign tasks to team members
- Update task status (pending, in-progress, completed)
- Archive and restore tasks
- Full task CRUD operations

### Team Collaboration
- Add team members to projects
- Remove team members from projects
- View team members per project
- Global team overview page

### User Management
- User registration
- User login/logout
- Profile management (name, email)
- Password update
- Password reset functionality
- Email verification

### Additional Features
- Dashboard with project and task statistics
- Archives page for soft-deleted items
- RESTful API for programmatic access
- Responsive design with Tailwind CSS

## Tech Stack

| Component | Technology |
|-----------|------------|
| Framework | Laravel 13 |
| Language | PHP 8.3+ |
| Frontend | Tailwind CSS, Alpine.js |
| Database | MySQL |
| Build Tool | Vite |
| Testing | Pest PHP |
| Authentication | Laravel Breeze |

## Project Structure

```
devtrack/
├── app/
│   ├── Http/Controllers/    # HTTP controllers
│   ├── Models/              # Eloquent models
│   └── ...
├── config/                  # Configuration files
├── database/
│   ├── migrations/          # Database migrations
│   └── seeders/            # Database seeders
├── public/                 # Public assets
├── resources/
│   └── views/              # Blade templates
├── routes/                  # Route definitions
│   ├── web.php             # Web routes
│   └── api.php             # API routes
└── vendor/                 # Composer dependencies
```

## Prerequisites

- PHP 8.3 or higher
- Composer
- Node.js 18+ and npm
- MySQL

## Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd devtrack
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Copy environment file**
   ```bash
   cp .env.example .env
   ```

4. **Generate application key**
   ```bash
   php artisan key:generate
   ```

5. **Configure database**
   
   For Mysql:
   ```bash
   touch database/database.sqlite
   ```
   
   For MySQL, update `.env`:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=devtrack
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Run migrations**
   ```bash
   php artisan migrate
   ```

7. **Install frontend dependencies**
   ```bash
   npm install
   ```

8. **Build assets**
   ```bash
   npm run build
   ```

## Configuration

### Environment Variables

Key configuration options in `.env`:

| Variable | Description | Default |
|----------|-------------|---------|
| `APP_NAME` | Application name | DevTrack |
| `APP_ENV` | Application environment | local |
| `APP_DEBUG` | Enable debug mode | true |
| `APP_URL` | Application URL | http://localhost |
| `DB_CONNECTION` | Database driver | Mysql |


## Running the Application

### Development Mode (Recommended)

Run all services simultaneously (Laravel server, queue worker, Vite):
```bash
npm run dev
```

### Manual Startup

Start the Laravel development server:
```bash
php artisan serve
```

Start the Vite development server:
```bash
npm run dev
```

## API Endpoints

### Tasks API

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/projects/{project}/tasks` | List all tasks for a project |
| GET | `/api/projects/{project}/tasks/{task}` | Get a specific task |


## Database Schema

### Users Table
- id, name, email, email_verified_at, password, remember_token, timestamps

### Projects Table
- id, title, description, status, user_id (owner), deleted_at, timestamps

### Tasks Table
- id, title, description, status, priority, due_date, project_id, user_id (assigned_to), deleted_at, timestamps

### Project User Table (Pivot)
- project_id, user_id (team members)

## Testing

Run all tests:
```bash
php artisan test
```

## Available Commands

```bash
# Setup project (install, key, migrate, build)
composer run setup

# Development server with all services
npm run dev

# Run tests
composer run test

# Clear config cache
php artisan config:clear

# Clear route cache
php artisan route:clear

# Clear view cache
php artisan view:clear

# List routes
php artisan route:list
```

## Screenshots

The application includes the following pages:
- **Dashboard** - Overview of all projects and tasks with statistics
<img width="1917" height="917" alt="Screenshot 2026-05-08 123006" src="https://github.com/user-attachments/assets/987c94ef-2b65-4ff2-a21a-9484a755913c" />

- **Projects** - List, create, edit, view projects
<img width="1917" height="917" alt="Screenshot 2026-05-08 122951" src="https://github.com/user-attachments/assets/f8addc9e-04bb-43df-bc2c-9e96326dd15e" />

- **Tasks** - Full task management interface
<img width="1918" height="918" alt="Screenshot 2026-05-08 123019" src="https://github.com/user-attachments/assets/e0aab4dd-739b-46c8-811f-78c409482cef" />

- **Team** - Manage team members across projects
<img width="1900" height="918" alt="Screenshot 2026-05-08 123033" src="https://github.com/user-attachments/assets/39040a88-2d17-4fdf-ba57-9db788773d35" />

- **Archives** - View and restore deleted items
<img width="1917" height="917" alt="Screenshot 2026-05-08 123121" src="https://github.com/user-attachments/assets/50773868-855a-4c5b-b84b-cb72df78506c" />


## Contributing

Thanks to: 
```
https://github.com/farahar2 & https://github.com/Pro-joseph
```
## License

MIT License - see the [LICENSE](LICENSE) file for details.
