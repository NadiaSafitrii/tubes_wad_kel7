<!DOCTYPE html>
<html>
<head>
    <title>Buku Panduan Peminjaman</title>
    <style>
        body { font-family: sans-serif; }
        .header { text-align: center; border-bottom: 2px solid #d9534f; padding-bottom: 10px; }
        .qna-box { margin-bottom: 20px; padding: 10px; border-bottom: 1px solid #eee; }
        .question { font-weight: bold; color: #d9534f; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Buku Panduan Peminjaman</h1>
        <p>Logistik Telkom University - {{ $date }}</p>
    </div>
    @foreach($qnas as $qna)
    <div class="qna-box">
        <div class="question">Q: {{ $qna->pertanyaan }}</div>
        <div class="answer">A: {{ $qna->jawaban ?? 'Belum dijawab' }}</div>
    </div>
    @endforeach
</body>
</html>