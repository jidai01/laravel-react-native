import React from 'react';
import { StyleSheet, Text, View, TouchableOpacity, Image } from 'react-native';
import { COLORS } from '../theme/constants';

export const DashboardScreen = ({ user, onStartQuiz, onFetchHistory, onLogout }) => (
    <View style={styles.content}>
        <Image 
            source={require('../../assets/icon.png')} 
            style={styles.headerLogo} 
            resizeMode="contain"
        />
        <View style={styles.avatarBox}><Text style={styles.avatarText}>{user?.name?.charAt(0)}</Text></View>
        <Text style={styles.welcomeText}>Hi, {user?.name}!</Text>
        
        <TouchableOpacity 
            style={[styles.menuBtn, user?.is_disqualified && {backgroundColor: '#F3F4F6', opacity: 0.7}]} 
            onPress={onStartQuiz}
        >
            <Text style={[styles.menuBtnText, user?.is_disqualified && {color: '#9CA3AF'}]}>Take New Quiz</Text>
            <Text style={[styles.menuBtnDesc, user?.is_disqualified && {color: '#9CA3AF'}]}>
                {user?.is_disqualified ? 'Access Blocked' : 'Start challenge'}
            </Text>
        </TouchableOpacity>

        <TouchableOpacity style={[styles.menuBtn, {backgroundColor: '#EEF2FF'}]} onPress={onFetchHistory}>
            <Text style={[styles.menuBtnText, {color: COLORS.primary}]}>My Results</Text>
        </TouchableOpacity>

        <TouchableOpacity style={styles.logoutBtn} onPress={onLogout}>
            <Text style={styles.logoutText}>Log Out</Text>
        </TouchableOpacity>
        <Text style={{color: '#9CA3AF', fontSize: 10, marginTop: 30}}>QuizLOS v.1.0</Text>
    </View>
);

const styles = StyleSheet.create({
  content: { flex: 1, justifyContent: 'center', alignItems: 'center', paddingHorizontal: 24 },
  headerLogo: { width: 60, height: 60, marginBottom: 20, borderRadius: 15 },
  avatarBox: { width: 80, height: 80, backgroundColor: COLORS.secondary, borderRadius: 30, justifyContent: 'center', alignItems: 'center', marginBottom: 20 },
  avatarText: { color: '#fff', fontSize: 32, fontWeight: '700' },
  welcomeText: { fontSize: 24, fontWeight: '800', color: COLORS.text, marginBottom: 4 },
  menuBtn: { width: '100%', backgroundColor: COLORS.primary, padding: 24, borderRadius: 24, marginBottom: 16 },
  menuBtnText: { color: '#fff', fontSize: 18, fontWeight: '700', marginBottom: 4 },
  menuBtnDesc: { color: 'rgba(255,255,255,0.7)', fontSize: 14 },
  logoutBtn: { marginTop: 20 },
  logoutText: { color: COLORS.danger, fontWeight: '700' }
});
