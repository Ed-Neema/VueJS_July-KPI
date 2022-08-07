<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Submission;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $statusOptions = Submission::getStatusOptions();
        $submissions = Submission::with('company')
        ->with('source')
        ->with('form')
        ->where('company_id', $request->user()->company->id)
        ->orderBy('id', 'desc')
        ->get();

        return Inertia::render('Dashboard', [
            'submissions' => $submissions->take(10),
            'statusOptions' => $statusOptions,
        ]);
    }
}
