<?php

namespace App\Http\Controllers;

use App\Models\ChatHistory;
use App\Models\CustomCharacter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

// gotta split this stuff soon for ease of access and readability, what even is this LOL
// And this thing IS NOT readable with the human eyes.

class ChatController extends Controller
{
    // ============================================================
    // KATA KUNCI YANG AKAN DI-FLAG
    // Tambah kata baru di array ini sesuai kebutuhan
    // ============================================================
    private array $flaggedKeywords = [
        // Self-harm & krisis
        'bunuh diri', 'mau mati', 'ingin mati', 'pengen mati',
        'tidak mau hidup', 'ga mau hidup', 'gak mau hidup',
        'menyakiti diri', 'nyakitin diri', 'self harm',
        'overdosis', 'gantung diri', 'lompat',

        // Kekerasan
        'membunuh', 'mau bunuh', 'pengen bunuh', 'ingin bunuh',

        // Kata senonoh
        'kontol', 'memek', 'ngentot', 'anjing', 'bangsat',
    ];

    private function checkFlag(string $message): array
    {
        $messageLower = strtolower($message);
        foreach ($this->flaggedKeywords as $keyword) {
            if (str_contains($messageLower, $keyword)) {
                return [true, $keyword];
            }
        }
        return [false, null];
    }

    // ============================================================

    public function index()
    {
        return view('chat.index');
    }

    public function kakAra()
    {
        $history = ChatHistory::where('user_id', Auth::id())
            ->where('character', 'kak-ara')
            ->orderBy('created_at', 'asc')
            ->get();

        if ($history->isEmpty()) {
            ChatHistory::create([
                'user_id'   => Auth::id(),
                'character' => 'kak-ara',
                'role'      => 'assistant',
                'content'   => 'Hei, aku Kak Ara! Senang banget kamu mau mampir ke sini. Cerita dulu yuk — ada apa yang lagi kamu rasain hari ini?',
            ]);

            $history = ChatHistory::where('user_id', Auth::id())
                ->where('character', 'kak-ara')
                ->orderBy('created_at', 'asc')
                ->get();
        }

        return view('chat.kak-ara', compact('history'));
    }

    public function kakReza()
    {
        $history = ChatHistory::where('user_id', Auth::id())
            ->where('character', 'kak-reza')
            ->orderBy('created_at', 'asc')
            ->get();

        if ($history->isEmpty()) {
            ChatHistory::create([
                'user_id'   => Auth::id(),
                'character' => 'kak-reza',
                'role'      => 'assistant',
                'content'   => 'Hei! Aku Kak Reza. Yuk ngobrol — cerita apa yang lagi ada di pikiranmu sekarang? Kita coba lihat bareng-bareng.',
            ]);

            $history = ChatHistory::where('user_id', Auth::id())
                ->where('character', 'kak-reza')
                ->orderBy('created_at', 'asc')
                ->get();
        }

        return view('chat.kak-reza', compact('history'));
    }

    public function sendAra(Request $request)
    {
        return $this->handleSend($request, 'kak-ara');
    }

    public function sendReza(Request $request)
    {
        return $this->handleSend($request, 'kak-reza');
    }

    public function resetAra(Request $request)
    {
        return $this->handleReset('kak-ara');
    }

    public function resetReza(Request $request)
    {
        return $this->handleReset('kak-reza');
    }

    private function handleSend(Request $request, string $character)
    {
        $request->validate(['message' => 'required|string']);

        $user    = Auth::user();
        $gender  = $user->gender ?? 'laki-laki';
        $name    = $user->username ?? $user->name;
        $message = $request->message;

        // Cek flag
        [$isFlagged, $flagReason] = $this->checkFlag($message);

        // Simpan pesan user ke database
        ChatHistory::create([
            'user_id'     => $user->id,
            'character'   => $character,
            'role'        => 'user',
            'content'     => $message,
            'is_flagged'  => $isFlagged,
            'flag_reason' => $flagReason,
        ]);

        // Ambil history untuk dikirim ke AI
        $history = ChatHistory::where('user_id', $user->id)
            ->where('character', $character)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(fn($h) => ['role' => $h->role, 'content' => $h->content])
            ->toArray();

        $systemPrompt = $this->getSystemPrompt($character, $name, $gender);

        // Kirim ke Groq
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.groq.key'),
            'Content-Type'  => 'application/json',
        ])->post('https://api.groq.com/openai/v1/chat/completions', [
            'model'      => 'llama-3.3-70b-versatile',
            'max_tokens' => 1000,
            'messages'   => array_merge(
                [['role' => 'system', 'content' => $systemPrompt]],
                $history
            ),
        ]);

        $reply = $response->json('choices.0.message.content')
            ?? 'Maaf, aku tidak bisa menjawab sekarang. Coba lagi ya 🙏';

        // Simpan balasan AI ke database
        ChatHistory::create([
            'user_id'   => $user->id,
            'character' => $character,
            'role'      => 'assistant',
            'content'   => $reply,
        ]);

        return response()->json(['reply' => $reply]);
    }

    private function handleReset(string $character)
    {
        ChatHistory::where('user_id', Auth::id())
            ->where('character', $character)
            ->delete();

        $greeting = match($character) {
            'kak-ara'  => 'Hei, aku Kak Ara! Senang banget kamu mau mampir ke sini. Cerita dulu yuk — ada apa yang lagi kamu rasain hari ini?',
            'kak-reza' => 'Hei! Aku Kak Reza. Yuk ngobrol — cerita apa yang lagi ada di pikiranmu sekarang? Kita coba lihat bareng-bareng.',
            default    => 'Hei! Ada yang mau kamu ceritain?',
        };

        ChatHistory::create([
            'user_id'   => Auth::id(),
            'character' => $character,
            'role'      => 'assistant',
            'content'   => $greeting,
        ]);

        return response()->json([
            'status'   => 'reset',
            'greeting' => $greeting,
        ]);
    }

    private function getSystemPrompt(string $character, string $name, string $gender): string
    {
        if ($character === 'kak-ara') {
            return "Kamu adalah Kak Ara, teman curhat AI yang hangat dan penuh empati.
Kamu berbicara dalam bahasa Indonesia yang santai, seperti kakak perempuan yang peduli.
User bernama {$name} adalah seorang {$gender}. Sesuaikan sapaan dan cara bicaramu.
Kepribadian: selalu validasi perasaan user, gunakan bahasa lembut, ajukan 1 pertanyaan di akhir.
Batasan: jangan diagnosis, jika ada indikasi krisis sarankan hubungi 119 ext 8.
Jawab maksimal 3-4 kalimat, singkat dan natural.";
        }

        return "Kamu adalah Kak Reza, mentor AI yang tenang dan realistis.
Kamu berbicara dalam bahasa Indonesia yang santai tapi thoughtful, seperti kakak laki-laki yang jujur.
User bernama {$name} adalah seorang {$gender}. Sesuaikan sapaan dan cara bicaramu.
Kepribadian: bantu breakdown masalah, berikan perspektif baru, dorong langkah konkret.
Batasan: jangan diagnosis, jika ada indikasi krisis sarankan hubungi 119 ext 8.
Jawab maksimal 3-4 kalimat, singkat dan natural.";
    }

    public function custom()
    {
        $character = CustomCharacter::where('user_id', Auth::id())->first();

        if (!$character) {
            return redirect()->route('chat.create-character');
        }

        $history = ChatHistory::where('user_id', Auth::id())
            ->where('character', 'custom')
            ->orderBy('created_at', 'asc')
            ->get();

        $greeting = $character->first_message
            ?? 'Hei! Aku ' . $character->name . '. Ada yang mau kamu ceritain hari ini? 😊';

        if ($history->isEmpty()) {
            ChatHistory::create([
                'user_id'   => Auth::id(),
                'character' => 'custom',
                'role'      => 'assistant',
                'content'   => $greeting,
            ]);

            $history = ChatHistory::where('user_id', Auth::id())
                ->where('character', 'custom')
                ->orderBy('created_at', 'asc')
                ->get();
        }

        return view('chat.custom', compact('character', 'history'));
    }

    public function createCharacter(Request $request)
    {
        $character = CustomCharacter::where('user_id', Auth::id())->first();

        if ($character && !$request->has('edit')) {
            return redirect()->route('chat.custom');
        }

        return view('chat.create-character', compact('character'));
    }

    public function storeCharacter(Request $request)
    {
        $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'personality'   => ['required', 'string'],
            'avatar'        => ['nullable', 'image', 'max:2048'],
            'first_message' => ['nullable', 'string'],
        ]);

        $existing = CustomCharacter::where('user_id', Auth::id())->first();
        if ($existing) {
            return redirect()->route('chat.create-character')
                ->with('error', 'Kamu sudah punya karakter. Edit karakter yang ada.');
        }

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        CustomCharacter::create([
            'user_id'       => Auth::id(),
            'name'          => $request->name,
            'personality'   => $request->personality,
            'avatar'        => $avatarPath,
            'first_message' => $request->first_message,
        ]);

        return redirect()->route('chat.custom');
    }

    public function updateCharacter(Request $request)
    {
        $character = CustomCharacter::where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'personality'   => ['required', 'string'],
            'avatar'        => ['nullable', 'image', 'max:2048'],
            'first_message' => ['nullable', 'string'],
        ]);

        $avatarPath = $character->avatar;
        if ($request->hasFile('avatar')) {
            if ($avatarPath) Storage::disk('public')->delete($avatarPath);
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        $character->update([
            'name'          => $request->name,
            'personality'   => $request->personality,
            'avatar'        => $avatarPath,
            'first_message' => $request->first_message,
        ]);

        return redirect()->route('chat.custom');
    }

    public function deleteCharacter()
    {
        $character = CustomCharacter::where('user_id', Auth::id())->firstOrFail();

        if ($character->avatar) {
            Storage::disk('public')->delete($character->avatar);
        }

        ChatHistory::where('user_id', Auth::id())
            ->where('character', 'custom')
            ->delete();

        $character->delete();

        return redirect()->route('chat.index');
    }

    public function sendCustom(Request $request)
    {
        $request->validate(['message' => 'required|string']);

        $user      = Auth::user();
        $character = CustomCharacter::where('user_id', $user->id)->firstOrFail();
        $message   = $request->message;

        // Cek flag
        [$isFlagged, $flagReason] = $this->checkFlag($message);

        ChatHistory::create([
            'user_id'     => $user->id,
            'character'   => 'custom',
            'role'        => 'user',
            'content'     => $message,
            'is_flagged'  => $isFlagged,
            'flag_reason' => $flagReason,
        ]);

        $history = ChatHistory::where('user_id', $user->id)
            ->where('character', 'custom')
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(fn($h) => ['role' => $h->role, 'content' => $h->content])
            ->toArray();

        $systemPrompt = $character->personality . "\nNama user yang sedang kamu ajak bicara adalah {$user->username}.";

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.groq.key'),
            'Content-Type'  => 'application/json',
        ])->post('https://api.groq.com/openai/v1/chat/completions', [
            'model'      => 'llama-3.3-70b-versatile',
            'max_tokens' => 1000,
            'messages'   => array_merge(
                [['role' => 'system', 'content' => $systemPrompt]],
                $history
            ),
        ]);

        $reply = $response->json('choices.0.message.content')
            ?? 'Maaf, aku tidak bisa menjawab sekarang. Coba lagi ya 🙏';

        ChatHistory::create([
            'user_id'   => $user->id,
            'character' => 'custom',
            'role'      => 'assistant',
            'content'   => $reply,
        ]);

        return response()->json(['reply' => $reply]);
    }

    public function resetCustom()
    {
        $character = CustomCharacter::where('user_id', Auth::id())->firstOrFail();

        ChatHistory::where('user_id', Auth::id())
            ->where('character', 'custom')
            ->delete();

        $greeting = $character->first_message
            ?? 'Hei! Aku ' . $character->name . '. Ada yang mau kamu ceritain hari ini? 😊';

        ChatHistory::create([
            'user_id'   => Auth::id(),
            'character' => 'custom',
            'role'      => 'assistant',
            'content'   => $greeting,
        ]);

        return response()->json([
            'status'   => 'reset',
            'greeting' => $greeting,
        ]);
    }
}