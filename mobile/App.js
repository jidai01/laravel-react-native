import React, { useState, useEffect, Suspense, useRef } from 'react';
import { StyleSheet, View, ActivityIndicator, Alert, StatusBar, Platform, KeyboardAvoidingView, BackHandler, AppState, Text, TouchableOpacity } from 'react-native';
import { SafeAreaProvider, SafeAreaView } from 'react-native-safe-area-context';
import { SQLiteProvider, useSQLiteContext } from 'expo-sqlite';
import * as SecureStore from 'expo-secure-store';
import { useKeepAwake } from 'expo-keep-awake';
import * as NavigationBar from 'expo-navigation-bar';
import axios from 'axios';

// Import Custom Modules
import { COLORS, API_URL } from './src/theme/constants';
import { shuffleArray } from './src/utils/helpers';
import { initDB, saveQuizzesToLocal, getQuizzesFromLocal, clearQuizzes } from './database';

// Import Screens & Components
import { LockModal, DisqualifiedModal } from './src/components/Modals';
import { AuthScreen } from './src/screens/AuthScreen';
import { DashboardScreen } from './src/screens/DashboardScreen';
import { QuizScreen } from './src/screens/QuizScreen';
import { HistoryScreen } from './src/screens/HistoryScreen';

function QuizApp() {
  const db = useSQLiteContext();
  useKeepAwake(); 

  const [loading, setLoading] = useState(false);
  const [view, setView] = useState('login'); 
  const [auth, setAuth] = useState({ token: null, user: null });
  
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [name, setName] = useState('');

  const [questions, setQuestions] = useState([]);
  const [currentIndex, setCurrentIndex] = useState(0);
  const [userAnswers, setUserAnswers] = useState({});
  const [logs, setLogs] = useState([]);
  const [userHistory, setUserHistory] = useState([]);
  const [expandedHistoryId, setExpandedHistoryId] = useState(null);
  
  const [showLockModal, setShowLockModal] = useState(false);
  const [showDisqualifiedModal, setShowDisqualifiedModal] = useState(false);

  const viewRef = useRef(view);
  const userAnswersRef = useRef(userAnswers);
  const questionsRef = useRef(questions);
  const logsRef = useRef(logs);
  const authRef = useRef(auth);
  const isSyncingRef = useRef(false);

  useEffect(() => {
    viewRef.current = view;
    userAnswersRef.current = userAnswers;
    questionsRef.current = questions;
    logsRef.current = logs;
    authRef.current = auth;
  }, [view, userAnswers, questions, logs, auth]);

  // --- Strict Mode Logic ---
  useEffect(() => {
    const lockSystemUI = async () => {
      if (Platform.OS === 'android') {
        try {
            if (view === 'quiz') {
              await NavigationBar.setVisibilityAsync('hidden');
              await NavigationBar.setBehaviorAsync('sticky-immersive');
            } else {
              await NavigationBar.setVisibilityAsync('visible');
              await NavigationBar.setBehaviorAsync('overlay-pan');
            }
        } catch (e) { console.log("Nav bar warning"); }
      }
    };
    lockSystemUI();
  }, [view]);

  useEffect(() => {
    const backAction = () => {
      if (view === 'quiz') {
        Alert.alert("LOCKED", "Finish the quiz to exit.");
        return true; 
      }
      return false;
    };
    const backHandler = BackHandler.addEventListener("hardwareBackPress", backAction);
    return () => backHandler.remove();
  }, [view]);

  useEffect(() => {
    const subscription = AppState.addEventListener("change", nextAppState => {
      if (viewRef.current === 'quiz' && !isSyncingRef.current && nextAppState.match(/inactive|background/)) {
        autoSubmitDisqualified();
      }
    });
    return () => subscription.remove();
  }, []);

  const autoSubmitDisqualified = async () => {
    if (isSyncingRef.current) return;
    isSyncingRef.current = true;

    const currentQuestions = questionsRef.current;
    const currentAnswers = userAnswersRef.current;
    const currentLogs = logsRef.current;
    const currentToken = authRef.current.token;

    setView('start');
    resetQuizState();
    setShowDisqualifiedModal(true);

    if (!currentToken || currentQuestions.length === 0) {
        isSyncingRef.current = false;
        return;
    }

    const score = currentQuestions.reduce((acc, q) => currentAnswers[q.id] === q.correct_answer ? acc + 1 : acc, 0);
    const deviceInfo = `DISQUALIFIED - ${Platform.OS}`;

    try {
        const res = await axios.post(`${API_URL}/results`, 
          { 
            score, 
            logs: [...currentLogs, { action: 'disqualified', timestamp: new Date().toISOString() }], 
            answers: currentAnswers, 
            device_info: deviceInfo, 
            is_disqualified: 1 
          }, 
          { headers: { Authorization: `Bearer ${currentToken}` } }
        );
        
        await clearQuizzes(db);
        if (res.data.user) {
            setAuth(prev => ({ ...prev, user: res.data.user }));
        }
    } catch (e) {
        if (e.response?.status === 401) handleLogout();
    } finally {
        isSyncingRef.current = false;
    }
  };

  // --- Auth & Data ---
  useEffect(() => {
    async function loadAuth() {
        const token = await SecureStore.getItemAsync('userToken');
        if (token) {
            try {
                const res = await axios.get(`${API_URL}/user`, { headers: { Authorization: `Bearer ${token}` } });
                setAuth({ token, user: res.data });
                if (res.data.is_disqualified) setShowDisqualifiedModal(true);
                setView('start');
            } catch (e) { await SecureStore.deleteItemAsync('userToken'); }
        }
    }
    loadAuth();
  }, []);

  const handleLogin = async () => {
    if (!email || !password) return Alert.alert('Error', 'Fields required');
    setLoading(true);
    try {
      const res = await axios.post(`${API_URL}/login`, { email, password });
      const { access_token, user } = res.data;
      await SecureStore.setItemAsync('userToken', access_token);
      setAuth({ token: access_token, user });
      if (user.is_disqualified) setShowDisqualifiedModal(true);
      setView('start');
    } catch (e) { Alert.alert('Login Failed', 'Invalid credentials'); } 
    finally { setLoading(false); }
  };

  const handleRegister = async () => {
    if (!name || !email || !password) return Alert.alert('Error', 'Fields required');
    setLoading(true);
    try {
      const res = await axios.post(`${API_URL}/register`, { name, email, password });
      const { access_token, user } = res.data;
      await SecureStore.setItemAsync('userToken', access_token);
      setAuth({ token: access_token, user });
      setView('start');
    } catch (e) { Alert.alert('Registration Failed', 'Check your data'); } 
    finally { setLoading(false); }
  };

  const handleLogout = async () => {
    await SecureStore.deleteItemAsync('userToken');
    setAuth({ token: null, user: null });
    setView('login');
  };

  const startQuizFlow = async () => {
      setLoading(true);
      try {
          const res = await axios.get(`${API_URL}/user`, { headers: { Authorization: `Bearer ${auth.token}` } });
          setAuth(prev => ({ ...prev, user: res.data }));
          setLoading(false);
          if (res.data.is_disqualified) {
              setShowDisqualifiedModal(true);
              return;
          }
      } catch (e) { 
          setLoading(false);
          if (auth.user?.is_disqualified) {
              setShowDisqualifiedModal(true);
              return;
          }
      }
      setShowLockModal(true);
  };

  const confirmStartQuiz = async () => {
    setShowLockModal(false);
    setLoading(true);
    try {
      const response = await axios.get(`${API_URL}/quizzes`, { timeout: 5000 });
      const remoteData = response.data.map(q => ({
        ...q,
        options: typeof q.options === 'string' ? JSON.parse(q.options) : q.options,
        shuffle_options: !!q.shuffle_options 
      }));
      await saveQuizzesToLocal(db, remoteData);
    } catch (error) { console.log('Using local'); }

    const localData = await getQuizzesFromLocal(db);
    if (localData.length > 0) {
      const randomized = shuffleArray(localData).map(q => ({
          ...q,
          options: q.shuffle_options ? shuffleArray(q.options) : q.options
      }));
      setQuestions(randomized);
      setView('quiz');
      setCurrentIndex(0);
      setUserAnswers({});
    } else { Alert.alert('Error', 'Quiz unavailable'); }
    setLoading(false);
  };

  const handleAnswer = (selectedOption) => {
    const currentQ = questions[currentIndex];
    setUserAnswers(prev => ({ ...prev, [currentQ.id]: selectedOption }));
    setLogs(prev => [...prev, {
      question_id: currentQ.id,
      action: 'select',
      selected_option: selectedOption,
      timestamp: new Date().toISOString()
    }]);
  };

  const validateAndFinish = () => {
    const incomplete = questions
        .map((q, index) => userAnswers[q.id] ? null : index + 1)
        .filter(val => val !== null);

    if (incomplete.length > 0) {
      return Alert.alert("Incomplete", `Please answer questions: ${incomplete.join(', ')}`);
    }
    Alert.alert("Confirm", "Ready to submit?", [
      { text: "No", style: "cancel" },
      { text: "Yes, Submit", onPress: () => setView('result') }
    ]);
  };

  const syncResults = async () => {
    if (isSyncingRef.current) return;
    isSyncingRef.current = true;
    setLoading(true);
    const score = questions.reduce((acc, q) => userAnswers[q.id] === q.correct_answer ? acc + 1 : acc, 0);
    const deviceInfo = `${Platform.OS} ${Platform.Version}`;
    
    try {
      await axios.post(`${API_URL}/results`, { score, logs, answers: userAnswers, device_info: deviceInfo }, { headers: { Authorization: `Bearer ${auth.token}` } });
      await clearQuizzes(db);
      Alert.alert('Success', 'Quiz synced!');
      setView('start');
      resetQuizState();
    } catch (e) { Alert.alert('Error', 'Sync failed'); } 
    finally { setLoading(false); isSyncingRef.current = false; }
  };

  const fetchHistory = async () => {
    setLoading(true);
    try {
        const res = await axios.get(`${API_URL}/history`, { headers: { Authorization: `Bearer ${auth.token}` } });
        setUserHistory(res.data);
        setView('history');
    } catch (e) { Alert.alert('Error', 'Failed load'); }
    finally { setLoading(false); }
  };

  const resetQuizState = () => {
    setCurrentIndex(0);
    setUserAnswers({});
    setLogs([]);
    setQuestions([]);
  };

  if (loading) return (
    <View style={styles.centerContainer}>
        <ActivityIndicator size="large" color={COLORS.primary} />
    </View>
  );

  return (
    <SafeAreaProvider>
    <SafeAreaView style={styles.safeArea}>
      <StatusBar hidden={view === 'quiz'} barStyle="dark-content" />
      <KeyboardAvoidingView behavior={Platform.OS === 'ios' ? 'padding' : 'height'} style={{ flex: 1 }}>
        <View style={styles.container}>
            
            <LockModal visible={showLockModal} onCancel={() => setShowLockModal(false)} onConfirm={confirmStartQuiz} />
            <DisqualifiedModal visible={showDisqualifiedModal} onClose={() => setShowDisqualifiedModal(false)} />

            {(view === 'login' || view === 'register') && (
                <AuthScreen 
                  view={view} setView={setView} 
                  email={email} setEmail={setEmail} 
                  password={password} setPassword={setPassword} 
                  name={name} setName={setName} 
                  onLogin={handleLogin} onRegister={handleRegister} 
                />
            )}

            {view === 'start' && (
                <DashboardScreen 
                    user={auth.user} 
                    onStartQuiz={startQuizFlow} 
                    onFetchHistory={fetchHistory} 
                    onLogout={handleLogout} 
                />
            )}

            {view === 'quiz' && (
                <QuizScreen 
                    questions={questions} 
                    currentIndex={currentIndex} 
                    userAnswers={userAnswers} 
                    setCurrentIndex={setCurrentIndex}
                    onAnswer={handleAnswer} 
                    onNext={() => currentIndex < questions.length - 1 && setCurrentIndex(currentIndex + 1)} 
                    onFinish={validateAndFinish} 
                />
            )}

            {view === 'result' && (
                <View style={styles.centerContent}>
                    <View style={styles.successIcon}><Text style={styles.successIconText}>✓</Text></View>
                    <Text style={styles.completeTitle}>Completed!</Text>
                    <TouchableOpacity style={[styles.primaryBtn, {backgroundColor: COLORS.success}]} onPress={syncResults}>
                        <Text style={styles.btnText}>Sync & Finish</Text>
                    </TouchableOpacity>
                </View>
            )}

            {view === 'history' && (
                <HistoryScreen 
                    history={userHistory} 
                    expandedId={expandedHistoryId} 
                    setExpandedId={setExpandedHistoryId} 
                    onBack={() => setView('start')} 
                />
            )}
        </View>
      </KeyboardAvoidingView>
    </SafeAreaView>
    </SafeAreaProvider>
  );
}

export default function App() {
  return (
    <Suspense fallback={<ActivityIndicator />}>
        <SQLiteProvider databaseName="quiz.db" onInit={initDB}>
            <QuizApp />
        </SQLiteProvider>
    </Suspense>
  );
}

const styles = StyleSheet.create({
  safeArea: { flex: 1, backgroundColor: COLORS.bg },
  container: { flex: 1 },
  centerContainer: { flex: 1, justifyContent: 'center', alignItems: 'center', backgroundColor: COLORS.bg },
  centerContent: { flex: 1, justifyContent: 'center', alignItems: 'center', padding: 24 },
  completeTitle: { fontSize: 28, fontWeight: '800', color: COLORS.text, marginBottom: 8 },
  primaryBtn: { width: '100%', height: 56, borderRadius: 16, justifyContent: 'center', alignItems: 'center' },
  btnText: { color: '#fff', fontSize: 16, fontWeight: '700' },
  successIcon: { width: 70, height: 70, backgroundColor: '#ECFDF5', borderRadius: 35, justifyContent: 'center', alignItems: 'center', marginBottom: 24 },
  successIconText: { color: COLORS.success, fontSize: 40, fontWeight: '700' }
});
