<p>Hi {{$parentUser->first_name}},<br /></p>

<p>{{$participantUser->first_name}}'s pledge video is ready to watch and share!<br />
Watch it here: <a href="{{$participantShareLink}}">{{$participantShareLink}}</a></p>

<p>Click <a href="{{$participantShareLink}}">here</a> to share the video with Facebook, email, or text.</p>

<p>Your Student Star video is the perfect way to ask for pledges. Send it to:</p>

<ul>
    <li>Faraway friends</li>
    <li>Old classmates</li>
    <li>Distant family</li>
</ul>

<p>Happy pledging!</p>
<ul>
    <li>{{$programName}}</li>
</ul>

<p><a href="{{$emailPreferencesUrl}}">Unsubscribe</a></p>
