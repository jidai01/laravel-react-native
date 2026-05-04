# QuizLOS Admin Server (Laravel) 🖥️

This is the backend logic and administrative dashboard for the **QuizLOS** platform.

## 🚀 Setup Instructions

1. **Install Dependencies**:
   ```bash
   cd laravel-server
   composer install
   npm install
   ```

2. **Configure Environment**:
   - Copy `.env.example` to `.env`.
   - Set your database credentials (`DB_DATABASE`, `DB_USERNAME`, etc.).
   - Ensure `APP_TIMEZONE=Asia/Makassar` is set for accurate logs.

3. **Initialize System**:
   ```bash
   php artisan key:generate
   php artisan migrate:fresh --seed
   ```

4. **Run the Server**:
   ```bash
   php artisan serve --host=0.0.0.0
   ```
   *Note: Use the host IP to allow mobile devices to connect.*

## 🛡️ Admin Features
- **📊 Live Activity Monitor**: Track participant progress and disqualifications in real-time.
- **📝 Quiz Management**: Full CRUD for questions with "Shuffle Options" support.
- **👥 Participant Audit**: Manage accounts, reset disqualification status, and delete records.
- **🔒 Security**: Built-in rate limiting and Sanctum-protected API routes.

## 🎨 Design System
- **Theme**: Premium Indigo UI.
- **Data Tables**: Integrated DataTables for high-performance data management (search, sort, paginate).

---
## 🚀 Deployment (InfinityFree)
This project is configured for auto-deployment via GitHub Actions.
1. Go to your GitHub Repository **Settings > Secrets and variables > Actions**.
2. Add the following secrets:
   - `FTP_USERNAME`: Your InfinityFree FTP username (e.g., `if0_3xxx`).
   - `FTP_PASSWORD`: Your InfinityFree FTP password.
3. Every push to `main` affecting the `laravel-server` folder will trigger an automatic upload to `htdocs`.

**Note**: Since InfinityFree is a shared hosting, you may need to add an `.htaccess` in the root to redirect traffic to the `public` folder.

**QuizLOS Backend v.1.0 • Admin Control Center**
