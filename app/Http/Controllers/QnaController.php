<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Qna; 
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class QnaController extends Controller
{
    

    
    public function indexAdmin()
    {
        
        $qnaList = Qna::with('user')
                    ->orderBy('created_at', 'desc')
                    ->get();

        
        return view('admin_qna', compact('qnaList'));
    }

    
    public function jawab(Request $request, $id)
    {
        $request->validate([
            'jawaban' => 'required'
        ]);

        $qna = Qna::findOrFail($id);
        $qna->update([
            'jawaban' => $request->jawaban,
            'status'  => 'Dijawab' 
        ]);

        return redirect()->route('admin.qna')->with('success', 'Jawaban berhasil dikirim!');
    }

    
    public function destroy($id)
    {
        $qna = Qna::findOrFail($id);
        $qna->delete();

        return redirect()->route('admin.qna')->with('success', 'Pertanyaan dihapus.');
    }

    
    
    public function storeTanya(Request $request)
    {
        $request->validate([
            'subjek' => 'required',
            'pertanyaan' => 'required'
        ]);

        Qna::create([
            'user_id' => Auth::id(), 
            'subjek' => $request->subjek,
            'pertanyaan' => $request->pertanyaan,
            'status' => 'Terkirim'
        ]);
        
        return redirect()->back()->with('success', 'Pertanyaan berhasil dikirim!');
    }
}