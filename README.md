# QuizLOS v.1.0 🚀

<div align="center">
  <img src="laravel-server/public/logo.svg" width="150" height="150" alt="QuizLOS Logo">
  <h3>Secure • Professional • Offline-First</h3>
  <p><b>A modern examination ecosystem for high-integrity testing.</b></p>
</div>

---

## 🌟 Project Ecosystem

**QuizLOS** is a full-stack examination platform designed to eliminate cheating and provide real-time oversight for administrators.

- **[Admin Server](laravel-server/)**: Laravel 11 Backend & Dashboard.
- **[Participant App](mobile/)**: React Native Expo Mobile Application.

---

## 🛠 Tech Stack & Security

### 🖥️ Backend (Laravel 11)
- **Security**: Sanctum API Auth, Rate Limiting, Input Sanitation.
- **Monitoring**: Custom Live Log Activity with Asia/Makassar (WITA) precision.
- **UI**: Premium Indigo UI with DataTables for advanced data management.

### 📱 Mobile (React Native Expo)
- **Security**: **Anti-Cheat Enforcement** (Background Detection), System Navigation Lock.
- **Offline First**: Local data persistence via `expo-sqlite` and `SecureStore`.
- **Branding**: Official QLOS "Q-Timer" branding with environment-based config.

---

## 🔐 Key Features

- **🛡️ Integrity Enforcement**: Automatic disqualification if the app is minimized or exited.
- **📊 Real-time Oversight**: Admins can track exactly when questions are answered or changed.
- **🌐 Seamless Sync**: Works offline and syncs progress automatically when reconnected.
- **🕒 Regional Precision**: Full support for Asia/Makassar (WITA) timezone across the system.

---

## 🚀 Quick Start

1. **Backend**:
   ```bash
   cd laravel-server && php artisan serve --host=0.0.0.0
   ```
2. **Mobile**:
   ```bash
   cd mobile && npx expo start
   ```

*See individual folder READMEs for detailed installation steps.*

---

## 📂 Repository Structure
```text
.
├── laravel-server/   # Laravel 11 Backend & Admin Dashboard
├── mobile/           # React Native Expo Participant App
└── README.md         # Main Project Documentation
```

---

## 📄 License
Internal development for high-integrity examination environments.

**QuizLOS v.1.0 • Built for Integrity**
