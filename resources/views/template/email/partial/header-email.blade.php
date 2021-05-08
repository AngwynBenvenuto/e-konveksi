<tr>
    <td class="email-masthead">
        @php $logo = asset('public/img/logo.png');  @endphp
        <a href="{{ route('admin.dashboard') }}" target="_blank" class="f-fallback email-masthead_name">
            {{ env('APP_NAME') }}
        </a>
    </td>
</tr>