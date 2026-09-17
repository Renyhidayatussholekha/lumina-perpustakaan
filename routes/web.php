<?php

use App\Http\Controllers\LuminaController;
use Illuminate\Support\Facades\Route;

// Halaman Utama Lumina (Netflix-Style Streaming Library)
Route::get('/', [LuminaController::class, 'index'])->name('lumina.index');

// Halaman Detail Buku & Klub Diskusi Virtual
Route::get('/buku/{id}', [LuminaController::class, 'showBook'])->name('lumina.book');

// Ruang Baca Digital (Mode Fokus & Reader View)
Route::get('/baca/{id}', [LuminaController::class, 'reader'])->name('lumina.reader');

// Halaman Gamifikasi, Fraksi Sekolah & Leaderboard
Route::get('/gamifikasi', [LuminaController::class, 'gamification'])->name('lumina.gamification');

// API Endpoints untuk Interaksi Frontend Interaktif (SPA-like)
Route::post('/api/matchmaker', [LuminaController::class, 'aiMatchmaker'])->name('lumina.api.matchmaker');
Route::post('/api/roleplay-chat', [LuminaController::class, 'roleplayChat'])->name('lumina.api.roleplay');
Route::post('/api/ai-summarize', [LuminaController::class, 'aiSummarize'])->name('lumina.api.summarize');
Route::post('/api/diskusi', [LuminaController::class, 'storeDiscussion'])->name('lumina.api.discussion');
Route::post('/api/claim-quest', [LuminaController::class, 'claimQuest'])->name('lumina.api.quest');
