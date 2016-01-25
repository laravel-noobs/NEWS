<p>
    This is a test, an email test.
</p>
<p>
    The variable <code>$testVar</code> contains the value:
</p>
<ul>
    <li><strong>{{ $testVar }}</strong></li>
</ul>
<hr>
<p>
    That is all.
</p>

<pre>
    Mail::send('emails.test', ['testVar' => 'Just a silly test'], function($message) { $message->from('administrator@meongu.net', 'NEWS')->to('tsuneka.kou@gmail.com')->subject('A simple test');});
</pre>