import React from 'react';
import { StyleSheet, Text, View, TouchableOpacity, FlatList } from 'react-native';
import { COLORS } from '../theme/constants';

export const HistoryScreen = ({ history, expandedId, setExpandedId, onBack }) => (
    <View style={styles.content}>
        <Text style={styles.title}>History</Text>
        <FlatList
            data={history}
            keyExtractor={item => item.id.toString()}
            style={{width: '100%'}}
            renderItem={({item}) => (
                <View style={styles.historyCard}>
                    <TouchableOpacity onPress={() => setExpandedId(expandedId === item.id ? null : item.id)} style={styles.historyHeader}>
                        <View>
                            <Text style={styles.historyScore}>Score: {item.score}</Text>
                            <Text style={styles.historyDate}>{new Date(item.created_at).toLocaleDateString()}</Text>
                        </View>
                    </TouchableOpacity>
                    {expandedId === item.id && item.answers && (
                        <View style={styles.historyDetails}>
                            {Object.entries(item.answers).map(([qId, ans]) => (
                                <View key={qId} style={styles.detailItem}>
                                    <Text style={styles.detailQ}>Q{qId}:</Text>
                                    <Text style={styles.detailA}>{ans}</Text>
                                </View>
                            ))}
                        </View>
                    )}
                </View>
            )}
        />
        <TouchableOpacity style={[styles.primaryBtn, {marginTop: 10, width: '100%'}]} onPress={onBack}>
            <Text style={styles.btnText}>Back</Text>
        </TouchableOpacity>
    </View>
);

const styles = StyleSheet.create({
  content: { flex: 1, padding: 24, alignItems: 'center' },
  title: { fontSize: 28, fontWeight: '800', color: COLORS.text, marginBottom: 20 },
  historyCard: { backgroundColor: '#fff', padding: 20, borderRadius: 24, marginBottom: 12, borderWidth: 1, borderColor: '#F3F4F6', width: '100%' },
  historyHeader: { flexDirection: 'row', justifyContent: 'space-between', alignItems: 'center' },
  historyScore: { fontSize: 18, fontWeight: '800', color: COLORS.text },
  historyDate: { fontSize: 13, color: COLORS.textLight, marginTop: 2 },
  historyDetails: { marginTop: 16, paddingTop: 16, borderTopWidth: 1, borderTopColor: '#F3F4F6' },
  detailItem: { flexDirection: 'row', marginBottom: 8 },
  detailQ: { width: 40, fontWeight: '700', color: COLORS.textLight },
  detailA: { flex: 1, color: COLORS.text, fontWeight: '600' },
  primaryBtn: { backgroundColor: COLORS.primary, height: 56, borderRadius: 16, justifyContent: 'center', alignItems: 'center' },
  btnText: { color: '#fff', fontSize: 16, fontWeight: '700' }
});
