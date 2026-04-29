
<p>{{__('emails.dear')}}</p>
<p>{{__('emails.inform')}} <b>{{ $content['nameForm'] }}</b></p>
<p>{{__('emails.response')}}</p>
<p></p>
<hr>
<div>
    @if(isset($content['f-name']))
        <p><b>{{ $content['tagf-name'] }}</b> &nbsp;{{ $content['f-name'] }}</p>
    @endif
    @if(isset($content['f-email']))
        <p><b>{{ $content['tagf-email'] }}</b> &nbsp;{{ $content['f-email'] }}</p>
    @endif
    @if(isset($content['f-tel']))
        <p><b>{{ $content['tagf-tel'] }}</b> &nbsp;{{ $content['f-tel'] }}</p>
    @endif
    @if(isset($content['f-birthday']))
        <p><b>{{ $content['tagf-birthday'] }}:</b> &nbsp;{{ $content['f-birthday'] }}</p>
    @endif
    @if(isset($content['f-cp']))
        <p><b>{{ $content['tagf-cp'] }}</b> &nbsp;{{ $content['f-cp'] }}</p>
    @endif
    @if(isset($content['f-text']))
        <p><b>{{ $content['tagf-text'] }}</b> &nbsp;{{ $content['f-text'] }}</p>
    @endif
    @if(isset($content['f-textArea']))
        <p><b>{{ $content['tagf-textArea'] }}</b> &nbsp;{{ $content['f-textArea'] }}</p>
    @endif
    @if(isset($content['f-terms']))
        <p><b>{{__('emails.terms')}} </b> &nbsp;{{__('emails.yes')}} </p>
    @endif
</div>
<hr>
<br>
<p>{{__('emails.thanks')}}</p>
<p>{{__('emails.sincerely')}}</p>
<img style="width:200px" src="https://app.playfunnel.net/images/SVG/Logo-Horizontal-BgClear.svg" alt="PlayFunnel">
<br/>

