import React from 'react';
import { Modal, View, Text, TouchableOpacity, StyleSheet } from 'react-native';
import { COLORS } from '../theme/constants';

export const LockModal = ({ visible, onCancel, onConfirm }) => (
    <Modal visible={visible} transparent animationType="fade">
        <View style={styles.modalOverlay}>
            <View style={styles.modalContent}>
                <Text style={styles.modalTitle}>Strict Mode Required</Text>
                <Text style={styles.modalBody}>
                    Ujian berada dalam Mode Ketat. Silakan aktifkan fitur "Sematkan Aplikasi" sekarang.{"\n\n"}
                    Keluar aplikasi = GUGUR otomatis.
                </Text>
                <View style={styles.modalActions}>
                    <TouchableOpacity style={styles.modalBtnCancel} onPress={onCancel}>
                        <Text style={styles.modalBtnCancelText}>Cancel</Text>
                    </TouchableOpacity>
                    <TouchableOpacity style={styles.modalBtnConfirm} onPress={onConfirm}>
                        <Text style={styles.modalBtnConfirmText}>Understand & Start</Text>
                    </TouchableOpacity>
                </View>
            </View>
        </View>
    </Modal>
);

export const DisqualifiedModal = ({ visible, onClose }) => (
    <Modal visible={visible} transparent animationType="fade">
        <View style={styles.modalOverlay}>
            <View style={styles.modalContent}>
                <View style={styles.errorIcon}><Text style={styles.errorIconText}>!</Text></View>
                <Text style={[styles.modalTitle, {textAlign: 'center'}]}>ACCESS DENIED</Text>
                <Text style={[styles.modalBody, {textAlign: 'center'}]}>
                    Anda telah **DIDISKUALIFIKASI** karena meninggalkan aplikasi.{"\n\n"}
                    Akses diblokir sampai dipulihkan Admin.
                </Text>
                <TouchableOpacity style={[styles.primaryBtn, {backgroundColor: COLORS.danger}]} onPress={onClose}>
                    <Text style={styles.btnText}>OK</Text>
                </TouchableOpacity>
            </View>
        </View>
    </Modal>
);

const styles = StyleSheet.create({
  modalOverlay: { flex: 1, backgroundColor: 'rgba(0,0,0,0.7)', justifyContent: 'center', alignItems: 'center', padding: 24 },
  modalContent: { backgroundColor: '#fff', borderRadius: 24, padding: 32, width: '100%', elevation: 10 },
  modalTitle: { fontSize: 22, fontWeight: '800', color: COLORS.text, marginBottom: 12 },
  modalBody: { fontSize: 16, color: COLORS.textLight, lineHeight: 24, marginBottom: 32 },
  modalActions: { flexDirection: 'row', gap: 12 },
  modalBtnCancel: { flex: 1, height: 56, borderRadius: 16, justifyContent: 'center', alignItems: 'center', backgroundColor: '#F3F4F6' },
  modalBtnCancelText: { fontWeight: '700', color: COLORS.textLight },
  modalBtnConfirm: { flex: 2, height: 56, borderRadius: 16, justifyContent: 'center', alignItems: 'center', backgroundColor: COLORS.primary },
  modalBtnConfirmText: { fontWeight: '700', color: '#fff' },
  errorIcon: { width: 70, height: 70, backgroundColor: '#FEE2E2', borderRadius: 35, justifyContent: 'center', alignItems: 'center', marginBottom: 20, alignSelf: 'center' },
  errorIconText: { color: COLORS.danger, fontSize: 40, fontWeight: '800' },
  primaryBtn: { height: 56, borderRadius: 16, justifyContent: 'center', alignItems: 'center' },
  btnText: { color: '#fff', fontSize: 16, fontWeight: '700' }
});
