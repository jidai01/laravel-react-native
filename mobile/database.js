import * as SQLite from 'expo-sqlite';

// Open the database
const dbName = 'quiz.db';

export const initDB = async (db) => {
    try {
        await db.execAsync(`
            PRAGMA journal_mode = WAL;
            CREATE TABLE IF NOT EXISTS local_quizzes (
                id INTEGER PRIMARY KEY NOT NULL,
                question TEXT NOT NULL,
                options TEXT NOT NULL,
                correct_answer TEXT NOT NULL
            );
        `);
        
        // SAFE MIGRATION: Add shuffle_options if it doesn't exist
        const columns = await db.getAllAsync("PRAGMA table_info(local_quizzes)");
        const hasShuffle = columns.some(c => c.name === 'shuffle_options');
        if (!hasShuffle) {
            await db.execAsync("ALTER TABLE local_quizzes ADD COLUMN shuffle_options INTEGER DEFAULT 1");
            console.log('Migrated: Added shuffle_options column');
        }

        console.log('Local DB initialized');
    } catch (error) {
        console.error('DB Init Error:', error);
    }
};

export const saveQuizzesToLocal = async (db, quizzes) => {
    try {
        await db.runAsync('DELETE FROM local_quizzes');
        for (const quiz of quizzes) {
            await db.runAsync(
                'INSERT INTO local_quizzes (id, question, options, correct_answer, shuffle_options) VALUES (?, ?, ?, ?, ?)',
                [
                    quiz.id, 
                    quiz.question, 
                    JSON.stringify(quiz.options), 
                    quiz.correct_answer,
                    quiz.shuffle_options ? 1 : 0
                ]
            );
        }
        console.log('Quizzes saved to local SQLite');
    } catch (error) {
        console.error('Save Quizzes Error:', error);
    }
};

export const getQuizzesFromLocal = async (db) => {
    try {
        const allRows = await db.getAllAsync('SELECT * FROM local_quizzes');
        return allRows.map(row => ({
            ...row,
            options: JSON.parse(row.options),
            shuffle_options: !!row.shuffle_options
        }));
    } catch (error) {
        console.error('Get Quizzes Error:', error);
        return [];
    }
};

export const clearQuizzes = async (db) => {
    try {
        await db.runAsync('DELETE FROM local_quizzes');
        console.log('Local SQLite cleared');
    } catch (error) {
        console.error('Clear DB Error:', error);
    }
};
