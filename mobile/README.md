# QuizLOS Participant App (Mobile) 📱

This is the React Native (Expo) application for **QuizLOS** participants.

## 🚀 Setup Instructions

1. **Install Dependencies**:
   ```bash
   cd mobile
   npm install
   ```

2. **Configure Environment Variables**:
   Copy the example environment file and update it with your server's IP address:
   ```bash
   cp .env.example .env
   ```
   Open `.env` and set your `EXPO_PUBLIC_API_URL`.
   *Note: Ensure your mobile device and server are on the same network.*

3. **Run the App**:
   ```bash
   npx expo start
   ```

## 🔒 Security Features
- **🛡️ Anti-Cheat Enforcement**: Automatically detects when the app enters the background and triggers disqualification.
- **🚫 Lockdown Mode**: Utilizes `expo-navigation-bar` to lock navigation on Android devices during active quizzes.
- **🔑 Secure Storage**: Authentication tokens are stored using `expo-secure-store`.
- **🕵️ Activity Logs**: Sends real-time activity (selecting/changing answers) to the admin dashboard.

## 📦 Project Highlights
- **Branding**: Uses the official QLOS "Q-Timer" logo and unified Indigo theme.
- **Offline First**: Uses `expo-sqlite` to store quiz progress locally before syncing.
- **Modular Design**: Screens are separated into `Auth`, `Dashboard`, `Quiz`, and `History`.

---
**QuizLOS Mobile v.1.0 • Built for Integrity**
