<div class="container">
    <h3>Phản hồi liên hệ: {{ $contact->fullname }}</h3>

    <form action="{{ route('contacts.reply.send', $contact->id) }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Email người gửi:</label>
            <input type="text" class="form-control" value="{{ $contact->email }}" readonly>
        </div>

        <div class="form-group">
            <label>Chủ đề:</label>
            <input type="text" class="form-control" value="{{ $contact->subject }}" readonly>
        </div>

        <div class="form-group">
            <label>Nội dung phản hồi:</label>
            <textarea name="reply_message" class="form-control" rows="6" required>{{ old('reply_message') }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Gửi phản hồi</button>
        <a href="{{ route('contacts.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
