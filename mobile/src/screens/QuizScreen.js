import React from 'react';
import { StyleSheet, Text, View, TouchableOpacity, ScrollView } from 'react-native';
import { COLORS } from '../theme/constants';

export const QuizScreen = ({ questions, currentIndex, userAnswers, onAnswer, onNext, onBack, onFinish, setCurrentIndex }) => {
    const currentQ = questions[currentIndex];
    if (!currentQ) return null;

    return (
        <View style={styles.quizContent}>
            <View style={styles.quizHeader}>
                <View style={styles.statusBadge}><View style={styles.pulse} /><Text style={styles.statusBadgeText}>STRICT MODE</Text></View>
                <Text style={styles.progressText}>Q {currentIndex + 1} of {questions.length}</Text>
            </View>
            <View style={styles.progressBar}><View style={[styles.progressFill, {width: `${((currentIndex + 1)/questions.length)*100}%`}]} /></View>
            <Text style={styles.questionText}>{currentQ.question}</Text>
            <ScrollView style={styles.optionsScroll}>
                {currentQ.options.map((opt, idx) => (
                    <TouchableOpacity 
                        key={idx} 
                        style={[styles.optionBtn, userAnswers[currentQ.id] === opt && styles.selectedOption]} 
                        onPress={() => onAnswer(opt)}
                    >
                        <Text style={[styles.optionText, userAnswers[currentQ.id] === opt && styles.selectedOptionText]}>{opt}</Text>
                    </TouchableOpacity>
                ))}
            </ScrollView>
            <View style={styles.navRow}>
                <TouchableOpacity 
                    onPress={() => currentIndex > 0 && setCurrentIndex(currentIndex - 1)} 
                    disabled={currentIndex === 0} 
                    style={[styles.navBtn, currentIndex === 0 && styles.disabled]}
                >
                    <Text style={styles.navBtnText}>Back</Text>
                </TouchableOpacity>
                {currentIndex < questions.length - 1 ? (
                    <TouchableOpacity onPress={onNext} style={[styles.navBtn, {backgroundColor: COLORS.secondary, borderColor: COLORS.secondary}]}>
                        <Text style={[styles.navBtnText, {color: '#fff'}]}>Next</Text>
                    </TouchableOpacity>
                ) : (
                    <TouchableOpacity onPress={onFinish} style={styles.finishBtn}>
                        <Text style={styles.finishBtnText}>Finish Quiz</Text>
                    </TouchableOpacity>
                )}
            </View>
        </View>
    );
};

const styles = StyleSheet.create({
  quizContent: { flex: 1, padding: 24 },
  quizHeader: { flexDirection: 'row', justifyContent: 'space-between', alignItems: 'center', marginBottom: 16 },
  statusBadge: { backgroundColor: '#FFF7ED', paddingVertical: 6, paddingHorizontal: 12, borderRadius: 12, flexDirection: 'row', alignItems: 'center', borderWidth: 1, borderColor: '#FFEDD5' },
  pulse: { width: 8, height: 8, borderRadius: 4, backgroundColor: COLORS.warning, marginRight: 8 },
  statusBadgeText: { color: COLORS.warning, fontSize: 11, fontWeight: '800' },
  progressText: { fontSize: 12, fontWeight: '700', color: COLORS.textLight },
  progressBar: { height: 6, backgroundColor: '#E5E7EB', borderRadius: 3, marginBottom: 32 },
  progressFill: { height: '100%', backgroundColor: COLORS.primary, borderRadius: 3 },
  questionText: { fontSize: 22, fontWeight: '800', color: COLORS.text, marginBottom: 24, lineHeight: 32 },
  optionsScroll: { flex: 1 },
  optionBtn: { backgroundColor: '#fff', padding: 20, borderRadius: 20, marginBottom: 12, borderWidth: 1, borderColor: '#F3F4F6' },
  selectedOption: { borderColor: COLORS.primary, backgroundColor: '#EEF2FF' },
  optionText: { fontSize: 16, color: COLORS.text, fontWeight: '500' },
  selectedOptionText: { color: COLORS.primary, fontWeight: '700' },
  navRow: { flexDirection: 'row', justifyContent: 'space-between', marginTop: 10, borderTopWidth: 1, borderTopColor: '#F3F4F6', paddingTop: 15 },
  navBtn: { paddingVertical: 12, paddingHorizontal: 24, borderRadius: 12, backgroundColor: '#fff', borderWidth: 1, borderColor: '#E5E7EB' },
  navBtnText: { fontWeight: '700', color: COLORS.text },
  finishBtn: { backgroundColor: COLORS.success, paddingVertical: 12, paddingHorizontal: 24, borderRadius: 12 },
  finishBtnText: { color: '#fff', fontWeight: '800' },
  disabled: { opacity: 0.3 }
});
