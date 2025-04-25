<div class="container">
    <h3>Danh sách liên hệ</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Họ tên</th>
                <th>Điện thoại</th>
                <th>Email</th>
                <th>Chủ đề</th>
                <th>Nội dung</th>
                <th>Ngày gửi</th>
                <th>Phản hồi</th> {{-- Thêm cột phản hồi --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($contacts as $contact)
                <tr>
                    <td>{{ $contact->fullname }}</td>
                    <td>{{ $contact->phone }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ $contact->subject }}</td>
                    <td>{{ $contact->message }}</td>
                    <td>{{ $contact->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        @if ($contact->is_replied)
                            <span class="text-success">Đã phản hồi</span>
                        @else
                            <span class="text-danger">Chưa phản hồi</span>
                        @endif
                    </td>
                    {{-- <td>
                        <a href="{{ route('contacts.reply', $contact->id) }}" class="btn btn-sm btn-primary">
                            Phản hồi
                        </a>
                    </td> --}}
                    <td>
                        <a href="{{ route('contacts.reply', $contact->id) }}" class="btn btn-primary btn-sm">
                            Phản hồi
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $contacts->links() }}
</div>
