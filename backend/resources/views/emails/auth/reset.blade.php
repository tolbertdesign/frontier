<html>
    <body>
        <div>
            <p>{{$user->first_name}},</p>
            <p>Who needs that old password anyway? To change the password for the account associated with this email, please click <a href="{{ route('password.reset', $token) }}">here</a>.</p>
            <p>If you're having trouble with the link above, copy/paste this link into your browser:<br/>
            {{ route('password.reset', $token) }}</p>
            <p>A new password, a new day.</p>
            <p>-- Booster Support Team</p>
        </div>
    </body>
</html>
