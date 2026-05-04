import React, { useState } from 'react';
import { StyleSheet, Text, View, TouchableOpacity, TextInput, ScrollView, Image } from 'react-native';
import { COLORS } from '../theme/constants';

export const AuthScreen = ({ view, setView, email, setEmail, password, setPassword, name, setName, onLogin, onRegister }) => {
    const [secureText, setSecureText] = useState(true);

    return (
        <ScrollView contentContainerStyle={styles.authContainer}>
            <Image 
                source={require('../../assets/icon.png')} 
                style={styles.logo} 
                resizeMode="contain"
            />
            <Text style={styles.title}>{view === 'login' ? 'QuizLOS' : 'Sign Up'}</Text>
            <Text style={[styles.subtitle, {marginBottom: 20}]}>Version 1.0</Text>
            
            {view === 'register' && (
                <TextInput style={styles.input} placeholder="Full Name" value={name} onChangeText={setName} />
            )}
            
            <TextInput 
                style={styles.input} 
                placeholder="Email" 
                value={email} 
                onChangeText={setEmail} 
                autoCapitalize="none" 
            />

            <View style={styles.passwordWrapper}>
                <TextInput 
                    style={styles.passwordInput} 
                    placeholder="Password" 
                    value={password} 
                    onChangeText={setPassword} 
                    secureTextEntry={secureText} 
                />
                <TouchableOpacity 
                    style={styles.toggleBtn} 
                    onPress={() => setSecureText(!secureText)}
                >
                    <Text style={styles.toggleText}>{secureText ? 'Show' : 'Hide'}</Text>
                </TouchableOpacity>
            </View>
            
            <TouchableOpacity style={styles.primaryBtn} onPress={view === 'login' ? onLogin : onRegister}>
                <Text style={styles.btnText}>{view === 'login' ? 'Login' : 'Register'}</Text>
            </TouchableOpacity>
            
            <TouchableOpacity onPress={() => setView(view === 'login' ? 'register' : 'login')}>
                <Text style={styles.linkText}>{view === 'login' ? "Create account" : "Sign in"}</Text>
            </TouchableOpacity>
        </ScrollView>
    );
};

const styles = StyleSheet.create({
  authContainer: { flexGrow: 1, justifyContent: 'center', paddingVertical: 40, paddingHorizontal: 24 },
  logo: { width: 100, height: 100, alignSelf: 'center', marginBottom: 20, borderRadius: 24 },
  title: { fontSize: 28, fontWeight: '800', color: COLORS.text, marginBottom: 8, textAlign: 'center' },
  subtitle: { fontSize: 16, color: COLORS.textLight, textAlign: 'center' },
  input: { backgroundColor: '#fff', height: 56, borderRadius: 16, paddingHorizontal: 20, marginBottom: 16, fontSize: 16, borderWidth: 1, borderColor: '#E5E7EB', color: COLORS.text },
  passwordWrapper: { flexDirection: 'row', alignItems: 'center', backgroundColor: '#fff', height: 56, borderRadius: 16, paddingHorizontal: 20, marginBottom: 16, borderWidth: 1, borderColor: '#E5E7EB' },
  passwordInput: { flex: 1, height: 56, fontSize: 16, color: COLORS.text },
  toggleBtn: { padding: 8 },
  toggleText: { color: COLORS.primary, fontWeight: '700', fontSize: 12 },
  primaryBtn: { backgroundColor: COLORS.primary, width: '100%', height: 56, borderRadius: 16, justifyContent: 'center', alignItems: 'center' },
  btnText: { color: '#fff', fontSize: 16, fontWeight: '700' },
  linkText: { color: COLORS.primary, marginTop: 24, textAlign: 'center', fontWeight: '600' }
});
