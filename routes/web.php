<?php

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;

use App\Models\Job;


Route::get('/', function () {
    return view('home');
});

// Index
Route::get('/jobs', function () {
    $jobs = Job::with('employer')->latest()->simplePaginate(6);

    return view('jobs.index', [
        'jobs' => $jobs
    ]);
});

// Create
Route::get('/jobs/create', function () {
    return view('jobs.create');
});

// Show
Route::get('/jobs/{id}', function ($id) {

    $job = Job::find($id);

    return view('jobs.show', ['job' => $job]);
});

// Store
Route::post('/jobs', function () {
    // validation...
    request()->validate([
        'title' => ['required', 'min:3'],
        'salary' => ['required'],

    ]);

    Job::create([
        'title' => request('title'),
        'salary' => request('salary'),
        'employer_id' => 1,
    ]);

    return redirect('/jobs');
});

Route::get('/jobs/{id}/edit', function ($id) {
    $job = Job::find($id);

    return view('jobs.edit', ['job' => $job]);
});

// Update
Route::patch('/jobs/{id}', function ($id) {
    // validate
    request()->validate([
        'title' => ['required', 'min:3'],
        'salary' => ['required'],
    ]);

    // authorize (On hold....)

    $job = Job::findOrFail($id);

    $job->update([
        'title' => request('title'),
        'salary' => request('salary'),
    ]);

    return redirect('/jobs/'. $job->id);
});

// Destroy
Route::delete('/jobs/{id}', function ($id) {
    //authorize (On hold)

    $job = Job::findOrFail($id)->delete();

    return redirect('/jobs');
});

Route::get('/contact', function () {
    return view('contact');
});
