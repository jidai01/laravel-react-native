# QuizLOS Admin Server (Laravel) 🖥️

This branch contains the backend logic and administrative dashboard for the **QuizLOS** platform.

## 🚀 Setup Instructions

1. **Clone the branch**:
   ```bash
   git clone -b laravel-server https://github.com/jidai01/laravel-react-native.git
   ```

2. **Install Dependencies**:
   ```bash
   composer install
   npm install
   ```

3. **Configure Environment**:
   - Copy `.env.example` to `.env`.
   - Set `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`.
   - Ensure `TIMEZONE=Asia/Makassar` is set.

4. **Initialize Database**:
   ```bash
   php artisan key:generate
   php artisan migrate:fresh --seed
   ```

5. **Run the Server**:
   ```bash
   php artisan serve --host=0.0.0.0
   ```

## 🛡️ Admin Features
- **Dashboard**: Real-time activity monitor for all active participants.
- **Quiz Management**: Create, edit, and delete questions with "Shuffle Options" configuration.
- **Participant Management**: Delete accounts, reset disqualification status, and audit results.
- **API Endpoints**: Secure Sanctum-protected routes for the mobile app.

## ⚙️ Key Configurations
- **Rate Limiting**: Configured in `routes/api.php` to prevent brute-force.
- **Timezone**: Defaulted to **Asia/Makassar (WITA)** for accurate log timestamps.
- **DataTables**: Integrated for advanced searching and sorting.

---
**QuizLOS Backend v.1.0**
