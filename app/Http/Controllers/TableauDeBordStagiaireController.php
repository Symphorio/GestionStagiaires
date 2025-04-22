<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tache;

class TableauDeBordStagiaireController extends Controller
{
    public function dashboard()
    {
        $stagiaireId = auth('stagiaire')->id();
        
        $tasksQuery = Tache::where('stagiaire_id', $stagiaireId);
        
        $completedTasks = (clone $tasksQuery)->where('status', 'completed')->count();
        $pendingTasks = (clone $tasksQuery)->where('status', 'pending')->count();
        $lateTasks = (clone $tasksQuery)
                    ->where('status', 'pending')
                    ->where('deadline', '<', now())
                    ->count();
        
        $totalTasks = $completedTasks + $pendingTasks + $lateTasks;
        
        $recentTasks = (clone $tasksQuery)
                     ->orderBy('created_at', 'desc')
                     ->take(3)
                     ->get();

        return view('stagiaire.dashboard', compact(
            'completedTasks',
            'pendingTasks',
            'lateTasks',
            'totalTasks',
            'recentTasks'
        ));
    }

    public function taches()
    {
        $stagiaireId = auth('stagiaire')->id();
        $taches = Tache::where('stagiaire_id', $stagiaireId)
                     ->orderBy('created_at', 'desc')
                     ->get();

        return view('stagiaire.taches', compact('taches'));
    }

    public function updateTaskStatus(Request $request, $taskId)
    {
        $task = Tache::findOrFail($taskId);
        $task->status = $request->input('status');
        $task->save();
        
        return back()->with('success', 'Statut de la tâche mis à jour');
    }

    public function rapports()
{
    return view('stagiaire.rapports', [
        'hasReports' => false // Vous pouvez remplacer par une vérification réelle
    ]);
}public function uploadRapport(Request $request)
{
    $request->validate([
        'report_file' => 'required|file|mimes:pdf,doc,docx|max:10240',
        'comments' => 'nullable|string|max:500'
    ]);

    // Traitement du fichier
    $path = $request->file('report_file')->store('rapports');

    // Enregistrement en base de données (à adapter selon votre modèle)
    Rapport::create([
        'stagiaire_id' => auth('stagiaire')->id(),
        'file_path' => $path,
        'comments' => $request->comments,
        'submitted_at' => now()
    ]);

    return redirect()->route('stagiaire.rapports')
                    ->with('success', 'Rapport soumis avec succès');
}
}