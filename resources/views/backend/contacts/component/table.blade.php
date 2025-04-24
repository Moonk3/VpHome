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
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $contacts->links() }}
</div>
