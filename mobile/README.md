# QuizLOS Participant App (Mobile) 📱

This branch contains the React Native (Expo) application for **QuizLOS** participants.

## 🚀 Setup Instructions

1. **Clone the branch**:
   ```bash
   git clone -b mobile https://github.com/jidai01/laravel-react-native.git
   ```

2. **Install Dependencies**:
   ```bash
   npm install
   ```

3. **Configure API URL**:
   - Update `API_URL` in `src/theme/constants.js` to match your server's IP address.

4. **Run the App**:
   ```bash
   npx expo start
   ```

## 🔒 Security Features
- **Anti-Cheat**: Automatically detects when the app enters the background and triggers disqualification.
- **Lockdown Mode**: Utilizes `expo-navigation-bar` to lock navigation on Android devices during active quizzes.
- **Secure Token**: Authentication tokens are stored using `expo-secure-store`.

## 📦 Architecture
- **Screens**: Modularized into `Auth`, `Dashboard`, `Quiz`, and `History`.
- **Offline First**: Uses `expo-sqlite` to store quiz data locally before syncing to the server.
- **Branding**: Uses the official QLOS "Q-Timer" logo and Indigo theme.

## ⚠️ Notes
- Ensure your mobile device and server are on the same network.
- For production, replace the local IP in `constants.js` with your production domain.

---
**QuizLOS Mobile v.1.0**
