# QuizLOS v.1.0 🚀

**QuizLOS** is a premium, secure, and offline-first quiz platform designed for high-integrity examinations. It consists of a robust backend for administrators and a sleek, anti-cheat mobile application for participants.

## 🌟 Repository Structure

This repository uses separate branches to manage the backend and frontend codebases independently:

- **[`main`](https://github.com/jidai01/laravel-react-native/tree/main)**: Overview and project documentation.
- **[`laravel-server`](https://github.com/jidai01/laravel-react-native/tree/laravel-server)**: The administrative dashboard and API built with Laravel 11.
- **[`mobile`](https://github.com/jidai01/laravel-react-native/tree/mobile)**: The participant application built with React Native (Expo).

---

## 🛠 Tech Stack

### Backend (Laravel 11)
- **Framework**: Laravel 11 with Sanctum Authentication.
- **Real-time Monitoring**: Custom Live Activity Log with Asia/Makassar (WITA) precision.
- **Database**: MySQL with support for automated disqualification flags.
- **UI**: Premium Indigo theme with DataTables integration.

### Mobile (React Native Expo)
- **Framework**: Expo (SDK 51+) with modular architecture.
- **Security**: background state detection (Anti-Cheat), `expo-navigation-bar` lock.
- **Storage**: Offline-first synchronization with SQLite and SecureStore.
- **Styling**: Consistent "QLOS Indigo" branding.

---

## 🔐 Key Features

1. **Automated Disqualification**: Real-time detection of app backgrounding or unauthorized exits.
2. **Activity Monitor**: Admins can track exactly when a student selects or changes an answer.
3. **Offline Mode**: Participants can continue the quiz even if the internet connection is unstable; data syncs automatically.
4. **Brute-Force Protection**: Server-side rate limiting on login and registration.
5. **Secure Sync**: All data transmissions are protected by Sanctum tokens and validated on the server.

---

## 🚀 Getting Started

To get started with each part of the project, please switch to the respective branch and follow the instructions in the `README.md` provided there:

- For Admin Setup: `git checkout laravel-server`
- For Mobile Setup: `git checkout mobile`

---

## 📄 License
This project is for internal development and examination purposes.

**QuizLOS v.1.0 • All Systems Operational**
