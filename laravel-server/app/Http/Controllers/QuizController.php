<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizResult;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    // API for Mobile
    public function getQuizzes()
    {
        return response()->json(Quiz::all());
    }

    public function submitResult(Request $request)
    {
        $request->validate([
            'score' => 'required|integer|min:0|max:100',
            'logs' => 'nullable|array',
            'answers' => 'nullable|array',
            'device_info' => 'nullable|string|max:255',
            'is_disqualified' => 'nullable'
        ]);

        $user = Auth::user(); // Get user from Sanctum token

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // STRICT CHECK: If flag is present or device_info contains DISQUALIFIED
        if ($request->is_disqualified == true || $request->is_disqualified == '1' || str_contains($request->device_info, 'DISQUALIFIED')) {
            $user->is_disqualified = true;
            $user->save();
        }

        QuizResult::create([
            'user_id' => $user->id,
            'user_name' => strip_tags($user->name),
            'score' => $request->score,
            'logs' => $request->logs,
            'answers' => $request->answers,
            'ip_address' => $request->ip(),
            'device_info' => strip_tags($request->device_info ?? $request->header('User-Agent')),
        ]);

        return response()->json([
            'message' => 'Result processed securely',
            'user' => $user->fresh()
        ], 201);
    }

    public function getUserHistory(Request $request)
    {
        $results = $request->user()->results()->latest()->limit(50)->get();
        return response()->json($results);
    }

    // Web for Admin
    private function checkAdmin()
    {
        if (!Auth::check()) return false;
        $user = Auth::user();
        return $user->is_admin === true || $user->is_admin === 1;
    }

    public function dashboard()
    {
        if (!$this->checkAdmin()) return redirect('/login');
        $results = QuizResult::latest()->get();
        return view('dashboard', compact('results'));
    }

    // Quiz Management
    public function indexQuizzes(Request $request)
    {
        if (!$this->checkAdmin()) return redirect('/login');
        
        $quizzes = Quiz::all();
        $editingQuiz = null;
        
        if ($request->has('edit')) {
            $editingQuiz = Quiz::find($request->edit);
        }

        return view('quizzes.index', compact('quizzes', 'editingQuiz'));
    }

    public function storeQuiz(Request $request)
    {
        if (!$this->checkAdmin()) return response()->json(['error' => 'Unauthorized'], 401);
        
        $request->validate([
            'question' => 'required|string',
            'options' => 'required|array|min:2|max:6',
            'options.*' => 'required|string',
            'correct_answer' => 'required|string',
        ]);

        if (!in_array($request->correct_answer, $request->options)) {
            return redirect()->back()->withInput()->with('error', 'Correct answer must be one of the options.');
        }
        
        Quiz::create([
            'question' => $request->question,
            'options' => $request->options,
            'correct_answer' => $request->correct_answer,
            'shuffle_options' => $request->has('shuffle_options'),
        ]);
        
        return redirect('/admin/quizzes')->with('success', 'Quiz added!');
    }

    public function updateQuiz(Request $request, $id)
    {
        if (!$this->checkAdmin()) return redirect('/login');

        $request->validate([
            'question' => 'required|string',
            'options' => 'required|array|min:2|max:6',
            'options.*' => 'required|string',
            'correct_answer' => 'required|string',
        ]);

        if (!in_array($request->correct_answer, $request->options)) {
            return redirect()->back()->withInput()->with('error', 'Correct answer must be one of the options.');
        }

        $quiz = Quiz::findOrFail($id);
        $quiz->update([
            'question' => $request->question,
            'options' => $request->options,
            'correct_answer' => $request->correct_answer,
            'shuffle_options' => $request->has('shuffle_options'),
        ]);

        return redirect('/admin/quizzes')->with('success', 'Quiz updated!');
    }

    public function deleteQuiz($id)
    {
        if (!$this->checkAdmin()) return redirect('/login');
        Quiz::destroy($id);
        return redirect()->back()->with('success', 'Quiz deleted!');
    }

    // Participants Management
    public function indexParticipants()
    {
        if (!$this->checkAdmin()) return redirect('/login');
        $participants = User::where('is_admin', false)->get();
        return view('participants.index', compact('participants'));
    }

    public function resetDisqualification($id)
    {
        if (!$this->checkAdmin()) return redirect('/login');
        $user = User::findOrFail($id);
        $user->is_disqualified = false;
        $user->save();
        return redirect()->back()->with('success', 'Participant is now allowed to take quizzes again!');
    }

    public function deleteParticipant($id)
    {
        if (!$this->checkAdmin()) return redirect('/login');
        $user = User::findOrFail($id);
        
        // Delete their results first
        QuizResult::where('user_id', $user->id)->delete();
        $user->delete();
        
        return redirect()->back()->with('success', 'Participant and their results have been deleted.');
    }

    public function deleteResult($id)
    {
        if (!$this->checkAdmin()) return redirect('/login');
        QuizResult::destroy($id);
        return redirect()->back()->with('success', 'Quiz entry deleted!');
    }
}
