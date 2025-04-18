<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tache; // N'oublie pas d'importer le modèle

class TableauDeBordStagiaireController extends Controller
{
    public function dashboard()
    {
        $stagiaireId = auth('stagiaire')->id();
        
        // Requête de base commune
        $tasksQuery = Tache::where('stagiaire_id', $stagiaireId);
        
        // Calcul des différentes statistiques
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

    public function updateTaskStatus(Request $request, $taskId)
    {
        // Implémentation de la mise à jour
        $task = Tache::findOrFail($taskId);
        $task->status = $request->input('status');
        $task->save();
        
        return back()->with('success', 'Statut de la tâche mis à jour');
    }
}